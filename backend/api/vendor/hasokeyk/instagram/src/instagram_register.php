<?php
    
    namespace instagram;
    
    class instagram_register extends instagram_request{
        
        public $username;
        public $password;
        public $functions;
        public $user_info;
        public $register_cookie = null;
        
        function __construct($username, $password, $functions = null){
            $this->username  = $username;
            $this->password  = $password;
            $this->functions = $functions;
        }
        
        public function register_step_cookie_mid(){
            
            $url     = 'https://www.instagram.com/ajax/bz';
            $headers = [
                'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0',
                'X-Web-Device-Id' => '6CAB518D-4AE9-49C0-82FB-84A4960F875D',
                //'X-Ig-App-Id'      => '936619743392459',
                //'X-Mid'            => 'qptjl42ctvrl133v8mzp5q7avwa0jbnkufiq618ehj4fv9tyjg',
                //'X-Asbd-Id'        => '198387',
                //'X-Requested-With' => 'XMLHttpRequest',
                'Referer'         => 'https://www.instagram.com/',
            ];
            $data    = [
                'q'  => '[{"page_id":"ervhq8","app_id":"936619743392459","device_id":"6CAB518D-4AE9-49C0-82FB-84A4960F875D","posts":[["qex:expose",{"universe_id":"e42bb34173aaba74caf60de2dabb1e9e","device_id":"6CAB518D-4AE9-49C0-82FB-84A4960F875D"},1639600484679,0],["ods:incr",{"key":"web.logged_out_3p_consent_dialog.new_dialog_shown"},1639600484931,0],["ods:incr",{"key":"web.logged_out_3p_consent_dialog.accept_attempt.accept_all"},1639600486873,0]],"trigger":"falco","send_method":"ajax"}]',
                'ts' => 1639600487790
            ];
            $json    = $this->request($url, 'POST', $data, $headers);
            $cookie  = $json['headers']['Set-Cookie'];
            
            $url     = 'https://www.instagram.com/data/shared_data/';
            
            $json    = $this->request($url, 'GET', null, $headers, $cookie);
            if(isset($json['headers']['Set-Cookie'])){
                foreach($json['headers']['Set-Cookie'] as $cookie){
                    if(strstr($cookie, 'mid=')){
                        preg_match('|mid=(.*?);|is', $cookie, $mid);
                        break;
                    }
                }
                if($mid != null){
                    return $mid[1];
                }
            }
            
            return false;
        }
        
        public function register_step_1_send_verify_email(){
            
            $url       = 'https://i.instagram.com/api/v1/accounts/send_verify_email/';
            $post_data = [
                'email'     => $this->user_info['email'],
                'device_id' => 'YbpK_gALAAEMBCHGKOjm0PWXAv5s',
            ];
            $headers   = [
                'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0',
                'X-Web-Device-Id'  => '6CAB518D-4AE9-49C0-82FB-84A4960F875D',
                'x-csrftoken'      => $this->get_csrftoken(),
                'X-Ig-App-Id'      => '936619743392459',
                'X-Mid'            => 'qptjl42ctvrl133v8mzp5q7avwa0jbnkufiq618ehj4fv9tyjg',
                'X-Asbd-Id'        => '198387',
                'X-Requested-With' => 'XMLHttpRequest',
                'Referer'          => 'https://www.instagram.com/',
            ];
            
            $cookie = [
                'mid'       => 'YB2r4AABAAERcl5ESNxLjr_tt4Q5',
                'csrftoken' => $this->get_csrftoken(),
            ];
            
            $json = $this->request($url, 'POST', $post_data, $headers, $cookie);
            if($json['status'] == 'ok'){
                $json = json_decode($json['body']);
            }
            return $json;
            
        }
        
        public function register_step_2_check_confirmation_code($code = null){
            
            if($code != null){
                
                $url       = 'https://i.instagram.com/api/v1/accounts/check_confirmation_code/';
                $post_data = [
                    'code'      => $code,
                    'device_id' => 'YbpK_gALAAEMBCHGKOjm0PWXAv5s',
                    'email'     => $this->user_info['email'],
                ];
                
                $headers   = [
                    'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0',
                    'X-Web-Device-Id'  => '6CAB518D-4AE9-49C0-82FB-84A4960F875D',
                    'x-csrftoken'      => $this->get_csrftoken(),
                    'X-Ig-App-Id'      => '936619743392459',
                    'X-Mid'            => 'qptjl42ctvrl133v8mzp5q7avwa0jbnkufiq618ehj4fv9tyjg',
                    'X-Asbd-Id'        => '198387',
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Referer'          => 'https://www.instagram.com/',
                ];
                
                $cookie = [
                    'mid'       => 'YB2r4AABAAERcl5ESNxLjr_tt4Q5',
                    'csrftoken' => $this->get_csrftoken(),
                ];
                
                $json = $this->request($url, 'POST', $post_data, $headers, $cookie);
                if($json['status'] == 'ok'){
                    $json = json_decode($json['body']);
                }
                return $json;
                
            }
            
            return false;
        }
        
        public function register_step_3_register($signup_code = null){
            
            if($signup_code != null){
                
                $url       = 'https://www.instagram.com/accounts/web_create_ajax/';
                $post_data = [
                    'enc_password'           => $this->functions->login->encrypt($this->user_info['password']),
                    'email'                  => ($this->user_info['email']),
                    'username'               => ($this->user_info['username']),
                    'first_name'             => ($this->user_info['first_name']),
                    'month'                  => ($this->user_info['month']),
                    'day'                    => ($this->user_info['day']),
                    'year'                   => ($this->user_info['year']),
                    'client_id'              => 'YB2r4AABAAERcl5ESNxLjr_tt4Q5',
                    'seamless_login_enabled' => 1,
                    'tos_version'            => 'row',
                    'force_sign_up_code'     => $signup_code,
                ];
                
                $headers   = [
                    'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0',
                    'X-Web-Device-Id'  => '6CAB518D-4AE9-49C0-82FB-84A4960F875D',
                    'x-csrftoken'      => $this->get_csrftoken(),
                    'X-Ig-App-Id'      => '936619743392459',
                    'X-Mid'            => 'qptjl42ctvrl133v8mzp5q7avwa0jbnkufiq618ehj4fv9tyjg',
                    'X-Asbd-Id'        => '198387',
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Referer'          => 'https://www.instagram.com/',
                ];
                
                $cookie = [
                    'mid'       => 'YcSxIwALAAFkGvjK1a8GmQFLyorC',
                    'csrftoken' => $this->get_csrftoken(),
                ];
                
                $json = $this->request($url, 'POST', $post_data, $headers, $cookie);
                if($json['status'] == 'ok'){
                    $json = json_decode($json['body']);
                }
                return $json;
                
            }
            
            return false;
            
        }
        
  
        
        public function register(){
            
        
            
        }
        
        public function check_username($username = null){
            
            $username = $username ?? $this->username;
            
            $url       = 'https://i.instagram.com/api/v1/users/check_username/';
            $post_data = [
                'username' => $username,
                '_uuid'    => $this->get_guid(),
            ];
            $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
            $json      = $this->request($url, 'POST', $post_data);
            if($json['status'] == 'ok'){
                $json = json_decode($json['body']);
            }
            return $json;
            
        }
        
        public function check_email($email = null){
            
            if($email != null){
                $url       = 'https://i.instagram.com/api/v1/users/check_email/';
                $post_data = [
                    'email' => $email,
                    '_uuid' => $this->get_guid(),
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                $json      = $this->request($url, 'POST', $post_data);
                if($json['status'] == 'ok'){
                    $json = json_decode($json['body']);
                }
                return $json;
            }
            
            return false;
        }
        
        public function check_phone_number($phone_number = null){
            
            if($phone_number != null){
                $url       = 'https://i.instagram.com/api/v1/accounts/check_phone_number/';
                $post_data = [
                    'phone_number'    => $phone_number,
                    '_uuid'           => $this->get_guid(),
                    'prefill_shown'   => false,
                    'login_nonce_map' => '{}',
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                $json      = $this->request($url, 'POST', $post_data);
                if($json['status'] == 'ok'){
                    $json = json_decode($json['body']);
                }
                return $json;
            }
            
            return false;
        }
        
        public function get_steps(){
            
            $url       = 'https://i.instagram.com/api/v1/dynamic_onboarding/get_steps/';
            $post_data = [
                'is_secondary_account_creation' => 'false',
                'fb_connected'                  => 'false',
                'seen_steps'                    => "[]",
                'progress_state'                => "prefetch",
                'fb_installed'                  => "false",
                'is_ci'                         => "false",
                'network_type'                  => "WIFI-UNKNOWN",
                'waterfall_id'                  => "57d01ad3-6555-49ac-b7f5-69da74f241367",
                'tos_accepted'                  => "false",
                'phone_id'                      => $this->get_phone_id(),
                '_uuid'                         => $this->get_guid(),
                'guid'                          => $this->get_guid(),
                '_csrftoken'                    => $this->get_csrftoken(),
                'android_id'                    => $this->get_device_id(),
            ];
            $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
            $json      = $this->request($url, 'POST', $post_data);
            if($json['status'] == 'ok'){
                $json = json_decode($json['body']);
            }
            return $json;
            
        }
        
        public function register_old($username = null, $password = null, $email = null, $first_name = null, $month = '01', $day = '01', $year = '1991'){
            
            $username = $username ?? $this->username;
            $password = $password ?? $this->password;
            
            $url       = 'https://www.instagram.com/accounts/web_create_ajax/';
            $post_data = [
                'enc_password'           => $this->encrypt($password),
                'email'                  => $email,
                'username'               => $username,
                'first_name'             => $first_name,
                'month'                  => "false",
                'day'                    => "false",
                'year'                   => "WIFI-UNKNOWN",
                'client_id'              => "97d01ad3-6555-49ac-b7f5-69da7f241367",
                'seamless_login_enabled' => "false",
                'tos_version'            => $this->get_phone_id(),
                'force_sign_up_code'     => $this->get_guid(),
            ];
            $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
            $json      = $this->request($url, 'POST', $post_data);
            if($json['status'] == 'ok'){
                $json = json_decode($json['body']);
            }
            return $json;
            
        }
    }