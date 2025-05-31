<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonTraits;
use App\Traits\ApisTraits;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Models\Rcdetails;

class NameMatchController extends Controller
{
    use CommonTraits;
    use ApisTraits;

    public function name_matchView(){
        return view("name_match.name_match");
    }

    public function namematchPost(Request $request){
        $sessionData = session('data');
        if($this->checkCredit() === false)
        {
            return response()->json(['status' => 'No more credit limit available']);
        }else{
            $response_from = 1;
            $apiUrl     = Config::get('custom.invincible.name_match.url');
            $clientId   = Config::get('custom.invincible.name_match.clientId');
            $secretKey  = Config::get('custom.invincible.name_match.secretKey');
            $api_id     = Config::get('custom.invincible.name_match.api_id');
            $api_name   = Config::get('custom.invincible.name_match.api_name');
            $vendor     = Config::get('custom.invincible.name_match.vender');


            // Get the vehicle number from the request
            $method = 'POST';
            $name1 = $request->input('name1');
            $name2 = $request->input('name2');
            $response = "";


            // $response = $this->checkHistoryAadhar($aadhar_no, $vendor);
            $data = [
                'type' =>  'nameMatchV2',
                'name1' => $name1,
                'name2' => $name2
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

                // print_r($response);
				
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
						// $this->addHistoryaadhar($aadhar_no, $vendor, $jsonData, $response,$error_no);
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
            $api_log->input = json_encode([
                'name1' => $name1,
                'name2' => $name2
            ]);
            $api_log->response = $response;
            $api_log->response_from = $response_from;
            $api_log->status = '1';
            $api_log->method = $method;
            $api_log->save();
            return $return;
        }
    }
}
