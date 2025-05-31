<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

trait CommonTraits	
{
    public function updateUtilizedCredit($clientId)
    {
        $query = DB::table('clients')
            ->where('id', $clientId)
            ->where('status', 1)
            ->where('del_status', 1)
            ->update([
                'used_credit' => DB::raw('used_credit + 1'),
                'max_count' => DB::raw('max_count - 1'),
            ]);
        return  $query;
    }

    public function checkCredit($clientID = '')
    {
        if(empty($clientID))
        {
            $sessionData = session('data');
            $clientID = (isset($sessionData['Client_id'])) ? $sessionData['Client_id'] : '' ;
        }
        $maxCnt = DB::select("SELECT max_count as max_count, envtype FROM `clients` WHERE id = '$clientID'");
        if($maxCnt[0]->max_count > 0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function getCredit($clientID = '')
    {
        if(empty($clientID))
        {
            $sessionData = session('data');
            $clientID = (isset($sessionData['Client_id'])) ? $sessionData['Client_id'] : '' ;
        }
        $maxCnt = DB::select("SELECT max_count as max_count, envtype FROM `clients` WHERE id = '$clientID'");
        
        return $maxCnt[0]->max_count;
    }

    public function validateVehicleNumber($vehicleNumber)
    {
        // Regular expression pattern for vehicle number validation
        // $regex = '/^[A-Z]{2}[0-9]{1,2}[A-Z]{1,2}[0-9]{1,4}$/';
        $regex = '/^[A-Z]{2}[0-9]{1,2}[A-Z0-9]{1,3}[0-9]{1,4}$/';
    
        // Test the vehicle number against the regex pattern
        $isValid = preg_match($regex, $vehicleNumber);
        if($isValid === 0)
        {
            // Velidate BH echo "inside:".$isValid;
          $BHregex = '/^\d{2}BH\d{1,4}[A-Z]{1,2}$/'; 
          $isValid = preg_match($BHregex, $vehicleNumber);
        }
        return $isValid === 1;
    }

    public function validateChassisNumber($Number)
    {
        // Regular expression pattern for vehicle number validation
        $regex = '/^[A-HJ-NPR-Z0-9]{17}$/i';
    
        // Test the vehicle number against the regex pattern
        $isValid = preg_match($regex, $Number);
    
        return $isValid === 1;
    }

    // public function filterVehicleNumber($vehicleNumber)
    // {
    //     $vehicleNumber  = trim($vehicleNumber);
    //     $vehicleStart   = substr($vehicleNumber, 0, 2);
    //     if (strtoupper($vehicleStart) == 'DL' && (strlen($vehicleNumber) == 11 || strlen($vehicleNumber) == 10) && $vehicleNumber[2] === '0') {
    //         $vehicleNumber = substr_replace($vehicleNumber, '', 2, 1);
    //     }
    //     return $vehicleNumber;
    // }

    public function filterVehicleNumber($vehicleNumber)
    {
        $vehicleNumber = trim($vehicleNumber);

        // Check if 'DL0' is present at the beginning of the vehicle number
        if (strpos($vehicleNumber, 'DL0') === 0) {
            $vehicleNumber = str_replace('DL0', 'DL', $vehicleNumber);
        }

        return $vehicleNumber;
    }

    // public function filterVehicleNumber($vehicleNumber)
    // {
    //     $vehicleNumber = trim($vehicleNumber);
        
    //     // Check if the first two characters are 'DL' and if the length is 11
    //     if (strlen($vehicleNumber) == 11 && strtoupper(substr($vehicleNumber, 0, 2)) === 'DL') {
    //         // Check if the third character is '0', and if so, remove it
    //         if ($vehicleNumber[2] == 0) {
    //             $vehicleNumber = substr_replace($vehicleNumber, '', 2, 1);
    //         }
    //     }
        
    //     return $vehicleNumber;
    // }

    // public function filterVehicleNumber($vehicleNumber)
    // {
    //     $vehicleNumber = trim($vehicleNumber);
        
    //     if (strlen($vehicleNumber) >= 10 && strtoupper(substr($vehicleNumber, 0, 2)) === 'DL') {
    //         if ($vehicleNumber[2] === '0') {
    //             // Remove the '0' character at the third position
    //             $vehicleNumber = substr_replace($vehicleNumber, '', 2, 1);
    //         }
    //     }
        
    //     return $vehicleNumber;
    // }
	
	public function sanitizeInputData($input, $type = '')
	{
		$input  = mb_convert_encoding(trim($input), 'UTF-8', 'UTF-8');
		if(!empty($type))
		{
			switch ($type) {
				case 'text':
					// Sanitize and validate for plain text input
					$input = strip_tags($input);
					break;
			}
		}
		return $input;
	}
}