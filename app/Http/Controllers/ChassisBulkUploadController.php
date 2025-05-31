<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Rcdetails;
use App\Models\Bulkfilelog;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\CommonTraits;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ChassisBulkUploadController extends Controller
{
    use CommonTraits;

    public function authbridgeViewRC()
    {
        return view('rc.rc_bulk');
    }
    
    public function invincibleChassisBulkData(Request $request)
    {
        $sessionData = session('data');
        
       // echo "<pre>"; print_r($sessionData);die;
        $request->validate([
            'rcdata' => 'required|file|mimes:csv,txt|max:20480', // Adjust the max file size as per your requirements
        ]);

        if ($request->hasFile('rcdata')) {
            $file = $request->file('rcdata');
            $fileName = date('Y_m_d_His') . '_' . $file->getClientOriginalName();
            // Move the uploaded file to the storage directory
            $file->storeAs('csv', $fileName, 'public');
            $existFileName = 'csv/'.$fileName;
            $fileExists = Storage::disk('public')->exists($existFileName);
            if($fileExists)
            {
                $filePath                       = Storage::disk('public')->path($existFileName);
                $vehicleNumbers                 = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $vehicleNumbers                 = array_slice($vehicleNumbers, 1);
                // Extract the first column from each line
                //echo "<pre>"; print_r($vehicleNumbers);
                $vehicleNumbers = array_map(function ($vehicleNumbers) {
                    $columns = str_getcsv($vehicleNumbers); // Parse CSV data from each line
                    return $columns[0]; // Return the first column (index 0) of each line
                }, $vehicleNumbers);
                $count  = count($vehicleNumbers);
                if($this->getCredit($sessionData['Client_id']) < $count)
                {
                    return response()->json(['status'=> 'failed', 'msg' => 'You do not have enough credit to perform this action. Please add credit to continue.']);
                }
                else if($count == 0)
                {
                    return response()->json(['status'=> 'failed', 'msg' => 'Sorry, empty file not allowed.']);

                }
                else if($count > 50001)
                {
                    return response()->json(['status'=> 'failed', 'msg' => 'You can not contain more then 50000 vehicles no in one file.']);

                }
                else
                {
                    // $filePath = Storage::disk('public')->path('csv/'.$fileName);
                    $Bulkfilelog =  new Bulkfilelog();
                    $Bulkfilelog->user_id = $sessionData['userID'];
                    $Bulkfilelog->client_id = $sessionData['Client_id'];
                    $Bulkfilelog->api_id = Config::get('custom.invincible.chassis_rc.api_id');
                    $Bulkfilelog->vendor = Config::get('custom.invincible.chassis_rc.vender');
                    $Bulkfilelog->filename = $fileName;
                    $Bulkfilelog->upload_url = $filePath;
                    $Bulkfilelog->api_name  = Config::get('custom.invincible.chassis_rc.api_name');
                    $Bulkfilelog->count     = $count;
                    $Bulkfilelog->processed_count  = 0;
                    $Bulkfilelog->status  = 1;
                    $Bulkfilelog->is_processed  = 1;
                    $Bulkfilelog->request_type  = 'chassis';
                    $Bulkfilelog->save();
                    
                    if($Bulkfilelog)
                    {
                        if(!empty($vehicleNumbers))
                        {
                            foreach($vehicleNumbers as $k => $input)
                            {
                                DB::table('cron_bulk_dump')->insert([
                                    'bulk_id' => $Bulkfilelog->id,
                                    'input' => $this->sanitizeInputData($input, 'text'),
                                    'status' => 1,
                                    'created_at' => now()
                                ]);
                            }
                        }
                        // $result = $this->processUploadedFiles($Bulkfilelog->id);
                        
                        $result['status'] = 'success';
                        if($result['status'] == 'success'){
                            return response()->json(['status'=> 'success', 'msg' => 'We have recieved your data please check the RC Bulk Upload List for the status in Report TAB.']);
                            // return redirect('rc.rc_bulk_upload')->with('success', 'We have recieved your data please check the RC Bulk Upload List for the status.');
                        }
                        else{
                        return response()->json(['status'=> 'failed', 'msg' => $result['msg']]);
                            // return redirect('rc.rc_bulk_upload')->with('failed', $result['msg']);
                        }
                            
                    }
                    else{
                        // redirect()->route('rc.rc_bulk_upload')->with('success', 'Sorry Unable to process the data!');
                        return response()->json(['status'=> 'failed', 'msg' => 'Sorry Unable to process the data.']);
                        // return redirect('rc.rc_bulk_upload')->with('failed', 'Sorry Unable to process the data');
                    }
                }
            }
            else{
                return response()->json(['status'=> 'failed', 'msg' => 'Sorry, Not able to find the data.']);
            }  
        }
        else{
            return response()->json(['status'=> 'failed', 'msg' => 'Sorry, Unable to find the file.']);
        }
    }

  
}
