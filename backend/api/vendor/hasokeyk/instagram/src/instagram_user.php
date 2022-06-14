<?php
    
    namespace instagram;
    
    class instagram_user extends instagram_request{
        
        public $username;
        public $password;
        public $functions;
        
        function __construct($username, $password, $functions = null){
            $this->username  = $username;
            $this->password  = $password;
            $this->functions = $functions;
        }
        
        public function get_user_id($username = null){
            
            $username = $username ?? $this->username;
            if($username != null){
                $cache = $this->cache($username.'-id');
                if($cache === false){
                    
                    $url = 'https://www.instagram.com/web/search/topsearch/?query='.$username;
    
                    $json = $this->request($url);
                    $json = json_decode($json['body']);
    
                    $user_id = 0;
                    foreach($json->users as $user){
                        if($username == $user->user->username){
                            $user_id = $user->user->pk;
                        }
                    }
    
                    $this->cache($username.'-id', $user_id);
                    
                }else{
                    $user_id = $cache;
                }
                return $user_id;
            }
            
            return false;
            
        }
        
        public function get_user_posts($username = null){
            
            $cache = $this->cache($username.'-posts');
            if($cache == false){
                
                $post_hashquery = $this->get_post_queryhash();
                $user_id        = $this->get_user_id($username);
                $url            = 'https://www.instagram.com/graphql/query/?query_hash='.$post_hashquery.'&variables={"id":"'.$user_id.'","first":50}';
                $json           = $this->request($url);
                $json           = json_decode($json['body'])->data->user;
                
                $this->cache($username.'-posts', $json);
                
                $result = $json;
            }
            else{
                $result = $cache;
            }
            
            return $result;
        }
        
        public function change_profil_pic($image_path = null){
            
            $upload_id         = $this->functions->upload->get_upload_id();
            $upload_session_id = $this->functions->upload->get_upload_session_id($upload_id);
            $url               = 'https://i.instagram.com/rupload_igphoto/'.$upload_session_id;
            
            $file      = file_get_contents($image_path);
            $file_size = strlen($file);
            
            $header = [
                "Content-Type"               => "application/octet-stream",
                "X-Entity-Type"              => "image/jpeg",
                "X-Entity-Name"              => $upload_session_id,
                "Offset"                     => "0",
                "X-Entity-Length"            => $file_size,
                "Cookie"                     => $this->create_cookie(),
                "X-Instagram-Rupload-Params" => $this->functions->upload->rupload_params($upload_id),
            ];
            
            $json = $this->request($url, 'UPLOAD', ['body' => $file], $header);
            $json = json_decode($json['body']);
            if($json->status == 'ok'){
                $result = $this->_change_profil_pic($upload_id);
                if($result->status == 'ok'){
                    return true;
                }
            }
            
            return false;
        }
        
        protected function _change_profil_pic($upload_id){
            
            $url       = 'https://i.instagram.com/api/v1/accounts/change_profile_picture/';
            $post_data = [
                '_csrftoken'     => $this->get_csrftoken(),
                '_uuid'          => $this->get_guid(),
                'use_fbuploader' => 'true',
                'upload_id'      => $upload_id,
            ];
            $json      = $this->request($url, 'POST', $post_data);
            return json_decode($json['body']);
            
        }
        
        public function get_user_info_show($user_id = null){
            
            $cache = $this->cache('users/'.$user_id);
            if(!$cache){
                if($user_id != null){
                    $url  = 'https://i.instagram.com/api/v1/users/'.$user_id.'/info/';
                    $json = $this->request($url);
                    $json = json_decode($json['body']);
                    $this->cache('users/'.$user_id, $json);
                    return $json;
                }
            }
            else{
                return $cache;
            }
            
            return false;
            
        }
        
        public function get_user_info_by_username($username = null){
            
            $username = $username ?? $this->username;
            $cache    = $this->cache('users/'.$username);
            if(!$cache){
                if($username != null){
                    $url  = 'https://i.instagram.com/api/v1/users/'.$username.'/full_detail_info/';
                    $json = $this->request($url);
                    if($json['status'] == 'ok'){
                        $json = json_decode($json['body']);
                        $this->cache('users/'.$username, $json);
                        return $json;
                    }
                    else{
                        return $json;
                    }
                    
                }
            }
            else{
                return $cache;
            }
            
            return false;
            
        }
        
        public function get_user_friendship_show($user_id = null){
            
            $cache = $this->cache('users/'.$user_id);
            if(!$cache){
                if($user_id != null){
                    $url  = 'https://i.instagram.com/api/v1/friendships/show/'.$user_id.'/';
                    $json = $this->request($url);
                    $json = json_decode($json['body']);
                    $this->cache('users/'.$user_id, $json);
                    return $json;
                }
            }
            else{
                return $cache;
            }
            
            return false;
            
        }
        
        public function get_multi_user_friendship_show($user_ids = []){
            
            if($user_ids != null){
                $user_ids  = implode(',', $user_ids);
                $url       = 'https://i.instagram.com/api/v1/friendships/show_many/';
                $post_data = [
                    'user_ids' => $user_ids,
                ];
                $json      = $this->request($url, 'POST', $post_data);
                $json      = json_decode($json['body']);
                return $json;
            }
            
            return false;
            
        }
        
        public function get_my_surfaces(){
            $cache = $this->cache('surface');
            if(!$cache){
                $username = $this->username;
                if($username != null){
                    $url  = 'https://i.instagram.com/api/v1/scores/bootstrap/users/?surfaces=["coefficient_direct_closed_friends_ranking","coefficient_direct_recipients_ranking_variant_2","coefficient_rank_recipient_user_suggestion","coefficient_besties_list_ranking","coefficient_ios_section_test_bootstrap_ranking","autocomplete_user_list"]';
                    $json = $this->request($url);
                    if($json['status'] == 'ok'){
                        $json = json_decode($json['body']);
                        $this->cache('surface', $json);
                        return $json;
                    }
                    else{
                        return $json;
                    }
                }
            }
            else{
                return $cache;
            }
            
            return false;
            
        }
        
        public function get_users_score(){
            $cache = $this->cache('user_score');
            if(!$cache){
                $username = $this->username;
                if($username != null){
                    $url  = 'https://i.instagram.com/api/v1/banyan/banyan/?views=["direct_user_search_keypressed","group_stories_share_sheet","reshare_share_sheet","direct_inbox_active_now","story_share_sheet","forwarding_recipient_sheet","direct_user_search_nullstate","threads_people_picker"]';
                    $json = $this->request($url);
                    if($json['status'] == 'ok'){
                        $json = json_decode($json['body']);
                        $this->cache('user_score', $json);
                        return $json;
                    }
                    else{
                        return $json;
                    }
                }
            }
            else{
                return $cache;
            }
            
            return false;
            
        }
        
        public function follow($username){
            
            if($username != null){
                $user_id    = $this->get_user_id($username);
                $me_user_id = $this->get_user_id();
                
                $url = 'https://i.instagram.com/api/v1/friendships/create/'.$user_id.'/';
                
                $post_data = [
                    'container_module' => 'self_following',
                    'radio_type'       => 'wifi-none',
                    'user_id'          => $user_id,
                    '_csrftoken'       => $this->get_csrftoken(),
                    '_uid'             => $me_user_id,
                    '_uuid'            => $this->get_guid(),
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $json = $this->request($url, 'POST', $post_data);
                $json = json_decode($json['body']);
                
                return $json;
            }
            
            return false;
            
        }
        
        public function unfollow($username){
            
            if($username != null){
                $user_id    = $this->get_user_id($username);
                $me_user_id = $this->get_user_id();
                
                $url = 'https://i.instagram.com/api/v1/friendships/destroy/'.$user_id.'/';
                
                $post_data = [
                    'container_module' => 'self_following',
                    'radio_type'       => 'wifi-none',
                    'user_id'          => $user_id,
                    '_csrftoken'       => $this->get_csrftoken(),
                    '_uid'             => $me_user_id,
                    '_uuid'            => $this->get_guid(),
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $json = $this->request($url, 'POST', $post_data);
                $json = json_decode($json['body']);
                
                return $json;
            }
            
            return false;
            
        }
        
        public function unfollow_me($username){
            
            if($username != null){
                $user_id    = $this->get_user_id($username);
                $me_user_id = $this->get_user_id();
                
                $url = 'https://i.instagram.com/api/v1/friendships/remove_follower/'.$user_id.'/';
                
                $post_data = [
                    'container_module' => 'self_following',
                    'radio_type'       => 'wifi-none',
                    'user_id'          => $user_id,
                    '_csrftoken'       => $this->get_csrftoken(),
                    '_uid'             => $me_user_id,
                    '_uuid'            => $this->get_guid(),
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $json = $this->request($url, 'POST', $post_data);
                $json = json_decode($json['body']);
                
                return $json;
            }
            
            return false;
            
        }
        
        public function send_inbox_text($username, $text = 'Hello', $style = null){
            
            if($username != null){
                
                $user_id = $this->get_user_id($username);
                $url     = 'https://i.instagram.com/api/v1/direct_v2/threads/broadcast/text/';
                //$thread_id = $this->get_inbox_user_thread($username);
                $post_data = [
                    'text'                 => $text,
                    'action'               => 'send_item',
                    'is_shh_mode'          => '0',
                    'recipient_users'      => '[['.$user_id.']]',
                    //'thread_ids'           => '['.$thread_id['thread_id'].']',
                    'send_attribution'     => 'direct_thread',
                    'client_context'       => $this->generate_client_context(),
                    '_csrftoken'           => $this->get_csrftoken(),
                    'device_id'            => $this->get_device_id(),
                    'mutation_token'       => $this->generate_client_context(),
                    '_uuid'                => $this->get_guid(),
                    'offline_threading_id' => $this->generate_client_context(),
                ];
                
                if($style != null){
                    $post_data['power_up_data'] = '{"style":'.$style.'}';
                }
                
                $json = $this->request($url, 'POST', $post_data);
                $json = json_decode($json['body']);
                
                return $json;
            }
            
            return false;
            
        }
        
        public function send_inbox_text_heart($username, $text = 'Hello'){
            
            if($username != null){
                return $this->send_inbox_text($username, $text, 1);
            }
            
            return false;
            
        }
        
        public function send_inbox_text_gift($username, $text = 'Hello'){
            
            if($username != null){
                return $this->send_inbox_text($username, $text, 2);
            }
            
            return false;
            
        }
        
        public function send_inbox_text_confetti($username, $text = 'Hello'){
            
            if($username != null){
                return $this->send_inbox_text($username, $text, 3);
            }
            
            return false;
            
        }
        
        public function send_inbox_text_fire($username, $text = 'Hello'){
            
            if($username != null){
                return $this->send_inbox_text($username, $text, 4);
            }
            
            return false;
            
        }
        
        public function send_inbox_like($username){
            
            if($username != null){
                
                $user_id = $this->get_user_id($username);
                $url     = 'https://i.instagram.com/api/v1/direct_v2/threads/broadcast/like/';
                //$thread_id = $this->get_inbox_user_thread($username);
                $post_data = [
                    'action'               => 'send_item',
                    'is_shh_mode'          => '0',
                    'recipient_users'      => '[['.$user_id.']]',
                    //'thread_ids'           => '['.$thread_id['thread_id'].']',
                    'send_attribution'     => 'direct_thread',
                    'client_context'       => $this->generate_client_context(),
                    '_csrftoken'           => $this->get_csrftoken(),
                    'device_id'            => $this->get_device_id(),
                    'mutation_token'       => $this->generate_client_context(),
                    '_uuid'                => $this->get_guid(),
                    'offline_threading_id' => $this->generate_client_context(),
                ];
                
                $json = $this->request($url, 'POST', $post_data);
                $json = json_decode($json['body']);
                
                return $json;
            }
            
            return false;
            
        }
        
        public function send_inbox_photo($username, $image_path = null){
            
            if($username != null and $image_path != null){
                
                //IMAGE UPLOAD
                $upload_id         = $this->functions->upload->get_upload_id();
                $upload_session_id = $this->functions->upload->get_upload_session_id($upload_id);
                $url               = 'https://i.instagram.com/rupload_igphoto/'.$upload_session_id;
                
                $file      = file_get_contents($image_path);
                $file_size = strlen($file);
                
                $header = [
                    "Content-Type"               => "application/octet-stream",
                    "X-Entity-Type"              => "image/jpeg",
                    "X-Entity-Name"              => $upload_session_id,
                    "Offset"                     => "0",
                    "X-Entity-Length"            => $file_size,
                    "Cookie"                     => $this->create_cookie(),
                    "X-Instagram-Rupload-Params" => $this->functions->upload->rupload_params($upload_id),
                ];
                
                $upload_json = $this->request($url, 'UPLOAD', ['body' => $file], $header);
                $upload_json = json_decode($upload_json['body']);
                //IMAGE UPLOAD
                
                //IMAGE SEND
                $user_id = $this->get_user_id($username);
                $url     = 'https://i.instagram.com/api/v1/direct_v2/threads/broadcast/configure_photo/';
                //$thread_id = $this->get_inbox_user_thread($username);
                $post_data = [
                    'upload_id'               => $upload_json->upload_id,
                    'allow_full_aspect_ratio' => 'true',
                    'action'                  => 'send_item',
                    'is_shh_mode'             => '0',
                    'recipient_users'         => '[['.$user_id.']]',
                    //'thread_ids'              => '['.$thread_id['thread_id'].']',
                    'send_attribution'        => 'direct_thread',
                    'client_context'          => $this->generate_client_context(),
                    '_csrftoken'              => $this->get_csrftoken(),
                    'device_id'               => $this->get_device_id(),
                    'mutation_token'          => $this->generate_client_context(),
                    '_uuid'                   => $this->get_guid(),
                    'offline_threading_id'    => $this->generate_client_context(),
                ];
                $json      = $this->request($url, 'POST', $post_data);
                $json      = json_decode($json['body']);
                //IMAGE SEND
                
                return $json;
            }
            
            return false;
            
        }
        
        public function get_create_inbox_thread($username){
            
            $user_id = $this->get_user_id($username);
            $url     = 'https://i.instagram.com/api/v1/direct_v2/threads/get_by_participants/?recipient_users=%5B'.$user_id.'%5D&seq_id=1573&limit=20';
            $json    = $this->request($url, 'GET');
            $json    = json_decode($json['body']);
            return $json;
            
        }
        
        public function get_inbox_threads(){
            
            $url  = 'https://i.instagram.com/api/v1/direct_v2/inbox/?visual_message_return_type=unseen&thread_message_limit=10&persistentBadging=true&limit=20&push_disabled=true&fetch_reason=manual_refresh';
            $json = $this->request($url, 'GET');
            $json = json_decode($json['body']);
            return $json;
            
        }
        
        public function get_inbox_user_thread($username = null, $group = false){
            
            if($username){
                
                $threads_id      = null;
                $user_id         = $this->get_user_id($username);
                $threads_id_list = $this->get_inbox_threads();
                if($threads_id_list->inbox->threads != null){
                    foreach($threads_id_list->inbox->threads as $thread){
                        
                        if($group === true and count($thread->users) > 0){
                            foreach($thread->users as $user){
                                if($user->pk == $user_id){
                                    $threads_id = [
                                        'thread_id'    => $thread->thread_id,
                                        'thread_v2_id' => $thread->thread_v2_id,
                                    ];
                                    break;
                                }
                            }
                        }
                        else{
                            if($thread->users[0]->pk == $user_id){
                                $threads_id = [
                                    'thread_id'    => $thread->thread_id,
                                    'thread_v2_id' => $thread->thread_v2_id,
                                ];
                                break;
                            }
                        }
                        
                    }
                    
                    if($threads_id == null){
                        $thread = $this->get_create_inbox_thread($username);
                        print_r($thread);
                        exit;
                        $threads_id = [
                            'thread_id'    => $thread->thread->thread_id,
                            'thread_v2_id' => $thread->thread->thread_v2_id,
                        ];
                    }
                    
                }
                else{
                    $thread     = $this->get_create_inbox_thread($username);
                    $threads_id = [
                        'thread_id'    => $thread->thread->thread_id,
                        'thread_v2_id' => $thread->thread->thread_v2_id,
                    ];
                }
                
                return $threads_id;
                
            }
            
            return false;
            
        }
        
        public function get_me_least_interacted_with(){
            
            $url  = 'https://i.instagram.com/api/v1/friendships/smart_groups/least_interacted_with/?search_surface=follow_list_page&query=&enable_groups=true&rank_token=e667dad2-ccf4-461a-ba53-d83f9007cc7f';
            $json = $this->request($url);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function get_me_most_seen_in_feed(){
            
            $url  = 'https://i.instagram.com/api/v1/friendships/smart_groups/most_seen_in_feed/?search_surface=follow_list_page&query=&enable_groups=true&rank_token=b66b8315-8421-427b-a9c8-c99a894775b6';
            $json = $this->request($url);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function get_my_statistic(){
            
            $url      = 'https://i.instagram.com/api/v1/ads/graphql/?locale=tr_TR&vc_policy=insights_policy&surface=account';
            $post_var = [
                'variables' => '{"query_params":{"access_token":"","id":"7573271439"},"timezone":"Asia/Bahrain"}',
                'doc_id'    => '1706456729417729',
            ];
            $json     = $this->request($url, 'POST', $post_var);
            $json     = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function get_my_notification(){
            
            $url  = 'https://i.instagram.com/api/v1/news/inbox/?mark_as_seen=false&timezone_offset=10800&push_disabled=true';
            $json = $this->request($url);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function get_my_pending_inbox(){
            
            $url  = 'https://i.instagram.com/api/v1/direct_v2/pending_inbox/?visual_message_return_type=unseen&persistentBadging=true&push_disabled=true';
            $json = $this->request($url);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function get_my_inbox(){
            
            $url  = 'https://i.instagram.com/api/v1/direct_v2/inbox/?visual_message_return_type=unseen&thread_message_limit=100&persistentBadging=true&limit=20&push_disabled=true&fetch_reason=manual_refresh';
            $json = $this->request($url);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function get_my_followers(){
            
            $user_id = $this->get_user_id();
            
            $url  = 'https://i.instagram.com/api/v1/friendships/'.$user_id.'/followers/?includes_hashtags=true&search_surface=follow_list_page&query=&enable_groups=true&rank_token=4c6947e0-bebe-4f69-a7bf-24be28dc4990';
            $json = $this->request($url);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function get_my_following(){
    
            $user_id = $this->get_user_id();
            
            $url  = 'https://i.instagram.com/api/v1/friendships/'.$user_id.'/following/?includes_hashtags=true&search_surface=follow_list_page&query=&enable_groups=true&rank_token=4c6947e0-bebe-4f69-a7bf-24be28dc4990';
            $json = $this->request($url);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
    
        public function get_user_followers($username = null){
        
            $user_id = $this->get_user_id($username);
        
            $url  = 'https://i.instagram.com/api/v1/friendships/'.$user_id.'/followers/?includes_hashtags=true&search_surface=follow_list_page&query=&enable_groups=true';
            $json = $this->request($url);
            $json = json_decode($json['body']);
        
            return $json;
        
        }
    
        public function get_user_following($username = null){
        
            $user_id = $this->get_user_id($username);
        
            $url  = 'https://i.instagram.com/api/v1/friendships/'.$user_id.'/following/?includes_hashtags=true&search_surface=follow_list_page&query=&enable_groups=true&rank_token=4c6947e0-bebe-4f69-a7bf-24be28dc4990';
            $json = $this->request($url);
            $json = json_decode($json['body']);
        
            return $json;
        
        }
        
        public function get_friendships_status_by_username($username = null){
            
            if($username != null){
                $user_id   = $this->get_user_id($username);
                $url       = 'https://i.instagram.com/api/v1/friendships/show_many/';
                $post_data = [
                    'user_ids' => $user_id,
                ];
                $json      = $this->request($url, 'POST', $post_data);
                $json      = json_decode($json['body']);
                return $json;
                
            }
            return false;
            
        }
        
        public function get_former_usernames($username = null){
            
            $username = $username ?? $this->username;
            $user_id  = $this->get_user_id($username);
            $url      = 'https://i.instagram.com/api/v1/users/'.$user_id.'/former_usernames/';
            $json     = $this->request($url, 'GET');
            $json     = json_decode($json['body']);
            if(isset($json->status) and $json->status == 'ok'){
                return $json;
            }
            return false;
            
        }
        
        /*
        public function get_accounts_with_shared_followers($username = null){
            
            $username = $username??$this->username;
            $user_id = $this->get_user_id($username);
            $url     = 'https://i.instagram.com/api/v1/users/'.$user_id.'/accounts_with_shared_followers/';
            $json    = $this->request($url, 'POST');
            $json    = json_decode($json['body']);
            if(isset($json->status) and $json->status == 'ok'){
                return $json;
            }
            return false;
            
        }
        */
        
        
        public function get_multiple_accout_detected($user_id = null){
            
            $user_id = $user_id ?? $this->get_user_id($this->username);
            $cache   = $this->cache('users/multiple-account-'.$user_id);
            if(!$cache){
                if($user_id != null){
                    $url  = 'https://i.instagram.com/api/v1/multiple_accounts/get_featured_accounts/?target_user_id='.$user_id;
                    $json = $this->request($url);
                    $json = json_decode($json['body']);
                    $this->cache('users/multiple-account-'.$user_id, $json);
                    return $json;
                }
            }
            else{
                return $cache;
            }
            
            return false;
            
        }
        
        private function generate_client_context(){
            return (round(microtime(true) * 1000) << 22 | random_int(PHP_INT_MIN, PHP_INT_MAX) & 4194303) & PHP_INT_MAX;
        }
        
        public function register($email = null, $full_name = null, $password = null){
            
            if($email != null and $full_name != null and $password != null){
                $url       = 'https://i.instagram.com/api/v1/accounts/send_verify_email/';
                $post_data = [
                    'auto_confirm_only' => 'false',
                    'waterfall_id'      => 'b86ef5d6-fe14-4f62-83fb-563f4ec2ddb4',
                    'email'             => $email,
                    'device_id'         => $this->get_device_id(),
                    'guid'              => $this->get_guid(),
                    'phone_id'          => $this->get_phone_id(),
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $json = $this->request($url, 'BODYPOST', $post_data, null, null, false);
                $json = json_decode($json['body']);
                
                return $json;
            }
            
            return false;
        }
        
        public function register_email_code_check($email = null, $code = null){
            
            if($code != null and $email != null){
                $url       = 'https://i.instagram.com/api/v1/accounts/check_confirmation_code/';
                $post_data = [
                    'auto_confirm_only' => 'false',
                    'waterfall_id'      => 'b86ef5d6-fe14-4f62-83fb-563f4ec2ddb4',
                    'email'             => $email,
                    'code'              => $code,
                    'device_id'         => $this->get_device_id(),
                    'guid'              => $this->get_guid(),
                    'phone_id'          => $this->get_phone_id(),
                ];
                $post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
                
                $json = $this->request($url, 'POST', $post_data, null, null, false);
                $json = json_decode($json['body']);
                
                return $json;
            }
            
            return false;
        }
        
        public function register_end($username = null, $password = null, $email = null, $full_name = null, $singup_code = null){
            
            if($username != null and $password != null and $email != null and $full_name != null and $singup_code != null){
                
                $url       = 'https://i.instagram.com/api/v1/accounts/create/';
                $post_data = [
                    'is_secondary_account_creation'          => 'false',
                    'jazoest'                                => '22354',
                    'tos_version'                            => 'row',
                    'suggestedUsername'                      => '',
                    'allow_contacts_sync'                    => 'true',
                    'sn_result'                              => "API_ERROR:+class+X.9Be:7:+",
                    'do_not_auto_login_if_credentials_match' => "true",
                    'waterfall_id'                           => 'b86ef5d6-fe14-4f62-83fb-563f4ec2ddb4',
                    'sn_nonce'                               => 'aGFzb2tleWsrMTJAeWFuZGV4LmNvbXwxNjMyMTcwODQ2fJWSSEq6UzsPO4Gccq7rn7ymR3z8rbbOXA==',
                    'username'                               => $username,
                    'password'                               => $this->functions->login->encrypt($password),
                    'first_name'                             => $full_name,
                    'day'                                    => 20,
                    'year'                                   => 1991,
                    'month'                                  => 9,
                    'email'                                  => $email,
                    'force_sign_up_code'                     => $singup_code,
                    'device_id'                              => $this->get_device_id(),
                    'guid'                                   => $this->get_guid(),
                    'phone_id'                               => $this->get_phone_id(),
                ];
                //$post_data = http_build_query(['signed_body' => 'SIGNATURE.'.json_encode($post_data)]);
                
                $post_data = 'signed_body=SIGNATURE.%7B%22is_secondary_account_creation%22%3A%22false%22%2C%22jazoest%22%3A%2222354%22%2C%22tos_version%22%3A%22row%22%2C%22suggestedUsername%22%3A%22%22%2C%22allow_contacts_sync%22%3A%22true%22%2C%22sn_result%22%3A%22API_ERROR%3A+class+X.9Be%3A7%3A+%22%2C%22do_not_auto_login_if_credentials_match%22%3A%22true%22%2C%22phone_id%22%3A%22bb81ea3b-341c-4d04-9501-853630ab8d5c%22%2C%22enc_password%22%3A%22%23PWD_INSTAGRAM%3A4%3A1632170953%3AAdPQCpWGjUJyNBI7WRcAAW0zRJkkuFJl164CgAO6fEqTVP%2BYKFVhYeOmHCDIKPvY9zNtsbyXD7lIaa%2BmDodn4i%2BXkRYxxIq3zY0yPHpdBEfMbaRHJKbUBDcuZLYOQFY5rk03eJyvKaJMGhzfQ4vqgiOWFupbTxRDpFnzCnF%2FAUxsQth4SfKoaU6UafVrg5HkLS1prtKMsFvJYkgANUQZyxTkvEDSabq9SN0UaP71kbGG8EqkU4thP6DXgq%2FlDNinX801l0I6KD4sG6etTpDv%2BDpL04bwEi7TnQcxcidDFADo3XLSIvojZ731Bg%2BKIN2yOrEsJ4WQAln9SC99LvYE%2FZUG8KN8w453Rqnb5oJuIw7vbPqbZQOmjkyiRkCVyj78gtrqWac1rw%3D%3D%22%2C%22username%22%3A%22ramazandogan7515%22%2C%22first_name%22%3A%22Ramazan+Do%C4%9Fan%22%2C%22day%22%3A%2220%22%2C%22adid%22%3A%22904b800c-50b4-4cb6-9030-6d6816d19f0d%22%2C%22guid%22%3A%220ff470bf-e663-4a1d-a327-38603a77a1bc%22%2C%22year%22%3A%221991%22%2C%22device_id%22%3A%22android-d96d1dea964853ad%22%2C%22_uuid%22%3A%220ff470bf-e663-4a1d-a327-38603a77a1bc%22%2C%22email%22%3A%22hasokeyk%2B12%40yandex.com%22%2C%22month%22%3A%229%22%2C%22sn_nonce%22%3A%22aGFzb2tleWsrMTJAeWFuZGV4LmNvbXwxNjMyMTcwODQ2fJWSSEq6UzsPO4Gccq7rn7ymR3z8rbbOXA%3D%3D%22%2C%22force_sign_up_code%22%3A%22wLqO8Hsl%22%2C%22waterfall_id%22%3A%22b86ef5d6-fe14-4f62-83fb-563f4ec2ddb4%22%2C%22qs_stamp%22%3A%22%22%2C%22one_tap_opt_in%22%3A%22true%22%7D';
                
                $header = [
                    'User-Agent'   => 'Instagram 203.0.0.29.118 Android (25/7.1.2; 160dpi; 540x960; Google/google; google Pixel 2; x86; android_x86; tr_TR; 314665258)',
                    'Content-Type' => ' application/x-www-form-urlencoded; charset=UTF-8',
                    //'Cookie'       => ' csrftoken=UIzWq1MUKRonOIvUIXui5l0IDvb6Y1Ch; ig_did=624DFF22-C0FD-4408-A5B0-04F0AC02E040; ig_nrcb=1; mid=YUj9BAAEAAEHv1uFrFcQxsWkFbpj'
                ];
                
                $json = $this->request($url, 'UPLOAD', $post_data);
                print_r($json);
                $json = json_decode($json['body']);
                
                return $json;
                
            }
            
            return false;
        }
        
        public function set_status($status_text = 'I love ', $emoji = '😍'){
            
            $url      = 'https://i.instagram.com/api/v1/status/set_status/';
            $post_var = [
                'status_type' => 'manual',
                'expires_at'  => strtotime('+1 days'),
                'text'        => $status_text,
                '_uuid'       => '0ff470bf-e663-4a1d-a327-38603a77a1bc',
                'emoji'       => $emoji,
                'audience'    => 'mutual_follows',
            ];
            
            $json = $this->request($url, 'POST', $post_var);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function set_status_reply($status_id = 'I love ', $thread_id = '', $message = 'Status Message'){
            
            $url      = 'https://i.instagram.com/api/v1/direct_v2/threads/broadcast/status_reply/';
            $post_var = [
                'status_id'            => $status_id,
                'thread_id'            => $thread_id,
                'action'               => 'send_item',
                'is_shh_mode'          => 0,
                'thread_ids'           => '%5B340282366841710300949128185597418409807%5D',
                'send_attribution'     => '',
                'client_context'       => '6875500892161881179',
                'reply_type'           => 'text',
                'device_id'            => 'android-d96d1dea964853ad',
                'mutation_token'       => '6875500892161881179',
                '_uuid'                => '0ff470bf-e663-4a1d-a327-38603a77a1bc',
                'reply'                => $message,
                'status_key'           => 0,
                'status_author_id'     => 7573271439,
                'offline_threading_id' => 687550089216188,
            ];
            
            $json = $this->request($url, 'POST', $post_var);
            $json = json_decode($json['body']);
            
            return $json;
            
        }
        
        public function set_biography($biography = 'Hi instagram'){
            
            $url       = 'https://i.instagram.com/api/v1/accounts/set_biography/';
            $post_data = [
                'raw_text'  => $biography,
                'device_id' => $this->get_device_id(),
                'guid'      => $this->get_guid(),
                'phone_id'  => $this->get_phone_id(),
            ];
            $post_data = http_build_query(['signed_body' => 'SIGNATURE.'.json_encode($post_data)]);
            $json = $this->request($url, 'POST', $post_data);
            $json = json_decode($json['body']);
    
            return $json;
            
        }
    }