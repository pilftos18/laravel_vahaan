<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Rcdetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\CommonTraits;
use App\Traits\ApisTraits;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


class AadharController extends Controller
{
    use CommonTraits;
    use ApisTraits;

    public function aadharverificationView(){
        return view('aadhar.aadhar');
        // echo "dkksfkmn";
    }

    public function aadharDataPost(Request $request){
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }else{
            $response_from = 1;
            $apiUrl     = Config::get('custom.invincible.aadhar_verification.url');
            $clientId   = Config::get('custom.invincible.aadhar_verification.clientId');
            $secretKey  = Config::get('custom.invincible.aadhar_verification.secretKey');
            $api_id     = Config::get('custom.invincible.aadhar_verification.api_id');
            $api_name   = Config::get('custom.invincible.aadhar_verification.api_name');
            $vendor     = Config::get('custom.invincible.aadhar_verification.vender');

            // Get the vehicle number from the request
            $method = 'POST';
            $aadhar_no = $request->input('input');
            $response = "";

            $response = $this->checkHistoryAadhar($aadhar_no, $vendor);
            $data = [
                'aadharNumber' => $aadhar_no
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
						$this->addHistoryaadhar($aadhar_no, $vendor, $jsonData, $response,$error_no);
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
            $api_log->input = $aadhar_no;
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;
            $api_log->save();
            return $return;
        }
    }

    public function checkHistoryAadhar($aadhar_no,$vendor){
        $returnArr = '';
        $result = DB::select("SELECT id, response FROM `history_aadhar` WHERE aadhar_no = '$aadhar_no' AND vendor = '$vendor' AND `status` IN (0,1) 
        ORDER BY id DESC LIMIT 1");

        if (!empty($result)) {
            
            $returnArr = $result[0]->response;
        }
        // echo "<pre>"; print_r($returnArr);die;
        return $returnArr;
    }

    public function addHistoryaadhar($aadhar_no,$vendor, $request, $response,$status_code){
        $createdAt = now();
        return DB::table('history_aadhar')->insert([
            'aadhar_no' => $aadhar_no,
            'vendor' => $vendor,
            'request' => $request,
            'status_code' => $status_code,
            'response' => $response,
            'status' => 1,
            'created_at' => $createdAt,
        ]);
    }
}
