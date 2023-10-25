<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\trips;
use App\User;
use App\Employee;
use App\Trucks;
use App\Commodity;
use App\Roles;
use App\trip_expense;
use App\Notification;
use App\Cash_History;
use Carbon\Carbon;
use Auth;
use App\Events\ExpensesUpdated;
use App\Events\CashierCashUpdated; 
use App\UserPermission;
class tripController extends Controller
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
    public function index(){
        $driver= DB::table('employee')
            ->join('roles', 'roles.id', '=', 'employee.role_id')
            ->select('employee.*','employee.id AS emp_id',  'roles.id','roles.role')
            ->where('roles.role','LIKE','%driver%')
            ->get();
        $laborer= DB::table('employee')
            ->join('roles', 'roles.id', '=', 'employee.role_id')
            ->select('employee.*','employee.id AS emp_id',  'roles.id','roles.role')
            ->where('roles.role','LIKE','%labor%')
            ->get();

        $commodity = Commodity::all();
        $trucks = Trucks::all();
        return view('main.trip')->with(compact('driver','commodity','trucks','laborer'));
    }


    public function store(Request $request){
        $trip= new trips;
        $trip->trip_ticket = $request->ticket;
        $trip->expense = $request->expense;
        $trip->commodity_id = $request->commodity;
        $trip->destination = $request->destination;
        $trip->driver_id = $request->driver_id;
        $trip->truck_id = $request->plateno;
        $trip->num_liters = $request->num_liters;
        $trip->laborers = $request->laborer; 
        $trip->remarks = $request->remark;
        $trip->save();
        $lastInsertedId = $trip->id;
        $trip_expenses = new trip_expense;
        $trip_expenses->trip_id = $lastInsertedId;
        $trip_expenses->description = $request->destination;
        $trip_expenses->type ="TRIP EXPENSE";
        $trip_expenses->amount = $request->expense;
        $trip_expenses->status = "On-Hand";
        $trip_expenses->released_by = '';
        $trip_expenses->save();
        $details =  DB::table('trips')->orderBy('trip_ticket', 'desc')->first();
        
        if($trip_expenses) {
            $notification = new Notification;
            $notification->notification_type = "Trips Expense";
            $notification->message = "Trip Expense";
            $notification->status = "Pending";
            $notification->admin_id = Auth::id();
            $notification->table_source = "trip_expense";
            $notification->trip_expense_id = $trip_expenses->id;
            $notification->save();
            
            $datum = Notification::where('id', $notification->id)
                    ->with('admin', 'cash_advance', 'expense', 'dtr.dtrId.employee', 'trip.tripId.employee')
                    ->get()[0];

            $notification = array();

            if(!empty($datum)) {
                $notification = array(
                    'notifications' => $datum,
                    'customer' => $datum->trip->tripId->employee,
                    'time' => time_elapsed_string($datum->updated_at), 
                );
            }

            event(new \App\Events\NewNotification($notification));
        }

        echo json_encode($details);
    }

    public function update_trip(Request $request){
        $trip= trips::find($request->id);
        $trip_expenses =trip_expense::find($request->id);
        $user = User::find(Auth::user()->id);  
        $released = trip_expense::find($request->id);  
        $output="Success";  
        if($trip->expense!=$request->expense && $released->status=="Released"){
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
            $cash_history->cash_change = $released->amount;
            $cash_history->total_cash = $user->cashOnHand + $trip->expense;
            $cash_history->type = "Edit Data on - Trips";
            $cash_history->save();
            $user->cashOnHand += $trip->expense;
            $user->save();
            $trip_expenses->status = "On-Hand";
            $trip_expenses->released_by = '';
            $output = array(
                'cashOnHand' => $user->cashOnHand,
                'trip_data' => $trip
            );
            
        }
        $trip->trip_ticket = $request->ticket;
        $trip->expense = $request->expense;
        $trip->commodity_id = $request->commodity;
        $trip->destination = $request->destination;
        $trip->driver_id = $request->driver_id;
        $trip->truck_id = $request->plateno;
        $trip->num_liters = $request->num_liters;
        $trip->laborers = $request->laborer;
        $trip->remarks = $request->remark;
        $trip->save();
        $trip_expenses->description = $request->destination;
        $trip_expenses->amount = $request->expense;
        $trip_expenses->save();
        
        
 
        return json_encode($output);
    }
     public function release_update(Request $request){
         $check_admin =Auth::user()->id;
        if($check_admin==1){
            $logged_id = Auth::user()->name;
            $user = User::find(Auth::user()->id);
            $released = trip_expense::find($request->id);
            $released->status = "Released";
            $released->released_by = $logged_id;
            $released->save();
            event(new ExpensesUpdated($released));
        }else{
            $logged_id = Auth::user()->emp_id;
            $name= Employee::find($logged_id);      
            $user = User::find(Auth::user()->id);       
            $released=trip_expense::find($request->id);
            $released->status = "Released";
            $released->released_by = $name->fname." ".$name->mname." ".$name->lname;;
            $released->save();
            event(new ExpensesUpdated($released));
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
        $cash_history->type = "Release Cash - Trips";
        $cash_history->save();

        $user->cashOnHand -= $released->amount;
        $user->save();

        event(new CashierCashUpdated());
        
        $output = array(
            'cashOnHand' => $user->cashOnHand,
            'cashHistory' => $dateTime
        );
        
        echo json_encode($output);
    }
    public function refresh(Request $request){
        $from = $request->date_from;
        $to = $request->date_to;

        if($to==""){
          $trips = DB::table('trips')
            ->join('commodity', 'commodity.id', '=', 'trips.commodity_id')
            ->join('trucks', 'trucks.id', '=', 'trips.truck_id')
            ->join('employee', 'employee.id', '=', 'trips.driver_id')
            ->join('trip_expense', 'trip_expense.trip_id', '=', 'trips.id')
            ->select('trips.id','trips.trip_ticket','trips.laborers','trips.remarks','commodity.name AS commodity_name','trucks.plate_no AS plateno','trips.destination', 'employee.fname','employee.mname','employee.lname', 'trips.num_liters','trucks.name AS name','trips.expense AS expense' ,'trips.created_at AS created_at','trip_expense.status')
            ->whereBetween('trips.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
            ->get();
        }else{
           
              $trips = DB::table('trips')
            ->join('commodity', 'commodity.id', '=', 'trips.commodity_id')
            ->join('trucks', 'trucks.id', '=', 'trips.truck_id')
            ->join('employee', 'employee.id', '=', 'trips.driver_id')
            ->join('trip_expense', 'trip_expense.trip_id', '=', 'trips.id')
            ->select('trips.id','trips.trip_ticket','trips.laborers','trips.remarks','commodity.name AS commodity_name','trucks.plate_no AS plateno','trips.destination', 'employee.fname','employee.mname','employee.lname', 'trips.num_liters','trucks.name AS name','trips.expense AS expense' ,'trips.created_at AS created_at','trip_expense.status')
             ->where('trips.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
             ->where('trips.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
            ->get();
        }
       
        return \DataTables::of($trips)
        ->addColumn('action', function($trips){
            $userid= Auth::user()->id;
            $permit = UserPermission::where('user_id',$userid)->where('permit',1)->where('permission_id',2)->get();
            if($userid!=1){
                $delete=$permit[0]->permit_delete;  
                $edit = $permit[0]->permit_edit;
            }   
            
            if($userid==1){
                 return '<div class="btn-group"><button class="btn btn-xs btn-warning update_pickup waves-effect" id="'.$trips->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;
                     <button class="btn btn-xs btn-danger delete_pickup waves-effect" id="'.$trips->id.'"><i class="material-icons">delete</i></button></div>';
            }
            if($userid!=1 && $delete==1 && $edit==1&&$trips->status=="On-Hand"){
                return '<div class="btn-group"><button class="btn btn-xs btn-warning update_pickup waves-effect" id="'.$trips->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;
                     <button class="btn btn-xs btn-danger delete_pickup waves-effect" id="'.$trips->id.'"><i class="material-icons">delete</i></button></div>';
            }
            if($userid!=1 && $delete==1 && $edit==1&&$trips->status=="Released"){
                return 'Released';
            }
             if($userid!=1 && $delete==0 && $edit==1){
                return '<div class="btn-group"><button class="btn btn-xs btn-warning update_pickup waves-effect" id="'.$trips->id.'"><i class="material-icons">mode_edit</i></button>';
            }
            if($userid!=1 && $delete==1 && $edit==0){
                return '<button class="btn btn-xs btn-danger delete_pickup waves-effect" id="'.$trips->id.'"><i class="material-icons">delete</i></button></div>';
            }
           
        })
        ->editColumn('expense', function ($data) {
            return '₱ '.number_format($data->expense, 2, '.', ',');
        })
         ->editColumn('created_at', function ($data) {
            return date('F d Y, h:i:s A',strtotime($data->created_at));
        })

        ->make(true);
    }

    function updateId(){
        /*$temp = DB::table('trips')
            ->select(DB::raw('max(cast(trip_ticket as Int) as temp)'))
            ->get();*/
       $output = DB::table('trips')->select('trips.*')->latest()->first();
        echo json_encode($output);
     }

     function updatedata(Request $request){
        $id = $request->input('id');
        $output = DB::table('trips')
            ->join('commodity', 'commodity.id', '=', 'trips.commodity_id')
            ->join('trucks', 'trucks.id', '=', 'trips.truck_id')
            ->join('employee', 'employee.id', '=', 'trips.driver_id')
            ->select('trips.id','trips.trip_ticket','trips.laborers','trips.remarks','commodity.id AS commodity_id','trucks.plate_no AS plateno', 'trips.destination', 'employee.id as driver_id', 'employee.fname','employee.mname','employee.lname', 'trips.num_liters', 'trucks.id as truck_id', 'trucks.name AS name','trips.expense')
            ->where('trips.id',$id)
            ->get();
        echo json_encode($output);
    }

    function deletedata(Request $request){
        $trips = trips::find($request->input('id'));
        $trip_expenses =trip_expense::find($request->id);
        $user = User::find(1);  
        $output="success";
        if($trip_expenses->status=="Released"){
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
            $cash_history->cash_change = $trip_expenses->amount;
            $cash_history->total_cash = $user->cashOnHand + $trip_expenses->amount;
            $cash_history->type = "Delete Released Data on - Trips";
            $cash_history->save();
            $user->cashOnHand += $trip_expenses->amount;
            $user->save();
            $output = array(
                'cashOnHand' => $user->cashOnHand,
                'trip_data' => $trips
            );
            $trip_expenses->delete();
            $trips->delete();
        }else{
            $trip_expenses->delete();
            $trips->delete();
        }
        return json_encode($output);
    }
     public function trip_expense_view(Request $request)
    {
       $from = $request->date_from;
       $to = $request->date_to;
       if($to==""&&$from==""){
          $trip_expense = DB::table('trips')
            ->join('trip_expense', 'trip_expense.trip_id', '=', 'trips.id')
            ->select('trip_expense.id','trips.trip_ticket AS trip_id','trips.laborers','trips.remarks','trip_expense.description AS description','trip_expense.type AS type','trip_expense.amount AS amount','trip_expense.status AS status','trip_expense.released_by as released_by','trip_expense.created_at as created_at')
            ->whereBetween('trips.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
            ->get()->sortByDesc('created_at');
        }else{
           
             $trip_expense = DB::table('trips')
            ->join('trip_expense', 'trip_expense.trip_id', '=', 'trips.id')
            ->select('trip_expense.id','trips.trip_ticket AS trip_id','trips.laborers','trips.remarks','trip_expense.description AS description','trip_expense.type AS type','trip_expense.amount AS amount','trip_expense.status AS status','trip_expense.released_by as released_by','trip_expense.created_at as created_at')
                ->where('trip_expense.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
                ->where('trip_expense.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
                      ->get()->sortByDesc('created_at');
        }
      
        return \DataTables::of($trip_expense)
        ->addColumn('action', function($trip_expense){
            if($trip_expense->status=="On-Hand"){
                 return '<button class="btn btn-xs btn-success release_expense waves-effect" id="'.$trip_expense->id.'"><i class="material-icons">eject</i></button>';
            }else{
                 return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$trip_expense->id.'"><i class="material-icons">done_all</i></button>';
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
