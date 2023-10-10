<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\dtr;
use App\dtr_expense;
use App\expense;
use App\emp_payment;
use App\employee;
use App\User;
use App\Notification;
use App\Cash_History;
use App\employee_ca;
use Carbon\Carbon;
use Auth;
use App\employee_bal;
use App\UserPermission;
use App\Events\CashierCashUpdated;
use App\Events\BalanceUpdated;
use App\Events\DtrUpdated;
class dtrController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function isAdmin(){
    return Auth::user()->id;
    }
    public function index(){
        $employee = employee::all();
        $pusher = [
            'key' => env('MIX_PUSHER_APP_KEY'),
            'cluster' => env('MIX_PUSHER_APP_CLUSTER')
        ];

        return view('main.dtr', compact('employee'), ['pusher' => $pusher]);
    }

    public function checkPendingTransactions($employee_id){
        $cash_advance = employee_ca::where('employee_id', $employee_id)->where('status', '!=', 'Released')->count();
        if ($cash_advance) {
            return response()->json([
                'message' => "The employee has an unreleased CA. Please finalize it before proceeding."
            ], 400);
        }

        $payment = emp_payment::where('logs_id', $employee_id)->whereNull('status')->count();
        if ($payment) {
            return response()->json([
                'message' => "The employee has an unreceived Payment. Please finalize it before proceeding."
            ], 400);
        }

        $dtr = dtr::where('employee_id', $employee_id)->where('status', '!=', 'Released')->count();
        if ($dtr) {
            return response()->json([
                'message' => "The employee has an unreleased DTR. Please finalize it before proceeding."
            ], 400);
        }

        return true;
    }

    public function store(Request $request){
        if($request->get('button_action') == ''){
            $check_pending = $this->checkPendingTransactions($request->employee_id);
            if ($check_pending !== true) return $check_pending;

            // balance fetching
            $empbalance = employee_ca::where('employee_id', '=', $request->employee_id)->latest()->first();
            $balance = $empbalance ? $empbalance->balance : 0;

            if ($balance != $request->emp_balance) {
                return response()->json([
                    'message' => 'Balances does not match. Please close this form and try again.'
                ], 400);
            }

            $dtr = new dtr;
            $dtr->employee_id = $request->employee_id;
            $dtr->role = $request->role;
            $dtr->overtime = $request->overtime;
            $dtr->num_hours = $request->num_hours;
            $dtr->rate = $request->rate;
            $dtr->bonus = $request->bonus;
            $dtr->dtr_balance = $request->emp_balance;
            $dtr->r_balance = $request->emp_rbalance;
            $dtr->p_payment = $request->p_payment;
            $dtr->salary = $request->salary;
            $dtr->deductions_object = [
                "sss_deductions" => number_format($request->sss_deductions ?? 0, 2),
                "phic_deductions" => number_format($request->phic_deductions ?? 0, 2),
                "hdmf_deductions" => number_format($request->hdmf_deductions ?? 0, 2),
                "lodging_deductions" => number_format($request->lodging_deductions ?? 0, 2),
                "other_deductions" => number_format($request->other_deductions ?? 0, 2),
            ];
            $total_deductions = 0;
            foreach($dtr->deductions_object as $key => $value) {
                $total_deductions += $value;
            }
            $dtr->deductions = $total_deductions;
            $dtr->status = "On-Hand";
            $dtr->save();
            $dtr_id = dtr::where('employee_id', '=', $request->employee_id)->latest()->first();
            
            $output = array(
                'cashOnHand' => 0,
            );

            event(new DtrUpdated());
            return  json_encode($output);
        }
        if($request->get('button_action') == 'update'){
            $dtr = dtr::find($request->add_id);

            // balance fetching
            $empbalance = employee_ca::where('employee_id', '=', $dtr->employee_id)->latest()->first();
            $balance = $empbalance ? $empbalance->balance : 0;

            if ($balance != $request->emp_balance) {
                return response()->json([
                    'message' => 'Balances does not match. Please close this form and try again.'
                ], 400);
            }

            $user = User::find(1);
            $user->cashOnHand -= $dtr->p_payment;
            $user->save();
            $dtr->role = $request->role;
            $dtr->overtime = $request->overtime;
            $dtr->num_hours = $request->num_hours;
            $dtr->rate = $request->rate;
            $dtr->bonus = $request->bonus;
            $dtr->dtr_balance = $request->emp_balance;
            $dtr->r_balance = $request->emp_rbalance;
            $dtr->p_payment = $request->p_payment;
            $dtr->salary = $request->salary; 
            $dtr->deductions_object = [
                "sss_deductions" => $request->sss_deductions ?? 0,
                "phic_deductions" => $request->phic_deductions ?? 0,
                "hdmf_deductions" => $request->hdmf_deductions ?? 0,
                "lodging_deductions" => $request->lodging_deductions ?? 0,
                "other_deductions" => $request->other_deductions ?? 0,
            ];
            $total_deductions = 0;
            foreach($dtr->deductions_object as $key => $value) {
                $total_deductions += $value;
            }
            $dtr->deductions = $total_deductions;
            $checkpayment = emp_payment::all();
            if($checkpayment!==null){                      
                $paymentlogs = emp_payment::firstOrFail()->where('dtr_id',$request->add_id)->count();
            if($paymentlogs>0){
                $user1 = User::find(1);
                $user_current =  $user1->cashOnHand;
                $user1->cashOnHand += $request->p_payment;
                $user1->save();

                $userGet = User::where('id', '=', 1)->first();
                $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
                $cash_history = new Cash_History;
                $cash_history->user_id = $userGet->id;

                $getDate = Carbon::now();
                
                if($cashLatest != null){
                    $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
                }
                else{
                    $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
                }
                $employeeName= employee::where('id', '=', $request->employee_ni)->first();
                $cash_history->trans_no = $dateTime;
                $cash_history->previous_cash = $user_current;
                $cash_history->cash_change = $request->p_payment;
                $cash_history->total_cash = $user->cashOnHand;
                $cash_history->type = "Edit DTR CA Payment (".$employeeName->fname." ".$employeeName->lname.")";
                $cash_history->save();

                $output = array(
                    'cashOnHand' => $user->cashOnHand,
                    'cashHistory'=> $dateTime,
                    'user'       => Auth::user()->id,
                );
                
                $recent = emp_payment::where('dtr_id', '=', $request->add_id)->latest()->first();
                $new_payment = new emp_payment;
                $new_payment->logs_id = $recent->logs_id;
                $new_payment->dtr_id = $recent->dtr_id;
                $new_payment->paymentmethod = "From ADD DTR Form";
                $balance = employee_ca::where('employee_id', '=', $recent->logs_id)->latest()->first();
                $r_balance = emp_payment::where('logs_id', '=', $recent->logs_id)->latest()->first(); 
                $empbalance = employee_bal::where('employee_id', '=', $recent->logs_id)->first();
            
            
                $r_balance->r_balance = $request->last_payment+$empbalance->balance; 
                $new_payment->r_balance=$r_balance->r_balance-$request->p_payment;
                $new_payment->remarks = "Edited Partial Payment from DTR FORM";
                $balance->balance = $new_payment->r_balance;
                $empbalance->balance = $balance->balance;
                $new_payment->checknumber = "Not Specified";
                $new_payment->paymentamount = $request->p_payment;
                if($request->p_payment!=0){                   
                    $new_payment->save();                                     
                }
                $balance->save();  
                $empbalance->save();   
                $dtr->save();
                event(new DtrUpdated());
                return json_encode($output);       
                 }
            }  
                $dtr->save();
                event(new DtrUpdated());
                return json_encode($checkpayment);
    }
}

    public function add_dtr_expense(Request $request){
        $dtr = new dtr_expense;
        $dtr->dtr_id = $request->id;
        $dtr->description = "description";
        $dtr->type ="DTR EXPENSE";
        $dtr->amount = $request->salary;
        $dtr->status = "On-Hand";
        $dtr->released_by = '';
        $dtr->save();

        if($dtr) {
            $notification = new Notification;
            $notification->notification_type = "Daily Time Record";
            $notification->message = "Daily Time Record Release";
            $notification->status = "Pending";
            $notification->admin_id = Auth::id();
            $notification->table_source = "dtr_expense";
            $notification->dtr_expense_id = $dtr->id;
            $notification->save();

            $datum = Notification::where('id', $notification->id)->with('admin', 'dtr.dtrId.employee')->get()[0];

            $notification = array();

            if(!empty($datum->dtr)) {
                $notification = array(
                    'notifications' => $datum,
                    'customer' => $datum->dtr->dtrId->employee,
                    'time' => time_elapsed_string($datum->updated_at), 
                );
            }

            event(new \App\Events\NewNotification($notification));
        }

        $details = dtr_expense::all();

        echo json_encode($details);
    }
     public function release_update_dtr(Request $request){
        $check_admin =Auth::user()->id;
        $released = dtr::find($request->id);
        if($check_admin==1){
            $logged_id = Auth::user()->name;
            $user = User::find(Auth::user()->id);
            $released->status = "Released";
            $released->released_by = $logged_id;   
        }else{
            $logged_id = Auth::user()->emp_id;
            $user = User::find(Auth::user()->id);
            $name= Employee::find($logged_id);
            $released->status = "Released";
            $released->released_by = $name->fname." ".$name->mname." ".$name->lname;   
        }
                
            $paymentlogs = new emp_payment;
            $paymentlogs->logs_id = $released->employee_id;
            $paymentlogs->dtr_id = $released->id;
            $paymentlogs->paymentmethod = "From ADD DTR Form";
            $balance = employee_ca::where('employee_id', '=', $released->employee_id)->latest()->first();
            $empbalance = employee_bal::where('employee_id', '=', $released->employee_id)->first();
            if($released->p_payment!=0){
                $paymentlogs->r_balance=$balance->balance-$released->p_payment;
                $paymentlogs->remarks = "Partial Payment";
                if($check_admin==1){
                    $logged_id = Auth::user()->name;
                    $user = User::find(Auth::user()->id);
                    $paymentlogs->received_by=$logged_id;  
                    $paymentlogs->status="Received";  
                }else{
                    $logged_id = Auth::user()->emp_id;
                    $user = User::find(Auth::user()->id);
                    $name= Employee::find($logged_id);
                    $paymentlogs->status = "Received";
                    $paymentlogs->received_by = $name->fname." ".$name->mname." ".$name->lname;   
                }
                $balance->balance = $empbalance->balance-$released->p_payment;
                $empbalance->balance = $empbalance->balance-$released->p_payment;
                
                $paymentlogs->checknumber = "Not Specified";
                $paymentlogs->paymentamount = $released->p_payment;
                if($released->p_payment!=0){
                    $paymentlogs->save();
                    $balance->save();  
                    $empbalance->save();     
                }
                }
                if($released->p_payment>0){
                    //
                    $users = User::find(1);
                    $user_current =  $users->cashOnHand;
                    $users->cashOnHand += $released->p_payment;
                    $users->save();
 
                    $userGets = User::where('id', '=', 1)->first();
                    $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
                    $cash_history = new Cash_History;
                    $cash_history->user_id = $userGets->id;

                    $getDate = Carbon::now();
                    
                    if($cashLatest != null){
                        $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
                    }
                    else{
                        $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
                    }
                    $employeeName= employee::where('id', '=', $released->employee_id)->first();
                    $cash_history->trans_no = $dateTime;
                    $cash_history->previous_cash = $user_current;
                    $cash_history->cash_change = $released->p_payment;
                    $cash_history->total_cash = $users->cashOnHand;
                    $cash_history->type = "Employee CA Payment (".$employeeName->fname." ".$employeeName->lname.")";
                    $cash_history->save();
                }

                $userGet = User::where('id', '=', $user->id)->first();
                $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
                $cash_history = new Cash_History;
                $cash_history->user_id = $userGet->id;

                $getDate = Carbon::now();
                
                if($cashLatest != null){
                    $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
                }
                else{
                    $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
                }

                $cash_history->trans_no = $dateTime;
                $cash_history->previous_cash = $user->cashOnHand;
                $cash_history->cash_change = $released->salary;
                $cash_history->total_cash = $user->cashOnHand - $released->salary;
                $cash_history->type = "Release Cash - DTR";
                

                $user->cashOnHand -= $released->salary;
                $user->save();
                $released->save();
                $cash_history->save();

                event(new CashierCashUpdated());

                $output = array(
                    'cashOnHand' => $user->cashOnHand,
                    'cashHistory' => $dateTime
                );
                
                event(new DtrUpdated());
                echo json_encode($output);
            }

    public function check_balance5(Request $request){
        $user = User::find(Auth::user()->id);
        $expense = dtr::find($request->id);

        if($user->cashOnHand < $expense->salary){
            return 0;
        }
        else{
            if($expense->status == 'Released'){
                return 2;
            }
            return 1;
        }
    }
    public function check_emp_balance(Request $request){
        $balance = employee_ca::where('employee_id', '=', $request->id)->latest()->first();
        return json_encode($balance);
    }

    public function add_emp_ca(Request $request){
        $check_pending = $this->checkPendingTransactions($request->employee_id);
        if ($check_pending !== true) return $check_pending;

        $ca = new employee_ca;
        $ca->employee_id = $request->employee_id;
        $ca->reason = $request->reason;
        $ca->amount = $request->amount;
        $ca->balance = $request->balance + $request->amount;
        $ca->status = "On-Hand";
        $ca->released_by = '';
        $ca->save();

        return json_encode($ca);
    }

    public function emp_payment(Request $request){
        $check_pending = $this->checkPendingTransactions($request->employee_payment_id);
        if ($check_pending !== true) return $check_pending;

        $paymentlogs = new emp_payment;
        $paymentlogs->logs_id = $request->employee_payment_id;
        $paymentlogs->paymentmethod = $request->paymentmethod;
        if( $request->checknumber!=""){
            $paymentlogs->checknumber = $request->checknumber;
        }
        else{
            $paymentlogs->checknumber = "Not Specified";
        }
        $paymentlogs->remarks = $request->remarks;
        $paymentlogs->paymentamount = $request->amount;
        $balance = employee_ca::where('employee_id', '=', $request->employee_payment_id)->latest()->first();
        $paymentlogs->r_balance=$balance->balance;
        $paymentlogs->save();
        if($request->balance <= 0){
             $output = array(
            'cashOnHand' => 0
        );
            echo json_encode($output);
        }else{
            $output =['cashOnHand' => 1];
            echo json_encode($output);    
        }
        
    }
    public function delete_payment(Request $request){
        $check_admin =Auth::user()->id;
        $paymentDetails = emp_payment::where('id', '=',$request->id)->latest()->first();
        if($paymentDetails->status==null){
            $paymentDetails->delete();
            return "deleted";
        }else{
            $balance = employee_ca::where('employee_id', '=', $paymentDetails->logs_id)->latest()->first();
            $paymentDetails->r_balance=$balance->balance+$paymentDetails->paymentamount;
            $balance->balance = $balance->balance+$paymentDetails->paymentamount;
            $empbalance = employee_bal::where('employee_id', '=', $paymentDetails->logs_id)->latest()->first();
            $empbalance->balance = $paymentDetails->r_balance;
            
                $user = User::find(Auth::user()->id);
                $user_current =  $user->cashOnHand;
                $user->cashOnHand -= $paymentDetails->paymentamount;
                $user->save();
        
                $userGet = User::where('id', '=',Auth::user()->id)->first();
                $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
                $cash_history = new Cash_History;
                $cash_history->user_id = $userGet->id;

                $getDate = Carbon::now();
                
                if($cashLatest != null){
                    $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
                }
                else{
                    $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
                }
                $employeeName= employee::where('id', '=', $paymentDetails->logs_id)->first();
                $cash_history->trans_no = $dateTime;
                $cash_history->previous_cash = $user_current;
                $cash_history->cash_change = $paymentDetails->paymentamount;
                $cash_history->total_cash = $user->cashOnHand;
                $cash_history->type = "Delete Employee CA Payment (".$employeeName->fname." ".$employeeName->lname.")";
                $cash_history->save();
                $empbalance->save();
                $balance->save();
                

                $output = array(
                    'cashOnHand' => $user->cashOnHand,
                    'cashHistory'=> $dateTime,
                    'user'       => Auth::user()->id,
                    'amount'       => $paymentDetails->paymentamount,
                );
                $paymentDetails->delete();
                
            return json_encode($output);    
     
            //
        }
        
        
    }
    public function receive_payment(Request $request){
        $check_admin =Auth::user()->id;
        $paymentDetails = emp_payment::where('id', '=',$request->id)->latest()->first();
        $balance = employee_ca::where('employee_id', '=', $paymentDetails->logs_id)->latest()->first();
        $paymentDetails->r_balance=$balance->balance-$paymentDetails->paymentamount;
        $balance->balance = $balance->balance-$paymentDetails->paymentamount;
        $empbalance = employee_bal::where('employee_id', '=', $paymentDetails->logs_id)->latest()->first();
        $empbalance->balance = $paymentDetails->r_balance;
        if($check_admin==1){
            $logged_id = Auth::user()->name;
            $user = User::find(Auth::user()->id);
            $paymentDetails->received_by=$logged_id;  
            $paymentDetails->status="Received";  
        }else{
            $logged_id = Auth::user()->emp_id;
            $user = User::find(Auth::user()->id);
            $name= Employee::find($logged_id);
            $paymentDetails->status = "Received";
            $paymentDetails->received_by = $name->fname." ".$name->mname." ".$name->lname;   
        }
        //
        //
      
     
            $user = User::find(Auth::user()->id);
            $user_current =  $user->cashOnHand;
            $user->cashOnHand += $paymentDetails->paymentamount;
            $user->save();
     
       

        $userGet = User::where('id', '=',Auth::user()->id)->first();
        $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
        $cash_history = new Cash_History;
        $cash_history->user_id = $userGet->id;

        $getDate = Carbon::now();
        
        if($cashLatest != null){
            $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
        }
        else{
            $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
        }
        $employeeName= employee::where('id', '=', $paymentDetails->logs_id)->first();
        $cash_history->trans_no = $dateTime;
        $cash_history->previous_cash = $user_current;
        $cash_history->cash_change = $paymentDetails->paymentamount;
        $cash_history->total_cash = $user->cashOnHand;
        $cash_history->type = "Received Employee CA Payment (".$employeeName->fname." ".$employeeName->lname.")";
        $cash_history->save();
        $empbalance->save();
        $balance->save();
        $paymentDetails->save();

        $output = array(
            'cashOnHand' => $user->cashOnHand,
            'cashHistory'=> $dateTime,
            'user'       => Auth::user()->id,
            'amount'       => $paymentDetails->paymentamount,
        );
        
       return json_encode($output);    
     
        
    }
    function updatedata(Request $request){
         $id = $request->input('id');
        $dtr_view = DB::table('dtr')
            ->join('employee', 'employee.id', '=', 'dtr.employee_id')
            ->select('dtr.*', 'employee.fname', 'employee.mname', 'employee.lname')
            ->where('dtr.id', $id)
            ->get();

        $output = array(
            'employee_id' => $dtr_view[0]->employee_id,
            'role' => $dtr_view[0]->role,
            'overtime' => $dtr_view[0]->overtime,
            'rate' => $dtr_view[0]->rate,
            'bonus' => $dtr_view[0]->bonus,
            'p_payment' => $dtr_view[0]->p_payment,
            'r_balance' => $dtr_view[0]->r_balance,
            'dtr_balance' => $dtr_view[0]->dtr_balance,
            'num_hours' => $dtr_view[0]->num_hours,
            'salary' => $dtr_view[0]->salary,
            'deductions_object' => json_decode($dtr_view[0]->deductions_object) ?? [
                "sss_deductions" => number_format(0, 2),
                "phic_deductions" => number_format(0, 2),
                "hdmf_deductions" => number_format(0, 2),
                "lodging_deductions" => number_format(0, 2),
                "other_deductions" => number_format(0, 2),
            ],
        );
        echo json_encode($output);
    }

    function deletedata(Request $request){
        $dtr = dtr::find($request->input('id'));
        if($dtr->status == "Released"){
            $user = User::find(Auth::user()->id);
            $userGet = User::where('id', '=', $user->id)->first();
            $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
            $cash_history = new Cash_History;
            $cash_history->user_id = $userGet->id;

            $getDate = Carbon::now();
            
            if($cashLatest != null){
                $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
            }
            else{
                $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
            }

            $cash_history->trans_no = $dateTime;
            $cash_history->previous_cash = $user->cashOnHand;
            $cash_history->cash_change = $dtr->salary;
            $cash_history->total_cash = $user->cashOnHand + $dtr->salary;
            $cash_history->type = "Released DTR Deleted";
            $cash_history->save();

            $user->cashOnHand += $dtr->salary;
            $user->save();
             $output = array(
                'cashOnHand' => $user->cashOnHand,
                'cashHistory' => $dateTime
            );
            $dtr->delete();
            $empbalance = employee_bal::where('employee_id', '=', $dtr->employee_id)->first();
            $paymentlogs = emp_payment::where('dtr_id',$request->id)->count();
            $delete_dtr = emp_payment::where('dtr_id',$request->id);
            if($paymentlogs>0){
                $recent = emp_payment::where('dtr_id', '=', $request->id)->latest()->first();
                $recent_balance = emp_payment::where('logs_id', '=', $recent->logs_id)->latest()->first();
                $balance = employee_ca::where('employee_id', '=', $recent->logs_id)->latest()->first();
                $balance->balance = $recent->paymentamount+$balance->balance;
                $empbalance->balance = $empbalance->balance+$dtr->p_payment;
                $empbalance->save();
                $balance->save();  
                }
            $delete_dtr->delete();   
            echo json_encode($output);
        }else{
            $paymentlogs = emp_payment::where('dtr_id',$request->id)->count();
            $delete_dtr = emp_payment::where('dtr_id',$request->id);
            if($paymentlogs>0){
                $recent = emp_payment::where('dtr_id', '=', $request->id)->latest()->first();
                $recent_balance = emp_payment::where('logs_id', '=', $recent->logs_id)->latest()->first();
                $empbalance = employee_bal::where('employee_id', '=', $recent->logs_id)->first();
                $balance = employee_ca::where('employee_id', '=', $recent->logs_id)->latest()->first();
                $balance->balance = $recent->paymentamount+$balance->balance;
                $empbalance->balance = $balance->balance;
                $empbalance->save();  
                $balance->save();  
            }
            $delete_dtr->delete();
            $dtr->delete();
            echo  json_encode("deleted"); 
        }
        
    }
    

    function delete_ca_employee(Request $request){
        $ca = employee_ca::where('id',$request->id)->first();
        
            $check_balance= employee_ca::where('employee_id',$ca->employee_id)->latest()->first();
            if($check_balance->balance<$check_balance->amount){
                return json_encode("No");
            }else{
            if($ca->status=="Released"){
            $user = User::find(Auth::user()->id);
            $userGet = User::where('id', '=', $user->id)->first();
            $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
            $cash_history = new Cash_History;
            $cash_history->user_id = $userGet->id;

            $getDate = Carbon::now();
            
            if($cashLatest != null){
                $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
            }
            else{
                $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
            }
            $amount_ca = $ca->amount;
            
            $recent_ca= employee_ca::where('employee_id',$ca->employee_id)->latest()->first();
            $recent_ca->balance = $recent_ca->balance-$amount_ca;
            $empbalance = employee_bal::where('employee_id', '=', $ca->employee_id)->first();
            $empbalance->balance =$recent_ca->balance;
            $empbalance->save();  
            $recent_ca->save();
            $ca->delete();
            $cash_history->trans_no = $dateTime;
            $cash_history->previous_cash = $user->cashOnHand;
            $cash_history->cash_change = $ca->amount;
            $cash_history->total_cash = $user->cashOnHand + $ca->amount;
            $cash_history->type = "Released CA of Employee Deleted";
            $cash_history->save();

            $user->cashOnHand += $ca->amount;
            $user->save();
             $output = array(
                'cashOnHand' => $user->cashOnHand,
                'cashHistory' => $dateTime,
                'balance' => $recent_ca->balance,
                'username' => $user->username
            );
            return  json_encode($output);
        }
        else{
            $amount_ca = $ca->amount;
            $recent_ca= employee_ca::where('employee_id',$ca->employee_id)->latest()->first();
            $recent_ca->balance = $recent_ca->balance-$amount_ca;
            $empbalance = employee_bal::where('employee_id', '=', $ca->employee_id)->first();
            $empbalance->balance = $recent_ca->balance;
            $empbalance->save();  
            $recent_ca->save();
            $ca->delete();
            return json_encode("deleted");
        }   
            }
        
        
    }


    public function refresh(){
        $join = DB::table('dtr')
            ->select(DB::raw('max(created_at) as maxdate'), 'employee_id')
            ->groupBy('employee_id');
        $sql = '(' . $join->toSql() . ') as dtr2';

        $dtr = DB::table('dtr as dtr1')
            ->select('dtr1.*', 'emp.fname', 'emp.mname', 'emp.lname')
            ->join(DB::raw($sql), function($join){
                $join->on('dtr2.employee_id', '=', 'dtr1.employee_id')
                    ->on('dtr2.maxdate', '=', 'dtr1.created_at');
            })
            ->leftJoin('employee as emp', 'dtr1.employee_id', '=', 'emp.id')
            ->get();

        // check for pending ca
        $pending_cash_advances = DB::table('employee_cas')
            ->where('status', '!=', 'Released')
            ->get();
        // check for pending payments
        $pending_payments = DB::table('emp_payments')
            ->where('paymentmethod', '!=', 'From ADD DTR Form')
            ->whereNull('status')
            ->get();

        return \DataTables::of($dtr)
        ->addColumn('action', function($dtr) use ($pending_cash_advances, $pending_payments) {
            $pending_ca = $pending_cash_advances->where('employee_id', $dtr->employee_id)->count();
            $pending_payment = $pending_payments->where('logs_id', $dtr->employee_id)->count();

            return '<button class="btn btn-xs btn-info view_dtr waves-effect" id="'.$dtr->employee_id.'"><i class="material-icons" style="width: 25px;">visibility</i></button>&nbsp<button class="btn btn-xs btn-warning view_ca waves-effect" id="'.$dtr->employee_id.'"><i class="material-icons" style="width: 25px;">ballot</i></button>' . (($pending_ca || $pending_payment) ? '<span class="badge-notify-parent"><span class="badge badge-notify">!</span></span>' : '');//info/visibility
        })
        ->addColumn('wholename', function ($data){
            return $data->lname.", ".$data->fname." ".substr($data->mname, 0, 1);
        })
        ->editColumn('bonus', function ($data) {
            return '₱ '.number_format($data->bonus, 2, '.', ',');
        })
        ->editColumn('created_at', function ($data) {
            return date('F d, Y g:i a', strtotime($data->created_at));
        })
        ->editColumn('salary', function ($data) {
            return '₱ '.number_format($data->salary, 2, '.', ',');
        })
        ->addColumn('gross_salary', function ($data){
            return '₱ '.number_format(($data->salary + $data->p_payment + $data->deductions), 2, '.', ',');
        })
        ->editColumn('deductions', function ($data){
            return '₱ '.number_format(($data->deductions), 2, '.', ',');
        })
        ->addColumn('sss_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->sss_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->addColumn('phic_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->phic_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->addColumn('hdmf_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->hdmf_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->addColumn('lodging_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->lodging_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->addColumn('other_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->other_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->make(true);
    }

    public function refresh_view(Request $request){
        $id = $request->input('id');
        $dtr_view = DB::table('dtr')
            ->join('employee', 'employee.id', '=', 'dtr.employee_id')
           // ->join('employee_bal', 'employee.id', '=', 'employee_bal.employee_id')
            ->select('dtr.*', 'employee.fname', 'employee.mname', 'employee.lname')
            ->where('dtr.employee_id', $id)
            ->latest();

        return \DataTables::of($dtr_view)
        ->addColumn('action', function($dtr_view){
            if($dtr_view->status=="On-Hand" && isAdmin()==1){
                 return '<button class="btn btn-xs btn-success release_expense_dtr waves-effect" id="'.$dtr_view->id.'" ><i class="material-icons">eject</i></button>&nbsp&nbsp<button class="btn btn-xs btn-warning update_dtr waves-effect" id="'.$dtr_view->id.'" ><i class="material-icons">mode_edit</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_dtr waves-effect" id="'.$dtr_view->id.'" ><i class="material-icons">delete</i></button>';
            }else if($dtr_view->status=="On-Hand" && isAdmin()!=1){
                return '<button class="btn btn-xs btn-success release_expense_dtr waves-effect" id="'.$dtr_view->id.'" ><i class="material-icons">eject</i></button>&nbsp<button class="btn btn-xs btn-danger delete_dtr waves-effect" id="'.$dtr_view->id.'" ><i class="material-icons">delete</i></button>';    
            }
            else if($dtr_view->status=="Released" && isAdmin()==1){
                 return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$dtr_view->id.'"><i class="material-icons">done_all</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_dtr waves-effect" id="'.$dtr_view->id.'" ><i class="material-icons">delete</i></button>';
            }else{
                return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$dtr_view->id.'"><i class="material-icons">done_all</i></button>';
            }
        })
        ->editColumn('deductions', function ($data){
            return '₱ '.number_format(($data->deductions), 2, '.', ',');
        })
        ->addColumn('sss_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->sss_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->addColumn('phic_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->phic_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->addColumn('hdmf_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->hdmf_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->addColumn('lodging_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->lodging_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
        ->addColumn('other_deductions', function ($data){
            if($data->deductions_object){
                $deductions_object = json_decode($data->deductions_object);
                return '₱ '.number_format(($deductions_object->other_deductions ?? 0), 2, '.', ',');;
            } else {
                return '₱ 0.00';
            }
        })
		->editColumn('salary', function ($data) {
            return '₱ '.number_format($data->salary, 2, '.', ',');
        })
        ->editColumn('bonus', function ($data) {
            return '₱ '.number_format($data->bonus, 2, '.', ',');
        })
        ->editColumn('created_at', function ($data) {
            return date('F d, Y g:i a', strtotime($data->created_at));
        })
         ->editColumn('released_by', function ($data) {
            if($data->released_by==""){
                return 'None';
            }else{
                return $data->released_by;
            }

        })
        ->make(true);
       
    }

     public function employee_view_ca(Request $request){
         
        $id = $request->input('id');
        $cash_advance = DB::table('employee_cas')
            ->join('employee', 'employee.id', '=', 'employee_cas.employee_id')
            ->select('employee_cas.id','employee_cas.employee_id', 'employee.fname', 'employee.mname', 'employee.lname', 'employee_cas.reason', 'employee_cas.amount', 'employee_cas.created_at','employee_cas.balance','employee_cas.status','employee_cas.released_by')
            ->where('employee_cas.employee_id', $id)
            ->latest();
        return \DataTables::of($cash_advance)
         ->addColumn('action', function($cash_advance){
            $userid= Auth::user()->id;
            $permit = UserPermission::where('user_id',$userid)->where('permit',1)->where('permission_id',5)->get();   
            if($userid!=1){
                $delete=$permit[0]->permit_delete;  
                $edit = $permit[0]->permit_edit;  
            }
            if($cash_advance->status=="On-Hand" && isAdmin()==1){
                 return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">delete</i></button>';
            }if($cash_advance->status=="On-Hand" && isAdmin()!=1 && $delete==1 && $edit==1){
                 return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">delete</i></button>';
            }if($cash_advance->status=="On-Hand" && isAdmin()!=1 && $delete==1 && $edit==0){
                 return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">delete</i></button>';
            }if($cash_advance->status=="On-Hand" && isAdmin()!=1 && $delete==0 && $edit==1){
                 return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>';
            }else if($cash_advance->status=="On-Hand" && isAdmin()!=1 && $delete==0 && $edit==0){
                 return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>';
            }
             else if($cash_advance->status=="Released" && isAdmin()==1){
                 return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">done_all</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">delete</i></button>';
            }
            else{
                 return '<button class="btn btn-xs btn-danger waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">done_all</i></button>';
            }
           
        })
         ->editColumn('released_by', function ($data) {
            if($data->released_by==""){
                return 'None';
            }else{
                return $data->released_by;
            }
             
        })
        ->editColumn('created_at', function ($data) {
            return date('F d, Y g:i a', strtotime($data->created_at));
        })
        ->editColumn('amount', function ($data) { 
            return '₱'.number_format($data->amount, 2, '.', ',');
        })
        //  ->editColumn('created_at', function ($data) {
        //     return date('F d, Y g:i a', strtotime($data->created_at));
        // })

        ->make(true);

        echo json_encode($cash_advance);
    }


        public function employee_view_payment(Request $request){
         
        $id = $request->input('id');
        $payments = DB::table('emp_payments')
            ->join('employee', 'employee.id', '=', 'emp_payments.logs_id')
            ->select('emp_payments.id','emp_payments.logs_id', 'employee.fname', 'employee.mname', 'employee.lname', 'emp_payments.paymentmethod', 'emp_payments.paymentamount', 'emp_payments.created_at','emp_payments.checknumber','emp_payments.remarks','emp_payments.r_balance','received_by','status')
            ->where('emp_payments.logs_id', $id)
            ->get()->sortByDesc('created_at');
        return \DataTables::of($payments)
         ->addColumn('action', function($cash_advance){
          
            if($cash_advance->status!="Received"){
         return '<button class="btn btn-xs btn-success receive_payment waves-effect" id="'.$cash_advance->id.'">
         <i class="material-icons">details</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_payment waves-effect" id="'.$cash_advance->id.'" >
         <i class="material-icons">delete</i></button>';
        }else if($cash_advance->paymentmethod=="From ADD DTR Form" && isAdmin()==1){
            return 'No Action';
        }else if($cash_advance->status=="Received" && isAdmin()==1){
            return '<button class="btn btn-xs btn-danger waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">done_all</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_payment waves-effect" id="'.$cash_advance->id.'" >
            <i class="material-icons">delete</i></button>';
        }else if($cash_advance->status=="Received"){
            return '<button class="btn btn-xs btn-danger waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">done_all</i></button>';
        }
            
           
        })
        ->editColumn('paymentamount', function ($data) {
           return '₱'.number_format($data->paymentamount, 2, '.', ',');
        })
        ->editColumn('r_balance', function ($data) { 
            return '₱'.number_format($data->r_balance, 2, '.', ',');
        })
         ->editColumn('created_at', function ($data) {
            return date('F d, Y g:i a', strtotime($data->created_at));
        })
        ->editColumn('received_by', function ($data) {
            if($data->received_by==null){
                return "None";
            }else{
                return $data->received_by;
            }
           
        })

        ->make(true);

        echo json_encode($cash_advance);
    }

    public function check_employee(Request $request){
        if($request->id!=null){
            $employee_details = DB::table('employee')
            ->join('roles', 'employee.role_id', '=', 'roles.id')
            //->join('employee_bal', 'employee.id', '=', 'employee_bal.employee_id')
            ->select('employee.*', 'roles.role','roles.rate')   
            ->where('employee.id', $request->id)
            ->get();
            $balance=0;
            $empbalance = employee_ca::where('employee_id', '=', $request->id)->latest()->first();
            // $empbalance = employee_bal::where('employee_id', '=', $request->id)->first();
            if($empbalance!=null){
                $balance= $empbalance->balance;
            }
            $output = array(
                'role' => $employee_details[0]->role,
                'rate' => $employee_details[0]->rate,
                'balance'=>$balance,
    
            );
            echo json_encode($output);
        }
        
    }

	public function refresh_total(Request $request){
		 $total = DB::table('dtr')
		 ->where('employee_id', '=', $request->id)
		 ->where('status',"=", "On-Hand")
		 ->sum('salary');

        echo json_encode($total);
    }

    public function check_balance_user(Request $request){
        $user = User::find(Auth::user()->id);
        $expense = employee_ca::find($request->id);

        if($user->cashOnHand < $expense->amount){
            return 0;
        }
        else{
            return 1;
        }
    }


    public function release_ca_employee(Request $request){
        $check_admin =Auth::user()->id;
        if($check_admin==1){
            $logged_id = Auth::user()->name;
            $user = User::find(Auth::user()->id);
            $released = employee_ca::find($request->id);
            $released->status = "Released";
            $released->released_by = $logged_id;
            $released->save();
            event(new BalanceUpdated($released));
        }else{
            $logged_id = Auth::user()->emp_id;
            $name= Employee::find($logged_id);
            $user = User::find(Auth::user()->id);
            $released = employee_ca::find($request->id);
            $released->status = "Released";
            $released->released_by = $name->fname." ".$name->mname." ".$name->lname;
            $released->save();
            event(new BalanceUpdated($released));
        }
            $check_ca= employee_bal::where('employee_id', '=', $released->employee_id)->first();

            if($check_ca!=null){
                $balance = employee_bal::where('employee_id', '=', $released->employee_id)->first();
                $balance->balance = $balance->balance + $released->amount;
                $balance->save();     
            }else{
                $balance = new employee_bal;
                $balance->employee_id=$released->employee_id;
                $balance->logs_id=$released->employee_id;
                $balance->balance = $released->amount;
                $balance->save();   
            }

        $userGet = User::where('id', '=', $user->id)->first();
        $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
        $cash_history = new Cash_History;
        $cash_history->user_id = $userGet->id;

        $getDate = Carbon::now();
        
        if($cashLatest != null){
            $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
        }
        else{
            $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
        }

        $cash_history->trans_no = $dateTime;
        $cash_history->previous_cash = $user->cashOnHand;
        $cash_history->cash_change = $released->amount;
        $cash_history->total_cash = $user->cashOnHand - $released->amount;
        $cash_history->type = "Release Cash - Employee Cash Advance";
        $cash_history->save();

        $user->cashOnHand -= $released->amount;
        $user->save();
        $cashLatest->save();
        
        event(new CashierCashUpdated());
        
        $output = array(
            'cashOnHand' => $user->cashOnHand,
            'cashHistory' => $dateTime
        );
        
        echo json_encode($output);
        //return $user->cashOnHand;
    }

    public function employee_balance(){
          
        $dtr_view = DB::table('employee_bal')
            ->join('employee', 'employee.id', '=', 'employee_bal.employee_id')
            ->join('dtr', 'employee.id', '=', 'dtr.employee_id')
            ->select('employee_bal.balance','dtr.role','employee.fname','employee.lname')
            ->where('employee_bal.balance','>',0)
            ->groupBy('employee_bal.employee_id')
            ->get();
             
        return \DataTables::of($dtr_view)
        ->editColumn('balance', function ($data) {
            return '₱ '.number_format($data->balance, 2, '.', ',');
        })
        ->editColumn('name', function ($data) {
            return $data->fname." ".$data->lname;
        })
         ->editColumn('role', function ($data) {
            return $data->role; 

        })
        ->make(true);
     return json_encode($dtr_view);
    }
}
