<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Rcdetails;
use App\Models\Module;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Print_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\CommonTraits;
use App\Traits\ApisTraits;
use Carbon\Carbon;
use PDF;

class ChallanController extends Controller
{   
    use CommonTraits;
    use ApisTraits;

    public function invincibleViewChallanWithChassis()
    {
        //echo "123"; die;
        //$users = Users::whereIn('status', [0,1,2])->get(); //compact('users')
        return view('challan.challan_chassis');
    }

    public function invincibleChallanWithChassisPostData(Request $request)
    { 
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }
        else{
            
            $response_from = 1;
            // echo "<pre>"; print_r($request->input);die;
            $apiUrl =     Config::get('custom.invincible.challan_chassis.challan_url');
            $clientId =   Config::get('custom.invincible.challan_chassis.clientId');
            $secretKey =  Config::get('custom.invincible.challan_chassis.secretKey');
            $api_id     = Config::get('custom.invincible.challan_chassis.api_id');
            $api_name   = Config::get('custom.invincible.challan_chassis.api_name');
            $vendor     = Config::get('custom.invincible.challan_chassis.vender');
            
            // Get the vehicle number from the request
            $vehicleNo      = $request->input('vehicle_No');
            $chassis_No     = $request->input('chassis_No');
            $method         = 'POST';
            $data = array(
                'vehicleNumber' => $vehicleNo,
                'chassisLast_5_digits' => $chassis_No,
            );
            
            $jsonData = json_encode($data);

            // Request data
            $response = $this->checkHistoryChallan($vehicleNo, $vendor);
            if(empty($response))
            {
                // Create the headers array with the token
                $headers = array(
                    'clientId:'.$clientId,
                    'secretKey:'.$secretKey,
                    'Content-Type: application/json'
                );

                try {
                    //Make the API request
                // $response = Http::withHeaders($headers)->post($apiUrl, $data);
                    $curl = curl_init();
                    // Set the cURL options
                    curl_setopt($curl, CURLOPT_URL, $apiUrl);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                    // Execute the cURL request
                    $response = curl_exec($curl);
                    //echo "<pre>";print_r($headers); echo "<pre>";print_r($response);die;

                    if ($response === false) {
                        $error = curl_error($curl);
                        $error_no = curl_errno($curl);
                        $remark = 'Curl Error';
                        $return = json_encode(array('code' => $error_no, 'message'=> $error));
                    } 
                    else 
                    {
                        if(empty($response))
                        {
                            return json_encode(array('status' => 'No Record Found!'));
                        }
                        
                        // API call was successful
                        $responseData = json_decode($response, true);
                        $error = isset($responseData['message']) ? $responseData['message'] : '';
                        $error_no = isset($responseData['code']) ? $responseData['code'] : '';
                        $remark = 'Response from Vendor API';
                        //success
                        if($error_no == 200)
                        {
                            $this->addHistoryChallan($vehicleNo, $vendor, $jsonData, $response);
                            $this->updateUtilizedCredit($sessionData['Client_id']);
                            $return = $this->formateDataforinvChallan($responseData);
                        }
                        else{
                            //error
                            $return = json_encode(array('code' => $error_no, 'message'=> $error));
                        }
                    }
                } catch (\Exception $e) {
                    return response()->json(['error' => $response], $response);
                }
            }
            else{
                $responseData = json_decode($response, true);
                $error = isset($responseData['message']) ? $responseData['message'] : '';
                $error_no = isset($responseData['code']) ? $responseData['code'] : '';
                $remark = 'Response from History';
                $response_from = 2;
                if($error_no == 200)
                {
                    $return = $this->formateDataforinvChallan($responseData);
                    $this->updateUtilizedCredit($sessionData['Client_id']);
                }
                else{
                    $return = json_encode(array('code' => $error_no, 'message'=> $error));
                }
            }


            $api_log = new Rcdetails();
            $api_log->api_id = $api_id;
            $api_log->api_name = $api_name;
            $api_log->vender = $vendor;
            $api_log->user_id = $sessionData['userID'];
            $api_log->client_id = $sessionData['Client_id'];
            $api_log->client_name = $sessionData['clientName'];
            $api_log->response_status_code = isset($error_no) ? $error_no : '';
            $api_log->response_message  = isset($error) ? $error : '';
            $api_log->remark  = isset($remark) ? $remark : '';
            $api_log->api_url = $apiUrl;
            $api_log->request = $jsonData;
			$api_log->input = $vehicleNo;
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;

            return json_encode($response);
        }
    }

    public function formateDataforinvChallan($responseData)
    {
        $resArr = [];
        if(!empty($responseData['Error']))
        {
            return json_encode($responseData);
        }
        if(!empty($responseData['result']['challanDetails']))
        {
            return json_encode(array('Error' => $responseData['result']['challanDetails']));
        }
        if(!empty($responseData['result']['challans']))
        {
            foreach($responseData['result']['challans'] as $key => $values)
            {
                foreach($values as $k => $val)
                {
                    $resArr[$key][$this->separateWordsFromCamelCase($k)] = $val;
                }
            
            }
        } 
        return $resArr;
    }
   
   
    public function signzyViewChallan()
    {
        //echo "123"; die;
        //$users = Users::whereIn('status', [0,1,2])->get(); //compact('users')
        return view('challan.schallan');
    }

    public function signzyChallanPostData(Request $request)
    {   
        
        
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            //return response()->json(['status' => 'No more credit limit available']);
            return $result = json_encode(array('code' => 401, 'message'=> 'No more credit limit available'));
        }
        else{
            
            $response_from = 1;
          // echo "<pre>"; print_r($request->input);die;
            $apiUrl = Config::get('custom.signzy.challan.url');
            $Authorization = Config::get('custom.signzy.challan.Authorization');
            $api_id     = Config::get('custom.signzy.challan.api_id');
            $api_name   = Config::get('custom.signzy.challan.api_name');
            $vendor     = Config::get('custom.signzy.challan.vender');
            
            // Get the vehicle number from the request
            $vehicleNo = $request->input('vehicle_No');
            $method = 'POST';
            
            $data = array(
                'essentials' => array(
                    'vehicleNumber' => $vehicleNo
                ),
                'task' => 'challanSearch'
            );
            
            // Convert data to JSON format
            $jsonData = json_encode($data);
          
            // Create the headers array with the token

            $response = $this->checkHistoryChallan($vehicleNo, $vendor);
            // echo "<pre>";print_r($response);die;
            if(empty($response))
            {

                $headers = array(
                    'Authorization:'.$Authorization,
                    'Content-Type:application/json',
                );

                
                    //Make the API request
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $apiUrl);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                    // Execute the cURL request
                    $response = curl_exec($curl);
                    // echo "<pre>";print_r($headers); echo "<pre>";print_r($response);die;
                  //  $error = '';
                    if ($response === false) {
                        $error = curl_error($curl);
                        $error_no = curl_errno($curl);
                        $remark = 'Curl Error';
                        $return = json_encode(array('code' => $error_no, 'message'=> $error));
                    } 
                    else 
                    {
                        $responseData = json_decode($response, true);

                        //return $responseData;
                        // $error = isset($responseData['message']) ? $responseData['message'] : '';
                        // $error_no = isset($responseData['code']) ? $responseData['code'] : '';
                        $remark = 'Response from API';
                        //success
                        if(!empty($responseData['result']))
                        {   
                            //  echo "step 1";die;
                            $error_no = 200;
                            $this->addHistoryChallan($vehicleNo, $vendor, $jsonData, $response);
                            $this->updateUtilizedCredit($sessionData['Client_id']);
                            $return = json_encode(array('code' => $error_no, 'message'=> $responseData));
                        }
                        else{
                           
                            //error
                                $error = isset($responseData['error']['message']) ? $responseData['error']['message'] : 'Not Found';
                                $error_no = isset($responseData['error']['status']) ? $responseData['error']['status'] : '101';
                                $return = json_encode(array('code' => $error_no, 'message'=> $error));
                        }   

                        $secondaryVendor = '';
                        $secondary_response = '-';
                        $secondary_status = '';

                        $api_detail_log_id = DB::table('api_detail_log')->insertGetId([
                            'input' => $vehicleNo,
                            'primary_vendor' => $vendor,
                            'primary_response' => $response,
                            'primary_status' => $error_no,
                            'secondary_vendor' => $secondaryVendor,
                            'secondary_response' => $secondary_response,
                            'secondary_status' => $secondary_status,
                            'status' => 1,
                            'created_at' => now(),
                        ]);

                    }

            }
            else{

                $responseData = json_decode($response, true);
                //return $responseData;
                // $error = isset($responseData['message']) ? $responseData['message'] : '';
                // $error_no = isset($responseData['code']) ? $responseData['code'] : '';
                $remark = 'Response from History';
                $response_from = 2;
                $api_detail_log_id  = 0;
                if(!empty($responseData['result']))
                {   
                    // echo "<pre>";print_r($responseData['result']['status_code']);die;
                    // echo "step 2";die;
                    if(!empty($responseData['result']['status_code']) && $responseData['result']['status_code']==204){
                        $error_no = 204;
                        $error = $responseData['result']['message'];
                        $return = json_encode(array('code' => $error_no, 'message'=> $responseData));
                        $this->updateUtilizedCredit($sessionData['Client_id']);
                    }else{
                        $error_no = 200;
                        $return = json_encode(array('code' => $error_no, 'message'=> $responseData));
                        $this->updateUtilizedCredit($sessionData['Client_id']);
                    }
                    
                }
                else{

                    $error = isset($responseData['error']['message']) ? $responseData['error']['message'] : '';
                                $error_no = isset($responseData['error']['status']) ? $responseData['error']['status'] : '101';
                                $return = json_encode(array('code' => $error_no, 'message'=> $error));
                }
            } 


                    
                    $api_log =  new Rcdetails();
                    $api_log->api_id = $api_id;
                    $api_log->api_name = $api_name;
                    $api_log->vender = $vendor;
                    $api_log->user_id = $sessionData['userID'];
                    $api_log->client_id = $sessionData['Client_id'];
                    $api_log->client_name = $sessionData['clientName'];
                    $api_log->response_status_code = isset($error_no) ? $error_no : '101';
                    $api_log->response_message  = isset($error) ? $error : '';
                    $api_log->remark  = isset($remark) ? $remark : '';
                    $api_log->api_url = $apiUrl;
                    $api_log->request = $jsonData;
                    $api_log->input = $vehicleNo;
                    $api_log->api_detail_log_id = $api_detail_log_id;
                    $api_log->response = $response;
                    $api_log->response_from = $response_from;
                    $api_log->status = '1';
                    $api_log->method = $method;
                    $api_log->save();


                    $returnArr['api_log_id'] = $api_log->id;
                    $returnArr['return'] = json_decode($return, true);

                    return $returnArr;
        }
    }
    // public function signzyChallanPostData(Request $request)
    // {   
    //     $sessionData = session('data');
    //     if($this->checkCredit() === false)
    //     {
    //         //return response()->json(['status' => 'No more credit limit available']);
    //         return $result = json_encode(array('code' => 401, 'message'=> 'No more credit limit available'));
    //     }
    //     else{
            
    //         $response_from = 1;
    //       // echo "<pre>"; print_r($request->input);die;
    //         $apiUrl = Config::get('custom.signzy.challan.url');
    //         $Authorization = Config::get('custom.signzy.challan.Authorization');
    //         $api_id     = Config::get('custom.signzy.challan.api_id');
    //         $api_name   = Config::get('custom.signzy.challan.api_name');
    //         $vendor     = Config::get('custom.signzy.challan.vender');
            
    //         // Get the vehicle number from the request
    //         $vehicleNo = $request->input('vehicle_No');
    //         $method = 'POST';

    //         $data = array(
    //             'essentials' => array(
    //                 'vehicleNumber' => $vehicleNo
    //             ),
    //             'task' => 'challanSearch'
    //         );
            
    //         // Convert data to JSON format
    //         $jsonData = json_encode($data);
           
    //         // Create the headers array with the token

    //         $response = $this->checkHistoryChallan($vehicleNo, $vendor);

    //         if(empty($response))
    //         {

    //             $headers = array(
    //                 'Authorization:'.$Authorization,
    //                 'Content-Type:application/json',
    //             );

                
    //                 //Make the API request
    //                 $curl = curl_init();
    //                 curl_setopt($curl, CURLOPT_URL, $apiUrl);
    //                 curl_setopt($curl, CURLOPT_POST, true);
    //                 curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    //                 curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //                 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //                 // Execute the cURL request
    //                 $response = curl_exec($curl);
    //                 //echo "<pre>";print_r($headers); echo "<pre>";print_r($response);die;

    //                 if ($response === false) {
    //                     $error = curl_error($curl);
    //                     $error_no = curl_errno($curl);
    //                     $remark = 'Curl Error';
    //                     $return = json_encode(array('code' => $error_no, 'message'=> $error));
    //                 } 
    //                 else 
    //                 {
    //                     $responseData = json_decode($response, true);

    //                     //return $responseData;
    //                     // $error = isset($responseData['message']) ? $responseData['message'] : '';
    //                     // $error_no = isset($responseData['code']) ? $responseData['code'] : '';
    //                     $remark = 'Response from API';
    //                     //success
    //                     if(!empty($responseData['result']))
    //                     {   
    //                         $error_no = 200;
    //                         $this->addHistoryChallan($vehicleNo, $vendor, $jsonData, $response);
    //                         $this->updateUtilizedCredit($sessionData['Client_id']);
    //                         $return = json_encode(array('code' => $error_no, 'message'=> $responseData));
    //                     }
    //                     else{
    //                         //error
    //                             $error = isset($responseData['error']['message']) ? $responseData['error']['message'] : '';
    //                             $error_no = isset($responseData['error']['code']) ? $responseData['error']['code'] : '';
    //                             $return = json_encode(array('code' => $error_no, 'message'=> $error));
    //                     }
    //                 }

    //         }
    //         else{

    //             $responseData = json_decode($response, true);
    //             //return $responseData;
    //             // $error = isset($responseData['message']) ? $responseData['message'] : '';
    //             // $error_no = isset($responseData['code']) ? $responseData['code'] : '';
    //             $remark = 'Response from History';
    //             $response_from = 2;
    //             if(!empty($responseData['result']))
    //             {   
    //                 $error_no = 200;
    //                 $return = json_encode(array('code' => $error_no, 'message'=> $responseData));
    //                 $this->updateUtilizedCredit($sessionData['Client_id']);
    //             }
    //             else{

    //                 $error = isset($responseData['error']['message']) ? $responseData['error']['message'] : '';
    //                             $error_no = isset($responseData['error']['code']) ? $responseData['error']['code'] : '';
    //                             $return = json_encode(array('code' => $error_no, 'message'=> $error));
    //             }
    //         } 


                    
    //                 $api_log =  new Rcdetails();
    //                 $api_log->api_id = $api_id;
    //                 $api_log->api_name = $api_name;
    //                 $api_log->vender = $vendor;
    //                 $api_log->user_id = $sessionData['userID'];
    //                 $api_log->client_id = $sessionData['Client_id'];
    //                 $api_log->client_name = $sessionData['clientName'];
    //                 $api_log->response_status_code = isset($error_no) ? $error_no : '';
    //                 $api_log->response_message  = isset($error) ? $error : '';
    //                 $api_log->remark  = isset($remark) ? $remark : '';
    //                 $api_log->api_url = $apiUrl;
    //                 $api_log->request = $jsonData;
    //                 $api_log->input = $vehicleNo;
    //                 $api_log->response = $response;
    //                 $api_log->response_from = $response_from;
    //                 $api_log->status = '1';
    //                 $api_log->method = $method;
    //                 $api_log->save();


    //                 $returnArr['api_log_id'] = $api_log->id;
    //                 $returnArr['return'] = json_decode($return, true);

    //                 return $returnArr;
    //     }
    // }

    public function retrieveChallanRtoData(Request $request ){
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return $result = json_encode(array('code' => 401, 'message'=> 'No more credit limit available'));
        }
        else{

            $response_from =    1;
            $apiUrl =           Config::get('custom.rto.challan.url');
            $user_id =          Config::get('custom.rto.challan.user_id');
            $Authorization =    Config::get('custom.rto.challan.Authorization');
            $api_id     =       Config::get('custom.rto.challan.api_id');
            $api_name   =       Config::get('custom.rto.challan.api_name');
            $vendor     =       Config::get('custom.rto.challan.vender');
            
            // Get the vehicle number from the request
            $vehicleNo = $request->input('vehicle_No');
            $method = 'POST';
            // Request data
            $data = [
                'vehicle_number' => $vehicleNo,
                'user_id' => $user_id
            ];

            $jsonData = json_encode($data);

            $response = $this->checkHistoryChallan($vehicleNo, $vendor);

            if(empty($response))
            {
               
                $headers = array(
                    'Authorization:'.$Authorization,
                    'Content-Type:application/json',
                );
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                
                $response = curl_exec($curl);
                $requestHeaders = implode("\r\n", $headers);

                if ($response === false) {
                    $error = curl_error($curl);
                    $error_no = curl_errno($curl);
                    $remark = 'Curl Error';
                    $return = json_encode(array('code' => $error_no, 'message'=> $error));
                } 
                else 
                {
                    $responseData = json_decode($response, true);

                    $error = isset($responseData['message']) ? $responseData['message'] : '';
                    $error_no = isset($responseData['statusCode']) ? $responseData['statusCode'] : '';
                    $remark = 'Response from Vendor API';

                    if($error_no == 200)
                    {
                        $this->addHistoryChallan($vehicleNo, $vendor, $jsonData, $response);
                        $this->updateUtilizedCredit($sessionData['Client_id']);
                        $return = json_encode(array('code' => $error_no, 'message'=> $responseData));

                    }
                    else{
                        $error = isset($responseData['message']) ? $responseData['message'] : '';
                        $error_no = isset($responseData['statusCode']) ? $responseData['statusCode'] : '';
                        $return = json_encode(array('code' => $error_no, 'message'=> $error));
                    }
                }

            }
            else{
                $responseData = json_decode($response, true);
                $error = isset($responseData['message']) ? $responseData['message'] : '';
                $error_no = isset($responseData['statusCode']) ? $responseData['statusCode'] : '';
                $remark = 'Response from History';
                $response_from = 2;
                if($error_no == 200)
                {
                    $return = json_encode(array('code' => $error_no, 'message'=> $responseData));
                    $this->updateUtilizedCredit($sessionData['Client_id']);
                }
                else{
                    $error = isset($responseData['message']) ? $responseData['message'] : '';
                    $error_no = isset($responseData['statusCode']) ? $responseData['statusCode'] : '';
                    $return = json_encode(array('code' => $error_no, 'message'=> $error));
                }
            }

            $api_log =  new Rcdetails();
            $api_log->api_id = $api_id;
            $api_log->api_name = $api_name;
            $api_log->vender = $vendor;
            $api_log->user_id = $sessionData['userID'];
            $api_log->client_id = $sessionData['Client_id'];
            $api_log->client_name = $sessionData['clientName'];
            $api_log->response_status_code = isset($error_no) ? $error_no : '';
            $api_log->response_message  = isset($error) ? $error : '';
            $api_log->remark  = isset($remark) ? $remark : '';
            $api_log->api_url = $apiUrl;
            $api_log->request = $jsonData;
			$api_log->input = $vehicleNo;
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;
            $api_log->save();

            return $return;
        }
    }
   
   
    public function retrieveChallanData(Request $request)
    {   
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return $result = json_encode(array('code' => 401, 'message'=> 'No more credit limit available'));
        }
        else{
          // echo "<pre>"; print_r($request->input);die;
            $response_from = 1;
            $apiUrl =        Config::get('custom.signzy.challan.url');
            $Authorization = Config::get('custom.signzy.challan.Authorization');
            $api_id     =    Config::get('custom.signzy.challan.api_id');
            $api_name   =    Config::get('custom.signzy.challan.api_name');
            $vendor     =    Config::get('custom.signzy.challan.vender');
            
            // Get the vehicle number from the request
            $vehicleNo = $request->input('vehicle_No');
            $method = 'POST';
            // Request data
            $data = [
                'essentials' => ['vehicleNumber' => $vehicleNo],
                'task' => 'challanSearch'
            ];
            
            // Convert data to JSON format
            $jsonData = json_encode($data);
            
            //-------------------------Start Check History-------------------------------------
            $response = $this->checkHistoryChallan($vehicleNo, $vendor);
            // echo $vehicleNo."<pre>dfasdf"; print_r($response);die;
            if(empty($response))
            {
                // Create the headers array with the token
                $headers = array(
                    'Authorization:'.$Authorization,
                    'Content-Type:application/json',
                );
                    //Make the API request
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                // $requestHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);
                // Execute the cURL request
                $response = curl_exec($curl);
                $requestHeaders = implode("\r\n", $headers);
                //echo "requestHeaders : <pre>";print_r($responseHeaders); 
               // echo "<pre>";print_r($requestHeaders); echo "<pre>";print_r($jsonData);  echo "<pre>";print_r($response);die;

                if ($response === false) {
                    $error = curl_error($curl);
                    $error_no = curl_errno($curl);
                    $remark = 'Curl Error';
                    $return = json_encode(array('code' => $error_no, 'message'=> $error));
                } 
                else 
                {
                    $responseData = json_decode($response, true);
                    $error = isset($responseData['result']['message']) ? $responseData['result']['message'] : '';
                    $error_no = isset($responseData['result']['status_code']) ? $responseData['result']['status_code'] : '';
                    $remark = 'Response from Vendor API';
                    //success
                    if($error_no == 200)
                    {
                        $this->addHistoryChallan($vehicleNo, $vendor, $jsonData, $response);
                        $this->updateUtilizedCredit($sessionData['Client_id']);
                        $return = json_encode(array('code' => $error_no, 'message'=> $responseData));
                        
                    }
                    else{
                        $error = isset($responseData['error']['message']) ? $responseData['error']['message'] : '';
                        $error_no = isset($responseData['error']['statusCode']) ? $responseData['error']['statusCode'] : '';
                        $return = json_encode(array('code' => $error_no, 'message'=> $error));
                    }
                }

            }
            else{
                $responseData = json_decode($response, true);
                $error = isset($responseData['result']['message']) ? $responseData['result']['message'] : '';
                $error_no = isset($responseData['result']['status_code']) ? $responseData['result']['status_code'] : '';
                $remark = 'Response from History';
                $response_from = 2;
                //success
                if($error_no == 200)
                {
                    $return = json_encode(array('code' => $error_no, 'message'=> $responseData));
                    $this->updateUtilizedCredit($sessionData['Client_id']);
                }
                else{
                    $error = isset($responseData['error']['message']) ? $responseData['error']['message'] : '';
                    $error_no = isset($responseData['error']['statusCode']) ? $responseData['error']['statusCode'] : '';
                    $return = json_encode(array('code' => $error_no, 'message'=> $error));
                }
            }

            $api_log =  new Rcdetails();
            $api_log->api_id = $api_id;
            $api_log->api_name = $api_name;
            $api_log->vender = $vendor;
            $api_log->user_id = $sessionData['userID'];
            $api_log->client_id = $sessionData['Client_id'];
            $api_log->client_name = $sessionData['clientName'];
            $api_log->response_status_code = isset($error_no) ? $error_no : '';
            $api_log->response_message  = isset($error) ? $error : '';
            $api_log->remark  = isset($remark) ? $remark : '';
            $api_log->api_url = $apiUrl;
            $api_log->request = $jsonData;
			$api_log->input = $vehicleNo;
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;
            $api_log->save();

            return $return;
        }
    }
    
    
    public function authbridgeViewChallan(){
        return view('challan.challan_auth');
    }

    public function authbridgeChallanPostData(Request $request)
    {       
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }
        else{
        // return $request;
            $response_from          = 1;
            $encrypted_string_url   = Config::get('custom.authbridge.challan.encrypted_string_url');
            $utilitysearch_url      = Config::get('custom.authbridge.challan.utilitysearch_url');
            $decrypt_encrypted_string_url      = Config::get('custom.authbridge.challan.decrypt_encrypted_string_url');
            $username               = Config::get('custom.authbridge.challan.username');
            $api_id                 = Config::get('custom.authbridge.challan.api_id');
            $api_name               = Config::get('custom.authbridge.challan.api_name');
            $vendor                 = Config::get('custom.authbridge.challan.vender');
            $doc_type               = Config::get('custom.authbridge.challan.doc_type');
            // Get the vehicle number from the request
            $method = 'POST';
            $vehicleNo = $request->input('vehicleNo'); 
            $vehicleNo = $this->filterVehicleNumber($vehicleNo);
            $isValidVehicleNumber = $this->validateVehicleNumber($vehicleNo);
            if ($isValidVehicleNumber === false) {
                return response()->json(['status' => 'Please enter valid vehicle number']);
            }
            $response = "";
            $dataStep1 = [
                'docNumber' => $vehicleNo,
                'transID' => '123456',
                'docType' => $doc_type
            ];

            $jsonDataStep1 = json_encode($dataStep1);
            //-------------------------Start Check History-------------------------------------
            $response = $this->checkHistoryChallan($vehicleNo, $vendor);
            
            if(empty($response))
            {
                //------------------------- Step1-------------------------------------
                

                $headers = array(
                    'username:'.$username,
                    'Content-Type: application/json'
                );

                $curlStep1 = curl_init();
                curl_setopt($curlStep1, CURLOPT_URL, $encrypted_string_url);
                curl_setopt($curlStep1, CURLOPT_POST, true);
                curl_setopt($curlStep1, CURLOPT_POSTFIELDS, $jsonDataStep1);
                curl_setopt($curlStep1, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curlStep1, CURLOPT_RETURNTRANSFER, true);
                $responseStep1 = curl_exec($curlStep1);
                if ($responseStep1 === false) {
                    $message = curl_error($curlStep1);
                    $statusCode = curl_errno($curlStep1);
                    $remark = 'Curl Error';
                    $return = json_encode(array('status_code' => $statusCode, 'message'=> $message));
                }
                else
                { 
                    
                // ------------------------- Step2-------------------------------------
                    $dataStep2 = [
                        'requestData' => $responseStep1,
                    ];

                    $jsonDataStep2 = json_encode($dataStep2);

                    $headers = array(
                        'username:'.$username,
                        'Content-Type: application/json'
                    );

                    $curlStep2 = curl_init();
                    curl_setopt($curlStep2, CURLOPT_URL, $utilitysearch_url);
                    curl_setopt($curlStep2, CURLOPT_POST, true);
                    curl_setopt($curlStep2, CURLOPT_POSTFIELDS, $jsonDataStep2);
                    curl_setopt($curlStep2, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curlStep2, CURLOPT_RETURNTRANSFER, true);
                    $responseStep2 = curl_exec($curlStep2);

                    if ($responseStep2 === false) {
                        $message = curl_error($curlStep1);
                        $statusCode = curl_errno($curlStep1);
                        $remark = 'Curl Error';
                        $return = json_encode(array('status_code' => $statusCode, 'message'=> $message));
                    }
                    else
                    {
                        $headers = array(
                            'username:'.$username,
                            'Content-Type: application/json'
                        );

                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $decrypt_encrypted_string_url);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $responseStep2);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        // echo $apiUrl; die;
                    
                        if ($response === false) {
                            $message = curl_error($curl);
                            $statusCode = curl_errno($curl);
                            $remark = 'Curl Error';
                            $return = json_encode(array('status_code' => $statusCode, 'message'=> $message));
                        } 
                        else 
                        {
                            $responseData = json_decode($response, true);
                            //echo "<pre> "; print_r($responseData);die;
                            $message = isset($responseData['msg']) ? $responseData['msg'] : '';
                            $statusCode = isset($responseData['status']) ? $responseData['status'] : '';
                            $remark = 'Response from Vendor API';
                            //success
                            if($statusCode == 200 || $statusCode == 1 && (!empty($responseData['data']) && is_array($responseData['data']) === true))
                            {
                                $statusCode = 200;
                                $this->updateUtilizedCredit($sessionData['Client_id']);
                                $this->addHistoryChallan($vehicleNo, $vendor, $jsonDataStep1, $response);
                                $return = json_encode(array('status_code' => $statusCode, 'message'=> $responseData));
                            }
                            else{
                                //error
                                $return = json_encode(array('status_code' => $statusCode, 'message'=> $message));
                            }
                            //echo "<pre>"; print_r($responseData);die;
                        }

                    }
                }
            }
            else{
                $responseData = json_decode($response, true);
                //echo "<pre> "; print_r($responseData);die;
                $message = isset($responseData['msg']) ? $responseData['msg'] : '';
                $statusCode = isset($responseData['status']) ? $responseData['status'] : '';
                $remark = 'Response from History';
                $response_from = 2;
                //success
                if($statusCode == 200 || $statusCode == 1)
                {
                    $statusCode = 200;
                    $this->updateUtilizedCredit($sessionData['Client_id']);
                    $return = json_encode(array('status_code' => $statusCode, 'message'=> $responseData));
                }
                else{
                    //error
                    $return = json_encode(array('status_code' => $statusCode, 'message'=> $message));
                }

            }
            //echo "<pre>"; print_r($response);die;
           

            $api_log =  new Rcdetails();
            $api_log->api_id = $api_id;
            $api_log->api_name = $api_name;
            $api_log->vender = $vendor;
            $api_log->user_id = $sessionData['userID'];
            $api_log->client_id = $sessionData['Client_id'];
            $api_log->client_name = $sessionData['clientName'];
            $api_log->response_status_code = isset($statusCode) ? $statusCode : '';
            $api_log->response_message  = isset($message) ? $message : '';
            $api_log->remark  = isset($remark) ? $remark : '';
            $api_log->api_url = $decrypt_encrypted_string_url;
            $api_log->request = $jsonDataStep1;
			$api_log->input = $vehicleNo;
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;
            $api_log->save();

            // echo "<pre>"; print_r($api_log);die;
            return $return;

        }
    }


    // Helper function to separate camel case words into multiple words
    function separateWordsFromCamelCase($inputString)
    {
        $pattern = '/(?<=[a-z])(?=[A-Z])/';  // Pattern to match the position between lowercase and uppercase letters
        $words = preg_split($pattern, $inputString);
        $words = array_map('ucfirst', $words);
        $result = implode(' ', $words);
        return $result;
    }

  

    public function getCurrentControllerName()
    {
        $controllerName = class_basename(__CLASS__);
        return Str::replaceLast('Controller', '', $controllerName);
    }


    private function checkHistoryChallan($vehicleNo, $vendor)
    {
        $returnArr = '';
       // $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();
        $result = DB::select("SELECT id, response FROM `history_challan` WHERE vehicle_no = '$vehicleNo' AND vendor = '$vendor' AND `status` IN (0,1) AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY id DESC LIMIT 1");
        if (!empty($result)) {
           
            $returnArr = $result[0]->response;
        }
        else{
            DB::table('history_challan')
            ->where('vehicle_no', $vehicleNo)
            ->where('vendor', $vendor)
            ->whereIn('status', [0, 1])
            ->delete();
            $returnArr = '';
        }
        return $returnArr;
    }

    private function addHistoryChallan($vehicleNo, $vendor, $request, $response)
    {
        $createdAt = now();
        return DB::table('history_challan')->insert([
            'vehicle_no' => $vehicleNo,
            'vendor' => $vendor,
            'request' => $request,
            'response' => $response,
            'status' => 1,
            'created_at' => $createdAt,
        ]);
    }


    public function Challanpdf(Request $request){

        $id = $request->input('id'); 
        $sessionData = session('data');     
        $clientid   = $sessionData['Client_id'];    

        $apiResult = DB::table('api_log')
		->select('api_log.id', 'api_log.vender', 'api_log.response')
		->where('api_log.id', $id)
		->where('api_log.client_id', $clientid)
		->first();  


        $responseData = json_decode($apiResult->response, true);
		// $responseData = $this->standardRcResponse('signzy',$responseData); 
		$responseData = $this->standardChallanResponse($apiResult->vender,$responseData); 

        // echo "<pre>"; return $responseData;exit;
        $url = request()->root();
		$parsedUrl = parse_url($url);
		$baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];

        $headerImagePath = $baseUrl.'/assets/img/edas-logo-light.png';
		
        // Load the view with data and generate PDF content
        $pdf = PDF::loadView('pdf.rcchallan_pdf', ['data' => $responseData]);
        // $pdf->setOptions([
        //     'header-html' => $baseUrl.'/assets/img/edas-logo-light.png',
        //     'header-spacing' => 10, // Adjust spacing as needed
        //     'callbacks' => [
        //         'header' => function ($pdf) use ($headerImagePath) {
        //             $pdf->image(public_path($baseUrl.'/assets/img/edas-logo-light.png'), 10, 10, 30); // Adjust positioning and size as needed
        //         },
        //     ],
        // ]);

        // Generate a unique filename for the PDF
        $filename = 'challan_details' . time() . '.pdf';
        // Save the PDF to a storage directory (e.g., storage/app/pdf)
        $pdf->save(storage_path('app/pdf/' . $filename));
		
		$url = request()->root();
		$parsedUrl = parse_url($url);
		$baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
        $filePath = storage_path("app/pdf/$filename");
		$file_url = $baseUrl . "/storage/app/pdf/" . $filename;
		chmod($filePath, 0755);

        // Provide the option to download the PDF
		return response()->json(['download' => '1', 'file_url' => $file_url, 'file_name' => $filename], 200);
		
        // echo"<pre>";print_r( $pdfresponse);exit;
    }

    public function standardChallanResponse($vendor, $response)
	{
        switch (strtolower($vendor)) {
            case "invincible":
                $response = $this->challanIncResponsePDF($response);
                break;
            case "signzy":
                $response = $this->challanSignzyResponsePDF($response);
                break;
        }
        return $response;
	}

    public function challanIncResponsePDF($response){


    }

    public function challanSignzyResponsePDF($response){

        $returnArr = [];

        if (isset($response['result']['challanDetails']) && is_array($response['result']['challanDetails'])) {
            $challanDetails = $response['result']['challanDetails'];
    
            foreach ($challanDetails as $challan) {
                $data = [
                    'accusedName'    => isset($challan['accusedName']) ? $challan['accusedName'] : null,
                    'amount'         => isset($challan['amount']) ? $challan['amount'] : null,
                    'challanDate'    => isset($challan['challanDate']) ? $challan['challanDate'] : null,
                    'challanNumber'  => isset($challan['challanNumber']) ? $challan['challanNumber'] : null,
                    'challanPlace'   => isset($challan['challanPlace']) ? $challan['challanPlace'] : null,
                    'challanStatus'  => isset($challan['challanStatus']) ? $challan['challanStatus'] : null,
                    'court_challan'  => isset($challan['court_challan']) ? $challan['court_challan'] : null,
                    'offenseDetails' => isset($challan['offenseDetails']) ? $challan['offenseDetails'] : null,
                    'rto'            => isset($challan['rto']) ? $challan['rto'] : null,
                    'state'          => isset($challan['state']) ? $challan['state'] : null,
                ];
    
                $returnArr[] = $data;
            }
        }
    
        return $returnArr;


    }


}
