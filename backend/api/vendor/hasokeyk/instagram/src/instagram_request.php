<?php
    
    namespace instagram;
    
    use GuzzleHttp\Exception\GuzzleException;
    
    class instagram_request{
        
        public  $headers;
        private $app_id    = '567067343352427';
        private $phone_id  = '833f3947-2366-42c7-a49e-88136c36f7ad';
        private $device_id = 'android-d96d1dea964853ad';
        private $guid      = 'f1c270c4-8663-40ef-8612-3dc8853b3459';
        private $adid      = 'f5904e05-349a-48ca-8516-8555ae99660c';
        
        public $cache_path   = (__DIR__).'/cache/';
        public $cache_prefix = 'insta';
        public $cache_time   = 10; //Minute
        
        public $user_agent = 'Instagram 215.0.0.27.359 Android (25/7.1.2; 160dpi; 540x960; Google/google; google Pixel 2; x86; android_x86; tr_TR; 337202363)';
        
        public $username;
        public $password;
        
        public $functions;
        public $proxy = null;
        
        function __construct($username, $password, $functions = null){
            
            $this->username  = $username;
            $this->password  = $password;
            $this->functions = $functions;
            
        }
        
        public function get_csrftoken(){
            
            $url = 'https://www.instagram.com/';
            
            $cache_file = $this->cache('csrftoken');
            if($cache_file == false){
                
                $csrftoken_html = $this->request($url, 'GET', null, null, null, false);
                preg_match('|{"config":{"csrf_token":"(.*?)"|is', $csrftoken_html['body'], $csrftoken);
                
                $csrftoken = $csrftoken[1];
                
                $this->cache('csrftoken', [$csrftoken]);
            }
            else{
                $csrftoken = $cache_file[0];
            }
            
            return $csrftoken;
            
        }
        
        public function create_cookie($array = false, $session_id = true){
            
            $cookies_array = [
                'mid'       => 'YB2r4AABAAERcl5ESNxLjr_tt4Q5',
                'csrftoken' => $this->get_csrftoken(),
            ];
            
            if($session_id === true){
                $cookies_array['sessionid'] = $this->get_session_id();
            }
            
            if($array == false){
                $cookies = '';
                foreach($cookies_array as $cookie => $value){
                    $cookies .= $cookie.'='.$value.'; ';
                }
                return $cookies;
            }
            
            return $cookies_array;
            
        }
        
        public function cache($name, $desc = false, $json = false){
            
            if($this->username != null){
                if(!file_exists($this->cache_path.$this->username)){
                    mkdir($this->cache_path.$this->username, 777);
                }
                
                if(!file_exists($this->cache_path.$this->username.'/users/')){
                    mkdir($this->cache_path.$this->username.'/users/', 777);
                }
            }
            
            $cache_file_path = $this->cache_path.$this->username.'/';
            $cache_file      = $cache_file_path.($name.'.json');
            
            if(file_exists($cache_file) and time() <= strtotime('+'.$this->cache_time.' minute', filemtime($cache_file))){
                return json_decode(file_get_contents($cache_file));
            }
            else if($desc !== false){
                if($json == true){
                    file_put_contents($cache_file, $desc);
                }
                else{
                    file_put_contents($cache_file, json_encode($desc));
                }
                return $desc;
            }
            else{
                return false;
            }
        }
        
        public function request($url = '', $type = 'GET', $data = null, $header = null, $cookie = null, $user_cookie = true){
            
            if($type == 'BODYPOST'){
                $type = 'POST';
                $data = ['body' => $data];
            }
            if($type == 'UPLOAD'){
                $type = 'POST';
                $data = $data;
            }
            else if($type == 'POST' and $data != null){
                $data = [
                    'form_params' => $data,
                ];
            }
            
            $headers_default = [
                'X-IG-App-Locale'      => 'tr_TR',
                'X-IG-Device-Locale'   => 'tr_TR',
                'X-IG-Mapped-Locale'   => 'tr_TR',
                'X-Pigeon-Session-Id'  => 'UFS-106fbe3b-acf7-4851-bba9-16d25b955782-0',
                'X-IG-Connection-Type' => 'WIFI',
                'X-IG-Capabilities'    => '3brTvx8=',
                'Priority'             => 'u=3',
                'X-MID'                => 'YB2r4AABAAERcl5ESNxLjr_tt4Q5',
                'IG-INTENDED-USER-ID'  => 0,
                'Host'                 => 'i.instagram.com',
                'X-FB-HTTP-Engine'     => 'Liger',
                'X-FB-Client-IP'       => 'True',
                'X-FB-Server-Cluster'  => 'True',
                //'X-IG-Nav-Chain'       => '97Q:email_verify:2,96z:one_page_registration:3,97Q:email_verify:6,96z:one_page_registration:7,97H:add_birthday:8,97B:username_sign_up:9,97A:username_sign_up:10',
                'X-IG-App-ID'          => $this->app_id,
                'X-IG-Device-ID'       => $this->guid,
                'X-IG-Android-ID'      => $this->device_id,
                'User-Agent'           => $this->user_agent,
                'Authorization'        => $this->cache('Bearer'),
            ];
            
            $headers = $header ?? $headers_default;
            
            if($user_cookie == true){
                $cookie            = $cookie ?? $this->create_cookie(false, $user_cookie);
                $headers['Cookie'] = $cookie;
            }
            
            try{
                $client = new \GuzzleHttp\Client([
                    'verify'  => false,
                    'headers' => $headers,
                    'proxy'   => ($this->proxy ?? null)
                ]);
                
                if($type == 'POST'){
                    $res = $client->post($url, $data);
                }
                else{
                    $res = $client->get($url);
                }
                
                return [
                    'status'  => 'ok',
                    'headers' => $res->getHeaders(),
                    'body'    => $res->getBody()->getContents(),
                ];
            }
            catch(GuzzleException $exception){
                return [
                    'status'  => 'fail',
                    'message' => $exception->getMessage() ?? 'Empty',
                    'headers' => $exception->getResponse()->getHeaders() ?? null,
                    'body'    => $exception->getResponse()->getBody()->getContents() ?? null,
                ];
            }
            
        }
        
        public function get_adid(){
            return $this->adid;
        }
        
        public function get_device_id(){
            return $this->device_id;
        }
        
        public function get_phone_id(){
            return $this->phone_id;
        }
        
        public function get_guid(){
            $cache = $this->cache('guid');
            if($cache === false){
                if(function_exists('com_create_guid')){
                    $guid = $this->guid = mb_strtolower(str_replace(['{','}'], ['',''], com_create_guid()),'utf8');
                }
                else{
                    mt_srand((double) microtime() * 10000);//optional for php 4.2.0 and up.
                    $charid = strtoupper(md5(uniqid(rand(), true)));
                    $hyphen = chr(45);// "-"
                    $uuid   = chr(123)// "{"
                              .substr($charid, 0, 8).$hyphen.substr($charid, 8, 4).$hyphen.substr($charid, 12, 4).$hyphen.substr($charid, 16, 4).$hyphen.substr($charid, 20, 12).chr(125);// "}"
                    $guid = $this->guid = $uuid;
                }
                $this->cache('guid',$guid);
                return $guid;
            }else{
                return $cache;
            }
        }
        
        public function set_username($username){
            $this->username = $username;
        }
        
        public function get_session_id($username = null){
            
            $username       = $username ?? $this->username;
            $this->username = $username;
            
            $cookie = $this->cache('sessionid');
            if($cookie == false){
                $session_id = 0;
            }
            else{
                $session_id = $cookie[0];
            }
            
            return $session_id;
        }
        
        public function get_post_queryhash(){
            
            $url        = 'https://www.instagram.com/static/bundles/es6/Consumer.js/260e382f5182.js';
            $cache_file = $this->cache('post_queryhash');
            if($cache_file == false){
                
                $html = $this->request($url);
                preg_match('|l.pagination},queryId:"(.*?)"|is', $html['body'], $post_hashquery);
                
                $post_hashquery       = $post_hashquery[1];
                $this->post_hashquery = $post_hashquery;
                
                $this->cache('post_hashquery', [$post_hashquery]);
            }
            else{
                $post_hashquery = $cache_file[0];
            }
            
            return $post_hashquery;
            
        }
        
        //KELİME BAŞLIYORSA
        function start_with($samanlik, $igne){
            $length = strlen($igne);
            return (substr($samanlik, 0, $length) === $igne);
        }
        //KELİME BAŞLIYORSA
        
        //KELİME BİTİYORSA
        function end_with($samanlik, $igne){
            $length = strlen($igne);
            if($length == 0){
                return true;
            }
            
            return (substr($samanlik, -$length) === $igne);
        }
        
        //KELİME BİTİYORSA
        
    }