<?php
    
    
    namespace instagram;
    
    class instagram_statistics extends instagram_request{
        
        public $username;
        public $password;
        public $functions;
        public $posts;
        
        function __construct($username, $password, $functions = null){
            $this->username  = $username;
            $this->password  = $password;
            $this->functions = $functions;
        }
        
        public function get_user_insights(){
            
            $cache = $this->cache('insights');
            if($cache == false){
                $url       = 'https://i.instagram.com/api/v1/ads/graphql/?locale=tr_TR&vc_policy=insights_policy&surface=account';
                $post_data = [
                    'variables' => '{"query_params":{"access_token":"","id":"'.$this->functions->user->get_user_id().'"},"timezone":"Asia/Bahrain"}',
                    'doc_id'    => '1706456729417729',
                ];
                $request   = $this->request($url, 'POST', $post_data);
                $result    = json_decode($request['body']);
                $this->cache('insights', $result);
            }
            else{
                $result = $cache;
            }
            
            return $result;
        }
        
        public function get_post_insights($post_id = null){
        
            $cache = $this->cache($post_id);
            if($cache == false){
                if($post_id != null){
                
                    $post_param = [
                        'surface'        => 'post',
                        'doc_id'         => '3808023159239182',
                        'locale'         => 'tr_TR',
                        'vc_policy'      => 'insights_policy',
                        'signed_body'    => 'SIGNATURE.',
                        'strip_nulls'    => 'true',
                        'strip_defaults' => 'true',
                        'query_params'   => ('{"query_params":{"access_token":"","id":"'.$post_id.'"}}'),
                    ];
                
                    $link                   = "https://i.instagram.com/api/v1/ads/graphql/";
                    $user_general_statistic = $this->request($link, 'POST', $post_param);
                
                    $user_general_statistic = json_decode($user_general_statistic['body']);
                    $user_general_statistic = $user_general_statistic->data->instagram_post_by_igid->inline_insights_node->metrics;
                
                    if($user_general_statistic != null){
                        $this->cache($post_id, $user_general_statistic);
                    }
                    else{
                        $this->cache($post_id, "{}", true);
                    }
                }
                else{
                    $user_general_statistic = false;
                }
            }
            else{
                $user_general_statistic = $cache;
            }
        
            return $user_general_statistic;
        }
        
        public function get_post_popular_tags($post_insights = null){
            
            $result = [];
            if(isset($post_insights->hashtags_impressions)){
                $tags = $post_insights->hashtags_impressions;
                if($tags){
                    $result['organic'] = $tags->organic->value;
                    
                    if($tags->hashtags->count != null){
                        foreach($tags->hashtags->nodes as $hashtag){
                            $result['hashtag'][] = [
                                'value' => $hashtag->organic->value,
                                'name'  => $hashtag->name,
                            ];
                        }
                    }
                }
            }
            
            return $result;
        }
        
        public function get_user_post_detail($posts = null){
            
            $posts = $posts->edge_owner_to_timeline_media->edges;
            if($posts != null){
                $results = [];
                foreach($posts as $post){
                    
                    $post_insights = $this->get_post_insights($post->node->id);
                    $results[]     = [
                        'post_id'           => $post->node->id,
                        'post_insights'     => $post_insights,
                        'post_popular_tags' => $this->get_post_popular_tags($post_insights),
                    ];
                    
                }
                return $results;
            }
            else{
                return false;
            }
            
        }
        
    }