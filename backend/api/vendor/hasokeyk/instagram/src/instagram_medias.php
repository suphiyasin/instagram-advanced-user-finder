<?php

	namespace instagram;

	class instagram_medias extends instagram_request{

		public $username;
		public $password;
		public $functions;

		function __construct($username, $password, $functions = null){
			$this->username  = $username;
			$this->password  = $password;
			$this->functions = $functions;
		}

		public function get_post_likes($post_id = null){

			if($post_id != null){

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/likers/';

				$json = $this->request($url);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function get_comment_post($post_id = null){

			if($post_id != null){

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/comments/';

				$json = $this->request($url);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function get_permalink_by_shortcode($post_id = null){

			if($post_id != null){

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/permalink/?share_to_app=share_sheet';

				$json = $this->request($url);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function get_user_posts($username = null){

			$cache = $this->cache('posts');
			if($cache == false){

				$post_hashquery = $this->get_post_queryhash();
				$user_id        = $this->get_user_id();
				$url            = 'https://www.instagram.com/graphql/query/?query_hash='.$post_hashquery.'&variables={"id":"'.$user_id.'","first":50}';
				$json           = $this->request($url);
				$json           = json_decode($json['body'])->data->user;

				$this->cache('posts', $json);

				$result = $json;
			}
			else{
				$result = $cache;
			}

			return $result;
		}

		public function like($post_id){

			if($post_id != null){

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/like/';

				$post_data = [
					'container_module' => 'feed_contextual_profile',
					'delivery_class'   => 'organic',
					'radio_type'       => 'wifi-none',
					'feed_position'    => '0',
					'media_id'         => $post_id,
					'_csrftoken'       => $this->get_csrftoken(),
					'_uuid'            => $this->get_guid(),
				];
				$post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];

				$json = $this->request($url, 'POST', $post_data);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function unlike($post_id){

			if($post_id != null){

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/unlike/';

				$post_data = [
					'container_module' => 'feed_contextual_profile',
					'delivery_class'   => 'organic',
					'radio_type'       => 'wifi-none',
					'feed_position'    => '0',
					'media_id'         => $post_id,
					'_csrftoken'       => $this->get_csrftoken(),
					'_uuid'            => $this->get_guid(),
				];
				$post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];

				$json = $this->request($url, 'POST', $post_data);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function save($post_id){

			if($post_id != null){

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/save/';

				$post_data = [
					'module_name' => 'feed_timeline',
					'radio_type'  => 'wifi-none',
					'_csrftoken'  => $this->get_csrftoken(),
					'_uuid'       => $this->get_guid(),
				];
				$post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];

				$json = $this->request($url, 'POST', $post_data);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function unsave($post_id){

			if($post_id != null){

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/unsave/';

				$post_data = [
					'module_name' => 'feed_timeline',
					'radio_type'  => 'wifi-none',
					'_csrftoken'  => $this->get_csrftoken(),
					'_uuid'       => $this->get_guid(),
				];
				$post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];

				$json = $this->request($url, 'POST', $post_data);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}#

		public function send_comment_post($post_id, $comment = 'hi'){

			if($post_id != null){

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/comment/';

				$post_data = [
					'comment_text'      => $comment,
					'container_module'  => 'comments_v2_feed_contextual_profile',
					'delivery_class'    => 'organic',
					'idempotence_token' => '455f2f7e-7abf-4236-b527-8f422f84bab0',
					'_csrftoken'        => $this->get_csrftoken(),
					'_uuid'             => $this->get_guid(),
				];
				$post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];

				$json = $this->request($url, 'POST', $post_data);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function delete_comment_post($post_id = null, $comment_id = null, $auto_find_comment_id = false){

			if($post_id != null){

				if($auto_find_comment_id == true){
					$get_comment_posts = $this->get_comment_post($post_id);
					$me_user_id        = $this->functions->user->get_user_id();
					$comment_id        = 0;
					foreach($get_comment_posts->comments as $comment){
						if($me_user_id == $comment->user_id){
							$comment_id = $comment->pk;
							break;
						}
					}
					if($comment_id == 0){
						return false;
					}
				}

				$url = 'https://i.instagram.com/api/v1/media/'.$post_id.'/comment/bulk_delete/';

				$post_data = [
					'comment_ids_to_delete' => $comment_id,
					'container_module'      => 'comments_v2_feed_contextual_profile',
					'_csrftoken'            => $this->get_csrftoken(),
					'_uuid'                 => $this->get_guid(),
				];
				$post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];

				$json = $this->request($url, 'POST', $post_data);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function share_media_inbox($post_id = null, $username = null){

			if($post_id != null and $username != null){

				$get_thread_id = $this->functions->user->get_create_inbox_thread($username);

				$url = 'https://i.instagram.com/api/v1/direct_v2/threads/broadcast/media_share/?media_type=video';

				$post_data = [
					'action'           => 'send_item',
					'is_shh_mode'      => '0',
					'send_attribution' => 'comments_v2_feed_contextual_profile',
					'thread_ids'       => '['.$get_thread_id->thread->thread_id.']',
					'media_id'         => $post_id,
					'_csrftoken'       => $this->get_csrftoken(),
					'_uuid'            => $this->get_guid(),
				];

				$json = $this->request($url, 'POST', $post_data);
				$json = json_decode($json['body']);

				return $json;
			}

			return false;

		}

		public function share_photo($image_path = null, $desc = null){

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
				$result = $this->_share_photo($upload_id, $desc);
				print_r($result);
				if($result->status == 'ok'){
					return true;
				}
			}

			return false;

		}

		private function _share_photo($upload_id = null, $desc = null){

			$url       = 'https://i.instagram.com/api/v1/media/configure/';
			$post_data = [
				"scene_capture_type"         => "",
				"timezone_offset"            => "10800",
				"_csrftoken"                 => "L3toHeMiinPTPxRkOST8feCLY0gIa61x",
				"media_folder"               => "Camera",
				"source_type"                => "4",
				"_uid"                       => "44433622125",
				"device_id"                  => $this->get_device_id(),
				"_uuid"                      => $this->get_guid(),
				"creation_logger_session_id" => "cf4fea1e-a304-44d9-af56-62914c9d728e",
				"caption"                    => $desc,
				"upload_id"                  => $upload_id,
				"multi_sharing"              => "1",
				"device"                     => [
					"manufacturer"    => "Google",
					"model"           => "google+Pixel+2",
					"android_version" => 22,
					"android_release" => "5.1.1",
				],
				"edits"                      => [
					"crop_original_size" => [
						640,
						480,
					],
					"crop_center"        => [
						0,
						-0,
					],
					"crop_zoom"          => 1.3333334,
				],
				"extra"                      => [
					"source_width"  => 640,
					"source_height" => 480,
				],
			];
			$post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];
			$json      = $this->request($url, 'POST', $post_data);
			return json_decode($json['body']);

		}

		public function del_photo($post_id = null){

			if($post_id != null){

				$url       = 'https://i.instagram.com/api/v1/media/'.$post_id.'/delete/?media_type=PHOTO';
				$post_data = [
					'igtv_feed_preview' => 'false',
					'media_id'          => $post_id,
					'_csrftoken'        => $this->get_csrftoken(),
					'_uuid'             => $this->get_guid(),
				];
				$post_data = ['signed_body' => 'SIGNATURE.'.json_encode($post_data)];

				$json = $this->request($url, 'POST', $post_data);
				$json = json_decode($json['body']);

				return $json;

			}

			return false;
		}
        
        public function get_story($username = null){
    
            $username = $this->functions->user->get_user_id($username??$this->username);
            //$url = 'https://i.instagram.com/api/v1/feed/user/'.$username.'/story/?supported_capabilities_new=%5B%7B%22name%22%3A%22SUPPORTED_SDK_VERSIONS%22%2C%22value%22%3A%22103.0%2C104.0%2C105.0%2C106.0%2C107.0%2C108.0%2C109.0%2C110.0%2C111.0%2C112.0%2C113.0%2C114.0%2C115.0%2C116.0%2C117.0%2C118.0%2C119.0%2C120.0%2C121.0%22%7D%2C%7B%22name%22%3A%22FACE_TRACKER_VERSION%22%2C%22value%22%3A%2214%22%7D%2C%7B%22name%22%3A%22segmentation%22%2C%22value%22%3A%22segmentation_enabled%22%7D%2C%7B%22name%22%3A%22COMPRESSION%22%2C%22value%22%3A%22ETC2_COMPRESSION%22%7D%2C%7B%22name%22%3A%22world_tracker%22%2C%22value%22%3A%22world_tracker_enabled%22%7D%2C%7B%22name%22%3A%22gyroscope%22%2C%22value%22%3A%22gyroscope_enabled%22%7D%5D';
            $url = 'https://i.instagram.com/api/v1/feed/user/'.$username.'/story/';
            $json = $this->request($url, 'GET');
            $json = json_decode($json['body']);
    
            return $json;
            
        }
	}