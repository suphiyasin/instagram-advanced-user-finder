<?php
    
    namespace instagram;
    
    class instagram_upload extends instagram_request{
    
        public $username;
        public $password;
        public $functions;
    
        function __construct($username, $password, $functions = null){
            $this->username  = $username;
            $this->password  = $password;
            $this->functions = $functions;
        }
        
        public function get_upload_session_id($upload_id = null, $r_upload_param = 0){
            $upload_id             = $upload_id??$this->get_upload_id();
            $randTmpFileStr        = rand(3000000000000, 4000000000000);
            $tmpFilePath           = '/data/data/com.instagram.android/files/pending_media_images/pending_media_.'.$randTmpFileStr.'jpg,';
            $tmpFileStringHashCode = $this->hash_code($tmpFilePath);
            $formatStr             = '%s_%s_%s';
            return sprintf($formatStr, $upload_id, $r_upload_param, $tmpFileStringHashCode);
        }
        
        public function hash_code($str){
            $h = 0;
            if($h == 0 && strlen($str) > 0){
                $val = $str;
                for($i = 0; $i < strlen($val); $i++){
                    $hash = 31 * $h + ord($val[$i]);
                    $ch   = $hash % 4294967296;
                    if($ch > 2147483647){
                        $h = $ch - 4294967296;
                    }
                    else{
                        if($ch < -2147483648){
                            $h = $ch + 4294967296;
                        }
                        else{
                            $h = $ch;
                        }
                    }
                }
                
            }
            return $h;
        }
        
        public function get_upload_id($minutes = null){
            return time();
        }
    
        public function rupload_params($upload_id) {
            $retryContext = [
                "num_step_auto_retry" => 0,
                "num_reupload" => 0,
                "num_step_manual_retry" => 0
            ];
            $image_comp = [
                "lib_name" => "moz",
                "lib_version" => "3.1.m",
                "quality" => "89",
                "ssim" => 0.9966439604759216
            ];
        
            $data = [
                "retry_context" => json_encode($retryContext),
                "media_type" => 1,
                "upload_id" => $upload_id,
                "xsharing_user_ids" => "[]",
                "image_compression" => json_encode($image_comp),
                "original_photo_pdq_hash" => ""
            ];
            return json_encode($data);
        }
        
    }