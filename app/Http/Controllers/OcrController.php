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
use App\Models\Ocrdetails;
use Illuminate\Support\Facades\Log;
use PDF;
use Dompdf\FontMetrics;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OcrController extends Controller
{
    use CommonTraits;
    use ApisTraits;

    public function authbridgeViewOCR(){
        return view('ocr.ocr_auth');
    }

    public function authbridgeOCRPostData(Request $request)
    {               
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }
        else{  
               

        if ($request->hasFile('front_image') && $request->hasFile('back_image')) 
        {

            $response_from = 1;            
            $method = 'POST';
            $frontImage = $request->file('front_image');
            $backImage = $request->file('back_image');
            $doctype = $request->input('doctype');
            $front = date('Y_m_d_His') . '_' . $frontImage->getClientOriginalName();
            $frontImagePath = $frontImage->storeAs('ocr', $front);
            $frontImagePath = storage_path('app/' . $frontImagePath);           
			$front_filePath	= Storage::disk('public')->path($front);
			
			if($doctype == 1)
			{
				$token_url   			= Config::get('custom.authbridge.ocr_adhar.token_url');
				$token_decrypt_url      = Config::get('custom.authbridge.ocr_adhar.token_decrypt_url');
				$encrypted_url      	= Config::get('custom.authbridge.ocr_adhar.encrypted_url');
				$verify_url      		= Config::get('custom.authbridge.ocr_adhar.verify_url');
				$decrypt_encrypted_string_url      = Config::get('custom.authbridge.ocr_adhar.decrypt_encrypted_string_url');
				$username               = Config::get('custom.authbridge.ocr_adhar.username');
				$api_id                 = Config::get('custom.authbridge.ocr_adhar.api_id');
				$api_name               = Config::get('custom.authbridge.ocr_adhar.api_name');
				$vendor                 = Config::get('custom.authbridge.ocr_adhar.vender');
				
				
				$back = date('Y_m_d_His') . '_' . $backImage->getClientOriginalName();
				$backImagePath = isset($backImage) ? $backImage->storeAs('ocr', $back) :'';
				$backImagePath = isset($backImage) ? storage_path('app/' . $backImagePath) : '';
				$back_filePath	= Storage::disk('public')->path($back);
			
			
			} 
			else if($doctype == 3)
			{
				$token_url   			= Config::get('custom.authbridge.ocr_pan.token_url');
				$token_decrypt_url      = Config::get('custom.authbridge.ocr_pan.token_decrypt_url');
				$encrypted_url      	= Config::get('custom.authbridge.ocr_pan.encrypted_url');
				$verify_url      		= Config::get('custom.authbridge.ocr_pan.verify_url');
				$decrypt_encrypted_string_url      = Config::get('custom.authbridge.ocr_pan.decrypt_encrypted_string_url');
				$username               = Config::get('custom.authbridge.ocr_pan.username');
				$api_id                 = Config::get('custom.authbridge.ocr_pan.api_id');
				$api_name               = Config::get('custom.authbridge.ocr_pan.api_name');
				$vendor                 = Config::get('custom.authbridge.ocr_pan.vender');
				
				$back = date('Y_m_d_His') . '_' . $frontImage->getClientOriginalName();
				$backImagePath = isset($frontImage) ? $frontImage->storeAs('ocr', $back) :'';
				$backImagePath = isset($frontImage) ? storage_path('app/' . $backImagePath) : '';
				$back_filePath	= Storage::disk('public')->path($back);
			}
			
			else if($doctype == 4)
			{
				$token_url   			= Config::get('custom.authbridge.ocr_dl.token_url');
				$token_decrypt_url      = Config::get('custom.authbridge.ocr_dl.token_decrypt_url');
				$encrypted_url      	= Config::get('custom.authbridge.ocr_dl.encrypted_url');
				$verify_url      		= Config::get('custom.authbridge.ocr_dl.verify_url');
				$decrypt_encrypted_string_url      = Config::get('custom.authbridge.ocr_dl.decrypt_encrypted_string_url');
				$username               = Config::get('custom.authbridge.ocr_dl.username');
				$api_id                 = Config::get('custom.authbridge.ocr_dl.api_id');
				$api_name               = Config::get('custom.authbridge.ocr_dl.api_name');
				$vendor                 = Config::get('custom.authbridge.ocr_dl.vender');
				
				$back = date('Y_m_d_His') . '_' . $frontImage->getClientOriginalName();
				$backImagePath = isset($frontImage) ? $frontImage->storeAs('ocr', $back) :'';
				$backImagePath = isset($frontImage) ? storage_path('app/' . $backImagePath) : '';
				$back_filePath	= Storage::disk('public')->path($back);
			}
			else{
				$back = date('Y_m_d_His') . '_' . $frontImage->getClientOriginalName();
				$backImagePath = isset($frontImage) ? $frontImage->storeAs('ocr', $back) :'';
				$backImagePath = isset($frontImage) ? storage_path('app/' . $backImagePath) : '';
				$back_filePath	= Storage::disk('public')->path($back);
			}
 
            $dataStep1 = [
                'transID' => 213124,
                'docType' => $doctype
            ];
			// echo "<pre>"; print_r($dataStep1);die;
			$responseStep5 = '';
            $data = json_encode($dataStep1);

            // $jsonDataStep1 = json_encode($dataStep1);
            
            // if(empty($response))
            // {
                //------------------------- Step1-------------------------------------
                

                $headers = array(
                    'username:'.$username,

                );
                //echo "<pre>";print_r($headers);die;
                $curlStep1 = curl_init();
                curl_setopt($curlStep1, CURLOPT_URL, $token_url);
                curl_setopt($curlStep1, CURLOPT_POST, true);
                curl_setopt($curlStep1, CURLOPT_POSTFIELDS, $dataStep1);
                curl_setopt($curlStep1, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curlStep1, CURLOPT_RETURNTRANSFER, true);
                $responseStep1 = curl_exec($curlStep1);

                //return $responseStep1;
                if ($responseStep1 === false) {
                    $message = curl_error($curlStep1);
                    $statusCode = curl_errno($curlStep1);
                    $remark = 'Curl Error';
                    $return = array('status' => $statusCode, 'message'=> $message);
                }
                else
                { 
                    
                // ------------------------- Step2-------------------------------------
                
                    $jsonDataStep2 = $responseStep1;

                    $headers = array(
                        'username:'.$username,
                        'Content-Type: application/json'
                    );

                    $curlStep2 = curl_init();
                    curl_setopt($curlStep2, CURLOPT_URL, $token_decrypt_url);
                    curl_setopt($curlStep2, CURLOPT_POST, true);
                    curl_setopt($curlStep2, CURLOPT_POSTFIELDS, $jsonDataStep2);
                    curl_setopt($curlStep2, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curlStep2, CURLOPT_RETURNTRANSFER, true);
                    $responseStep2 = curl_exec($curlStep2);
                    
                    //echo "<pre>";print_r($responseStep2);exit;

                    if ($responseStep2 === false) {
                        $message = curl_error($curlStep2);
                        $statusCode = curl_errno($curlStep2);
                        $remark = 'Curl Error';
                        $return = array('status' => $statusCode, 'message'=> $message);
                    }
                    else
                    {   
                        $responseStep2Array = json_decode($responseStep2, true);
                        // $Token = $responseStep2['msg']['secretToken'];
                        // print_r($Token);exit;
                        // echo 1;
                        if (is_array($responseStep2Array) && array_key_exists('msg', $responseStep2Array)) {
                            $msg = $responseStep2Array['msg'];
                            //echo 2;
                            $Token = $responseStep2Array['msg']['secretToken'];
                            $transid  = $responseStep2Array['msg']['tsTransID'];
                            //===-----------------step 3------------------------------
                            $datastep3 = [
                                'token' => $Token,
                            ];
        
                            //$jsondatastep3 = json_encode($datastep3);
        
                            $headers = array(
                                'username:'.$username,
                            );

                            $curlStep3 = curl_init();
                            curl_setopt($curlStep3, CURLOPT_URL, $encrypted_url);
                            curl_setopt($curlStep3, CURLOPT_POST, true);
                            curl_setopt($curlStep3, CURLOPT_POSTFIELDS, $datastep3);
                            curl_setopt($curlStep3, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($curlStep3, CURLOPT_RETURNTRANSFER, true);
                            $responseStep3 = curl_exec($curlStep3);
                        
                            if ($responseStep3 === false) {
                                $message = curl_error($curlStep3);
                                $statusCode = curl_errno($curlStep3);
                                $remark = 'Curl Error';
                                $return = array('status' => $statusCode, 'message'=> $message);
                            } 
                            else 
                            {       
                                // $back_file_url = isset($back_file_url) ? $back_file_url : '';
                                ///////////////////////////step 4///////////////////////////
                                $datastep4 = [
                                    'tsTransID' => $transid,
                                    'secretToken' => $responseStep3,
                                    'front_image' => new \CURLFile($frontImagePath),
                                    'back_image' => new \CURLFile($backImagePath)
                                ];
            
                                //$jsondatastep4 = json_encode($datastep4);
            
                                $headers = array(
                                    'username:'.$username,
                                );
            
                                $curlStep4 = curl_init();
                                curl_setopt($curlStep4, CURLOPT_URL, $verify_url);
                                curl_setopt($curlStep4, CURLOPT_POST, true);
                                curl_setopt($curlStep4, CURLOPT_POSTFIELDS, $datastep4);
                                curl_setopt($curlStep4, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($curlStep4, CURLOPT_RETURNTRANSFER, true);
                                $responseStep4 = curl_exec($curlStep4);
            
                                if ($responseStep4 === false) {
                                    //echo 1;
                                    $message = curl_error($curlStep4);
                                    $statusCode = curl_errno($curlStep4);
                                    $remark = 'Curl Error';
                                    $return = array('status' => $statusCode, 'message'=> $message);
                                }
                                else
                                {   
                
                                    $jsonDataStep5 = $responseStep4;
                
                                    $headers = array(
                                        'username:'.$username,
                                        'Content-Type: application/json'
                                    );
                
                                    $curlStep5 = curl_init();
                                    curl_setopt($curlStep5, CURLOPT_URL, $decrypt_encrypted_string_url);
                                    curl_setopt($curlStep5, CURLOPT_POST, true);
                                    curl_setopt($curlStep5, CURLOPT_POSTFIELDS, $responseStep4);
                                    curl_setopt($curlStep5, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($curlStep5, CURLOPT_RETURNTRANSFER, true);
                                    $responseStep5 = curl_exec($curlStep5);
                
                                    if ($responseStep5 === false) {
                                        //echo 2;
                                        $message = curl_error($curlStep5);
                                        $statusCode = curl_errno($curlStep5);
                                        $remark = 'Curl Error';
                                        $return = array('status' => $statusCode, 'message'=> $message);
                                    }
                                    else
                                    { 

                                        $responseData = json_decode($responseStep5, true);

                                        //return $responseData;
                                        $message = isset($responseData['message']) ? $responseData['message'] : $responseData['msg'];
                                        $statusCode = isset($responseData['status_code']) ? $responseData['status_code'] : $responseData['status'];
                                        $status_code = isset($responseData['status']) ? $responseData['status'] : '';
                                        $remark = 'Response from Vendor API';
                                        if($statusCode == 200 || $status_code == 1)
                                        {
                                            $return = $responseData;
                                        }
                                        else{
                                            $return = array('status' => $statusCode, 'message'=> $message);
                                        }

                                    }
                                }
                            }
                    }
                    else{
                        $return = array('status' => 404, 'message'=> 'Error in getting data');
                    }

                    }
                }
            
				$this->updateUtilizedCredit($sessionData['Client_id']);
				$ocrType = '';
				if($doctype == 1){
					$ocrType = 'Adhar_card';
				}
				if($doctype == 3){
					$ocrType = 'pan_card';
				}
				if($doctype == 4){
					$ocrType = 'Driving_license';
				}

				$api_log =  new Rcdetails();
				$api_log->api_id = $api_id;
				$api_log->api_name = $api_name;
				$api_log->vender = $vendor;
				$api_log->user_id = $sessionData['userID'];
				$api_log->client_id = $sessionData['Client_id'];
				$api_log->client_name = $sessionData['clientName'];
				$api_log->response_status_code = isset($status_code) ? $status_code : '';
				$api_log->response_message  = isset($message) ? $message : '';
				$api_log->remark  = isset($remark) ? $remark : '';
				$api_log->api_url = $decrypt_encrypted_string_url;
				$api_log->request = $data;
				$api_log->input = $ocrType;
				$api_log->response = $responseStep5;//$responseStep5;
				$api_log->response_from = $response_from;
				$api_log->status = '1';
				$api_log->method = $method;
				$api_log->save(); 

				$logid = $api_log->id;

				$ocr = new Ocrdetails();
				$ocr->file1 = $front_filePath;
				$ocr->file2 = $back_filePath;
				$ocr->api_logid = $logid;
				$ocr->type = $ocrType;
				$ocr->status = 1;
				$ocr->created_at = now();
				$ocr->save(); 

				return $return;

			}
			else{
				$return = array('status' => 404, 'message'=> 'please upload file.');
			}
        }
    }


    public function invincibleOCRPostData(Request $request)
    {               
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }
        else
		{  
			if ($request->hasFile('front_image')) 
			{
				$response_from = 1;            
				$method = 'POST';
				$frontImage = $request->file('front_image');
				$backImage = $request->file('back_image');
				$doctype = $request->input('doctype');
				$front = date('Y_m_d_His') . '_' . $frontImage->getClientOriginalName();
				$frontImagePath = $frontImage->storeAs('ocr', $front);
				$frontImagePath = storage_path('app/' . $frontImagePath);           
				$front_filePath	= Storage::disk('public')->path($front);
                $back = date('Y_m_d_His') . '_' . $backImage->getClientOriginalName();
                $back_filePath	= Storage::disk('public')->path($back);
                $mime = File::mimeType($frontImagePath);
                $postname = basename($frontImagePath);

				
				//if($doctype == 3){
                $apiUrl     = Config::get('custom.invincible.pan_ocr.url');
                $clientId   = Config::get('custom.invincible.pan_ocr.clientId');
                $secretKey  = Config::get('custom.invincible.pan_ocr.secretKey');
                $api_id     = Config::get('custom.invincible.pan_ocr.api_id');
                $api_name   = Config::get('custom.invincible.pan_ocr.api_name');
                $vendor     = Config::get('custom.invincible.pan_ocr.vender');
				//}				
                
                $method = 'POST';
                $pancard = $request->input('input');
                $response = "";

                // $response = $this->checkHistoryPanOCR($postname, $vendor);

               
               	$data = [
					'file' =>  new \CURLFile($frontImagePath)
				];
                $jsonData = json_encode($data);


                // $data = [
                //     'file' => new \CURLFile($frontImagePath, $mime,  $postname)
                // ];
                // print_r($data);

                $headers = array(
                    'clientId:'.$clientId,
                    'secretKey:'.$secretKey,
                    'Content-Type: multipart/form-data'
                );
                
            

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
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
                        $this->addHistorypanocr($postname,$vendor, $jsonData, $response,$error_no);
                        $return = $responseData;
                    }
                    else{
                        $return = json_encode(array('code' => $error_no, 'message'=> $error));
                    }

                }
                    
                    
                $this->updateUtilizedCredit($sessionData['Client_id']);
                $ocrType = 'pan_card';
                $api_log =  new Rcdetails();
                $api_log->api_id = $api_id;
                $api_log->api_name = $api_name;
                $api_log->vender = $vendor;
                $api_log->user_id = $sessionData['userID'];
                $api_log->client_id = $sessionData['Client_id'];
                $api_log->client_name = $sessionData['clientName'];
                $api_log->response_status_code = isset($error_no) ? $error_no : '';
                $api_log->response_message  = isset($message) ? $message : '';
                $api_log->remark  = isset($remark) ? $remark : '';
                $api_log->api_url = $apiUrl;
                $api_log->request = $jsonData ;
                $api_log->input = $postname ;
                $api_log->response = $response;//$responseStep5;
                $api_log->response_from = $response_from;
                $api_log->status = '1';
                $api_log->method = $method;
                $api_log->save(); 

                $logid = $api_log->id;

                $ocr = new Ocrdetails();
                $ocr->file1 = $front_filePath;
                $ocr->file2 = $back_filePath;
                $ocr->api_logid = $logid;
                $ocr->type = $ocrType;
                $ocr->status = 1;
                $ocr->created_at = now();
                $ocr->save(); 

                return $return;
               
            }

        }
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

    public function addHistorypanocr($filename,$vendor, $request, $response,$status_code){
        $createdAt = now();
        return DB::table('history_panocr')->insert([
            'filename' => $filename,
            'vendor' => $vendor,
            'request' => $request,
            'status_code' => $status_code,
            'response' => $response,
            'status' => 1,
            'created_at' => $createdAt,
        ]);
    }


    public function checkHistoryPanOCR($filename,$vendor){

        $returnArr = '';
        $result = DB::select("SELECT id, response FROM `history_panocr` WHERE filename = '$filename' AND vendor = '$vendor' AND `status` IN (0,1) AND created_at >= 
        CASE 
            WHEN status_code IN ('404','9') THEN DATE_SUB(NOW(), INTERVAL 1 DAY) 
            ELSE DATE_SUB(NOW(), INTERVAL 7 DAY) 
        END ORDER BY id DESC LIMIT 1");

        print_r($result);

        if (!empty($result)) {
            
            $returnArr = $result[0]->response;
        }

        // echo "<pre>"; print_r($returnArr);die;
        return $returnArr;

    }
}
