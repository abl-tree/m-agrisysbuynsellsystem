<?php

function notifications($option) {
	if(Auth::check()){
		if($option == 'request'){
			$data = App\Notification::where(['notification_type' => $option, 'user_id' => Auth::id(), 'approved_by' => null, 'status' => 1])
            ->orderBy('id', 'DESC')
            ->with('requested_by')
            ->limit(10)
			->get();
		} else if($option == 'reply'){
			$data = App\Notification::where(['notification_type' => $option, 'requested_by' => Auth::id()])
				->whereNotNull('approved_by')
                ->orderBy('id', 'DESC')
                ->with('approved_by')
                ->limit(10)
				->get();
		}
			
		return $data;
	}

	return false;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'yr',
        'm' => 'mo',
        'w' => 'wk',
        'd' => 'day',
        'h' => 'hr',
        'i' => 'min',
        's' => 'sec',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function isAdmin() {
    $user = \App\User::with('role')->find(Auth::id())->role;

    return ($user->name == 'admin' ? true : false);
}

function isPurchaser(){
    $user = \App\User::with('emp_name.cashier')->find(Auth::id());

    return (strcasecmp($user->emp_name->cashier->role, 'purchaser') == 0 ? true : false);
}

function getName(){
    $id = Auth::user()->emp_id;
    $employee = \App\Employee::find($id);

    return $employee;
}

function userpermission() {
    $id = Auth::id();
    return \App\UserPermission::with('permission')->where('user_id', $id)->orderBy('permission_id')->get();
}

function canAddExpense(){
    return (Auth::user()->username != 'MAYETH' && auth()->user()->id != 10) ? true : false;
}