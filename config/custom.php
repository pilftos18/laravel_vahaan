<?php
return [
    'low_credit_limit' => 50,
    'max_credit_limit' => 20000000,
    //api for ac_auth_bridge
    'rc_authbridge' => [
        'rc_authbridge_url' => 'https://rc-webapi.edas.tech/rc_authbridge/Api/leadVahan',
        'rc_authbridge_token' => '7e3b270222252b2dadd547fb',
    ],
    //api for challan 
    'challan' => [
        'challan_url' => 'https://rc-webapi.edas.tech/challan/Api/leadVahan',
        'challan_token' => '7e3b270222252b2dadd547fb',
    ],
    'challan_chassis' => [
        'challan_url' => 'https://api.emptra.com/emptra/vehicleChallanInfo',
        'clientId' => 'a91c056f0527e1afddefc8021e5e6729:898e2dc71d7f0ed9dcda62e95ddf0cd4',
        'secretKey' => 'lvX99tB5L6hx7oTFfASgor4tLZcYEZXFR2Z2n0BaBzp69omlNf6TlxxneAI6LooPF',
    ],

    //api for driving license
    'license' => [
        'license_url' => 'https://rc-webapi.edas.tech/DL_VAHAN_API/Api/CheckVahan',
        'license_token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9',
    ],
    'invincible' => [
        'rc' => [
            'url' => 'https://api.invincibleocean.com/invincible/vehicleRcV6',
            'clientId' => '362b4fe098dbd9ba9e524d33b3821bd7:074aa1c4256789ea9ae0dcfe180a379e',
            'secretKey' => 'frp2y8e2pgmLIb7XXe1wmEMawW88N1a2ApVa95lsQ3w3byhifoioPR799KjSJSbRp',
            'api_id' => '24',
            'api_name' => 'rc',
            'vender' => 'invincible'
        ],
        'rc_chassis' => [
            'url' => 'https://api.invincibleocean.com/invincible/vehicleByChassis',
            'clientId' => '2e6d5ee61c9fe9b967545584fc987dc1:72796fe5ab3185d7220e46c1cf1cf738',
            'secretKey' => '2wS159z7jESHJPVzal6iJJIRIqiqmxgmoPwJzEw9CpYiOrQwb265rHQ8V2EPrTGAj',
            'api_id' => '9',
            'api_name' => 'rc_chassis',
            'vender' => 'invincible'
        ],
        'challan_chassis' => [
            'challan_url' => 'https://api.emptra.com/emptra/vehicleChallanInfo',
            'clientId' => 'a91c056f0527e1afddefc8021e5e6729:898e2dc71d7f0ed9dcda62e95ddf0cd4',
            'secretKey' => 'lvX99tB5L6hx7oTFfASgor4tLZcYEZXFR2Z2n0BaBzp69omlNf6TlxxneAI6LooPF',
            'api_id' => '8',
            'api_name' => 'challan_chassis',
            'vender' => 'invincible'
        ],
        'chassis_rc' => [
            'url' => 'https://api.invincibleocean.com/invincible/vehicleByChassis',
            'clientId' => '2e6d5ee61c9fe9b967545584fc987dc1:72796fe5ab3185d7220e46c1cf1cf738',
            'secretKey' => '2wS159z7jESHJPVzal6iJJIRIqiqmxgmoPwJzEw9CpYiOrQwb265rHQ8V2EPrTGAj',
            'api_id' => '25',
            'api_name' => 'chassis_rc',
            'vender' => 'invincible'
        ],
        'license' => [
            'url' => 'https://api.invincibleocean.com/invincible/drivingLicenceV2',
            'clientId' => '6bfc5c21e9789d51237e57a2e0bff73a:d149b1b64219bf39798494af8e1ef341',
            'secretKey' => 'e4if7FXjXdpC9UjnCMBXT0HUvtwjVXqTcqAo4WsmWpTUZZodwDneDHBP8di1Zp7eW',
            'api_id' => '26',
            'api_name' => 'license',
            'vender' => 'invincible'
        ],
        'pancard' => [
            'url' => 'https://api.invincibleocean.com/invincible/PANpluspro',
            'clientId' => '6bfc5c21e9789d51237e57a2e0bff73a:d149b1b64219bf39798494af8e1ef341',
            'secretKey' => 'e4if7FXjXdpC9UjnCMBXT0HUvtwjVXqTcqAo4WsmWpTUZZodwDneDHBP8di1Zp7eW',
            'api_id' => '27',
            'api_name' => 'pancard',
            'vender' => 'invincible'
        ],
        'pan_ocr' => [
            'url' => 'https://api.invincibleocean.com/invincible/ocr/pan',
            'clientId' => '6bfc5c21e9789d51237e57a2e0bff73a:d149b1b64219bf39798494af8e1ef341',
            'secretKey' => 'e4if7FXjXdpC9UjnCMBXT0HUvtwjVXqTcqAo4WsmWpTUZZodwDneDHBP8di1Zp7eW',
            'api_id' => '28',
            'api_name' => 'pan_ocr',
            'vender' => 'invincible'
        ],
        'aadhar_verification' => [
            'url' => 'https://api.invincibleocean.com/invincible/aadhaarValidation/V2',
            'clientId' => '6bfc5c21e9789d51237e57a2e0bff73a:d149b1b64219bf39798494af8e1ef341',
            'secretKey' => 'e4if7FXjXdpC9UjnCMBXT0HUvtwjVXqTcqAo4WsmWpTUZZodwDneDHBP8di1Zp7eW',
            'api_id' => '29',
            'api_name' => 'aadhar_verification',
            'vender' => 'invincible'
        ],
        'name_match' => [
            'url' => 'https://api.invincibleocean.com/invincible/nameMatcher',
            'clientId' => '6bfc5c21e9789d51237e57a2e0bff73a:d149b1b64219bf39798494af8e1ef341',
            'secretKey' => 'e4if7FXjXdpC9UjnCMBXT0HUvtwjVXqTcqAo4WsmWpTUZZodwDneDHBP8di1Zp7eW',
            'api_id' => '31',
            'api_name' => 'name_match',
            'vender' => 'invincible'
        ]
    ],
    'signzy' => [
        'rc' => [
            'url' => 'https://signzy.tech/api/v2/patrons/6412a199573cb600295a8f1f/vehicleregistrations',
            'Authorization' => '4O0LsUXHzaRxTISNvP3L931Y33Tw9hwNWu4KpSCXhrzC1AltNuT85Tvq1pcvQEYQ',
            'api_id' => '1',
            'api_name' => 'rc',
            'vender' => 'signzy'
        ],
        'challan' => [
            'url' => 'https://signzy.tech/api/v2/patrons/6412a199573cb600295a8f1f/vehicleregistrations',
            'Authorization' => 'sZHwxSnw3CLjvPesW3sT0ePjddFs66G00zKhx7SQt7bkfGMHQ5TKVvWZFcyVCkO2',
            'api_id' => '19',
            'api_name' => 'challan',
            'vender' => 'signzy'
        ],
        //////////////////////////
        'license' => [
            'url' => 'https://preproduction.signzy.tech/api/v2/snoops',
            'accessToken' => '7ut5ejo4quodooho6a3r2h555n939caso',
            'itemId' => '645cc8f11fb1350203242095',
            'api_id' => '6',
            'api_name' => 'license',
            'vender' => 'signzy',
            'service' => 'Identity',
            'task' => 'fetch'
        ],
        'chassis' => [
            'url' => 'https://api-preproduction.signzy.app/api/v3/vehicle/reverse-search',
            'Authorization' => 'uBw7XR0bpN9cnJ8ei5AucX6g5vgzD0vB',
            'api_id' => '19',
            'api_name' => 'chassis',
            'vender' => 'signzy'
        ],
        ///////////////////////////
    ],
    'SC' => [
        'rc' => [
            'url' => 'https://signzy.tech/api/v2/patrons/6412a199573cb600295a8f1f/vehicleregistrations',
            'Authorization' => 'sZHwxSnw3CLjvPesW3sT0ePjddFs66G00zKhx7SQt7bkfGMHQ5TKVvWZFcyVCkO2',
            'api_id' => '1',
            'api_name' => 'rc',
            'vender' => 'SC'
        ],
        
    ],
    'authbridge' => [
        'rc' => [
            'encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/encrypted_string',
            'utilitysearch_url' => 'https://www.truthscreen.com/api/v2.2/utilitysearch',
            'decrypt_encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'username' => 'prod_tataaig@edas.tech',
            'doc_type' => '372',
            'api_id' => '4',
            'api_name' => 'rc',
            'vender' => 'authbridge'
        ],
        'challan' => [
            'encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/encrypted_string',
            'utilitysearch_url' => 'https://www.truthscreen.com/EChallanApi/echallanRc',
            'decrypt_encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'username' => 'prod_tataaig@edas.tech',
            'doc_type' => '487',
            'api_id' => '5',
            'api_name' => 'challan',
            'vender' => 'authbridge'
        ],
        'license' => [
            'encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/encrypted_string',
            'utilitysearch_url' => 'https://www.truthscreen.com/api/v2.2/idsearch',
            'decrypt_encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'username' => 'test@edas.tech',
            'docType' => '326',
            'api_id' => '7',
            'api_name' => 'license',
            'vender' => 'authbridge'
        ],
        'pancard' => [
            'encrypted_string_url' => 'https://www.truthscreen.com/v1/apicall/encrypt',
            'utilitysearch_url' => 'https://www.truthscreen.com/v1/apicall/nid/panComprehensive',
            'decrypt_encrypted_string_url' => 'https://www.truthscreen.com/v1/apicall/decrypt',
            'username' => 'test@edas.tech',
            'docType' => '523',
            'api_id' => '22',
            'api_name' => 'pancard',
            'vender' => 'authbridge'
        ],
        'ocr_pan' => [
            'token_url' => 'https://www.truthscreen.com/api/v2.2/idocr/token',
            'token_decrypt_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'encrypted_url' => 'https://www.truthscreen.com/api/v2.2/idocr/tokenEncrypt',
            'verify_url' => 'https://www.truthscreen.com/api/v2.2/idocr/verify',
            'decrypt_encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'username' => 'test@edas.tech',
            'docType' => '1',
            'api_id' => '18',
            'api_name' => 'pan_ocr',
            'vender' => 'authbridge'
        ],
        'ocr_adhar' => [
            'token_url' => 'https://www.truthscreen.com/api/v2.2/idocr/token',
            'token_decrypt_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'encrypted_url' => 'https://www.truthscreen.com/api/v2.2/idocr/tokenEncrypt',
            'verify_url' => 'https://www.truthscreen.com/api/v2.2/idocr/verify',
            'decrypt_encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'username' => 'test@edas.tech',
            'docType' => '1',
            'api_id' => '20',
            'api_name' => 'adhar_ocr',
            'vender' => 'authbridge'
        ],
        'ocr_dl' => [
            'token_url' => 'https://www.truthscreen.com/api/v2.2/idocr/token',
            'token_decrypt_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'encrypted_url' => 'https://www.truthscreen.com/api/v2.2/idocr/tokenEncrypt',
            'verify_url' => 'https://www.truthscreen.com/api/v2.2/idocr/verify',
            'decrypt_encrypted_string_url' => 'https://www.truthscreen.com/InstantSearch/decrypt_encrypted_string',
            'username' => 'test@edas.tech',
            'docType' => '1',
            'api_id' => '21',
            'api_name' => 'dl_ocr',
            'vender' => 'authbridge'
        ],
    ],
    'edas_internal' => [
        'rc_logic' => [
            'url' => 'https://rc-webapi.edas.tech/taig/api/leadVahan',
            'token' => '7e3b270222252b2dadd547fb',
            'api_id' => '12',
            'api_name' => 'rc_logic',
            'vender' => 'edas_internal'
        ]
    ],
    'rto' => [
        'challan' =>[
                'url' => 'http://api.inbillsolutions.com/bbuser/vehicle_challan_detail',
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyZW1haWwiOiJ2aWJpbi52aW5jZW50QGVkYXMudGVjaCIsImlhdCI6MTY4ODE4ODY4NCwiZXhwIjoxNzE5NzI0Njg0fQ.42d_Ot0VN37Iy3Siwb9gTn9_mxoZ8yR_ZTQnNE7qKB8',
                'user_id' => '649fb70cb24c5f4d788169f0',
                'api_name' => 'challan',
                'vender' => 'rto',
                'api_id' => '13',
        ],
        'rc' =>[
            'url' => 'http://api.inbillsolutions.com/bbuser/vehicle_registration_detail_prime_reverse',
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyZW1haWwiOiJ2aWJpbi52aW5jZW50QGVkYXMudGVjaCIsImlhdCI6MTY4ODE4ODY4NCwiZXhwIjoxNzE5NzI0Njg0fQ.42d_Ot0VN37Iy3Siwb9gTn9_mxoZ8yR_ZTQnNE7qKB8',
            'user_id' => '649fb70cb24c5f4d788169f0',
            'api_name' => 'challan',
            'vender' => 'rto',
            'api_id' => '12',
        ]
    ],
    'digitap' =>[
        'license' =>[
            'url' => 'https://svcdemo.digitap.work/validation/kyc/v1/dl',
            'Authorization' => 'Basic NTMzNDU1Mjc6Q1JqSDR4TXgySFVXTzRZMXp1NmtmSUxTemplY0pBYkc=',
            'api_name' => 'license',
            'vender' => 'digitap',
            'client_ref_num' => '1234',
            'api_id' => '17',
        ]
    ]
    ,
    'surepass' => [
        'rc' => [
            'url' => 'https://kyc-api.aadhaarkyc.io/api/v1/rc/rc',
            'authorization_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTYyNjg2ODg1MywianRpIjoiMTk1ODE1ZTEtZTZjMy00ZjZlLWIzYmUtM2FkNzc4ZGY2YzZiIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LmFteWdiQGFhZGhhYXJhcGkuaW8iLCJuYmYiOjE2MjY4Njg4NTMsImV4cCI6MTk0MjIyODg1MywidXNlcl9jbGFpbXMiOnsic2NvcGVzIjpbInJlYWQiXX19.a5z7N9xJ5Nc-HccrFsP3feSFIvA5Ben09RCUITCtk7k',
            'api_id' => '32',
            'api_name' => 'rc',
            'vender' => 'surepass'
        ]
    ]

];

?>