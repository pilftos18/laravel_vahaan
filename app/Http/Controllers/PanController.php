<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Rcdetails;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\CommonTraits;
use App\Traits\ApisTraits;
use Illuminate\Support\Facades\Log;
use PDF;
use Dompdf\FontMetrics;

class PanController extends Controller
{
    use CommonTraits;
    use ApisTraits;

    public function authbridgeViewPancard(){
        return view('pancard.pancard');
    }

    public function authbridgePancardPostData(Request $request)
    {       
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }
        else{

            $response_from = 1;
            $apiUrl     = Config::get('custom.invincible.pancard.url');
            $clientId   = Config::get('custom.invincible.pancard.clientId');
            $secretKey  = Config::get('custom.invincible.pancard.secretKey');
            $api_id     = Config::get('custom.invincible.pancard.api_id');
            $api_name   = Config::get('custom.invincible.pancard.api_name');
            $vendor     = Config::get('custom.invincible.pancard.vender');
            // Get the vehicle number from the request
            $method = 'POST';
            $pancard = $request->input('input');
            $response = "";
            //-------------------------Start Check History-------------------------------------
            $response = $this->checkHistoryPan($pancard, $vendor);
            $data = [
                'panNumber' => $pancard
            ];

            $jsonData = json_encode($data);

            if(empty($response))
            {
				$headers = array(
                    'clientId:'.$clientId,
                    'secretKey:'.$secretKey,
                    'Content-Type: application/json'
                );

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);

				if ($response === false) {
					$message = curl_error($curl);
					$statusCode = curl_errno($curl);
					$remark = 'Curl Error';
					$return = json_encode(array('status_code' => $statusCode, 'message'=> $message));
				} 
				else 
				{
					$responseData = json_decode($response, true);
                    $error = isset($responseData['message']) ? $responseData['message'] : '';
                    $error_no = isset($responseData['code']) ? $responseData['code'] : '';
                    $remark = 'Response from Vendor API';
                    if($error_no == 200)
                    {
						$this->addHistorypan($pancard, $vendor, $jsonData, $response,$error_no);
                        $return = $responseData;
                    }
                    else{
                        $return = json_encode(array('code' => $error_no, 'message'=> $error));
                    }
				}
            }
            else{
                
				$responseData = (!empty($response)) ? json_decode($response, true) : '';
                $error = isset($responseData['message']) ? $responseData['message'] : '';
                $error_no = isset($responseData['code']) ? $responseData['code'] : '';
                $remark = 'Response from History';
                $response_from = 2;
                if($error_no == 200)
                {
                    $return = $responseData;
                }
                else{
                    $return = json_encode(array('code' => $error_no, 'message'=> $error));
                }

            }

            
            $this->updateUtilizedCredit($sessionData['Client_id']);

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
            $api_log->input = $pancard;
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;
            $api_log->save();
            return $return;

        }
    }

    
	public function invincibleViewPancard(){
        return view('pancard.pancardinv');
    }

	public function invinciblePancardPostData(Request $request)
    {       
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }
        else{
            $response_from = 1;
            $apiUrl     = Config::get('custom.invincible.pancard.url');
            $clientId   = Config::get('custom.invincible.pancard.clientId');
            $secretKey  = Config::get('custom.invincible.pancard.secretKey');
            $api_id     = Config::get('custom.invincible.pancard.api_id');
            $api_name   = Config::get('custom.invincible.pancard.api_name');
            $vendor     = Config::get('custom.invincible.pancard.vender');
            // Get the vehicle number from the request
            $method = 'POST';
            $pancard = $request->input('input');
            $response = "";
            //-------------------------Start Check History-------------------------------------
            $response = $this->checkHistoryPan($pancard, $vendor);          
            $data = [
                'panNumber' => $pancard
            ];
            $jsonData = json_encode($data);
            if(empty($response))
            {
				$headers = array(
                    'clientId:'.$clientId,
                    'secretKey:'.$secretKey,
                    'Content-Type: application/json'
                );

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
				
				if ($response === false) {
					$message = curl_error($curl);
					$statusCode = curl_errno($curl);
					$remark = 'Curl Error';
					$return = json_encode(array('status_code' => $statusCode, 'message'=> $message));
				} 
				else 
				{
					// $responseData = json_decode($response, true);
					
					$responseData = json_decode($response, true);
                    $error = isset($responseData['message']) ? $responseData['message'] : '';
                    $error_no = isset($responseData['code']) ? $responseData['code'] : '';
                    $remark = 'Response from Vendor API';
                    if($error_no == 200)
                    {
                        // $this->addHistoryRCWithChassis($chassisNumber, $vendor, $jsonData, $response);
						$this->addHistorypan($pancard, $vendor, $jsonData, $response,$error_no);
                        $return = $responseData;
                    }
                    else{
                        $return = json_encode(array('code' => $error_no, 'message'=> $error));
                    }
				}
            }
            else{
                
				$responseData = (!empty($response)) ? json_decode($response, true) : '';
                $error = isset($responseData['message']) ? $responseData['message'] : '';
                $error_no = isset($responseData['code']) ? $responseData['code'] : '';
                $remark = 'Response from History';
                $response_from = 2;
                if($error_no == 200)
                {
                    $return = $responseData;
                }
                else{
                    $return = json_encode(array('code' => $error_no, 'message'=> $error));
                }

            }

            
            $this->updateUtilizedCredit($sessionData['Client_id']);

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
            $api_log->input = $pancard;
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;
            $api_log->save();
            return $return;

        }
    }
	
	
	public function checkHistoryPan($pan,$vendor){

        $returnArr = '';
        $result = DB::select("SELECT id, response FROM `history_pan` WHERE pan_no = '$pan' AND vendor = '$vendor' AND `status` IN (0,1) AND created_at >= 
        CASE 
            WHEN status_code IN ('404','9') THEN DATE_SUB(NOW(), INTERVAL 1 DAY) 
            ELSE DATE_SUB(NOW(), INTERVAL 7 DAY) 
        END ORDER BY id DESC LIMIT 1");

        if (!empty($result)) {
            
            $returnArr = $result[0]->response;
        }
        else{
        }
        // echo "<pre>"; print_r($returnArr);die;
        return $returnArr;

    }
    private function addHistorypan($pan,$vendor, $request, $response,$status_code)
    {
        $createdAt = now();
        return DB::table('history_pan')->insert([
            'pan_no' => $pan,
            'vendor' => $vendor,
            'request' => $request,
            'status_code' => $status_code,
            'response' => $response,
            'status' => 1,
            'created_at' => $createdAt,
        ]);
    }


    
    private function separateWordsFromCamelCase($inputString)
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

    public function validateChassisNumber($Number)
    {
        // Regular expression pattern for vehicle number validation
        $regex = '/^[A-HJ-NPR-Z0-9]{17}$/i';
    
        // Test the vehicle number against the regex pattern
        $isValid = preg_match($regex, $Number);
    
        return $isValid === 1;
    }


    public function getsignzychassisPostData(Request $request){
        //echo 1;
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }
        else{
            //echo 2;
            $response_from = 1;
            $apiUrl     = Config::get('custom.signzy.chassis.url');
            $Authorization   = Config::get('custom.signzy.chassis.Authorization');
            $api_id     = Config::get('custom.signzy.chassis.api_id');
            $api_name   = Config::get('custom.signzy.chassis.api_name');
            $vendor     = Config::get('custom.signzy.chassis.vender');
            $method = 'POST';
            $chassisNumber = $request->input('chassisno'); 
            //echo 3;
        
            $isValidchassisNumber = $this->validateChassisNumber($chassisNumber);
            if ($isValidchassisNumber === false) {
                return response()->json(['status' => 'Please enter valid chassis number']);
            }


            $data = array(
                'chassisNumber' => $chassisNumber
            );

            $jsonData = json_encode($data);
            //echo 5;
            
            $response = $this->checkHistoryRCWithChassis($chassisNumber, $vendor);

            //echo 6;
            
            if(empty($response))
            {
                $headers = array(
                    'Authorization:'.$Authorization,
                    'Content-Type: application/json'
                );
                //echo 7;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                // print_r($response);exit;
                //echo 8;
                if ($response === false) {

                    $error = curl_error($curl);
                    $error_no = curl_errno($curl);
                    $remark = 'Curl Error';
                    $return = json_encode(array('code' => $error_no, 'message'=> $error));
                } 
                else 
                {
                    $responseData = json_decode($response, true);
                    //print_r($responseData);exit;
                    $error = isset($responseData['message']) ? $responseData['message'] : '';
                    $error_no = isset($responseData['status']) ? $responseData['status'] : '';
                    $status_code = isset($responseData['status_code']) ? $responseData['status_code'] : '';
                    $remark = 'Response from Vendor API';
                    if(!empty($responseData['result']))
                    {   //echo 1;
                        $status_code = 200;
                        $this->addHistoryRCWithChassis($chassisNumber, $vendor, $jsonData, $response,$status_code);
                        $return = $responseData;
                    }
                    else{
                        $status_code = 404;
                        $this->addHistoryRCWithChassis($chassisNumber, $vendor, $jsonData, $response,$status_code);
                        $return = json_encode(array('code' => $status_code, 'message'=> $error));
                    }
                }
            }
            else{

                $responseData = (!empty($response)) ? json_decode($response, true) : '';
                $error = isset($responseData['message']) ? $responseData['message'] : '';
                $error_no = isset($responseData['status']) ? $responseData['status'] : '';
                $status_code = isset($responseData['status_code']) ? $responseData['status_code'] : '';
                $remark = 'Response from History';
                $response_from = 2;
                if(!empty($responseData['result']))
                {
                    $return = $responseData;
                }
                else{
                    $return = json_encode(array('code' => $status_code, 'message'=> $error));
                }
            }   

            $this->updateUtilizedCredit($sessionData['Client_id']);
            $api_log =  new Rcdetails();
            $api_log->api_id = $api_id;
            $api_log->api_name = $api_name;
            $api_log->vender = $vendor;
            $api_log->user_id = $sessionData['userID'];
            $api_log->client_id = $sessionData['Client_id'];
            $api_log->client_name = $sessionData['clientName'];
            $api_log->response_status_code = isset($status_code) ? $status_code : '';
            $api_log->response_message  = isset($error) ? $error : '';
            $api_log->remark  = isset($remark) ? $remark : '';
            $api_log->api_url = $apiUrl;
            $api_log->request = $jsonData;
            $api_log->input = $chassisNumber;
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;
            $api_log->save();

            
            return $return;
        }

    }

    public function checkHistoryRCWithChassis($chassis_no, $vendor)
        {
            $returnArr = '';
           // $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();
            $result = DB::select("SELECT id, response FROM `history_rc_chassis` WHERE chassis_no = '$chassis_no' AND vendor = '$vendor' AND `status` IN (0,1) AND created_at >= 
            CASE 
                WHEN status_code IN ('404','9') THEN DATE_SUB(NOW(), INTERVAL 1 DAY) 
                ELSE DATE_SUB(NOW(), INTERVAL 7 DAY) 
            END ORDER BY id DESC LIMIT 1");
            if (!empty($result)) {
               
                $returnArr = $result[0]->response;
            }
            else{
                $returnArr = '';
            }
            return $returnArr;
        }
    
        public function addHistoryRCWithChassis($chassis_no, $vendor, $request, $response,$statuscode)
        {
            $createdAt = now();
            return DB::table('history_rc_chassis')->insert([
                'chassis_no' => $chassis_no,
                'vendor' => $vendor,
                'request' => $request,
                'response' => $response,
                'status_code' => $statuscode,
                'status' => 1,
                'created_at' => $createdAt,
            ]);
        }

}
