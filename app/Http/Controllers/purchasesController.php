<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Commodity;
use App\Customer;
use App\ca;
use App\balance;
use App\purchases;
use App\Employee;
use Auth;
use App\paymentlogs;
use App\Notification;
use App\UserPermission;
use App\User;
use App\Cash_History;
use App\Roles;
use Carbon\Carbon;
use App\Events\PurchasesUpdated;
use App\Events\BalanceUpdated;
use App\Events\CashierCashUpdated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
class purchasesController extends Controller
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

        $commodity = Commodity::all();
        $customer = Customer::all();
        $ca = ca::all();

        return view('main.purchases')->with(compact('commodity','customer','ca'));
    }

    function findAmount(Request $request){
        $id = $request->input('id');
        $balance = balance::where('customer_id', '=', $id)
            ->first();
        // dd($balance);
        $customer = Customer::where('id', '=', $id)
            ->first();
        if($balance!=null){
            $output = array(
                'balance' => $balance->balance,
                'suki_type'=> $customer->suki_type,
            );
    
            echo json_encode($output);
        }else{
            $output = array(
                'balance' => 0,
                'suki_type'=> $customer->suki_type,
            );
    
            echo json_encode($output);
        }
      
    }

    function findcomm(Request $request){
        $id = $request->input('id');

        $commodity = Commodity::where('id', '=', $id)
            ->first();

        $output = array(
            'price'=> $commodity->price,
            'suki_price'=> $commodity->suki_price,
        );

        echo json_encode($output);
    }

    public function check_balance3(Request $request){
        $user = User::find(Auth::user()->id);
        $expense = purchases::find($request->id);

        if($user->cashOnHand < $expense->amtpay){
            return 0;
        }
        else{
            if($expense->status == 'Released'){
                return 2;
            }
            return 1;
        }
    }


    public function store(Request $request){

        
        if($request->get('button_action1') == 'add' && $request->get('stat1') == 'old'){
            
            $purchases= new Purchases;
            $purchases->trans_no = $request->ticket;
            $purchases->customer_id = $request->customer;
            $purchases->commodity_id= $request->commodity;
            $purchases->sacks = $request->sacks;
            $purchases->ca_id = $request->customer;
            if ($request->cash != ""){
                $purchases->balance_id = $request->cash;
            }
            else if ($request->cash == ""){
                $purchases->balance_id = 0;
            }
            if ($request->partial != ""){
                $purchases->partial = $request->partial;
            }
            else if ($request->partial == ""){
                $purchases->partial = 0;
            }
            $purchases->previous_bal = $request->ca;
            $purchases->kilo = $request->kilo;
            $purchases->price = $request->price;
            $purchases->type = $request->type1;
            $purchases->tare = $request->tare;
            $purchases->moist = $request->moist;
            $purchases->net = $request->net;
            $purchases->total = $request->total;
            $purchases->amtpay= $request->amount;
            $purchases->remarks= $request->remarks;
            $purchases->status = "On-Hand";
            $purchases->released_by='';
            $purchases->save();
            // if ($request->cash != ""){
            //     $balance = balance::where('customer_id', $request->customer)->increment('balance',$request->cash);
            // }
            // if (intval($request->partial) != 0 && intval($request->cash) <= 0 ){
            //     $balance = balance::where('customer_id', $request->customer)->decrement('balance',$request->partial);
            // }
         
            // if( $request->partial > 0){
            //     $paymentlogs = new paymentlogs;
            //     $paymentlogs->logs_id = $request->customer;
            //     $paymentlogs->paymentmethod = 'FROM PURCHASE CA';
            //     $paymentlogs->checknumber = "Not Specified";
            //     $paymentlogs->paymentamount = $request->partial;
            //     $paymentlogs->save();
            //     event(new BalanceUpdated($paymentlogs));
            // }
        }
        if($request->get('button_action1') == 'update'){
            $check_admin =Auth::user()->access_id;
            $purchases=  Purchases::find($request->get('id'));
            $ca =  ca::where('pid',$request->get('id'))->first();
            if($ca->status == 'Released'){
                $balance1 = balance::where('customer_id', $ca->customer_id)->first();   
                $balance1->balance =  $request->balance;
                $balance1->save();
              
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

                $previousCash = $user->cashOnHand;

                $user->cashOnHand = $user->cashOnHand  - $request->cash + $request->partial + $ca->amount;
                
                $cash_history->trans_no = $dateTime;
                $cash_history->previous_cash = $previousCash;
                $cash_history->cash_change = $previousCash - $user->cashOnHand;
                $cash_history->total_cash = $user->cashOnHand;
                $cash_history->type = "Adjustment - Purchases";
                $cash_history->save();
                
                $user->save();

                
            }
            $ca->amount = $request->cashLAST - $request->partialLAST + $request->cash - $request->partial;
            $ca->save();
        
            if($purchases->status=="Released"&&$check_admin==1){
            $purchases->trans_no = $request->ticket;
            $purchases->customer_id = $request->customerID;
            $purchases->commodity_id= $request->commodityID;
            $purchases->sacks = $request->sacks;
            $purchases->ca_id = $request->caID;
            if ($request->cash != ""){
                $purchases->balance_id = $request->cash;
            }
            else if ($request->cash == ""){
                $purchases->balance_id = 0;
            }
            if ($request->partial != ""){
                $purchases->partial = $request->partial;
            }
            else if ($request->partial == ""){
                $purchases->partial = 0;
            }
            $purchases->previous_bal = $request->ca;
            $purchases->kilo = $request->kilo;
            $purchases->type = $request->type1;
            $purchases->tare = $request->tare;
            $purchases->moist = $request->moist;
            $purchases->net = $request->net;
            $purchases->price = $request->price;
            $purchases->total = $request->total;
            $purchases->amtpay= $request->amount;
            $purchases->remarks= $request->remarks;
            // $purchases->status = "On-Hand";
            $purchases->released_by='';
            $purchases->save();
           
            $user = User::find(Auth::user()->id);
            $output =  $user->cashOnHand;
            return  $output; 
            }else if($purchases->status=="On-Hand"){
            $purchases->trans_no = $request->ticket;
            $purchases->customer_id = $request->customerID;
            $purchases->commodity_id= $request->commodityID;
            $purchases->sacks = $request->sacks;
            $purchases->ca_id = $request->caID;
            if($request->cash != "" && $request->cash != $purchases->balance_id){
                $purchases->balance_id = $request->cash;
            }
            if($request->partial != "" && $request->partial != $purchases->partial){
                $purchases->partial = $request->partial;
            }
            $purchases->previous_bal = $request->ca;
            $purchases->kilo = $request->kilo;
            $purchases->type = $request->type1;
            $purchases->tare = $request->tare;
            $purchases->moist = $request->moist;
            $purchases->net = $request->net;
            $purchases->price = $request->price;
            $purchases->total = $request->total;
            $purchases->amtpay= $request->amount;
            $purchases->remarks= $request->remarks;
            $purchases->status = "On-Hand";
            $purchases->released_by='';
            $purchases->save();

            // if($request->partial == 0){
            //     $balance = balance::where('customer_id', $request->customerID)->increment('balance',$request->partialLAST); 
            // }
            // if($request->cash == 0){
            //     $balance = balance::where('customer_id', $request->customerID)->decrement('balance',$request->cashLAST); 
            // }
            // $balance = balance::where('customer_id', $request->customerID)->decrement('balance',$request->partial); 
            // $balance = balance::where('customer_id', $request->customerID)->increment('balance',$request->cash);    
            }else if($purchases->status=="Released"&&$check_admin!=1){
                $user = User::find(Auth::user()->id);
                $output =  $user->cashOnHand;
                return  $output; 
            }
           
        }

        if( $request->get('stat') == 'new'){
            $customer = new Customer;
            $customer1 = $customer->where('fname', '=', $request->fname)
            ->where('mname', '=', $request->mname)
            ->where('lname', '=', $request->lname)
            ->count();
            $customer->fname = $request->fname;
            $customer->mname = $request->mname;
            $customer->lname = $request->lname;
             
            if($customer1 > 0){
                return response('Customer already exists!', 500);
            }
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

            $balance = new balance;
            $balance->customer_id = $customer->id;
            $balance->balance = 0;
            $balance->logs_ID = $customer->id;
            $balance->save();

            $purchases= new Purchases;
            $purchases->trans_no = $request->ticket1;
            $purchases->customer_id = $request->customerid;
            $purchases->commodity_id= $request->commodity1;
            $purchases->sacks = $request->sacks1;
            $purchases->ca_id = $request->customerid;
            if ($request->bal != ""){
                $purchases->balance_id = $request->bal;
            }
            else if ($request->bal == ""){
                $purchases->balance_id = 0;
            }
            if ($request->partialpayment != ""){
                $purchases->partial = $request->partialpayment;
            }
            else if ($request->partialpayment == ""){
                $purchases->partial = 0;
            }
            $purchases->kilo = $request->kilo1;
            $purchases->type = $request->type2;
            $purchases->tare = $request->tare2;
            $purchases->net = $request->net2;
            $purchases->moist = $request->moist2;
            $purchases->price = $request->price1;
            $purchases->total = $request->amount1;
            $purchases->amtpay= $request->amountpay1;
            $purchases->remarks= $request->remarks1;
            $purchases->status = "On-Hand";
            $purchases->released_by='';
            $purchases->save();
            
            if($request->bal > 0){
                $ca = new ca;
                $ca->pid = $purchases->id;
                $ca->customer_id = $request->customerid;
                if ($request->bal != ""){
                    $ca->amount =   $request->bal;
                }   
                else if ($request->bal == ""){
                    $ca->amount = 0;
                    $ca->balance = 0;
                }
                if ($request->partialpayment == ""){
                    $ca->amount = $request->bal;
                }
                if ($request->bal != "" && $request->partialpayment != ""){
                    $ca->amount = $request->bal - $request->partialpayment ;
                }
                if($ca->amount > 0 ){
                    $ca->reason = "FROM PURCHASE (Cash Advance)";
                }
                else{
                    $ca->reason = "FROM PURCHASE (Cash Advance PHP ".$ca->bal.")";
                }
                $ca->status = "On-Hand";
                $ca->released_by = '';
                $ca->save();
            }
            if( $request->partialpayment > 0){
                $paymentlogs = new paymentlogs;
                $paymentlogs->logs_id = $request->customerid;
                $paymentlogs->paymentmethod = 'FROM PURCHASE CA';
                $paymentlogs->checknumber = "Not Specified";
                $paymentlogs->paymentamount = $request->partialpayment;
                $paymentlogs->save();
                event(new BalanceUpdated($paymentlogs));
            }
                
            if($request->cash > 0) {
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
        $user = User::find(Auth::user()->id);
        $output =  $user->cashOnHand;
        return $output; 
    }

public function release_purchase(Request $request){
    $check_admin = Auth::user()->access_id;
    $released = purchases::find($request->id);
    $user = User::find(Auth::user()->id);
    $fullname = $user->name;
    
    if($released->status == 'Released'){
        echo json_encode(['success' => false]);
        return;
    }
    
    try {
        DB::beginTransaction();
        
        // Update purchase status
        $released->status = "Released";
        $released->released_by = $fullname;
        
        // Handle related CA
        $releasedCA = ca::where('pid', $released->id)->first();
        if($releasedCA){
            $releasedCA->status = "Released";
            $releasedCA->released_by = $fullname;
            $releasedCA->save();
            balance::where('customer_id', $releasedCA->customer_id)->increment('balance', $releasedCA->amount);
        }
        
        $released->save();
        
        // Create cash history BEFORE updating user cash
        $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
        $getDate = Carbon::now();
        
        if($cashLatest != null){
            $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
        } else {
            $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
        }
        
        $cash_history = new Cash_History;
        $cash_history->user_id = $user->id;
        $cash_history->trans_no = $dateTime;
        $cash_history->previous_cash = $user->cashOnHand;
        $cash_history->cash_change = $released->amtpay;
        $cash_history->total_cash = $user->cashOnHand - $released->amtpay;
        $cash_history->type = "Release Cash - Purchases";
        $cash_history->save();
        
        // Update user cash
        $user->cashOnHand -= $released->amtpay;
        $user->save();
        
        // Handle balance_id cash advance
        if(intval($released->balance_id) > 0){    
            $ca = new ca;
            $ca->pid = $released->id;
            $ca->customer_id = $released->customer_id;
            $ca->amount = $released->balance_id;
            if($ca->amount > 0){
                $ca->reason = "FROM PURCHASE (Cash Advance)";
            } else {
                $ca->reason = "FROM PURCHASE (Cash Advance PHP ".$released->balance_id.")";
            }
            $ca->balance = 0;
            $ca->status = "Released";
            $ca->released_by = $fullname;
            $ca->save();
        
            balance::where('customer_id', $released->customer_id)->increment('balance', $released->balance_id);
            
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

            $notification = array(
                'notifications' => $datum,
                'customer' => $datum->cash_advance->customer,
                'time' => time_elapsed_string($datum->updated_at),
            );

            event(new \App\Events\NewNotification($notification));
        }    
        
        // Handle partial payment
        if($released->partial > 0){
            balance::where('customer_id', $released->customer_id)->decrement('balance', $released->partial);
            $paymentlogs = new paymentlogs;
            $paymentlogs->logs_id = $released->customer_id;
            $paymentlogs->paymentmethod = 'FROM PURCHASE CA';
            $paymentlogs->checknumber = "Not Specified";
            $paymentlogs->paymentamount = $released->partial;
            $paymentlogs->purchase_id = $released->id;
            $paymentlogs->save();
            
            event(new BalanceUpdated($paymentlogs));
        }
        
        DB::commit();
        
        // Fire events after successful commit
        event(new PurchasesUpdated($released));
        event(new BalanceUpdated($released));
        event(new CashierCashUpdated());
        
        $output = array(
            'cashOnHand' => $user->cashOnHand,
            'cashHistory' => $dateTime
        );
        
        echo json_encode($output);
        
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Release purchase failed: ' . $e->getMessage());
            echo json_encode(['success' => false]);
        }
}

    public function sync_cash_history(Request $request){ 
    $from = $request->date_from;
    $to = $request->date_to;   
     
    DB::beginTransaction();

    try {
       $cutoffDate = Carbon::parse($from)->startOfDay();
        $today = Carbon::parse($to)->endOfDay();

        // Count total missing records
        $totalMissing = DB::table('purchases as p')
            ->leftJoin('cash_histories as ch', function($join) {
                $join->on('p.id', '=', 'ch.purchase_id');
            })
            ->where('p.status', 'Released')
            ->whereBetween('p.created_at', [$cutoffDate, $today])
            ->whereNull('ch.id')
            ->count();

        if($totalMissing === 0) {
            DB::commit();
            return response()->json([
                'success' => true,
                'synced' => 0,
                'message' => 'No missing cash history records found'
            ]);
        }

        $chunkSize = 100; // Process 100 at a time
        $syncedCount = 0;

        for($offset = 0; $offset < $totalMissing; $offset += $chunkSize) {
            // Get a small chunk of missing records
            $releasedPurchases = DB::table('purchases as p')
                ->leftJoin('cash_histories as ch', function($join) {
                    $join->on('p.id', '=', 'ch.purchase_id');
                })
                ->where('p.status', 'Released')
                ->whereBetween('p.created_at', [$cutoffDate, $today])
                ->whereNull('ch.id')
                ->select('p.id', 'p.customer_id', 'p.amtpay', 'p.partial', 'p.balance_id', 'p.released_by', 'p.updated_at')
                ->offset($offset)
                ->limit($chunkSize)
                ->get();

            // Get user data for this chunk
            $releasedByNames = $releasedPurchases->pluck('released_by')->unique()->filter();
            $users = User::whereIn('name', $releasedByNames)
                ->select('id', 'name', 'cashOnHand')
                ->get()
                ->keyBy('name');

            // Track running balance for each user to calculate progressive totals
            $userRunningBalance = [];
            foreach($users as $name => $user) {
                $userRunningBalance[$name] = $user->cashOnHand;
            }

            $cashHistoriesToInsert = [];
            $caRecordsToInsert = [];
            $balanceUpdates = [];

            foreach($releasedPurchases as $purchase) {
                $user = $users->get($purchase->released_by);
                if(!$user) continue;
                $purchaseDate = Carbon::parse($purchase->updated_at);
                $dateTime = Carbon::parse($purchase->updated_at);
                // Use purchase ID to ensure uniqueness per purchase
                $trans_no = $dateTime->year . str_pad($dateTime->month, 2, '0', STR_PAD_LEFT) 
                            . str_pad($dateTime->day, 2, '0', STR_PAD_LEFT) . str_pad($purchase->id, 6, '0', STR_PAD_LEFT);

                // Get the current running balance for this user
                $previousCash = $userRunningBalance[$purchase->released_by] + $purchase->amtpay;
                $totalCash = $previousCash - $purchase->amtpay;
                
                // Check if identical record already exists
                $existingRecord = Cash_History::where('user_id', $user->id)
                    ->where('cash_change', $purchase->amtpay)
                    ->where('type', 'like', '%Release Cash - Purchases%')
                    ->whereBetween('created_at', [
                        $purchaseDate->copy()->subSeconds(15),
                        $purchaseDate->copy()->addSeconds(15)
                    ])
                    ->exists();
                
                if($existingRecord) {
                    continue; // Skip if duplicate exists
                }
                
                // Update running balance for next transaction
                $userRunningBalance[$purchase->released_by] = $totalCash;

                // Queue cash history record
                $cashHistoriesToInsert[] = [
                    'user_id' => $user->id,
                    'trans_no' => $trans_no,
                    'previous_cash' => $previousCash,
                    'cash_change' => $purchase->amtpay,
                    'total_cash' => $totalCash,
                    'type' => "Release Cash - Purchases (Synced)",
                    'purchase_id' => $purchase->id,
                    'created_at' => $purchase->updated_at,
                    'updated_at' => now(),
                ];

                // Handle CA (cash advance) from purchase - only if it doesn't already exist
                if(intval($purchase->balance_id) > 0) {
                    $existingCA = ca::where('pid', $purchase->id)->exists();
                    
                    if(!$existingCA) {
                        $caRecordsToInsert[] = [
                            'pid' => $purchase->id,
                            'customer_id' => $purchase->customer_id,
                            'amount' => $purchase->balance_id,
                            'reason' => "FROM PURCHASE (Cash Advance)",
                            'balance' => 0,
                            'status' => "Released",
                            'released_by' => 'System Sync',
                            'created_at' => $purchase->updated_at,
                            'updated_at' => now(),
                        ];

                        if(!isset($balanceUpdates[$purchase->customer_id])) {
                            $balanceUpdates[$purchase->customer_id] = 0;
                        }
                        $balanceUpdates[$purchase->customer_id] += $purchase->balance_id;
                    }
                }

                // Partial payment decreases balance
                if($purchase->partial > 0) {
                    if(!isset($balanceUpdates[$purchase->customer_id])) {
                        $balanceUpdates[$purchase->customer_id] = 0;
                    }
                    $balanceUpdates[$purchase->customer_id] -= $purchase->partial;
                }

                $syncedCount++;
            }

            // Batch insert cash histories
            if(!empty($cashHistoriesToInsert)) {
                Cash_History::insert($cashHistoriesToInsert);
            }

            // Batch insert CA records if any
            if(!empty($caRecordsToInsert)) {
                ca::insert($caRecordsToInsert);
            }

            // Apply balance updates
            foreach($balanceUpdates as $customerId => $amount) {
                if($amount > 0) {
                    balance::where('customer_id', $customerId)->increment('balance', $amount);
                } elseif($amount < 0) {
                    balance::where('customer_id', $customerId)->decrement('balance', abs($amount));
                }
            }

            // Clear memory
            unset($releasedPurchases);
            unset($users);
            unset($cashHistoriesToInsert);
            unset($caRecordsToInsert);
            unset($balanceUpdates);
            
            // Progress log (optional)
            \Log::info("Sync progress: " . min($offset + $chunkSize, $totalMissing) . " / $totalMissing processed");
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'synced' => $syncedCount,
            'message' => "$syncedCount missing Cash_History records have been synced successfully"
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Sync cash history failed: ' . $e->getMessage() . '\n' . $e->getTraceAsString());

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}




    function updateId(){
        $temp = DB::select('select MAX(id) as "temp" FROM purchases');
        echo json_encode($temp);
    }

    function updatecustomerId(){
       $temp = DB::select('select MAX(id) as "temp" FROM customer');
       echo json_encode($temp);
    }

    public function refresh(Request $request){   
        // echo '<script type="text/javascript">console.log("' . $commodity . '"); </script>';
        $from = $request->date_from;
        $to = $request->date_to;   
        $commodity= $request->commodity;
        
        if($to==""&&$from==""&&$commodity==null){
            $ultimatesickquery= DB::table('purchases')
              ->join('customer', 'customer.id', '=', 'purchases.customer_id')
              ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
              ->join('balance', 'balance.customer_id', '=', 'purchases.customer_id')
              ->select('purchases.created_at','purchases.id','purchases.trans_no','commodity.name AS commodity_name','purchases.sacks','purchases.net','purchases.tare','purchases.moist','purchases.type','purchases.previous_bal','purchases.balance_id','purchases.partial','purchases.kilo','purchases.price','purchases.total','purchases.amtpay','purchases.remarks','balance.balance','purchases.status','purchases.released_by','customer.fname','customer.mname','customer.lname')
              ->whereBetween('purchases.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
              //->orderBy('purchases.id', 'desc')
              ->latest();
          }
         else if($to==""&&$from==""&&$commodity=="none"){
            $ultimatesickquery= DB::table('purchases')
              ->join('customer', 'customer.id', '=', 'purchases.customer_id')
              ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
              ->join('balance', 'balance.customer_id', '=', 'purchases.customer_id')
              ->select('purchases.created_at','purchases.id','purchases.trans_no','commodity.name AS commodity_name','purchases.sacks','purchases.net','purchases.tare','purchases.moist','purchases.type','purchases.previous_bal','purchases.balance_id','purchases.partial','purchases.kilo','purchases.price','purchases.total','purchases.amtpay','purchases.remarks','balance.balance','purchases.status','purchases.released_by','customer.fname','customer.mname','customer.lname')
              ->whereBetween('purchases.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
              //->orderBy('purchases.id', 'desc')
              ->latest();
          }else if($to==""&&$from==""&&$commodity!="none"){
            $ultimatesickquery= DB::table('purchases')
              ->join('customer', 'customer.id', '=', 'purchases.customer_id')
              ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
              ->join('balance', 'balance.customer_id', '=', 'purchases.customer_id')
              ->select('purchases.created_at','purchases.id','purchases.trans_no','commodity.name AS commodity_name','purchases.sacks','purchases.net','purchases.tare','purchases.moist','purchases.type','purchases.previous_bal','purchases.balance_id','purchases.partial','purchases.kilo','purchases.price','purchases.total','purchases.amtpay','purchases.remarks','balance.balance','purchases.status','purchases.released_by','customer.fname','customer.mname','customer.lname')
              ->where('commodity.name',$commodity)
              ->whereBetween('purchases.created_at', [Carbon::now()->setTime(0,0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s')])
              //->orderBy('purchases.id', 'desc')
              ->latest();
          }
          else if($to!=""&&$from!=""&&$commodity=="none"){
              $ultimatesickquery= DB::table('purchases')
              ->join('customer', 'customer.id', '=', 'purchases.customer_id')
              ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
              ->join('balance', 'balance.customer_id', '=', 'purchases.customer_id')
              ->select('purchases.created_at','purchases.id','purchases.trans_no','commodity.name AS commodity_name','purchases.sacks','purchases.net','purchases.tare','purchases.moist','purchases.type','purchases.previous_bal','purchases.balance_id','purchases.partial','purchases.kilo','purchases.price','purchases.total','purchases.amtpay','purchases.remarks','balance.balance','purchases.status','purchases.released_by', 'customer.fname','customer.mname','customer.lname')
              ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
              ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
              //->orderBy('purchases.id', 'desc')
              ->latest();        
          }else if($to!=""&&$from!=""&&$commodity==null){
              $ultimatesickquery= DB::table('purchases')
              ->join('customer', 'customer.id', '=', 'purchases.customer_id')
              ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
              ->join('balance', 'balance.customer_id', '=', 'purchases.customer_id')
              ->select('purchases.created_at','purchases.id','purchases.trans_no','commodity.name AS commodity_name','purchases.sacks','purchases.net','purchases.tare','purchases.moist','purchases.type','purchases.previous_bal','purchases.balance_id','purchases.partial','purchases.kilo','purchases.price','purchases.total','purchases.amtpay','purchases.remarks','balance.balance','purchases.status','purchases.released_by', 'customer.fname','customer.mname','customer.lname')
              ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
              ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
              //->orderBy('purchases.id', 'desc')
              ->latest();        
          }else{
              $ultimatesickquery= DB::table('purchases')
              ->join('customer', 'customer.id', '=', 'purchases.customer_id')
              ->join('commodity', 'commodity.id', '=', 'purchases.commodity_id')
              ->join('balance', 'balance.customer_id', '=', 'purchases.customer_id')
              ->select('purchases.created_at','purchases.id','purchases.trans_no','commodity.name AS commodity_name','purchases.sacks','purchases.net','purchases.tare','purchases.moist','purchases.type','purchases.previous_bal','purchases.balance_id','purchases.partial','purchases.kilo','purchases.price','purchases.total','purchases.amtpay','purchases.remarks','balance.balance','purchases.status','purchases.released_by', 'customer.fname','customer.mname','customer.lname')
              ->where('commodity.name',$commodity)
              ->where('purchases.created_at', '>=', date('Y-m-d', strtotime($from))." 00:00:00")
              ->where('purchases.created_at','<=',date('Y-m-d', strtotime($to)) ." 23:59:59")
              //->orderBy('purchases.id', 'desc')
              ->latest();        
          }
        return \DataTables::of($ultimatesickquery)
        ->addColumn('action', function($ultimatesickquery){
            $userid= Auth::user()->id;
            if($userid != 1){
                $u = User::with('emp_name.cashier')->where('id', Auth::user()->id)->first();
                $userRole = $u->emp_name->cashier->role;
            }
            $permit = UserPermission::where('user_id',$userid)->where('permit',1)->where('permission_id',6)->get();
            if($userid!=1){
                 $delete=$permit[0]->permit_delete;  
                 $edit = $permit[0]->permit_edit;  
            }
            if($userid==1 && $ultimatesickquery->status=="On-Hand"){
                return '<button class="btn btn-xs btn-success release_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">eject</i></button>&nbsp;<button class="btn btn-xs btn-warning edit_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;<button class="btn btn-xs btn-danger delete_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button>';
            }
            if($userid != 1){
                if($userRole == 'PURCHASER' && $ultimatesickquery->status=='Released'){
                    return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">done_all</i></button>';
                }
            }
            if($userid==1 && $ultimatesickquery->status=="Released"){
                return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">done_all</i></button>&nbsp;<button class="btn btn-xs btn-warning edit_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;<button class="btn btn-xs btn-danger delete_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button>';
            }           
            if($userid!=1 && $ultimatesickquery->status=="On-Hand" && $delete==1 && $edit==1){
                return '<button class="btn btn-xs btn-success release_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">eject</i></button>&nbsp;<button class="btn btn-xs btn-warning edit_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>&nbsp;<button class="btn btn-xs btn-danger delete_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button>';
            }if($userid!=1 && $ultimatesickquery->status=="On-Hand" && $delete==0 && $edit==1){
                return '<button class="btn btn-xs btn-success release_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">eject</i></button>&nbsp;<button class="btn btn-xs btn-warning edit_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">mode_edit</i></button>';
            }if($userid!=1 && $ultimatesickquery->status=="On-Hand" && $delete==1 && $edit==0){
                return '<button class="btn btn-xs btn-success release_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">eject</i></button>&nbsp;<button class="btn btn-xs btn-danger delete_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">delete</i></button>';
            }if($userid!=1 && $ultimatesickquery->status=="On-Hand" && $delete==0 && $edit==0){
                return '<button class="btn btn-xs btn-success release_purchase waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">eject</i></button>';
            }else{
                return '<button class="btn btn-xs btn-danger released waves-effect" id="'.$ultimatesickquery->id.'"><i class="material-icons">done_all</i></button>';
            }
        })
        ->addColumn('wholename', function ($data){
            return $data->fname." ".$data->mname." ".$data->lname;
        })
        ->addColumn('commname', function ($data){
            return $data->commodity_name;
        })
        ->addColumn('balance', function ($data){
            return $data->balance;
        })
       
        ->editColumn('released_by', function ($data) {
            if($data->released_by==""){
                return "None";
            }else{
                return $data->released_by;
            }
        })
        ->editColumn('amtpay', function ($data) {
            return '₱'.number_format($data->amtpay, 2, '.', ',');
        })
        ->editColumn('moist', function ($data) {
            return $data->moist.'%';
        })


        ->editColumn('price', function ($data) {
            return '₱'.number_format($data->price, 2, '.', ',');
        })

        ->editColumn('balance_id', function ($data) {
            return '₱'.number_format($data->balance_id, 2, '.', ',');
        })

        ->editColumn('balance', function ($data) {
            return '₱'.number_format($data->balance_id+((float) $data->previous_bal-$data->partial), 2, '.', ',');
        })

        ->editColumn('partial', function ($data) {
            return '₱'.number_format($data->partial, 2, '.', ',');
        })
        ->editColumn('previous_bal', function ($data) {
            if($data->previous_bal==null || $data->previous_bal==" "){
                return '₱ 0.00';
            }else{
                return '₱'.number_format($data->previous_bal, 2, '.', ',');
            }
            
        })

        ->editColumn('total', function ($data) {
            return '₱'.number_format($data->total, 2, '.', ',');
        })
        ->editColumn('created_at', function ($data) {
            return date('F d, Y g:i a', strtotime($data->created_at));
        })
 
        ->make(true);
    }

    function deletedata(Request $request){
        $purchases = Purchases::find($request->input('id'));
        $ca =  ca::where('pid',$request->get('id'))->first();
        // return [
        //     "code"       => 500,
        //     "title"      => "Delete Error",
        //     "description" => "Cant process request, Cash advance is Paid.",
        //     "data"=>$purchases
        // ];
        // if($ca){
        //     if($purchases->status == 'Released'){
        //         $balance = balance::where('customer_id', $purchases->customer_id)->first();
        //         $balance->balance -= $purchases->partial;
        //         if($balance->balance==0){
        //             return [
        //                 "code"       => 500,
        //                 "title"      => "Delete Error",
        //                 "description" => "Cant process request, Cash advance is Paid.",
        //             ];
        //         }
        //         $balance->save();
        //         $user = User::find(Auth::user()->id);
    
        //         $userGet = User::where('id', '=', $user->id)->first();
        //         $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
        //         $cash_history = new Cash_History;
        //         $cash_history->user_id = $userGet->id;
    
        //         $getDate = Carbon::now();
                
        //         if($cashLatest != null){
        //             $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
        //         }
        //         else{
        //             $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
        //         }
                
        //         $cash_history->trans_no = $dateTime;
        //         $cash_history->previous_cash = $user->cashOnHand;
        //         $cash_history->cash_change = $ca->amount;
        //         $cash_history->total_cash = $user->cashOnHand + $ca->amount;
        //         $cash_history->type = "Released Purchase(CA) Deleted";
        //         $cash_history->save();
    
        //         $user->cashOnHand += $ca->amount;
        //         $user->save();
        //     }
        //     $ca->delete();
        // }
        if($purchases->status=="Released"){
            $user = User::find(Auth::user()->id);
            $userGet = User::where('id', '=', $user->id)->first();
            $cashLatest = Cash_History::orderBy('id', 'DESC')->first();
            $cash_history = new Cash_History;
            $cash_history->user_id = $userGet->id;
            $payment_history=paymentlogs::where('purchase_id', '=', $purchases->id)->first();
            $cash_advance=ca::where('pid', '=', $purchases->id)->first();
            $check_balance=balance::where('customer_id', $purchases->customer_id)->first();
            if($userGet->access_id!==1){
                return [
                    "code"       => 500,
                    "type"      =>"error",
                    "title"      => "Delete Error",
                    "description" => "Already Released, only Admin can delete this.",
                    "cash"        => null
                ];
            }
            if($payment_history!=null){
                $payment_history->delete();
                $balance = balance::where('customer_id', $purchases->customer_id)->increment('balance',$purchases->partial);
            }
            if($cash_advance!=null){

                 if(($check_balance->balance+$purchases->partial)-$purchases->balance_id<0){
                    return [
                        "code"       => 500,
                        "type"      =>"error",
                        "title"      => "Delete Error",
                        "description" => "Cant process request, Cash advance is fully or partially paid.",
                        "cash"        => null
                    ];
                }else{
                    $cash_advance->delete();
                    $balance = balance::where('customer_id', $purchases->customer_id)->decrement('balance',$purchases->balance_id);
                }
            }
           
            
            // if($balance->balance==0){
            //     return [
            //         "code"       => 500,
            //         "title"      => "Delete Error",
            //         "description" => "Cant process request, Cash advance is Paid.",
            //     ];
            // }

            $getDate = Carbon::now();
            
            if($cashLatest != null){
                $dateTime = $getDate->year.$getDate->month.$getDate->day.($cashLatest->id+1);
            }
            else{
                $dateTime = $getDate->year.$getDate->month.$getDate->day.'1';
            }
            
            $cash_history->trans_no = $dateTime;
            $cash_history->previous_cash = $user->cashOnHand;
            $cash_history->cash_change = $purchases->amtpay;
            $cash_history->total_cash = $user->cashOnHand + $purchases->amtpay;
            $cash_history->type = "Released Purchase Deleted";
            $cash_history->save();

            $user->cashOnHand += $purchases->amtpay;
            $user->save();
            $output = $user->cashOnHand;
        
            $purchases->delete();
        
            return [
                "code"       => 200,
                "type"      =>"success",
                "title"      => "Success Deleting purchase",
                "description" => "Pucrchase Deleted Successfully.",
                "cash"        => $output
            ];
        }
     
        $purchases->delete();
        $user = User::find(Auth::user()->id);
        $output =  $user->cashOnHand;
        return [
            "code"       => 200,
            "type"      =>"success",
            "title"      => "Success Deleting purchase",
            "description" => "Pucrchase Deleted Successfully.",
            "cash"        => $output
        ];
       
    }

    function updatedata(Request $request){
        $id = $request->input('id');
        $commodity = Purchases::find($id);
        $customer = Customer::find($commodity->customer_id);
        $output = array(
            'customer_id' => $commodity->customer_id,
            'name' => $customer->lname .', '.$customer->fname.' '.$customer->mname,
            'trans_no' => $commodity->trans_no,
            'commodity_id' => $commodity->commodity_id,
            'sacks' => $commodity->sacks,
            'ca_id' => $commodity->ca_id,
            'balance_id' => $commodity->balance_id,
            'partial' => $commodity->partial,
            'kilo' => $commodity->kilo,
            'tare' => $commodity->tare,
            'type' => $commodity->type,
            'net' => $commodity->net,
            'moist' => $commodity->moist,
            'price' => $commodity->price,
            'total' => $commodity->total,
            'amtpay' => $commodity->amtpay,
            'remarks' => $commodity->remarks,
            'status' => $commodity->status,
            //'released_by' => $commodity->suki_price,
        );
        echo json_encode($output);
    }
}
