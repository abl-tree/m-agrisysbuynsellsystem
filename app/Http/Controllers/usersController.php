<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
use App\Roles;
use App\Employee;
use App\access_levels;
use App\Permission;
use App\UserPermission;
use App\Cash_History;
use Auth;
use DB;
use Carbon\Carbon;
use App\Events\CashierCashUpdated;

class usersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        $employee = Employee::with('cashier')->get();

        return view('settings.users', compact('employee'), ['permissions' => $permissions]);
    }

    public function getBalance(Request $request){
        $user = User::find($request->id);
        $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
        $getDate = Carbon::now();
        $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);

        $output = array(
            'trans_no' => $dateTime,
            'id' => $user->id,
            'access_id' => $user->access_id,
            'username' => $user->username,
            'type' => $user->type
        );
        echo json_encode($output);
    }

    public function addCash(Request $request){
        $user = User::find($request->add_cash_id);
        $previous_cash = $user->cashOnHand;
        $total_cash = $previous_cash + $request->add_cash;
        $user->cashOnHand = $total_cash;
        $user->save();

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
        $cash_history->previous_cash = $previous_cash;
        $cash_history->cash_change = $request->add_cash;
        $cash_history->total_cash = $total_cash;
        if($request->remarks){
            $cash_history->type = "Add Cash (".$request->remarks.")";
        }
        else{
            $cash_history->type = "Add Cash";
        }
        $cash_history->save();

        event(new CashierCashUpdated());

        $output = array(
            'cashOnHand' => $user->cashOnHand,
            'cashHistory' => $dateTime
        );
        
        echo json_encode($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($option = null, Request $request)
    {
        if($option == "permission") {
            $request->validate([
                'id' => 'required'
            ]);

            return User::with('userpermission.permission')->find($request->id);
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->get('button_action') == 'add'){
            $user = new User;
            $user_info = Employee::where('id', '=', $request->emp_id)->first();
            $user->validation('create', $request->all());
            $user->emp_id = $request->emp_id;
            $user->name=  $user_info->fname." ".$user_info->mname." ".$user_info->lname;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->cashOnHand = 0;
            $user->access_id = 2;
            $user->save();

            $userGet = User::where('emp_id', '=', $request->emp_id)->first();
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
            $cash_history->previous_cash = 0;
            $cash_history->cash_change = 0;
            $cash_history->total_cash = 0;
            $cash_history->save();
        }

        if($request->get('button_action') == 'update'){
            $user = new User;
            $user = $user->validation('update', $request->all());
            $user->emp_id = $request->emp_id;
            $user->username = $request->username;
            $cash_history->type = "Add Cash";
            $user->save();
        }

        return response()->json('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    public function refresh()
    {
        // $user = User::where('access_id', '!=', 1)->get();
        return \DataTables::of(User::where('access_id', '!=', 1)->get())
        ->addColumn('action', function($user){
            if(isAdmin()){
                return '
                <button class="btn btn-xs btn-info waves-effect view_cash_history" id="'.$user->id.'" data-toggle="modal" data-target="#cash_view_modal"><i class="material-icons" style="width: 25px;">visibility</i></button>
                <button type="button" class="btn btn-xs btn-success waves-effect open_add_cash_modal" id="'.$user->id.'" data-toggle="modal" data-target="#add_cash_modal"><i class="material-icons">account_balance_wallet</i></button>
                <button class="btn btn-xs btn-info update_user waves-effect" id="'.$user->id.'"><i class="material-icons">mode_edit</i></button>
                <button class="btn btn-xs btn-danger delete_user waves-effect" id="'.$user->id.'"><i class="material-icons">delete</i></button>
                <button type="button" class="btn btn-xs btn-warning waves-effect" data-id="'.$user->id.'" data-toggle="modal" data-target="#user-permission"><i class="material-icons">vpn_key</i></button>';
            }
            else{
                return 'Admin';
            }
        })
        ->editColumn('access_id', function ($data){
            $level = access_levels::all();
            foreach($level as $l){
                if($l->id == $data->access_id)
                    $access_name = $l->name;
            }

            return $access_name;
        })
        ->editColumn('emp_id', function ($data){
            $employee = Employee::where('id', $data->emp_id)->get();            

            foreach($employee as $emp){
                $emp_name = $emp->fname." ".$emp->mname." ".$emp->lname;    
            }

            return $emp_name;
        })   
        ->make(true);
    }

    function updatedata(Request $request){
        $id = $request->input('id');
        $user = User::find($id);
        $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
        $output = array(
            'emp_id' => $user->emp_id,
            'name' => $user->name,
            'username' => $user->username,
            'cash' => $cashLatest
        );
        echo json_encode($output);
    }

    function viewCashHistory(Request $request){
        $to = date('Y-m-d', strtotime("+1 day", strtotime($request->date_to)));
        $id = $request->id;
        $cash_history = Cash_History::with('user')->where('created_at',[$request->date_from,$to])->orderBy('id', 'DESC')->get();
        return \DataTables::of($cash_history)
         ->editColumn('created_at', function ($data) {

                    return date('F d Y, h:i:s A',strtotime($data->created_at));
                })->make(true);
    }

    function deletedata(Request $request){
        $user = User::find($request->input('id'));
        $user->delete();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function permission($option, Request $request) {
        if($option == 'update') {            
            $request->validate([
                'id' => 'required'
            ]);
      
            $authorized = ($request->permission)?$request->permission:array();
            $authorized_delete = ($request->delete_permission)?$request->delete_permission:array();
            $authorized_edit = ($request->edit_permission)?$request->edit_permission:array();
            $permission = array();
            $permissions = Permission::select('id')->whereNotIn('id', $authorized)->get();

            for ($i=1; $i <= 13; $i++){
                UserPermission::updateOrCreate(['permission_id'=>$i, 'user_id'=>$request->id], ['permit' => 0,'permit_delete'=>0,'permit_edit'=>0]);
            } 

            if($authorized) {  
                   foreach ($authorized as $key => $value) {
                     UserPermission::updateOrCreate(['permission_id'=>$authorized[$key], 'user_id'=>$request->id],['permit'=>1]);
                } 
                // foreach ($authorized_edit as $key => $value) {
                //     $per_delete = UserPermission::where('user_id',$$request->id)->where('permit',1)->get();

                //      // UserPermission::find(['permission_id'=>$authorized_edit[$key], 'user_id'=>$authorized_edit[$key]],['permit'=>1,'permit_edit'=>1]);
                // } 
                foreach ($authorized_delete as $key => $value) {
                      $per_delete = UserPermission::where('permission_id',$authorized_delete[$key])->where('permit',1)->where('user_id',$request->id)->first();
                      $per_delete->permit_delete = 1;
                      $per_delete->save();

                } 
                foreach ($authorized_edit as $key => $value) {
                      $per_edit = UserPermission::where('permission_id',$authorized_edit[$key])->where('permit',1)->where('user_id',$request->id)->first();
                      $per_edit->permit_edit = 1;
                      $per_edit->save();
                } 
                
                // if($delete!=null && $edit == null){
                //    foreach ($authorized as $key => $value) {
                //      UserPermission::updateOrCreate(['permission_id'=>$authorized[$key], 'user_id'=>$request->id],['permit'=>1,'permit_delete'=>1]);
                // } 
                // }
                // if($edit&&$delete==null){
                //    foreach ($authorized as $key => $value) {
                //      UserPermission::updateOrCreate(['permission_id'=>$authorized[$key], 'user_id'=>$request->id],['permit'=>1,'permit_edit'=>1]);
                // } 
                // }
                
            }
           
          
                
        
            return $request->id;
        }
    }
}
