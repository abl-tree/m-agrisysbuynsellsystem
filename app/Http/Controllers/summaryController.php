<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Commodity;
use App\sales;
use App\purchases;
use App\Company;
use Carbon\Carbon;
use App\Events\SalesUpdated;
use Auth;
use App\UserPermission;
class summaryController extends Controller
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

        // $driver= DB::table('employee')
          //  ->join('roles', 'roles.id', '=', 'employee.role_id')
          //  ->select('employee.*','employee.id AS emp_id',  'roles.id','roles.role')
          //  ->where('roles.role','LIKE','%driver%')
          //  ->get();

        $commodity = Commodity::all();
        $company = Company::all();

        return view('main.summary')->with(compact('commodity','company'));
    }

    public function store(Request $request)
    {
          if($request->get('button_action') == 'add'){
            $sales= new sales;
            $sales->trans_number = $request->trans_num;
            $sales->commodity_id = $request->commodity;
            $sales->company_id = $request->company;
            $sales->kilos = $request->kilos;
            $sales->price = $request->price;
            $sales->amount = $request->amount;
            $sales->receiver_id = Auth::user()->id;
            if( $request->checknumber!=""){
                $sales->check_number = $request->checknumber;
            }
            else{
                $sales->check_number = "Not Specified";
            }
            $sales->save();
          }

        if($request->get('button_action') == 'update'){
          $sales= new sales;
          $sales= sales::find($request->get('id'));
          $sales->trans_number = $request->trans_num;
          $sales->commodity_id = $request->commodity;
          $sales->company_id = $request->company;
          $sales->kilos = $request->kilos;
          $sales->price = $request->price;
          $sales->amount = $request->amount;
          $sales->receiver_id = Auth::user()->id;
            if( $request->checknumber!=""){
                $sales->check_number = $request->checknumber;
            }
            if( $request->checknumber==""){
                $sales->check_number = "Not Specified";
            }
          $sales->save();
        }

        //$totalSalesToday = sales::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(amount) AS total_sales')]);
        
        event(new SalesUpdated($sales));
    }
     function getSales(Request $request){
        
        $salesLatest = sales::orderBy('id', 'DESC')->first();
        if($salesLatest==null){
          $getDate = Carbon::now();
        $dateTime = $getDate->year.$getDate->month.$getDate->day."1";
         $output = array(
            'trans_no' => $dateTime
            
        );
        return json_encode($output);

        }else{
        $getDate = Carbon::now();
        $dateTime = $getDate->year.$getDate->month.$getDate->day.($salesLatest->id+1);
         $output = array(
            'trans_no' => $dateTime
            
        );
        return json_encode($output);
      }
     }

    function updatedata(Request $request){
        $id = $request->input('id');
        $sales = sales::find($id);
        $output = array(
            'trans_number' => $sales->trans_number,
            'commodity_id' => $sales->commodity_id,
            'company_id' => $sales->company_id,
            'kilos' => $sales->kilos,
            'amount' => $sales->amount,
            'price' => $sales->price,
            'check_number' => $sales->check_number ,
        );
        echo json_encode($output);
    }

    function deletedata(Request $request){
        $sales = sales::find($request->input('id'));
        $sales->delete();
    }

    public function refresh(Request $request)
    {
        $from = $request->date_from;
        $to = $request->date_to; 
        $commodity= $request->commodity;
        $type= $request->type;
        if($to==null&&$commodity==null){
         $ultimatesickquery=  DB::table('purchases')
         ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
         ->select(\DB::raw('purchases.commodity_id as commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name, purchases.price as price'))
         ->groupBy(\DB::raw('commodity_id, price'))
         ->where('status','=','Released')
         ->whereBetween('purchases.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
         ->get();

         info($ultimatesickquery);
        }
        // if($commodity==""&&$to!=null){
        //     $ultimatesickquery=  DB::table('purchases')
        //     ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
        //     ->select(\DB::raw('commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name,commodity.price as price'))
        //     ->groupBy(\DB::raw('commodity_id'))
        //     ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
        //     ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
        //     ->get();                      
        // } 
        if($type==null||$type=="All"){
            if($commodity==null&&$to!==null){
                $ultimatesickquery=  DB::table('purchases')
                ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
                ->select(\DB::raw('purchases.commodity_id as commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name, purchases.price as price'))
                ->groupBy(\DB::raw('commodity_id, price'))
                ->where('status','=','Released')
                ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
                ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
                ->get();                
            }    
         if($commodity!="All"&&$commodity!=null&&$to!=null){
            $ultimatesickquery=  DB::table('purchases')
            ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
            ->select(\DB::raw('purchases.commodity_id as commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name, purchases.price as price'))
            ->groupBy(\DB::raw('commodity_id, price'))
            ->where('status','=','Released')
            ->whereIn('commodity.name',$commodity)
            ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
            ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
            ->get();                
        }   
         if($commodity!="All"&&$to==null&&$commodity!=null){
            $ultimatesickquery=  DB::table('purchases')
            ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
            ->select(\DB::raw('purchases.commodity_id as commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name, purchases.price as price'))
            ->groupBy(\DB::raw('commodity_id, price'))
            ->where('status','=','Released')
            ->whereIn('commodity.name',$commodity)
            ->whereBetween('purchases.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
            ->get();                
        } 
        if($commodity=="All"&&$to==null){
            $ultimatesickquery=  DB::table('purchases')
            ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
            ->select(\DB::raw('purchases.commodity_id as commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name, purchases.price as price'))
            ->groupBy(\DB::raw('commodity_id, price'))
            ->where('status','=','Released')
            ->whereBetween('purchases.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
            ->get();                
        }    
        if($commodity=="All"&&$to!=null){
            $ultimatesickquery=  DB::table('purchases')
            ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
            ->select(\DB::raw('purchases.commodity_id as commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name, purchases.price as price'))
            ->groupBy(\DB::raw('commodity_id, price'))
            ->where('status','=','Released')
            ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
            ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
            ->get();                
        } 
        
    }
        /// DIRI SUGOD
        if($type=="Price"){
        if($commodity!="All"&&$to==null&&$commodity!=null){
            $ultimatesickquery=  DB::table('purchases')
            ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
            ->select(\DB::raw('commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name,commodity.price as price'))
            ->groupBy(\DB::raw('purchases.price'))
            ->where('status','=','Released')
            ->whereIn('commodity.name',$commodity)
            ->whereBetween('purchases.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
            ->get();                
        } 
        if($commodity=="All"||$commodity==null&&$to!=null){

            $ultimatesickquery=  DB::table('purchases')
            ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
            ->select(\DB::raw('commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name,purchases.price as price'))
            // ->groupBy(\DB::raw('commodity_id'))
            ->groupBy(\DB::raw('purchases.price'))
            ->where('status','=','Released')
            // ->where('commodity.name',$commodity)
            ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
            ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
            ->get();                
        }   
        if($commodity=="All"&&$to!=null){
            
            $ultimatesickquery=  DB::table('purchases')
            ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
            ->select(\DB::raw('commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name,purchases.price as price'))
            // ->groupBy(\DB::raw('commodity_id'))
            ->groupBy(\DB::raw('purchases.price'))
            ->where('status','=','Released')
            ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
            ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
            ->get();                
        }   

        if($commodity!="All"&&$commodity!=null&&$to!=null){
            
            $ultimatesickquery=  DB::table('purchases')
            ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
            ->select(\DB::raw('commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name,purchases.price as price'))
            // ->groupBy(\DB::raw('commodity_id'))
            ->groupBy(\DB::raw('commodity_id,purchases.price'))
            ->where('status','=','Released')
            ->whereIn('commodity.name',$commodity)
            ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
            ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
            ->get();                
        }   
        
        //  if($commodity!="All"&&$to==null&&$commodity!=null){
        //     $ultimatesickquery=  DB::table('purchases')
        //     ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
        //     ->select(\DB::raw('commodity_id, SUM(net) as net_weight,SUM(total) as total,commodity.name as commodity_name,commodity.price as price'))
        //     ->groupBy(\DB::raw('commodity_id'))
        //     ->where('commodity.name',$commodity)
        //     ->whereBetween('purchases.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
        //     ->get();                
        // } 
    }
        // dd($ultimatesickquery);
        // var_dump($ultimatesickquery);
        // $ultimatesickquery->offsetSet('data_range', array('g1', 'g2'));
        //  dd($ultimatesickquery);
        return \DataTables::of($ultimatesickquery)
        // ->addColumn('action', function(  $ultimatesickquery){
        //     $userid= Auth::user()->id;
        //     $permit = UserPermission::where('user_id',$userid)->where('permit',1)->where('permission_id',7)->get();
        //     if($userid!=1){
        //       $delete=$permit[0]->permit_delete;  
        //       $edit = $permit[0]->permit_edit;
        //     }   
            
        //     if($userid==1){
        //        return '<div class="btn-group"><button class="btn btn-xs btn-warning update_sales  waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;
        //         <button class="btn btn-xs btn-danger delete_sales  waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button></div>';
        //     }
        //     if($userid!=1 && $delete==1 && $edit==1){
        //        return '<div class="btn-group"><button class="btn btn-xs btn-warning update_sales  waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;
        //         <button class="btn btn-xs btn-danger delete_sales  waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button></div>';
        //     }  
        //     if($userid!=1 && $delete==0 && $edit==1){
        //        return '<div class="btn-group"><button class="btn btn-xs btn-warning update_sales  waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>
        //         </div>';
        //     }if($userid!=1 && $delete==1 && $edit==0){
        //        return '<div class="btn-group">
        //         <button class="btn btn-xs btn-danger delete_sales  waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button></div>';
        //     }if($userid!=1 && $delete==0 && $edit==0){
        //        return 'No Action Permitted';
        //     }        
           
        // })
        // ->editColumn('amount', function ($data) {
        //     return '₱'.number_format($data->amount, 2, '.', ',');
        // })
        ->editColumn('commodity_name', function ($data) {
            return $data->commodity_name." (".$data->price.")";
        })
        ->editColumn('net_weight', function ($data) {
            return number_format($data->net_weight, 2, '.', ',');
        })
        ->editColumn('total', function ($data) {
            return '₱ '.number_format($data->total, 2, '.', ',');
        })
        // ->editColumn('price', function ($data) {
        //     return '₱ '.number_format($data->price, 2, '.', ',');
        // })
         ->editColumn('created_at', function ($data) {
            return "maoni";
        })
        ->make(true);

    }
}
