<?php
    
    
    namespace instagram;
    
    
    class instagram_smart_events extends instagram_request{
        
        public $username;
        public $password;
        public $functions;
        
        function __construct($username, $password, $functions = null){
            $this->username  = $username;
            $this->password  = $password;
            $this->functions = $functions;
        }
        
        public function get_fake_following_profile($username = null){
            
            $username = $username ?? $this->username;
            $user_id  = $this->functions->user->get_user_id($username);
            $url      = 'https://i.instagram.com/api/v1/friendships/'.$user_id.'/following/?includes_hashtags=false&search_surface=follow_list_page&order=date_followed_earliest&query=&enable_groups=true&rank_token=650f704c-8711-47a8-a7f5-a7c90d8e23d8';
            $json     = $this->request($url);
            $json     = json_decode($json['body']);
            
            $fake_following = [];
            foreach($json->users as $user){
                if($user->has_anonymous_profile_picture == true){
                    $fake_following[] = $user;
                }
            }
            
            return $fake_following;
            
        }
        
        public function get_fake_followers_profile($username = null, $page = 1){
            
            $username   = $username ?? $this->username;
            $user_id    = $this->functions->user->get_user_id($username);
            $url        = 'https://i.instagram.com/api/v1/friendships/'.$user_id.'/followers/?includes_hashtags=false&search_surface=follow_list_page&order=date_followed_lates&query=&enable_groups=true&rank_token=650f704c-8711-47a8-a7f5-a7c90d8e23d8&big_list=true';
            $json       = $this->request($url);
            print_r($json);
            $main_users = json_decode($json['body']);
            $max_id     = $main_users->next_max_id;
            
            if($page > 1){
                for($i = 0; $i < $page; $i++){
                    $url   = 'https://i.instagram.com/api/v1/friendships/'.$user_id.'/followers/?search_surface=follow_list_page&max_id='.$max_id.'&query=&enable_groups=true&rank_token=83b852da-cc4a-4eff-8877-2f436ebf223c';
                    $json  = $this->request($url);
                    $users = json_decode($json['body']);
                    foreach($users->users as $user){
                        $main_users->users[] = $user;
                    }
                    $max_id = $users->next_max_id;
                }
                sleep(1);
            }
            
            $fake_following = [];
            foreach($main_users->users as $user){
                if($user->has_anonymous_profile_picture == true){
                    $fake_following[] = $user;
                }
            }
            
            return $fake_following;
            
        }
        
        public function get_my_must_follow(){
            
            $surfaces          = $this->functions->user->get_my_surfaces();
            $surfaces_user_ids = [];
            foreach($surfaces->surfaces as $surface){
                foreach($surface->scores as $user_id => $score){
                    $surfaces_user_ids[] = $user_id;
                }
            }
            
            $must_follow       = (object) [];
            $friends_ship_info = $this->functions->user->get_multi_user_friendship_show(array_values($surfaces_user_ids));
            foreach($friends_ship_info->friendship_statuses as $user_id => $info){
                if(!$info->following and $info->outgoing_request == false){
                    
                    foreach($surfaces->users as $user){
                        if($user->pk == $user_id){
                            $must_follow->$user_id = (object) [
                                'user'        => $user,
                                'friendships' => $info,
                            ];
                            break;
                        }
                    }
                    
                }
                
            }
            
            return $must_follow;
        }
        
        public function get_my_secret_followers(){
            
            $surfaces          = $this->functions->user->get_my_surfaces();
            $surfaces_user_ids = [];
            foreach($surfaces->surfaces as $surface){
                foreach($surface->scores as $user_id => $score){
                    $surfaces_user_ids[] = $user_id;
                }
            }
            
            $must_follow       = (object) [];
            $friends_ship_info = $this->functions->user->get_multi_user_friendship_show(array_values($surfaces_user_ids));
            foreach($friends_ship_info->friendship_statuses as $user_id => $info){
                if(!$info->following and !$info->outgoing_request){
                    
                    foreach($surfaces->users as $user){
                        if($user->pk == $user_id){
                            $must_follow->$user_id = (object) [
                                'user'        => $user,
                                'friendships' => $info,
                            ];
                            break;
                        }
                    }
                    
                }
            }
            
            return $must_follow;
        }
        
        public function users_who_will_see_the_post_first(){
            
            $surfaces = $this->functions->user->get_my_surfaces();
            $users    = [];
            foreach($surfaces->surfaces as $id => $surface){
                if($surface->name = 'coefficient_direct_recipients_ranking_variant_2'){
                    $users_info = $this->array_percentage(array_keys((array) $surface->scores),10);
                    foreach($users_info as $user_id){
                        $users[] = $this->functions->user->get_user_info_show($user_id);
                    }
                    break;
                }
            }
    
            return $users;
            
        }
        
        public function who_viewed_my_profile(){
        
            
        
        }
        
        function array_percentage($array, $percentage){
            $count  = count($array);
            $result = array_slice($array, 0, ceil($count * $percentage / 100));
            return $result;
        }
        
    }