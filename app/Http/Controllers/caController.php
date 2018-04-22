<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\ca;
use App\Customer;
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
    public function index(){
        $customer = Customer::all();

        return view('main.ca', compact('customer'));
    }

    public function store(Request $request){
        $ca = new ca;
        $ca->customer_id = $request->customer_id;
        $ca->reason = $request->reason;
        $ca->amount = $request->amount;
        $ca->balance = $request->balance + $request->amount;
        $ca->save();
    }

    public function refresh(){
        $join = DB::table('cash_advance')
            ->select(DB::raw('max(created_at) as maxdate'), 'customer_id')
            ->groupBy('customer_id');
        $sql = '(' . $join->toSql() . ') as ca2';

        $cash_advance = DB::table('cash_advance as ca1')
            ->select('ca1.*', 'cus.fname', 'cus.mname', 'cus.lname')
            ->join(DB::raw($sql), function($join){
                $join->on('ca2.customer_id', '=', 'ca1.customer_id')
                    ->on('ca2.maxdate', '=', 'ca1.created_at');
            })
            ->leftJoin('customer as cus', 'ca1.customer_id', '=', 'cus.id')
            ->orderBy('p1.created_at', 'desc')
            ->get();
        return \DataTables::of($cash_advance)
        ->addColumn('action', function($cash_advance){
            return '<button class="btn btn-xs btn-info view_cash_advance" id="'.$cash_advance->customer_id.'"><i class="material-icons" style="width: 25px;">visibility</i></button>';//info/visibility
        })
        ->make(true);
    }

    public function refresh_view(Request $request){
        $id = $request->input('id');
        $cash_advance = DB::table('cash_advance')
            ->join('customer', 'customer.id', '=', 'cash_advance.customer_id')
            ->select('cash_advance.customer_id', 'customer.fname', 'customer.mname', 'customer.lname', 'cash_advance.reason', 'cash_advance.amount', 'cash_advance.created_at', 'cash_advance.balance')
            ->where('cash_advance.customer_id', $id)
            ->get();
        return \DataTables::of($cash_advance)
        ->make(true);
        echo json_encode($cash_advance);
    }

    public function check_balance(Request $request){
        $balance = ca::where('customer_id', $request->id)->orderBy('customer_id', 'desc')->latest()->get();
        echo json_encode($balance);
    }
}
