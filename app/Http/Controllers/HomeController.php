<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\UserPermission;
use App\paymentlogs;
use App\customer;
use App\commodity;
use App\trucks;
use App\purchases;
use App\sales;
use App\balance;
use App\expense;
use App\trip_expense;
use App\ca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Response;
use View;
use Carbon\Carbon;


class HomeController extends Controller
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
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        $paymentLogs = paymentlogs::orderBy('id', 'desc')->paginate(5);
        $commodityList = commodity::orderBy('id', 'desc')->paginate(6);
        $truckList = trucks::orderBy('id', 'desc')->paginate(6);
        $latestPurchases = purchases::orderBy('id', 'desc')->paginate(15);
        $topCommodities = purchases::groupBy('commodity_id')
            ->orderBy(DB::raw('SUM(total)'), 'desc')
            ->limit(6)
            ->get(['commodity_id', DB::raw('SUM(total) AS total')]);
        $latestCustomer = customer::latest()->first();

        $totalSalesYear = sales::whereYear('created_at', Carbon::today()->year)->get([DB::raw('SUM(amount) AS total_sales')]);
        $totalPurchasesYear = purchases::whereYear('created_at', Carbon::today()->year)->get([DB::raw('SUM(total) AS total_purchases')]);
        
        $balanceYear = ca::whereYear('created_at', Carbon::today()->year)->get([DB::raw('SUM(amount) AS amount')]);
        $paymentYear1 = paymentlogs::whereYear('created_at', Carbon::today()->year)->get([DB::raw('SUM(paymentamount) AS amount')]);
        $paymentYear2 = purchases::whereYear('created_at', Carbon::today()->year)->get([DB::raw('SUM(partial) AS amount')]);
        $totalBalanceYear = 0;
        $totalBalanceYear = $balanceYear[0]->amount - ($paymentYear1[0]->amount + $paymentYear2[0]->amount);
        
        $totalExpenseYear = expense::whereYear('created_at', Carbon::today()->year)->get([DB::raw('SUM(amount) AS total_expense')]);
        $totalTripExpenseYear = trip_expense::whereYear('created_at', Carbon::today()->year)->get([DB::raw('SUM(amount) AS total_trip_expense')]);
        $finalTotalExpenseYear = 0;
        $finalTotalExpenseYear = $totalExpenseYear[0]->total_expense + $totalTripExpenseYear[0]->total_trip_expense;

        $totalSalesMonth = sales::whereMonth('created_at', Carbon::today()->month)->get([DB::raw('SUM(amount) AS total_sales')]);
        $totalPurchasesMonth = purchases::whereMonth('created_at', Carbon::today()->month)->get([DB::raw('SUM(total) AS total_purchases')]);
        
        $balanceMonth = ca::whereMonth('created_at', Carbon::today()->month)->get([DB::raw('SUM(amount) AS amount')]);
        $paymentMonth1 = paymentlogs::whereMonth('created_at', Carbon::today()->month)->get([DB::raw('SUM(paymentamount) AS amount')]);
        $paymentMonth2 = purchases::whereMonth('created_at', Carbon::today()->month)->get([DB::raw('SUM(partial) AS amount')]);
        $totalBalanceMonth = 0;
        $totalBalanceMonth = $balanceMonth[0]->amount - ($paymentMonth1[0]->amount + $paymentMonth2[0]->amount);
        
        $totalExpenseMonth = expense::whereMonth('created_at', Carbon::today()->month)->get([DB::raw('SUM(amount) AS total_expense')]);
        $totalTripExpenseMonth = trip_expense::whereMonth('created_at', Carbon::today()->month)->get([DB::raw('SUM(amount) AS total_trip_expense')]);
        $finalTotalExpenseMonth = 0;
        $finalTotalExpenseMonth = $totalExpenseMonth[0]->total_expense + $totalTripExpenseMonth[0]->total_trip_expense;

        $totalSalesToday = sales::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(amount) AS total_sales')]);
        $totalPurchasesToday = purchases::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(total) AS total_purchases')]);
        $totalBalanceToday = balance::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(balance) AS total_balance')]);
        $totalExpenseToday = expense::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(amount) AS total_expense')]);
        $totalTripExpenseToday = trip_expense::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(amount) AS total_trip_expense')]);

        $finalTotalExpenseToday = $totalExpenseToday[0]->total_expense + $totalTripExpenseToday[0]->total_trip_expense;

        if($user->role->name === "admin") {
            return view('main.home', compact('paymentLogs', 'commodityList', 'truckList', 'latestPurchases', 'topCommodities', 'latestCustomer', 'totalSalesYear', 'totalPurchasesYear', 'totalBalanceYear', 'finalTotalExpenseYear', 'totalSalesToday', 'totalPurchasesToday', 'totalBalanceToday', 'finalTotalExpenseToday', 'totalSalesMonth', 'totalPurchasesMonth', 'totalBalanceMonth', 'finalTotalExpenseMonth'));
        } else if($user->role->name === "user") {
            $permissions = UserPermission::with('permission')->where('user_id', $id)->orderBy('permission_id')->get();
            
            return view('cashier.home', compact('permissions'));
        }
    }

    public function sales_today(){
        $totalSalesToday = sales::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(amount) AS amount')]);
        
        if($totalSalesToday[0]->amount){
            return $totalSalesToday;
        }else{
            $arr = array('amount' => 0);
            return response()->json([
                $arr
            ]);
        }
    }

    public function purchases_today(){
        $totalPurchasesToday = purchases::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(total) AS total')]);
        
        if($totalPurchasesToday[0]->total){
            return $totalPurchasesToday;
        }else{
            $arr = array('total' => 0);
            return response()->json([
                $arr
            ]);
        }
    }

    public function balance_today(){
        $balanceToday = ca::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(amount) AS amount')]);
        $paymentToday1 = paymentlogs::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(paymentamount) AS amount')]);
        $paymentToday2 = purchases::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(partial) AS amount')]);
        
        $totalBalanceToday = 0;
        $totalBalanceToday = $balanceToday[0]->amount - ($paymentToday1[0]->amount + $paymentToday2[0]->amount);
        $arr = array('amount' => $totalBalanceToday);
        return response()->json([
            $arr
        ]);
    }

    public function expenses_today(){
        $totalExpenseToday = expense::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(amount) AS total_expense')]);
        $totalTripExpenseToday = trip_expense::whereDate('created_at', Carbon::today())->get([DB::raw('SUM(amount) AS total_trip_expense')]);

        $finalTotalExpenseToday = 0;
        $finalTotalExpenseToday = $totalExpenseToday[0]->total_expense + $totalTripExpenseToday[0]->total_trip_expense;
        $arr = array('amount' => $finalTotalExpenseToday);
        return response()->json([
            $arr
        ]);
    }


}
