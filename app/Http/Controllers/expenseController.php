<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Expense;
use App\User;
use App\Employee;
use App\TripExpense;
use App\Cash_History;
use Auth;
use Carbon\Carbon;
use App\Events\ExpensesUpdated;
use App\UserPermission;
use DB;

class expenseController extends Controller  
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
        return view('main.expense');
    }

    public function isAdmin(){
            
    return Auth::user()->id;
    }
    
     
    public function store(Request $request)
    {
        if($request->get('button_action') == ''){
        $expense = new Expense;
        $expense->trans_number = $request->trans_number;
        $expense->description = $request->expense;
        $expense->type = $request->type;
        $expense->amount = $request->amount;
        $expense->status = "On-Hand";
        $expense->released_by = '';
        $expense->save();
        }
        if($request->get('button_action') == 'update'){
        $expense = Expense::find($request->get('id'));  
        $expense->description = $request->expense;
        $expense->type = $request->type;
        $expense->amount = $request->amount;
        $expense->save();          
        }
    }

    function getNumber(){
        $temp = DB::select('select MAX(id) as "temp" FROM expenses');
        echo json_encode($temp);
    }

    public function release_update_normal(Request $request){
        $check_admin =Auth::user()->id;
        if($check_admin==1){
            $logged_id = Auth::user()->name;
            $user = User::find(Auth::user()->id);
            $released = expense::find($request->id);
            $released->status = "Released";
            $released->released_by = $logged_id;
            $released->save();
            event(new ExpensesUpdated($released));
        }else{
            $logged_id = Auth::user()->emp_id;
            $name= Employee::find($logged_id);
            $user = User::find(Auth::user()->id);
            $released = expense::find($request->id);
            $released->status = "Released";
            $released->released_by = $name->fname." ".$name->mname." ".$name->lname;
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
        $cash_history->type = "Release Cash - Expense";
        $cash_history->save();

        $user->cashOnHand -= $released->amount;
        $user->save();
        
        $output = array(
            'cashOnHand' => $user->cashOnHand,
            'cashHistory' => $dateTime
        );
        echo json_encode($output);
    }

    public function check_balance(Request $request){
        $user = User::find(Auth::user()->id);
        $expense = Expense::find($request->id);

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

    public function check_balance2(Request $request){
        $user = User::find(Auth::user()->id);
        $expense = TripExpense::find($request->id);

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
        $expense = Expense::find($id);
        $output = array(
            'trans_number' => $expense->trans_number,
            'description' => $expense->description,
            'type' => $expense->type,
            'amount' => $expense->amount
        );
        echo json_encode($output);
    }

    function deletedata(Request $request){
        $expense = Expense::find($request->input('id'));
        $user = User::find(Auth::user()->id);
        if($expense->status=="Released"){
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
            $cash_history->cash_change = $expense->amount;
            $cash_history->total_cash = $user->cashOnHand + $expense->amount;
            $cash_history->type = "Released Expense Deleted";
            $cash_history->save();

            $user->cashOnHand += $expense->amount;
            $user->save();
            
            $output = array(
                'cashOnHand' => $user->cashOnHand,
                'cashHistory' => $dateTime
            );
            $expense->delete();
            echo json_encode($output);
        }else{
            $expense->delete();
            return json_encode($expense);
        }
        
       
    }

    public function refresh(Request $request){ 

                 
   
    
      $from = $request->date_from;
      $to = $request->date_to;    
        if($to==""){
        $expense = DB::table('expenses')
        ->whereBetween('expenses.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])->latest();
        }else{
           
             $expense = Expense::where('created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
                ->where('created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
                ->latest();
        }
          
       return \DataTables::of($expense)
       ->addColumn('action', function($expense){
            $userid= Auth::user()->id;
            $permit = UserPermission::where('user_id',$userid)->where('permit',1)->where('permission_id',1)->get();
            if($userid!=1){
                 $delete=$permit[0]->permit_delete;  
                 $edit = $permit[0]->permit_edit;  
            }             
            if($expense->status=="On-Hand" && isAdmin()==1 ){
                 return '<button class="btn btn-xs btn-success release_expense_normal waves-effect" id="'.$expense->id.'"><i class="material-icons">eject</i></button>&nbsp;<button class="btn btn-xs btn-warning update_expense waves-effect" id="'.$expense->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;<button class="btn btn-xs btn-danger delete_expense waves-effect" id="'.$expense->id.'"><i class="material-icons">delete</i></button>';
            }elseif($expense->status=="On-Hand" && isAdmin()!=1 && $delete==1 && $edit==0){
                 return '<button class="btn btn-xs btn-success release_expense_normal waves-effect" id="'.$expense->id.'"><i class="material-icons">eject</i></button>&nbsp;<button class="btn btn-xs btn-danger delete_expense waves-effect" id="'.$expense->id.'"><i class="material-icons">delete</i></button>';
             
            }elseif($expense->status=="On-Hand" && isAdmin()!=1  && $delete==0 && $edit==1){
               
                return '<button class="btn btn-xs btn-success release_expense_normal waves-effect" id="'.$expense->id.'"><i class="material-icons">eject</i></button>&nbsp;<button class="btn btn-xs btn-warning update_expense waves-effect" id="'.$expense->id.'"><i class="material-icons">mode_edit</i></button>';
         
            }elseif($expense->status=="On-Hand" && isAdmin()!=1 && $delete==1 && $edit==1){
                 return '<button class="btn btn-xs btn-success release_expense_normal waves-effect" id="'.$expense->id.'"><i class="material-icons">eject</i></button>&nbsp;<button class="btn btn-xs btn-warning update_expense waves-effect" id="'.$expense->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;<button class="btn btn-xs btn-danger delete_expense waves-effect" id="'.$expense->id.'"><i class="material-icons">delete</i></button>';
            }
            elseif($expense->status=="On-Hand" && isAdmin()!=1 &&  $delete==0 && $edit==0){
                 return '<button class="btn btn-xs btn-success release_expense_normal waves-effect" id="'.$expense->id.'"><i class="material-icons">eject</i></button>';
            }
            else if($expense->status=="Released" && isAdmin()==1 ){
                 return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$expense->id.'"><i class="material-icons">done_all</i></button>&nbsp;<button class="btn btn-xs btn-danger delete_expense waves-effect" id="'.$expense->id.'"><i class="material-icons">delete</i></button>';
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

    public function autoComplete(Request $request){
        $query = $request->get('term','');

        $products=Employee::where('fname','LIKE','%'.$query.'%')->orWhere('mname','LIKE','%'.$query.'%')->orWhere('lname','LIKE','%'.$query.'%')->get();

        $data=array();
        foreach ($products as $product){
            $data[]=array('value'=>$product->fname.' '.$product->mname.' '.$product->lname,'id'=>$product->id);
        }
        if(count($data))
        return $data;
    }


}
