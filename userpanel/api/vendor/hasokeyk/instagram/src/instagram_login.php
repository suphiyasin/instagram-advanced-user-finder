<?php
    
    namespace instagram;
    
    class instagram_login extends instagram_request{
        
        public $username;
        public $password;
        public $functions;
        
        function __construct($username, $password, $functions = null){
            $this->username  = $username;
            $this->password  = $password;
            $this->functions = $functions;
        }
        
        public function login($username = null, $password = null){
            
            $username       = $username ?? $this->username;
            $password       = $password ?? $this->password;
            $this->username = $username;
            
            $cookie = $this->cache('sessionid');
            if($cookie == false){
                
                $url       = 'https://i.instagram.com/api/v1/accounts/login/';
                $password  = $this->encrypt($password);
                $post_data = [
                    'jazoest'             => '22356',
                    'country_codes'       => '[{"country_code":"90","source":["sim","network","default","sim"]}]',
                    'phone_id'            => $this->get_phone_id(),
                    'enc_password'        => $password,
                    '_csrftoken'          => $this->get_csrftoken(),
                    'username'            => $username,
                    'adid'                => $this->get_adid(),
                    'guid'                => $this->get_guid(),
                    'device_id'           => $this->get_device_id(),
                    'google_tokens'       => '[]',
                    'login_attempt_count' => '0',
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $cookie = [
                    'mid'       => 'YB2r4AABAAERcl5ESNxLjr_tt4Q5',
                    'csrftoken' => $this->get_csrftoken(),
                ];
                
                $result = $this->request($url, 'POST', $post_data, null, $cookie);
                return $this->login_check($result);
                
            }
            else{
                return true;
            }
            
        }
        
        private function login_check($json = null){
            if($json != null){
                $json_body = json_decode($json['body']);
                if(!isset($json_body->two_factor_required)){
                    if($json_body->status == 'ok'){
                        $cookie = $this->cache('sessionid');
                        if($cookie == false){
                            foreach($json['headers']['ig-set-authorization'] as $cookie){
                                $this->cache('Bearer', $cookie);
                                preg_match('|Bearer IGT:(.*):(.*)|isu', $cookie, $session_json);
                                $session_json = json_decode(base64_decode($session_json[2]));
                                $this->cache('sessionid', $session_json->sessionid);
                            }
                        }
                        return true;
                    }
                }
                else{
                    return (object) [
                        'two_factor_identifier' => $json_body->two_factor_info->two_factor_identifier
                    ];
                }
            }
            return false;
        }
        
        public function two_factor_login($code = null, $two_factor_identifier = null){
            
            if($code != null and $two_factor_identifier != null){
                
                $username = $this->username;
                
                $url       = 'https://i.instagram.com/api/v1/accounts/two_factor_login/';
                $post_data = [
                    'verification_code'     => $code,
                    'phone_id'              => $this->get_phone_id(),
                    'two_factor_identifier' => $two_factor_identifier,
                    'trust_this_device'     => 1,
                    '_csrftoken'            => $this->get_csrftoken(),
                    'username'              => $username,
                    'adid'                  => $this->get_adid(),
                    'guid'                  => $this->get_guid(),
                    'device_id'             => $this->get_device_id(),
                    'verification_method'   => 1,
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $cookie = [
                    'mid'       => 'YB2r4AABAAERcl5ESNxLjr_tt4Q5',
                    'csrftoken' => $this->get_csrftoken(),
                ];
                
                $result = $this->request($url, 'POST', $post_data, null, $cookie);
                return $this->login_check($result);
                
            }
            
            return false;
            
        }
        
        public function login_control($username = null){
            try{
                $url         = 'https://i.instagram.com/api/v1/accounts/get_resurrection_days/';
                $result      = $this->request($url);
                $result_body = json_decode($result['body']);
                if($result_body->status == 'ok'){
                    return true;
                }
                return false;
            }
            catch(\Exception $err){
                return false;
            }
        }
        
        public function encrypt($password){
            
            $keys          = $this->get_sync();
            $public_key    = $keys->pub_key;
            $public_key_id = $keys->pub_key_id;
            
            $key  = openssl_random_pseudo_bytes(32);
            $iv   = openssl_random_pseudo_bytes(12);
            $time = time();
            
            openssl_public_encrypt($key, $encryptedAesKey, base64_decode($public_key));
            $encrypted = openssl_encrypt($password, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag, strval($time));
            
            $payload = base64_encode("\x01" | pack('n', intval($public_key_id)).$iv.pack('s', strlen($encryptedAesKey)).$encryptedAesKey.$tag.$encrypted);
            
            return sprintf('#PWD_INSTAGRAM:4:%s:%s', $time, ($payload));
            
        }
        
        public function get_sync(){
            
            $keys = $this->cache('app_key');
            if($keys == false){
                
                $url       = 'https://i.instagram.com/api/v1/qe/sync/';
                $post_data = [
                    '_csrftoken'              => $this->get_csrftoken(),
                    'id'                      => 'F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B',
                    'server_config_retrieval' => '1',
                    'experiments'             => "ig_growth_android_profile_pic_prefill_with_fb_pic_2,ig_account_identity_logged_out_signals_global_holdout_universe,ig_android_caption_typeahead_fix_on_o_universe,ig_android_retry_create_account_universe,ig_android_gmail_oauth_in_reg,ig_android_quickcapture_keep_screen_on,ig_android_smartlock_hints_universe,ig_android_reg_modularization_universe,ig_android_login_identifier_fuzzy_match,ig_android_passwordless_account_password_creation_universe,ig_android_security_intent_switchoff,ig_android_sim_info_upload,ig_android_device_verification_fb_signup,ig_android_reg_nux_headers_cleanup_universe,ig_android_direct_main_tab_universe_v2,ig_android_nux_add_email_device,ig_android_fb_account_linking_sampling_freq_universe,ig_android_device_info_foreground_reporting,ig_android_suma_landing_page,ig_android_device_verification_separate_endpoint,ig_android_direct_add_direct_to_android_native_photo_share_sheet,ig_android_device_detection_info_upload,ig_android_device_based_country_verification",
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $headers = [
                    'User-Agent'       => $this->user_agent,
                    'DEBUG-IG-USER-ID' => 0,
                    'Host'             => 'i.instagram.com',
                ];
                $res     = $this->request($url, 'POST', $post_data, $headers, null, false);
                
                $result = (object) [
                    'pub_key_id' => $res['headers']['ig-set-password-encryption-key-id'][0],
                    'pub_key'    => $res['headers']['ig-set-password-encryption-pub-key'][0],
                ];
                $this->cache('app-key', $result);
                //$this->get_launcher_sync();
            }
            else{
                $result = $keys;
            }
            return $result;
        }
        
        public function get_launcher_sync(){
            
            $keys = $this->cache('app_key');
            if($keys == false){
                
                $url       = 'https://i.instagram.com/api/v1/launcher/sync/';
                $post_data = [
                    '_csrftoken'              => 'khugUa357Qq939C5NQ2fReWGZXUraEzZ',
                    'id'                      => 'F2CD7326-EA40-44F8-9FC3-71A0A5E1F55B',
                    'server_config_retrieval' => '1',
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $headers = [
                    'User-Agent'       => $this->user_agent,
                    'DEBUG-IG-USER-ID' => 0,
                    'Host'             => 'i.instagram.com',
                ];
                $res     = $this->request($url, 'POST', $post_data, $headers, null, false);
                
                $result = (object) [
                    'pub_key_id' => $res['headers']['ig-set-password-encryption-key-id'][0],
                    'pub_key'    => $res['headers']['ig-set-password-encryption-pub-key'][0],
                ];
                $this->cache('launcheR_sync', $result);
                
            }
            else{
                $result = $keys;
            }
            return $result;
        }
        
        public function logout($username = null){
            
            $username = $username ?? $this->username;
            
            $url         = 'https://i.instagram.com/api/v1/accounts/logout/';
            $post_data   = [
                'phone_id'          => $this->get_phone_id(),
                '_csrftoken'        => $this->get_csrftoken(),
                'guid'              => $this->get_guid(),
                'device_id'         => $this->get_device_id(),
                '_uuid'             => $this->get_guid(),
                'one_tap_app_login' => 'true',
            ];
            $result      = $this->request($url, 'POST', $post_data);
            $result_body = json_decode($result['body']);
            if($result_body->status == 'ok'){
                if(file_exists($this->cache_path.$username)){
                    $this->del_tree($this->cache_path.$username, '');
                }
                return true;
            }
            
            return false;
        }
        
        public static function del_tree($dir){
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach($files as $file){
                (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        }
        
    }