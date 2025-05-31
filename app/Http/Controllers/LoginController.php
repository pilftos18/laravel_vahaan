<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Models\Session_Log;
use Carbon\Carbon;
use App\Models\Rcdetails;

class LoginController extends Controller
{
    public function indexfun(Request $request)
    {   
        $sessionData = Session::get('data');
        if(session()->has('data'))
        {	
            if (isset($sessionData) && $sessionData['userRole'] == 'admin') {

                if($sessionData['userRole'] == 'admin')
                {
					if($sessionData['Client_id'] == '15'){
						$resultData = $this->getDashboardForTATAautoclaims();
						$dl_total = $resultData['dl_total'];
						$rc_total = $resultData['rc_total'];
						$dl_month = $resultData['dl_month'];
						$rc_month = $resultData['rc_month'];
						$dl_yesterday = $resultData['dl_yesterday'];
						$rc_yesterday = $resultData['rc_yesterday'];
						$dl_yesterday_success = $resultData['dl_yesterday_success'];
						$rc_yesterday_success = $resultData['rc_yesterday_success'];
						$dl_yesterday_failed = $resultData['dl_yesterday_failed'];
						$rc_yesterday_failed = $resultData['rc_yesterday_failed'];
						
						return view('dashboard', compact('dl_total','rc_total','dl_month','rc_month','dl_yesterday','rc_yesterday','dl_yesterday_success','rc_yesterday_success','dl_yesterday_failed','rc_yesterday_failed'));
					}
					else{
					
                    $yesterday = Carbon::yesterday();

                    $Client_id = $sessionData['Client_id'];

                    $maxCount = DB::table('clients')
                    ->select('clients.max_count')
                    ->join('users', 'clients.id', '=', 'users.client_id')
                    ->where('users.client_id', '=', $Client_id)
                    ->value('clients.max_count');

                    $successCount = Rcdetails::where('response_status_code', 200)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->where('api_log.client_id', $Client_id)
                    ->count();

                    //{1}
                     $yesterdaysuccessCount = Rcdetails::where('client_id', '=', $Client_id)
                    ->whereDate('created_at', '=', $yesterday)
                    ->whereIn('response_status_code', [200, 401, 1])
                    ->distinct('input')
                    ->count();

                    // $yesterdaysuccessCount = Rcdetails::where('response_status_code', 200)
                    // ->join('users', 'users.id', '=', 'api_log.user_id')
                    // ->where('api_log.client_id', $Client_id)
                    // ->whereDate('api_log.created_at', $yesterday)
                    // ->count();

                    $utliziedCount = Rcdetails::where('users.client_id', $Client_id)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->count();

                    //[2]
                    $Client_id = $sessionData['Client_id'];

                    $yesterdayfailcount = Rcdetails::where('client_id', '=', $Client_id)
                    ->whereDate('created_at', '=', $yesterday)
                    ->whereNotIn('response_status_code', [200, 401, 1, 400, ''])
                    ->whereNotIn('input', function ($query) use ($Client_id, $yesterday) {
                        $query->select('input')
                            ->from('api_log')
                            ->where('api_log.client_id', '=', $Client_id)
                            ->whereDate('api_log.created_at', '=', $yesterday)
                            ->whereIn('api_log.response_status_code', [200, 401, 1]);
                    })
                    ->distinct('input')
                    ->count();

                    // $yesterdayutilizedCount = Rcdetails::where('users.client_id', $Client_id)
                    // ->join('users', 'users.id', '=', 'api_log.user_id')
                    // ->whereDate('api_log.created_at', $yesterday)
                    // ->count();

                    $yesterdayutilizedCount = Rcdetails::where('client_id', '=', $Client_id)
                    ->whereNotIn('response_status_code', [400, ''])
                    ->whereDate('created_at', '=', $yesterday)
                    ->distinct('input')
                    ->count();

                    $failcount =Rcdetails::where('response_status_code', '!=', 200)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->where('api_log.client_id', $Client_id)
                    ->count();

                    //[3]
                    // $yesterdayfailcount = Rcdetails::where('response_status_code', '!=', 200)
                    // ->join('users', 'users.id', '=', 'api_log.user_id')
                    // ->where('api_log.client_id', $Client_id)
                    // ->whereDate('api_log.created_at', $yesterday)
                    // ->count();

                    //////->where

                    $oneMonthAgo = now()->subMonth();
                    $previousDayInMonth = $oneMonthAgo->subDay();
                    $firstDayOfMonth = date("Y-m-01 00:00:00");


                    $monthportalhits = Rcdetails::where('client_id', $Client_id)
                    ->whereRaw("DATE(api_log.created_at) BETWEEN ? AND ?", [$firstDayOfMonth, $yesterday])
                    ->count();
                    //dd($monthportalhits);
                    
                    $monthapihits = DB::table('external_source_data')
                    ->where('external_source_data.client_name', '=', 'TATAAIG')
                    ->whereRaw("DATE(external_source_data.created_at) BETWEEN ? AND ?", [$firstDayOfMonth, $yesterday])
                    ->count();

                    ///////////

                    $apicount = DB::table('external_source_data')
                    ->where('client_name', '!=', null)
                    ->count();

                    //[4]
                    // $yesterdayapihits = DB::table('external_source_data')
                    // ->whereDate('external_source_data.created_at', $yesterday)
                    // ->count();

                        $yesterdayapihits = DB::table('external_source_data')
                        ->whereDate('created_at', '=', $yesterday)
                        ->whereNotIn('status_code', [400, ''])
                        ->distinct('input')
                        ->count();

                    //[5]
                    // $yesterdayapisuccesscount = DB::table('external_source_data')
                    // ->whereIn('status_code',['200','401'])
                    // ->whereDate('created_at', $yesterday)
                    // ->count();

                    $yesterdayapisuccesscount = DB::table('external_source_data')
                    ->whereDate('created_at', '=', $yesterday)
                    ->whereIn('status_code', [200, 401, 1])
                    ->distinct('input')
                    ->count();

                    //[6]
                    // $yesterdayapifailcount = DB::table('external_source_data')
                    // ->whereNotIn('status_code',['200','401'])
                    // ->whereDate('created_at', $yesterday)
                    // ->count();

                     $yesterdayapifailcount = DB::table('external_source_data')
                    ->whereNotIn('status_code', [200, 401, 1, 400, ''])
                    ->whereNotIn('input', function ($query) use ($yesterday) {
                        $query->select('input')
                            ->from('external_source_data')
                            ->whereDate('created_at', '=', $yesterday)
                            ->whereIn('status_code', [200, 401, 1]);
                    })
                    ->whereDate('created_at', '=', $yesterday)
                    ->distinct('input')
                    ->count();
					}

                }
                else{
                    $user = $sessionData['userID'];

                    $maxCount = DB::table('clients')
                    ->select('clients.max_count')
                    ->join('users', 'clients.id', '=', 'users.client_id')
                    ->where('users.id', '=', $user)
                    ->value('clients.max_count');

                    $successCount = Rcdetails::where('response_status_code', 200)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->where('users.id', $user)
                    ->count();

                    $utliziedCount = Rcdetails::where('users.id', $user)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->whereDate('api_log.created_at', $yesterday)
                    ->count();

                    $failcount =Rcdetails::where('response_status_code', '!=', 200)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->where('users.id', $user)
                    ->count();
                }  
                //return $utliziedCount;

                return view('dashboard', compact('maxCount','successCount','utliziedCount','failcount','apicount','yesterdaysuccessCount','yesterdayapifailcount','yesterdayapisuccesscount','yesterdayapihits','yesterdayfailcount','yesterdayutilizedCount','monthportalhits','monthapihits'));
            // return view('dashboard');
            }else if(isset($sessionData) && $sessionData['userRole'] == 'user')
            {   
                $user = $sessionData['userID'];

                    $maxCount = DB::table('clients')
                    ->select('clients.max_count')
                    ->join('users', 'clients.id', '=', 'users.client_id')
                    ->where('users.id', '=', $user)
                    ->value('clients.max_count');

                    $successCount = Rcdetails::where('response_status_code', 200)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->where('users.id', $user)
                    ->count();

                    $utliziedCount = Rcdetails::where('users.id', $user)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->count();

                    $failcount =Rcdetails::where('response_status_code', '!=', 200)
                    ->join('users', 'users.id', '=', 'api_log.user_id')
                    ->where('users.id', $user)
                    ->count();

                    return view('dashboard', compact('maxCount','successCount','utliziedCount','failcount'));
            }
            else{
                $companyCount = DB::select("SELECT COUNT(*) AS count FROM clients WHERE del_status = 1")[0]->count;
                
                $successCounts = Rcdetails::where('response_status_code', 200)
                ->selectRaw('COUNT(*) as count')
                ->get();

                $failCounts = Rcdetails::where('response_status_code', '!=', 200)
                    ->selectRaw('COUNT(*) as count')
                    ->get();
                
                // $sum = Company::where('status', 1)
                // ->sum('max_count');
                //echo "<pre>"; print_r($successCounts[0]['count']);die;
                $sum = $successCounts[0]['count'] + $failCounts[0]['count'];
                
                return view('dashboard', compact('companyCount','successCounts','failCounts','sum'));
           }
            	//return view('dashboard');
        }
        else{
            return view('login');
        }
    }
    
    public function signin(Request $request)
    {
         // $password = Hash::make($password);
        //in core php $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        //check session active or not
        $this->isSessionActive();  
        $sessionData    = session('data');
        //echo "sessionData : <pre>"; print_r($sessionData);//die;
        $currentDateTime = Carbon::now('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
        $ip = $request->ip();
        
        $username = $request->input('username');
        $password = $request->input('passwd');

        //  $userExist = DB::select("SELECT * FROM `users` WHERE password='$password' AND username='$username' AND status='1'");

         $userExist = DB::table('users')
         ->leftJoin('clients', 'users.client_id', '=', 'clients.id')
         ->select('users.*', 'clients.id as Client_id', 'clients.name as clientName', 'clients.email as clientEmail', 'clients.website as clientWebsite', 'clients.file as clientFile')
         ->whereIn('users.status', [0,1])
        // ->whereIn('clients.status', [0,1])
         ->where('users.username', $username)
        //  ->where('users.password', $password)
         ->latest()
         ->first();

        if($userExist)
        {
            if($userExist->role == 'user' && isset($userExist->Client_id) && empty($userExist->Client_id))
            {
                return Redirect()->back()->with('error','Not Authorized');
            }
            if(!password_verify($password, $userExist->password))
            {
                return Redirect()->back()->with('error','invalid username or password!');
            }

            $apiArr = [];
            $API_LIST = DB::select("SELECT id, apiname, api_alias, view_filename FROM `api_list` WHERE client_id='$userExist->Client_id' AND status='1' AND del_status = '1'");
            if(!empty($API_LIST))
            {
                foreach($API_LIST as $k => $api)
                {
                    $apiArr[$api->id]['id'] = $api->id;
                    $apiArr[$api->id]['name'] = $api->apiname;
                    $apiArr[$api->id]['api_alias'] = $api->api_alias;
                    $apiArr[$api->id]['view_filename'] = $api->view_filename;
                }
            }


            $userID         = $userExist->id;
            $userSessionID  = Session::getId();
         
            $data = [
                'userID' => $userID,
                'userRole' => $userExist->role,
                'Client_id' => $userExist->Client_id,
                'Name' => $userExist->name,
                'Username' => $userExist->username,
                'userEmail' => $userExist->email,
                'userMobile' => $userExist->mobile,
                'userGender' => $userExist->gender,
                'userSessionID' => $userSessionID,
                'clientName' => $userExist->clientName,
                'clientEmail' => $userExist->clientEmail,
                'clientWebsite' => $userExist->clientWebsite,
                'clientFile' => $userExist->clientFile,
                'ip_address' => $ip,
                'api_list' => $apiArr,
            ];
            $request->session()->put('data', $data);
            $checkUserSession = DB::select("SELECT * FROM `session_log` WHERE user_id='$userID' AND login_status = 1 ORDER BY id DESC LIMIT 1");
            if($checkUserSession)
            {
                DB::table('session_log')
                    ->where('user_id', $userID)
                    ->update([
                        'login_status' => '2'
                    ]);
            }
            $this->logInSession();
            // After successful authentication
            $request->session()->regenerateToken();
            
            DB::table('users')
                ->where('id', $userID)
                ->update([
                    'series_id' => Str::random(16),
                    'remember_token' => Hash::make(Str::random(20)),
                ]);
            
                return redirect('/dashboard');
            
        }else{
            return Redirect()->back()->with('error','Not Authorized!');
        }
    }

    public function signout(Request $request)
    {
        $this->logOutSession();
        Session::flush();
        return redirect('/login');
    }

    public function isSessionActive()
    {
        $sessionData    = session('data');
        $userSessionID  = $sessionData['userSessionID'];
        $userID         = $sessionData['userID'];
       // echo "sdfasdf<pre>"; print_r($sessionData);die;
        if(isset($sessionData['userSessionID'])) {
            $SessionTableData = DB::select("SELECT user_id, session_id, login_status FROM `session_log` WHERE session_id='$userSessionID' and user_id='$userID' AND login_status='1' ORDER BY id DESC");
            if($SessionTableData)
            {
                return redirect('/dashboard');
            }
        }
        return true;
    }

   
    public function logInSession()
    {
        $sessionData = Session::get('data');
        $session_log = new Session_Log();
        $session_log->user_id = $sessionData['userID'];
        $session_log->session_id = $sessionData['userSessionID'];
        $session_log->login_status = 1;
        $session_log->STATUS = 1;
        $session_log->ip_address = $sessionData['ip_address'];
        $session_log->save();
    }
    public function logOutSession()
    {
        $sessionData = Session::get('data');
        Session::flush();
        return DB::table('session_log')
            ->where('login_status', 1)
            ->where('user_id', $sessionData['userID'])
            ->update([
                'login_status' => 2
            ]);
       
        
    }

    public function availableBalance()
    {
        $availbleBalance = 0;
        if(session()->has('data'))
        {
            $sessionData = Session::get('data');
            if (isset($sessionData) && ($sessionData['userRole'] == 'user' || $sessionData['userRole'] == 'admin')) {
                $Client_id = $sessionData['Client_id'];
                $availbleBalance = DB::table('clients')
                ->select('max_count')
                ->where('id', '=', $Client_id)
                ->value('max_count');
            }
        }
        
        return $availbleBalance;
    }

    public function getNotificationData(Request $request){

        $userid = $request->input('userid');
        $clientid = $request->input('clientid');

        if (isset($userid) && isset($clientid)) {
            $notification_data = DB::table('notification')
                ->select('id','subject', 'created_at') 
                ->where('read_status', 1)
                ->where('status', 1)
                ->where('user_id', $userid)
                ->where('client_id', $clientid)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(); 
            
                return $notification_data;
        }
        else{
            return 1;
            }
    }

    public function getNotificationChange(Request $request){

        // notification.change
        $notification_id = $request->input('notification_id');

        // Update the read_status in the notification table
            $notification_change = DB::table('notification')
            ->where('id', $notification_id)
            ->update(['read_status' => 2]);

            return $notification_change;


    }


	public function getDashboardForTATAautoclaims($clientName = '')
	{		
	
		$result = array();
		$yesterday = Carbon::yesterday();
		$firstDayOfMonth = date("Y-m-01 00:00:00");
		
		$clientName = empty($clientName) ? 'Autoclaims' : $clientName;

		$result['dl_total'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'DL')
		->count();
		
		$result['rc_total'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'RC')
		->count();
		
		$result['dl_month'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'DL')
		->whereRaw("DATE(created_at) BETWEEN ? AND ?", [$firstDayOfMonth, $yesterday])
		->count();
		
		$result['rc_month'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'RC')
		->whereRaw("DATE(created_at) BETWEEN ? AND ?", [$firstDayOfMonth, $yesterday])
		->count();
		
		
		$result['dl_yesterday'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'DL')
		->whereDate('created_at', '=', $yesterday)
		->count();
		
		$result['rc_yesterday'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'RC')
		->whereDate('created_at', '=', $yesterday)
		->count();
		
			
		$result['dl_yesterday_success'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'DL')
		->whereDate('created_at', '=', $yesterday)
		->whereIn('status_code', [200])
		->count();
		
		$result['rc_yesterday_success'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'RC')
		->whereDate('created_at', '=', $yesterday)
		->whereIn('status_code', [200])
		->count();
		
		$result['dl_yesterday_failed'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'DL')
		->whereDate('created_at', '=', $yesterday)
		->whereNotIn('status_code', [200])
		->count();
		
		$result['rc_yesterday_failed'] = DB::table('external_source_data_tata_autoclaims')
		->where('client_name', 'Autoclaims')
		->where('module', 'RC')
		->whereDate('created_at', '=', $yesterday)
		->whereNotIn('status_code', [200])
		->count();

		return $result;
	}

}
