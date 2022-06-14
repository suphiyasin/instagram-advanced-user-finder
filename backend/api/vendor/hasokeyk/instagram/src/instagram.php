<?php
    
    namespace instagram;
    
    require "instagram_request.php";
    require "instagram_login.php";
    require "instagram_register.php";
    require "instagram_user.php";
    require "instagram_statistics.php";
    require "instagram_upload.php";
    require "instagram_medias.php";
    require "instagram_smart_events.php";
    
    class instagram{
        
        public $functions  = [];
        public $request    = null;
        public $login      = null;
        public $register   = null;
        public $user       = null;
        public $statistics = null;
        public $medias     = null;
        public $smart      = null;
        public $upload     = null;
        
        function __construct($username = null, $password = null){
            
            $this->functions = (object) [
                'request'    => new instagram_request($username, $password, $this->functions),
                'login'      => new instagram_login($username, $password, $this->functions),
                'register'   => new instagram_register($username, $password, $this->functions),
                'statistics' => new instagram_statistics($username, $password, $this->functions),
                'user'       => new instagram_user($username, $password, $this->functions),
                'upload'     => new instagram_upload($username, $password, $this->functions),
                'medias'     => new instagram_medias($username, $password, $this->functions),
                'smart'      => new instagram_smart_events($username, $password, $this->functions),
            ];
            
            $this->request    = new instagram_request($username, $password, $this->functions);
            $this->login      = new instagram_login($username, $password, $this->functions);
            $this->register   = new instagram_register($username, $password, $this->functions);
            $this->user       = new instagram_user($username, $password, $this->functions);
            $this->statistics = new instagram_statistics($username, $password, $this->functions);
            $this->upload     = new instagram_upload($username, $password, $this->functions);
            $this->medias     = new instagram_medias($username, $password, $this->functions);
            $this->smart      = new instagram_smart_events($username, $password, $this->functions);
            
        }
        
    }