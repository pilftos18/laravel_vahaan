<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

trait ApisTraits	
{
    public function rcAuthbridge($vendor, $vehicleNo)
    {
        //return $result = array('status'=>'failed','status_code' => '', 'msg'=>'Temporary', 'response'=>'');
        $response = '';
        $result = [];
        $encrypted_string_url           = Config::get('custom.authbridge.rc.encrypted_string_url');
        $utilitysearch_url              = Config::get('custom.authbridge.rc.utilitysearch_url');
        $decrypt_encrypted_string_url   = Config::get('custom.authbridge.rc.decrypt_encrypted_string_url');
        $username                       = Config::get('custom.authbridge.rc.username');
        $api_id                         = Config::get('custom.authbridge.rc.api_id');
        $api_name                       = Config::get('custom.authbridge.rc.api_name');
        $vendor                         = Config::get('custom.authbridge.rc.vender');
        


        $dataStep1      = array('docNumber' => $vehicleNo, 'transID' => '1234567', 'docType' => '372');
        $jsonDataStep1  = json_encode($dataStep1);
        $headers        = ['username:' . $username,'Content-Type: application/json'];
        $addArr         = array('url'=> $decrypt_encrypted_string_url, 'requestData' =>$jsonDataStep1);

        $step1 = $this->curlPostHit($encrypted_string_url, $headers, $jsonDataStep1, true);
        if(isset($step1['status']) && $step1['status'] == 'success')
        {
            $dataStep2      = ['requestData' => $step1['response']];
            $jsonDataStep2  = json_encode($dataStep2);
            $headers        = ['username:' . $username,'Content-Type: application/json'];
            $step2          = $this->curlPostHit($utilitysearch_url, $headers, $jsonDataStep2, true);

            if(isset($step2['status']) && $step2['status'] == 'success')
            {
                $dataStep3      = $step2['response'];
                $headers        = ['username:' . $username,'Content-Type: application/json'];
                $step3          = $this->curlPostHit($decrypt_encrypted_string_url, $headers, $dataStep3, true);
                if(isset($step3['status']) && $step3['status'] == 'success')
                {
                    $response       = $step3['response'];
                    $responseData   = json_decode($response, true);
                    $message        = isset($responseData['message']) ? $responseData['message'] : '';
                    $statusCode     = isset($responseData['status']) ? $responseData['status'] : '101';
                    if ((isset($responseData['status_code']) && $responseData['status_code'] === 200) || $responseData['status'] == 1)
                    {
                        $statusCode = 200;
                        $result   = ['status'=>'success','status_code'=>$statusCode, 'msg'=>'success', 'response'=>$response];
                    }
                    else{
                        $message    = isset($responseData['msg']) ? $responseData['msg'] : 'Failed';
                        $result     = ['status'=>'failed','status_code'=>$statusCode, 'msg'=>$message, 'response'=>$response];
                    }
					//Add History For 200/1 & 404/9
					if(in_array($statusCode, [200,1,9]))
					{
						$this->addHistoryRCForApiList($vehicleNo, $jsonDataStep1, $vendor, $response, $statusCode);
					}
                }
                else{
                    //Error
                    $result   = ['status'=>'failed','status_code'=>$step3['status_code'], 'msg'=>$step3['msg'], 'response'=>$response];
                }
            }
            else{
                //Error
                $result   = ['status'=>'failed','status_code'=>$step2['status_code'], 'msg'=>$step2['msg'], 'response'=>$response];
            }
        }
        else{
            //Error
            $result   = ['status'=>'failed','status_code'=>$step1['status_code'], 'msg'=>$step1['msg'], 'response'=>$response];
        }
        $returnArr = array_merge($addArr,$result);
        return $returnArr;
    }


    public function rcSignzy($vendor, $vehicleNo)
    {
        $response   = '';
        $result     = [];
        $url                = Config::get('custom.signzy.rc.url');
        $Authorization      = Config::get('custom.signzy.rc.Authorization');
        $api_id             = Config::get('custom.signzy.rc.api_id');
        $api_name           = Config::get('custom.signzy.rc.api_name');
        $vendor             = Config::get('custom.signzy.rc.vender');

        $headers            = array('Authorization:'.$Authorization,'Content-Type: application/json');
        $data = [
            'essentials' => ['vehicleNumber' => $vehicleNo, 'blacklistCheck' => 'true'], //,'cacheAgeMonths' => 36
            'task' => 'detailedSearch'
        ];
        $jsonData           = json_encode($data);
        $curlRes            = $this->curlPostHit($url, $headers, $jsonData, true);
        
        $addArr         = array('url'=> $url, 'requestData' =>$jsonData);
      
        if(isset($curlRes['status']) && $curlRes['status'] == 'success')
        {
            // echo "<pre> headers : "; print_r($curlRes); 
            // {
            //     "error": {
            //         "statusCode": 404,
            //         "name": "error",
            //         "message": "Vehicle data not found.",
            //         "status": 404
            //     }
            // }
            
            $response       = $curlRes['response'];
            $responseData   = json_decode($response, true);
            $message        = isset($responseData['message']) ? $responseData['message'] : '';
            $statusCode     = isset($responseData['status_code']) ? $responseData['status_code'] : '101';
            if($statusCode == 200 || !empty($responseData['result']))
            {
                
                $statusCode = 200;
                $result = array('status'=>'success','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
                // echo $historyStatus."<pre> inside : "; print_r($result);
            }
            else{
                
                $error          = isset($responseData['error']) ? $responseData['error'] : ''; 
                $statusCode     = isset($error['statusCode']) ? $error['statusCode'] : '101';
                $message        = isset($error['message']) ? $error['message'] : '';
                $result = array('status'=>'failed','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
            }
			
			//Add History For 200/1 & 404/9
			if(in_array($statusCode, [200,404]))
			{
				$historyStatus = $this->addHistoryRCForApiList($vehicleNo, $jsonData, $vendor, $response, $statusCode);
			}
        }
        else{
            $result = array('status'=>'failed','status_code' => '', 'msg'=> $curlRes['msg'], 'response'=>$response);
        }
        
        $returnArr = array_merge($addArr,$result);
        // echo "<pre> returnArr : "; print_r($returnArr);
        return $returnArr;
    }
    
    
	
    public function rcInvincible($vendor, $vehicleNo)
    {
        $response   = '';
        $result     = [];
        $url        = Config::get('custom.invincible.rc.url');
        $clientId   = Config::get('custom.invincible.rc.clientId');
        $secretKey  = Config::get('custom.invincible.rc.secretKey');
        $api_id     = Config::get('custom.invincible.rc.api_id');
        $api_name   = Config::get('custom.invincible.rc.api_name');
        $vendor     = Config::get('custom.invincible.rc.vender');

        $headers            = array('clientId:'.$clientId,'secretKey:'.$secretKey,'Content-Type: application/json');
        $data = ['vehicleNumber' => $vehicleNo];
        $jsonData           = json_encode($data);
        //$curlRes            = $this->curlPostHit($url, $headers, $jsonData, true);
        $curlRes = ApisTraits::curlPostHit($url, $headers, $jsonData, true);
        
        $addArr         = array('url'=> $url, 'requestData' =>$jsonData);
      
        if(isset($curlRes['status']) && $curlRes['status'] == 'success')
        {
            
            $response       = $curlRes['response'];
            $responseData   = json_decode($response, true);
            $message        = isset($responseData['message']) ? $responseData['message'] : '';
            $statusCode     = isset($responseData['code']) ? $responseData['code'] : '101';
            if($statusCode == '200' || !empty($responseData['result']))
            {                
                $statusCode = 200;
                $result = array('status'=>'success','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
                // echo $historyStatus."<pre> inside : "; print_r($result);
            }
            else{
                
                $error          = isset($responseData) ? $responseData : ''; 
                $statusCode     = isset($error['code']) ? $error['code'] : '101';
                $message        = isset($error['message']['errorMessage']) ? $error['message']['errorMessage'] : '';
                $result = array('status'=>'failed','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
            }
			//Add History For 200/1 & 404/9
			if(in_array($statusCode, [200]))
			{
				$historyStatus = ApisTraits::addHistoryRCForApiList($vehicleNo, $jsonData, $vendor, $response, $statusCode);
			}
        }
        else{
            $result = array('status'=>'failed','status_code' => '', 'msg'=> $curlRes['msg'], 'response'=>$response);
        }
        
        $returnArr = array_merge($addArr,$result);
        // echo "<pre> returnArr : "; print_r($returnArr);
        return $returnArr;
    }
	
	
	public function chassisInvincible($vendor, $chassisNumber)
    { 
		$response_from = 1;
		$url = Config::get('custom.invincible.chassis_rc.url');
		$clientId = Config::get('custom.invincible.chassis_rc.clientId');
		$secretKey = Config::get('custom.invincible.chassis_rc.secretKey');
		$api_id = Config::get('custom.invincible.chassis_rc.api_id');
		$api_name = Config::get('custom.invincible.chassis_rc.api_name');
		$vendor = Config::get('custom.invincible.chassis_rc.vender');
		$method = 'POST';
		// $chassisNumber = $input; 
	
		$isValidchassisNumber = $this->validateChassisNumber($chassisNumber);
		if ($isValidchassisNumber === false) {
			return response()->json(['status' => 'Please enter valid chassis number']);
		}

		$data = [
			'chassisNumber' => $chassisNumber
		];
		$jsonData = json_encode($data);
		
		$headers = array(
			'clientId:'.$clientId,
			'secretKey:'.$secretKey,
			'Content-Type: application/json'
		);
		
		$curlRes = ApisTraits::curlPostHit($url, $headers, $jsonData, true);
        
        $addArr         = array('url'=> $url, 'requestData' =>$jsonData);
      
        if(isset($curlRes['status']) && $curlRes['status'] == 'success')
        {
            
            $response       = $curlRes['response'];
            $responseData   = json_decode($response, true);
            $message        = isset($responseData['message']) ? $responseData['message'] : '';
            $statusCode     = isset($responseData['code']) ? $responseData['code'] : '101';
            if($statusCode == '200' || !empty($responseData['result']))
            {                
                $statusCode = 200;
                $result = array('status'=>'success','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
                // echo $historyStatus."<pre> inside : "; print_r($result);
            }
            else{
                
                $error          = isset($responseData) ? $responseData : ''; 
                $statusCode     = isset($error['code']) ? $error['code'] : '101';
                $message        = isset($error['message']['errorMessage']) ? $error['message']['errorMessage'] : '';
                $result = array('status'=>'failed','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
            }
			//Add History For 200/1 & 404/9
			if(in_array($statusCode, [200]))
			{
				$historyStatus = ApisTraits::addHistoryRCForApiList($chassisNumber, $jsonData, $vendor, $response, $statusCode);
			}
        }
        else{
            $result = array('status'=>'failed','status_code' => '', 'msg'=> $curlRes['msg'], 'response'=>[]);
        }

		/* $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $apiUrl);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
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
			$error_no = isset($responseData['code']) ? $responseData['code'] : '';
			$remark = 'Response from Vendor API';
			if($error_no == 200)
			{
				$result = array('status'=>'success','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
                // echo $historyStatus."<pre> inside : "; print_r($result);
            }
            else{
                
                $error          = isset($responseData) ? $responseData : ''; 
                $statusCode     = isset($error['code']) ? $error['code'] : '101';
                $message        = isset($error['message']['errorMessage']) ? $error['message']['errorMessage'] : '';
                $result = array('status'=>'failed','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
            }
		} */
		

		$returnArr = array_merge($addArr,$result);
		return $returnArr;
    }



	
	
	public function rcSC($vendor, $vehicleNo)
    {
        $response   = '';
        $result     = [];
        $url                = Config::get('custom.SC.rc.url');
        $Authorization      = Config::get('custom.SC.rc.Authorization');
        $api_id             = Config::get('custom.SC.rc.api_id');
        $api_name           = Config::get('custom.SC.rc.api_name');
        $vendor             = Config::get('custom.SC.rc.vender');

        $headers            = array('Authorization:'.$Authorization,'Content-Type: application/json');
        $data = [
            'essentials' => ['vehicleNumber' => $vehicleNo, 'cacheAgeMonths' => 36, 'alternateSource' => true], //,'cacheAgeMonths' => 36
            'task' => 'detailedSearch'
        ];
        $jsonData           = json_encode($data);
        $curlRes            = $this->curlPostHit($url, $headers, $jsonData, true);
        
        $addArr         = array('url'=> $url, 'requestData' =>$jsonData);
      
        if(isset($curlRes['status']) && $curlRes['status'] == 'success')
        {
            // echo "<pre> headers : "; print_r($curlRes); 
            // {
            //     "error": {
            //         "statusCode": 404,
            //         "name": "error",
            //         "message": "Vehicle data not found.",
            //         "status": 404
            //     }
            // }
            
            $response       = $curlRes['response'];
            $responseData   = json_decode($response, true);
            $message        = isset($responseData['message']) ? $responseData['message'] : '';
            $statusCode     = isset($responseData['status_code']) ? $responseData['status_code'] : '101';
            if($statusCode == 200 || !empty($responseData['result']))
            {
                
                $statusCode = 200;
                $result = array('status'=>'success','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
                // echo $historyStatus."<pre> inside : "; print_r($result);
            }
            else{
                
                $error          = isset($responseData['error']) ? $responseData['error'] : ''; 
                $statusCode     = isset($error['statusCode']) ? $error['statusCode'] : '101';
                $message        = isset($error['message']) ? $error['message'] : '';
                $result = array('status'=>'failed','status_code' => $statusCode, 'msg'=> $message, 'response'=>$response);
            }
			
			//Add History For 200/1 & 404/9
			if(in_array($statusCode, [200,404]))
			{
				$historyStatus = $this->addHistoryRCForApiList($vehicleNo, $jsonData, $vendor, $response, $statusCode);
			}
        }
        else{
            $result = array('status'=>'failed','status_code' => '', 'msg'=> $curlRes['msg'], 'response'=>$response);
        }
        
        $returnArr = array_merge($addArr,$result);
        // echo "<pre> returnArr : "; print_r($returnArr);
        return $returnArr;
    }
    public function curlPostHit($url, $header, $postFields, $post = true)
    {
        $response = array();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, $post);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        if ($result === false) {
            $message = curl_error($curl);
            $statusCode = curl_errno($curl);
            $remark = 'Curl Error';
            $response   = ['status'=>'failed','status_code'=>$statusCode, 'msg'=>$message, 'response'=>[]];
        }
        else{
            $response   = ['status'=>'success','status_code'=>'', 'msg'=>'', 'response'=>$result];
        }
        return $response;
    }

    // Insert the new record in history table
    public function addHistoryRCForApiList($vehicleNo, $request, $vendor, $response, $statusCode = 200)
    { 
        return DB::table('history_rc')->insert([
            'vehicle_no' => $vehicleNo,
            'vendor' => $vendor,
            'request' => $request,
            'response' => $response,
            'status_code' => $statusCode,
            'status' => 1,
            'created_at' => now(),
        ]);
    }

    public function checkHistoryRCForApiList($vendor, $vehicleNo)
    {
        if(is_array($vendor))
        {
            $vendorStr = implode("', '", $vendor);
        }
        else{
            $vendorStr = $vendor;
        }

        $returnArr = [];
        //$result = DB::select("SELECT response, vendor, status_code FROM `history_rc` WHERE vehicle_no = '$vehicleNo' AND vendor IN ('$vendorStr') AND `status` IN (0,1) AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY id DESC LIMIT 1");
		
		$result = DB::select("SELECT response, vendor, status_code FROM `history_rc` WHERE vehicle_no = '$vehicleNo' AND vendor IN ('$vendorStr') AND `status` IN (0,1) AND created_at >= 
         CASE 
             WHEN status_code IN ('404','9') THEN DATE_SUB(NOW(), INTERVAL 1 DAY) 
             ELSE DATE_SUB(NOW(), INTERVAL 1 DAY) 
         END ORDER BY id DESC LIMIT 1");

         // AND created_at >= 
        // CASE 
        //     WHEN status_code != 200 THEN DATE_SUB(NOW(), INTERVAL 1 DAY) 
        //     ELSE DATE_SUB(NOW(), INTERVAL 7 DAY) 
        // END
       
        if (!empty($result)) {
            
            $returnArr['response'] = $result[0]->response;
            $returnArr['vendor'] = $result[0]->vendor;
            $returnArr['status_code'] 	= $result[0]->status_code;
        }
        else{
            // DB::table('history_rc')
            // ->where('vehicle_no', $vehicleNo)
            // ->whereIn('vendor', $vendor)
            // ->whereIn('status', [0, 1])
            // ->delete();
            $returnArr = [];
        }
        // echo "<pre>returnArr : "; print_r($returnArr);die; 
        // echo "returnArr<pre>"; print_r($returnArr);die; 
        return $returnArr;
    }


}