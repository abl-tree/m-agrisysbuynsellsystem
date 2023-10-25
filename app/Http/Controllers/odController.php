<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Employee;
use App\Commodity;
use App\Company;
use App\od_expense;
use App\od;
use App\Roles;
use App\Trucks;
use Auth;
use App\User;
use App\Events\ExpensesUpdated;
use App\Events\CashierCashUpdated; 
use App\Notification;
use App\Cash_History;
use Carbon\Carbon;
use App\UserPermission;
class odController extends Controller
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
    public function index()
    {
        $driver= DB::table('employee')
            ->join('roles', 'roles.id', '=', 'employee.role_id')
            ->select('employee.*','employee.id AS emp_id',  'roles.id','roles.role')
            ->where('roles.role','LIKE','%driver%')
            ->get();

        $commodity = Commodity::all();
        $company = Company::all();
        $trucks = Trucks::all();
        return view('main.od')->with(compact('driver','commodity','company','trucks'));
    }

    public function store(Request $request)
    {
        $output; 
        if($request->get('button_action') == 'add'){
            $commodity= new od;
            $commodity->outboundTicket = $request->ticket;
            $commodity->commodity_id = $request->commodity;
            $commodity->destination = $request->destination;
            $commodity->driver_id = $request->driver_id;
            $commodity->company_id = $request->company;
            $commodity->plateno = $request->plateno;
            $commodity->fuel_liters = $request->liter;
            $commodity->kilos = $request->kilos;
            $commodity->allowance = $request->allowance;
            $commodity->save();
            $lastInsertedId = $commodity->id;
            $od_expenses = new od_expense;
            $od_expenses->od_id = $lastInsertedId;
            $od_expenses->description = $request->destination;
            $od_expenses->type ="Outbound Expense";
            $od_expenses->amount = $request->allowance;
            $od_expenses->status = "On-Hand";
            $od_expenses->released_by = '';
            $od_expenses->save();
            $details =  DB::table('deliveries')->orderBy('outboundTicket', 'desc')->first();

            if($od_expenses) {
                $notification = new Notification;
                $notification->notification_type = "Outbound Expense";
                $notification->message = "Outbound Expense";
                $notification->status = "Pending";
                $notification->admin_id = Auth::id();
                $notification->table_source = "od_expense";
                $notification->od_expense_id = $od_expenses->id;
                $notification->save();

                $datum = Notification::where('id', $notification->id)
                    ->with('admin', 'cash_advance', 'expense', 'dtr.dtrId.employee', 'trip.tripId.employee', 'od.odId.driver')
                    ->get()[0];

                $notification = array();

                $notification = array(
                    'notifications' => $datum,
                    'customer' => $datum->od->odId->driver,
                    'time' => time_elapsed_string($datum->updated_at),
                );

                event(new \App\Events\NewNotification($notification));
            }
            $output="Add"; 

            return json_encode($output);
        }

        if($request->get('button_action') == 'update'){
          $commodity= new od; 
          $commodity= od::find($request->get('id'));
          $od_expenses =od_expense::find($request->get('id'));
          $user = User::find(Auth::user()->id); 
          if($commodity->allowance!=$request->allowance && $od_expenses->status=="Released"){
            $userGet = User::where('id', '=', Auth::user()->id)->first();
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
            $cash_history->cash_change = $od_expenses->amount;
            $cash_history->total_cash = $user->cashOnHand + $commodity->allowance;
            $cash_history->type = "Edit Data on - Outbound Deliveries";
            $cash_history->save();
            $user->cashOnHand += $commodity->allowance;
            $user->save();
            $od_expenses->status = "On-Hand";
            $od_expenses->released_by = '';
            $output = array(
                'cashOnHand' => $user->cashOnHand,
                'outbound_data' => $commodity
            );
            
        }else{
            $output="Success"; 
        }
          $commodity->outboundTicket = $request->ticket;
          $commodity->commodity_id = $request->commodity;
          $commodity->destination = $request->destination;
          $commodity->driver_id = $request->driver_id;
          $commodity->company_id = $request->company;
          $commodity->plateno = $request->plateno;
          $commodity->fuel_liters = $request->liter;
          $commodity->kilos = $request->kilos;
          $commodity->allowance = $request->allowance;
          $od_expenses->description = $request->destination;
          $od_expenses->type ="Outbound Expense";
          $od_expenses->amount = $request->allowance;
          $od_expenses->save();
          $commodity->save();
          return json_encode($output);
        }
    }

    public function release_update_od(Request $request){
        $check_admin =Auth::user()->id;
        if($check_admin==1){
            $logged_id = Auth::user()->name;
            $user = User::find(Auth::user()->id);
            $released = od_expense::find($request->id);
            $released->status = "Released";
            $released->released_by = $logged_id;
            $released->save();
        }else{
            $logged_id = Auth::user()->emp_id;
            $name= Employee::find($logged_id);       
            $user = User::find(Auth::user()->id);      
            $released=od_expense::find($request->id);
            $released->status = "Released";
            $released->released_by = $name->fname." ".$name->mname." ".$name->lname;;
            $released->save();
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
        $cash_history->type = "Release Cash - Outbound Deliveries";
        $cash_history->save();
        
        event(new ExpensesUpdated($released));

        $user->cashOnHand -= $released->amount;
        $user->save();
         
        event(new CashierCashUpdated());
       
        $output = array(
            'cashOnHand' => $user->cashOnHand,
            'cashHistory' => $dateTime
        );
        
        echo json_encode($output);
   }

    public function check_balance_od(Request $request){
       $user = User::find(Auth::user()->id);
       $expense = od_expense::find($request->id);

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

    public function refresh(Request $request)
    {
        $from = $request->date_from;
        $to = $request->date_to;

        if($to==""){
         $ultimatesickquery= DB::table('deliveries')
            ->join('commodity', 'commodity.id', '=', 'deliveries.commodity_id')
            ->join('trucks', 'trucks.id', '=', 'deliveries.plateno')
            ->join('employee', 'employee.id', '=', 'deliveries.driver_id')
            ->join('company', 'company.id', '=', 'deliveries.company_id')
            ->join('od_expense', 'od_expense.od_id', '=', 'deliveries.id')
            ->select('deliveries.id','deliveries.outboundTicket','commodity.name AS commodity_name','trucks.plate_no AS plateno','deliveries.destination', 'employee.fname','employee.mname','employee.lname','company.name', 'deliveries.fuel_liters','deliveries.kilos','deliveries.allowance','deliveries.created_at','od_expense.status')
            ->whereBetween('deliveries.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
            ->latest();
        }else{
            $ultimatesickquery= DB::table('deliveries')
            ->join('commodity', 'commodity.id', '=', 'deliveries.commodity_id')
            ->join('trucks', 'trucks.id', '=', 'deliveries.plateno')
            ->join('employee', 'employee.id', '=', 'deliveries.driver_id')
            ->join('company', 'company.id', '=', 'deliveries.company_id')
            ->join('od_expense', 'od_expense.od_id', '=', 'deliveries.id')
            ->select('deliveries.id','deliveries.outboundTicket','commodity.name AS commodity_name','trucks.plate_no AS plateno','deliveries.destination', 'employee.fname','employee.mname','employee.lname','company.name', 'deliveries.fuel_liters','deliveries.kilos','deliveries.allowance','deliveries.created_at','od_expense.status')
            ->where('deliveries.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
            ->where('deliveries.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
            ->latest();
        }
        //$user = User::all();
       
        return \DataTables::of($ultimatesickquery)
        ->addColumn('action', function(  $ultimatesickquery){
            $userid= Auth::user()->id;
            $permit = UserPermission::where('user_id',$userid)->where('permit',1)->where('permission_id',4)->get();
            if($userid!=1){
                $delete=$permit[0]->permit_delete;  
                $edit = $permit[0]->permit_edit;
            }   
            
            if($userid==1){
                 return '<button class="btn btn-xs btn-warning update_delivery waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;
            <button class="btn btn-xs btn-danger delete_delivery waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button>';
            }if($userid!=1 && $delete==1 && $edit==1 &&$ultimatesickquery->status=="On-Hand"){
                     return '<button class="btn btn-xs btn-warning update_delivery waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;
                <button class="btn btn-xs btn-danger delete_delivery waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button>';
            }
            if($userid!=1 && $delete==1 && $edit==1 &&$ultimatesickquery->status=="Released"){
                return 'Released';
       }
            if($userid!=1 && $delete==1 && $edit==0 &&$ultimatesickquery->status=="On-Hand"){
            return '<button class="btn btn-xs btn-danger delete_delivery waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button>';
            }
            if($userid!=1 && $delete==1 && $edit==0 &&$ultimatesickquery->status=="Released"){
                return 'Released';
                }
            if($userid!=1 && $delete==0 && $edit==1 &&$ultimatesickquery->status=="On-Hand"){
                 return '<button class="btn btn-xs btn-warning update_delivery waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>';
            }
            if($userid!=1 && $delete==0 && $edit==1 &&$ultimatesickquery->status=="Released"){
                return 'Released';
           }
            if($userid!=1 && $delete==0 && $edit==0){
                 return 'No Action Permitted';
            }
           
        })
        ->editColumn('allowance', function ($data) {
            return '₱'.number_format($data->allowance, 2, '.', ',');
        })
        ->editColumn('kilos', function ($data) {
            return number_format($data->kilos, 2, '.', ',');
        })
        ->editColumn('fuel_liters', function ($data) {
            return number_format($data->fuel_liters, 2, '.', ',');
        })
         ->editColumn('created_at', function ($data) {
            return date('F d Y, h:i:s A',strtotime($data->created_at));
        })
        ->make(true);
    }

    function updatedata(Request $request){
        $id = $request->input('id');
        $od = od::find($id);
        $output = array(
            'outboundTicket' => $od->outboundTicket,
            'commodity_id' => $od->commodity_id,
            'destination' => $od->destination,
            'driver_id' => $od->driver_id,
            'company_id' => $od->company_id,
            'plateno' => $od->plateno,
            'fuel_liters' => $od->fuel_liters,
            'kilos' => $od->kilos,
            'allowance' => $od->allowance,
        );
        echo json_encode($output);
    }

    function updateId(){
       $temp = DB::select('select MAX(id) as "temp" FROM deliveries');
        echo json_encode($temp);
    }

    function deletedata(Request $request){
        $od = od::find($request->input('id'));
        $od_expenses =od_expense::find($request->id);
        $user = User::find(1);  
        $output="success";
        if($od_expenses->status=="Released"){
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
    
            $cash_history->trans_no = $dateTime;
            $cash_history->previous_cash = $user->cashOnHand;
            $cash_history->cash_change = $od_expenses->amount;
            $cash_history->total_cash = $user->cashOnHand + $od_expenses->amount;
            $cash_history->type = "Delete Released Data on - Outbound Deliveries";
            $cash_history->save();
            $user->cashOnHand += $od_expenses->amount;
            $user->save();
            $output = array(
                'cashOnHand' => $user->cashOnHand,
                'trip_data' => $od
            );
            $od_expenses->delete();
            $od->delete();
        }else{
            $od_expenses->delete();
            $od->delete();
        }
        return json_encode($output);
    }

    public function od_expense_view(Request $request)
    {
       $from = $request->date_from;
       $to = $request->date_to;
       if($to==""||$from==""){
          $od_expense = DB::table('deliveries')
            ->join('od_expense', 'od_expense.od_id', '=', 'deliveries.id')
            ->select('od_expense.id','deliveries.outboundTicket AS od_id','od_expense.description AS description','od_expense.type AS type','od_expense.amount AS amount','od_expense.status AS status','od_expense.released_by as released_by','od_expense.created_at as created_at')
            ->whereBetween('deliveries.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
            ->get()->sortByDesc('created_at');
        }else{
           
             $od_expense = DB::table('deliveries')
            ->join('od_expense', 'od_expense.od_id', '=', 'deliveries.id')
            ->select('od_expense.id','deliveries.outboundTicket AS od_id','od_expense.description AS description','od_expense.type AS type','od_expense.amount AS amount','od_expense.status AS status','od_expense.released_by as released_by','od_expense.created_at as created_at')
                ->where('od_expense.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
                ->where('od_expense.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
                ->get()->sortByDesc('created_at');
        }
      
        return \DataTables::of($od_expense)
        ->addColumn('action', function($od_expense){
            if($od_expense->status=="On-Hand"){
                 return '<button class="btn btn-xs btn-success release_expense_od waves-effect" id="'.$od_expense->id.'"><i class="material-icons">eject</i></button>';
            }else{
                 return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$od_expense->id.'"><i class="material-icons">done_all</i></button>';
            }
           
        })
        ->editColumn('amount', function ($data) {
            return '₱'.number_format($data->amount, 2, '.', ',');
        })
        ->editColumn('created_at', function ($data) {
            return date('F d Y, h:i:s A',strtotime($data->created_at));
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


}
