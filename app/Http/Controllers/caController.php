<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\Ca;
use App\Customer;
use App\balance;
use App\Notification;
use Auth;
use App\User;
use App\Employee;  
use App\Cash_History;
use Carbon\Carbon; 
use App\UserPermission;
use App\Events\BalanceUpdated;
use App\Events\CashierCashUpdated;

class caController extends Controller
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
    public function permission(){
    $userid= Auth::user()->id;

    $permit = UserPermission::find($request->id)->where('user_id',$userid);

    return $permit;
    }
    public function index(){
        $customer = Customer::all();
        return view('main.ca', compact('customer'));
    }

    public function store(Request $request){
        if($request->get('button_action_ca') == ''){
        
        if($request->stat=="new"){ 
            $customer = new Customer;
            $customer->fname = $request->fname;
            $customer->mname = $request->mname;
            $customer->lname = $request->lname;

            if($request->contacts == ""){
                $customer->contacts ="Not Specified";
            }
            else{
                $customer->contacts = $request->contacts;
            }
            if($request->address == ""){
                $customer->address ="Not Specified";
            }
            else{
                $customer->address = $request->address;
            }

            $customer->suki_type = 0;
            
            $customer->save();
            $cid =  $customer->id;
            $balance = new balance;
            $balance->customer_id =$cid;
            $balance->balance = 0;
            $balance->logs_ID = $cid;
            $balance->save();

            $ca = new Ca();
            $ca->customer_id = $cid;
            $ca->reason = $request->reason1;
            $ca->amount = $request->bal;
            $ca->balance = 0;
            $ca->status = "On-Hand";
            $ca->released_by = '';
            $ca->save();

            if($ca) {
                $notification = new Notification;
                $notification->notification_type = "Cash Advance";
                $notification->message = "Cash Advance";
                $notification->status = "Pending";
                $notification->admin_id = Auth::id();
                $notification->table_source = "cash_advance";
                $notification->cash_advance_id = $ca->id;
                $notification->save();

                $datum = Notification::where('id', $notification->id)
                    ->with('admin', 'cash_advance', 'expense', 'dtr.dtrId.employee', 'trip.tripId.employee')
                    ->get()[0];

                $notification = array();

                $notification = array(
                    'notifications' => $datum,
                    'customer' => $datum->cash_advance->customer,
                    'time' => time_elapsed_string($datum->updated_at),
                );  

                event(new \App\Events\NewNotification($notification));
            }
            
        }

        else{ 
            $ca = new Ca();
            $ca->customer_id = $request->customer_id;
            $ca->reason = $request->reason;
            $ca->amount = $request->amount;
            $ca->balance = $request->balance + $request->amount;
            $ca->status = "On-Hand";
            $ca->released_by = '';
            $ca->save();
    
            if($ca) {
                $notification = new Notification;
                $notification->notification_type = "Cash Advance";
                $notification->message = "Cash Advance";
                $notification->status = "Pending";
                $notification->admin_id = Auth::id();
                $notification->table_source = "cash_advance";
                $notification->cash_advance_id = $ca->id;
                $notification->save();
    
                $datum = Notification::where('id', $notification->id)
                    ->with('admin', 'cash_advance', 'expense', 'dtr.dtrId.employee', 'trip.tripId.employee')
                    ->get()[0];
    
                $notification = array();
    
                $notification = array(
                    'notifications' => $datum,
                    'customer' => $datum->cash_advance->customer,
                    'time' => time_elapsed_string($datum->updated_at),
                );
    
                event(new \App\Events\NewNotification($notification));
            }
    
            }
    }
        if($request->get('button_action_ca') == 'update'){
            $ca = Ca::find($request->get('id_ca'));
            $cash_advance = DB::table('cash_advance')
            ->join('customer', 'customer.id', '=', 'cash_advance.customer_id')
            ->select('cash_advance.id','cash_advance.customer_id', 'customer.fname', 'customer.mname', 'customer.lname', 'cash_advance.reason', 'cash_advance.amount', 'cash_advance.created_at','cash_advance.balance','cash_advance.status','cash_advance.released_by')
            ->where('cash_advance.id', $request->get('id_ca'))
            ->get();

            $user = User::find(Auth::user()->id);

            if($ca->status == 'Released'){
                $balance = balance::where('customer_id', $request->customer_id)->first();

                $ca->status = "On-Hand";
                $ca->released_by = '';

                $balance->balance -= $ca->amount;
                $balance->save();

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
                $cash_history->cash_change = $ca->amount;
                $cash_history->total_cash = $user->cashOnHand + $ca->amount;
                $cash_history->type = "Released CA Edit";
                $cash_history->save();

                $user->cashOnHand += $ca->amount;
                $user->save();
            }
            
            $ca->customer_id = $request->customer_id;
            $ca->reason = $request->reason;
            $ca->amount = $request->amount;
            $ca->save();
            
            return $user->cashOnHand;
        }
    }

    public function release_update(Request $request){
        $check_admin =Auth::user()->id;
        if($check_admin==1){
            $logged_id = Auth::user()->name;
            $user = User::find(Auth::user()->id);
            $released = Ca::find($request->id);
            $released->status = "Released";
            $released->released_by = $logged_id;
            $released->save();
            $balance = balance::where('customer_id', $released->customer_id)->increment('balance',$released->amount);
            event(new BalanceUpdated($released));
        }else{
            $logged_id = Auth::user()->emp_id;
            $name= Employee::find($logged_id);
            $user = User::find(Auth::user()->id);
            $released = Ca::find($request->id);
            $released->status = "Released";
            $released->released_by = $name->fname." ".$name->mname." ".$name->lname;
            $released->save();
            $balance = balance::where('customer_id', $released->customer_id)->increment('balance',$released->amount);
            event(new BalanceUpdated($released));
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
        $cash_history->type = "Release Cash - Cash Advance";
        $cash_history->save();

        $user->cashOnHand -= $released->amount;
        $user->save();
        
        event(new CashierCashUpdated());
        
        $output = array(
            'cashOnHand' => $user->cashOnHand,
            'cashHistory' => $dateTime
        );
        
        echo json_encode($output);
        //return $user->cashOnHand;
    }

    public function check_balance4(Request $request){
        $user = User::find(Auth::user()->id);
        $expense = Ca::find($request->id);

        if($user->cashOnHand < $expense->amount){
            return 0;
        }
        else{
            if($expense->status == 'Released'){
                return 2;
            }
            return 1;
        }
    }
    function updatedata(Request $request){
        $id = $request->input('id');
        $cash_advance = DB::table('cash_advance')
            ->join('customer', 'customer.id', '=', 'cash_advance.customer_id')
            ->select('cash_advance.id','cash_advance.customer_id', 'customer.fname', 'customer.mname', 'customer.lname', 'cash_advance.reason', 'cash_advance.amount', 'cash_advance.created_at','cash_advance.balance','cash_advance.status','cash_advance.released_by')
            ->where('cash_advance.id', $id)
            ->get();
            
        $output = array(
            'customer_id' => $cash_advance[0]->customer_id,
            'reason' => $cash_advance[0]->reason,
            'amount' => $cash_advance[0]->amount,
            'balance' => $cash_advance[0]->balance
        );
        echo json_encode($output);
    }

    function deletedata(Request $request){
        $ca = Ca::find($request->input('id'));
        $customer= $ca->customer_id; 
        $amount= $ca->amount;
        $balance = balance::where('customer_id', $customer)->first();
        
        if($ca->status == "Released"){
            if($balance->balance < $amount){
                return 2;
            }
            $balance->balance = ($balance->balance-$amount);
            $balance->save();
            
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
            $cash_history->cash_change = $ca->amount;
            $cash_history->total_cash = $user->cashOnHand + $ca->amount;
            $cash_history->type = "Released CA Deleted";
            $cash_history->save();

            $user->cashOnHand += $ca->amount;
            $user->save();
            echo json_encode($user->cashOnHand);
        }
        $ca->delete();
    }

    public function refresh(){
        $join = DB::table('cash_advance')
            ->select(DB::raw('max(created_at) as maxdate'), 'customer_id')
            ->groupBy('customer_id');
        $sql = '(' . $join->toSql() . ') as ca2';

        $cash_advance = DB::table('cash_advance as ca1')
            ->select('ca1.*', 'cus.fname', 'cus.mname', 'cus.lname','balance.balance')
            ->join(DB::raw($sql), function($join){
                $join->on('ca2.customer_id', '=', 'ca1.customer_id')
                    ->on('ca2.maxdate', '=', 'ca1.created_at');
            })
            ->leftJoin('customer as cus', 'ca1.customer_id', '=', 'cus.id')
             ->join('balance', 'balance.customer_id', '=', 'ca1.customer_id')
            ->orderBy('ca1.created_at', 'desc')
            ->get();

        // check for pending ca
        $pending_cash_advances = DB::table('cash_advance')
            ->where('status', '!=', 'Released')
            ->get();

        return \DataTables::of($cash_advance)
        ->addColumn('action', function($cash_advance) use ($pending_cash_advances) {
            $pending_ca = $pending_cash_advances->where('customer_id', $cash_advance->customer_id)->count();

            return '<button class="btn btn-xs btn-info waves-effect view_cash_advance" id="'.$cash_advance->customer_id.'"><i class="material-icons" style="width: 25px;">visibility</i></button>'. (($pending_ca) ? '<span class="badge-notify-parent"><span class="badge badge-notify">!</span></span>' : '');//info/visibility
        })
        ->addColumn('wholename', function ($data){
            return $data->lname.", ".$data->fname." ".substr($data->mname, 0, 1);
        })
        ->editColumn('balance', function ($data) {
            return '₱'.number_format($data->balance, 2, '.', ',');
        })
        ->editColumn('amount', function ($data) {
            return '₱'.number_format($data->amount, 2, '.', ',');
        })
         ->editColumn('created_at', function ($data) {
            return date('F d, Y g:i a', strtotime($data->created_at));
        })
        ->make(true);
    }

    public function refresh_view(Request $request){
         
        $id = $request->input('id');
        $cash_advance = DB::table('cash_advance')
            ->join('customer', 'customer.id', '=', 'cash_advance.customer_id')
            ->select('cash_advance.id','cash_advance.customer_id', 'customer.fname', 'customer.mname', 'customer.lname', 'cash_advance.reason', 'cash_advance.amount', 'cash_advance.created_at','cash_advance.balance','cash_advance.status','cash_advance.released_by', 'cash_advance.pid')
            ->where('cash_advance.customer_id', $id)
            ->latest();
        return \DataTables::of($cash_advance)
         ->addColumn('action', function($cash_advance){
            $userid= Auth::user()->id;
            $permit = UserPermission::where('user_id',$userid)->where('permit',1)->where('permission_id',5)->get();   
            if($userid!=1){
                $delete=$permit[0]->permit_delete;  
                $edit = $permit[0]->permit_edit;  
           }

            if($cash_advance->status=="On-Hand" && isAdmin()==1 && $cash_advance->pid == null){
                return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>&nbsp&nbsp<button class="btn btn-xs btn-warning update_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">mode_edit</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">delete</i></button>';
            }else if($cash_advance->status=="On-Hand" && isAdmin()!=1 && $delete==1 && $edit==1 && $cash_advance->pid == null){
                return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>&nbsp&nbsp<button class="btn btn-xs btn-warning update_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">mode_edit</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">delete</i></button>';
            }else if($cash_advance->status=="On-Hand" && isAdmin()!=1 && $delete==1 && $edit==0 && $cash_advance->pid == null){
                return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">delete</i></button>';
            }else if($cash_advance->status=="On-Hand" && isAdmin()!=1 && $delete==0 && $edit==1 && $cash_advance->pid == null){
                return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>&nbsp&nbsp<button class="btn btn-xs btn-warning update_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">mode_edit</i></button>';
            }else if($cash_advance->status=="On-Hand" && isAdmin()!=1 && $delete==0 && $edit==0 && $cash_advance->pid == null){
                return '<button class="btn btn-xs btn-success release_ca waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">eject</i></button>';
            }else if($cash_advance->status=="On-Hand" && $cash_advance->pid != null){
                
            }
            else if($cash_advance->status=="Released" && isAdmin()==1 && $cash_advance->pid == null){
                return '<button class="btn btn-xs btn-danger waves-effect" id="'.$cash_advance->id.'"><i class="material-icons">done_all</i></button>&nbsp&nbsp<button class="btn btn-xs btn-warning update_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">mode_edit</i></button>&nbsp&nbsp<button class="btn btn-xs btn-danger delete_ca waves-effect" id="'.$cash_advance->id.'" ><i class="material-icons">delete</i></button>';
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
        ->editColumn('balance', function ($data) {
           return '₱'.number_format($data->balance, 2, '.', ',');
        })
        ->editColumn('amount', function ($data) { 
            return '₱'.number_format($data->amount, 2, '.', ',');
        })
         ->editColumn('created_at', function ($data) {
            return date('F d, Y g:i a', strtotime($data->created_at));
        })

        ->make(true);

        echo json_encode($cash_advance);
    }

    public function check_balance(Request $request){
        //$balance = Ca::where('customer_id', $request->id)->orderBy('customer_id', 'desc')->latest()->get();
        $balance = balance::where('customer_id', '=', $request->id)
            ->get();
        echo json_encode($balance);
    }
    public function getCustomer(Request $request){
      $data =  Customer::find($request->id);
        return $data;
    }
}
