<?php 



/**
 * Add a video to our normalized tables for easier searching from front end
 *
 * @param object $video The video object from the cached_video_list meta_data
 * @param int $channel_id The channel_id of the normalized channel related to this video
 * @return void
 */
function jb_add_normalized_video($video, $channel_id){
	global $wpdb;

	if(empty($video->id) || empty($video->id->videoId)) return;

	$video_info = jb_get_yt_video_info($video->id->videoId);

	$tag_string = '';
	if($video_info->tags){
		$tag_string = '#'.implode(',#',$video_info->tags).',';
	}
	
	$video_info->title = html_entity_decode($video_info->title, ENT_QUOTES);
	$video_info->description = displayTextWithLinks( html_entity_decode($video_info->description, ENT_QUOTES));

	$prepared_description = apply_filters('the_content', $video_info->description); //sanitize_text_field(addslashes($video_info->description));


	// This query works but the insert above does not. Weird
	$wpdb->query(
		$wpdb->prepare("INSERT INTO {$wpdb->videos} (`youtube_id`, `channel_id`, `title`, `tags`, `description`, `date`) 
						VALUES (%s, %d, %s, %s, %s, %s)
						ON DUPLICATE KEY UPDATE
						`youtube_id` = %s, 
						`channel_id` = %d,
						`title` = %s,
						`tags` = %s,
						`description` = %s,
						`date` = %s", 
						$video->id->videoId, 
						$channel_id, 
						$video_info->title, 
						$tag_string,
						$prepared_description, 
						date('Y-m-d', strtotime($video_info->publishedAt)), 
						$video->id->videoId, 
						$channel_id,
						$video_info->title, 
						$tag_string, 
						$prepared_description, 
						date('Y-m-d', strtotime($video_info->publishedAt))
			
		)
	);

	// jb_print($wpdb->last_error);
	// jb_print($wpdb->last_query);

}





/**
 * Add a channel to our normalized channel table for easier searching
 *
 * @param object $channel The $post object for the channel in question
 * @param boolean $videos Do you also want to normalize this channels videos?
 * @return void
 */
function jb_add_normalized_channel($channel_ID){
	global $wpdb;

	$c_fields = get_fields($channel_ID);

	//
	if($c_fields['last_update'] && (int)$c_fields['last_update'] >= (int)date('Ymd')) return;


	$channel_img = jb_get_yt_channel_img($channel_ID);
	//$channel_videos = jb_get_yt_channel_videos($c_fields['channel_id'], $channel->ID);

	$youtube_id = $c_fields['channel_id'];

	if(empty($youtube_id)) return false;

	$wpdb->insert(
		$wpdb->channels,
		array(
			'youtube_id' => $youtube_id,
			'title' => get_the_title($channel_ID),
			'description' => get_the_content($channel_ID),
			'img_url' => $channel_img,
			'facebook' => $c_fields['facebook'],
			'instagram' => $c_fields['instagram'],
			'patreon' => $c_fields['patreon'],
			'tiktok' => $c_fields['tiktok'],
			'twitter' => $c_fields['twitter'],
			'twitch' => $c_fields['twitch'],
			'website' => $c_fields['website'],
			//'tags' => '',
		)
	);

	if($wpdb->insert_id === 0){
		$wpdb->update(
			$wpdb->channels,
			array(
				'title' => get_the_title($channel_ID),
				'description' => get_the_content($channel_ID),
				'img_url' => $channel_img,
				'facebook' => $c_fields['facebook'],
				'instagram' => $c_fields['instagram'],
				'patreon' => $c_fields['patreon'],
				'tiktok' => $c_fields['tiktok'],
				'twitter' => $c_fields['twitter'],
				'twitch' => $c_fields['twitch'],
				'website' => $c_fields['website'],
				//'tags' => '',
			),
			array(
				'youtube_id' => $youtube_id,
			)
		);
	}else if($wpdb->insert_id === false){
		// Error
	}


	$c_id = jb_get_channel_id_by_yt_id($youtube_id);

	
	// Add this channel's videos
	jb_add_channel_videos($youtube_id, $c_id);

	jb_set_channel_styles($channel_ID, $c_id);

	jb_set_channel_topics($channel_ID, $c_id);



	update_field( 'field_60236ff01e466', date('Ymd'), $channel_ID );
}

/**
 * Get the normalized channel_id based on the channel's YT ID
 *
 * @param string $youtube_id
 * @return int
 */
function jb_get_channel_id_by_yt_id($youtube_id){
	global $wpdb;

	return $wpdb->get_var($wpdb->prepare("SELECT channel_id FROM {$wpdb->channels} WHERE youtube_id = %s", $youtube_id));
}

/**
 * Set the styles for this channel
 *
 * @param int $post_id The post ID of the channel in the admin
 * @param int $channel_id The row ID of the
 * @return void
 */
function jb_set_channel_styles($post_id, $channel_id){
	global $wpdb;

	$styles = get_the_terms($post_id, 'style');

	if(! empty($styles)){
		$style_ids = array_column($styles, 'term_id');

		foreach($style_ids as $style_id){
			$wpdb->insert(
				$wpdb->channel_styles,
				array(
					'channel_id' => $channel_id,
					'style_id' => $style_id,
				)
			);
		}
		
	}
}



/**
 * Set the styles for this channel
 *
 * @param int $post_id The post ID of the channel in the admin
 * @param int $channel_id The row ID of the
 * @return void
 */
function jb_set_channel_topics($post_id, $channel_id){
	global $wpdb;

	$topics = get_the_terms($post_id, 'topic');

	if(! empty($topics)){
		$topic_ids = array_column($topics, 'term_id');

		foreach($topic_ids as $topic_id){
			$wpdb->insert(
				$wpdb->channel_topics,
				array(
					'channel_id' => $channel_id,
					'topic_id' => $topic_id,
				)
			);
		}
		
	}
}



/**
 * Add videos from a youtube channel based on the channel's youtube ID
 *
 * @param string $youtube_id YouTube ID
 * @param int $channel_id The table ID of the channel
 * @return void
 */
function jb_add_channel_videos($youtube_id, $channel_id){
	global $wpdb;

	$yt_id = get_field('yt_api_key', 'option');

	$done = false;
	$max_videos = 120; // TODO: Increase this number? OR Setup some other "Full Import"
	$page_limit = 6;
	$channel_obj = null;
	$count = 0;

	
	while(! $done){
		$count++;

		$url = 'https://www.googleapis.com/youtube/v3/search?key='.$yt_id.'&channelId='.$youtube_id.'&part=snippet&order=date&maxResults=20';

		if($channel_obj && ! empty($channel_obj->nextPageToken)){
			$url .= '&pageToken='.$channel_obj->nextPageToken;
		}

		$result = file_get_contents($url);

		if($result){

			$channel_obj = json_decode( $result );
			
			// jb_print($channel_obj);

			// Does the FIRST video exist?
			$video_exists = $wpdb->get_var(
							$wpdb->prepare("SELECT video_id FROM {$wpdb->videos} WHERE youtube_id = %s", $channel_obj->items[0]->id->videoId));
			
			// If we already have these videos we don't need to waste quota importing them
			if($video_exists){
				$done = true;
				break;
			}

			// Does the last video exist?
			$video_exists = $wpdb->get_var(
				$wpdb->prepare("SELECT video_id FROM {$wpdb->videos} WHERE youtube_id = %s", $channel_obj->items[count($channel_obj->items)-1]->id->videoId));

			// If we already have these videos we don't need to waste quota importing them
			if($video_exists){
				$done = true;
				// we don't want to break here because we still want to import some channel videos, but this will be the only batch we need
			}

			if(! empty($channel_obj->items)){
				foreach($channel_obj->items as $video){
					jb_add_normalized_video($video, $channel_id);
				}
				
			}

			if($count > $page_limit){
				$done = true;
				break;
			}
		}else{
			$done = true;
			break;
		}
	}
}


add_action('add_meta_boxes', 'wpse_add_custom_meta_box_2');
//making the meta box (Note: meta box != custom meta field)
function wpse_add_custom_meta_box_2() {
	add_meta_box(
		'channel-videos',       // $id
		'Videos',                  // $title
		'jb_show_channel_videos',  // $callback
		'channels',                 // $page
		'normal',                  // $context
		'low'                     // $priority
	);
}

//showing custom form fields
function jb_show_channel_videos() {
	global $post;

	$cached_list = str_replace("\'","'",get_post_meta($post->ID,'cached_video_list', true));

	$channel_videos = json_decode($cached_list);

	echo '<table>
			<thead>
				<tr>
					<th>Title</th>
					<th>ID</th>
					<th>Date</th>
				</tr>
			</thead>';
	foreach($channel_videos as $vkey => $video){
		if(empty($video->video_id)) continue;

		echo '<tr>
				<td>'.$video->title.'</td>
				<td>'.$video->video_id.'</td>
				<td>'.$video->date.'</td>
			</tr>';
	}
	
	echo '</table>';

}



/**
 * Create all of our normalized tables for each new site
 *
 * @return void
 */
function jb_create_normal_tables(){
	global $wpdb;

	$channel_table = "CREATE TABLE `{$wpdb->prefix}channels` (
						`channel_id` INT(11) NOT NULL AUTO_INCREMENT,
						`youtube_id` VARCHAR(50) NOT NULL DEFAULT NULL,
						`title` VARCHAR(100) NULL DEFAULT NULL,
						`description` TEXT NULL,
						`img_url` TEXT NULL,
						`facebook` VARCHAR(255) NULL DEFAULT NULL,
						`instagram` VARCHAR(255) NULL DEFAULT NULL,
						`patreon` VARCHAR(255) NULL DEFAULT NULL,
						`tiktok` VARCHAR(255) NULL DEFAULT NULL,
						`twitter` VARCHAR(255) NULL DEFAULT NULL,
						`twitch` VARCHAR(255) NULL DEFAULT NULL,
						`website` VARCHAR(255) NULL DEFAULT NULL,
						`tags` TEXT NULL,
						`active` TINYINT(4) NULL DEFAULT NULL,
						`last_updated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`channel_id`),
						UNIQUE INDEX `youtube_id` (`youtube_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					AUTO_INCREMENT=1;";
	
	$wpdb->query($channel_table);

	$channel_styles = "CREATE TABLE `{$wpdb->prefix}channel_styles` (
						`channel_id` INT(11) NULL DEFAULT NULL,
						`style_id` INT(11) NULL DEFAULT NULL,
						UNIQUE INDEX `channel_id_style_id` (`channel_id`, `style_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB;";

	$wpdb->query($channel_styles);

	$channel_topics = "CREATE TABLE `{$wpdb->prefix}channel_topics` (
						`channel_id` INT(11) NULL DEFAULT NULL,
						`topic_id` INT(11) NULL DEFAULT NULL,
						UNIQUE INDEX `channel_id_topic_id` (`channel_id`, `topic_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB;";

	$wpdb->query($channel_topics);


	$channel_views = "CREATE TABLE `{$wpdb->prefix}channel_views` (
						`channel_id` INT(11) NOT NULL,
						`view_count` INT(11) NOT NULL,
						`last_view` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`first_view` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`channel_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB;";

	$wpdb->query($channel_views);


	$user_history = "CREATE TABLE `{$wpdb->prefix}history` (
						`history_id` INT(11) NOT NULL AUTO_INCREMENT,
						`user_id` VARCHAR(50) NOT NULL DEFAULT '0',
						`video_id` INT(11) NULL DEFAULT NULL,
						`last_watched` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`history_id`),
						UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					AUTO_INCREMENT=1;";
	
	$wpdb->query($user_history);


	$user_liked = "CREATE TABLE `{$wpdb->prefix}liked` (
					`liked_id` INT(11) NOT NULL AUTO_INCREMENT,
					`user_id` VARCHAR(50) NOT NULL DEFAULT '0',
					`video_id` INT(11) NOT NULL DEFAULT '0',
					`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (`liked_id`),
					UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
				)
				COLLATE='latin1_swedish_ci'
				ENGINE=InnoDB
				AUTO_INCREMENT=1;";
	
	$wpdb->query($user_liked);


	// $styles = "CREATE TABLE `{$wpdb->prefix}styles` (
	// 			`style_id` INT(11) NOT NULL AUTO_INCREMENT,
	// 			`style_name` VARCHAR(50) NOT NULL,
	// 			PRIMARY KEY (`style_id`)
	// 		)
	// 		COLLATE='latin1_swedish_ci'
	// 		ENGINE=InnoDB
	// 		AUTO_INCREMENT=1;";

	// $wpdb->query($styles);


	// $topics = "CREATE TABLE `{$wpdb->prefix}topics` (
	// 				`topic_id` INT(11) NOT NULL AUTO_INCREMENT,
	// 				`topic_name` VARCHAR(255) NULL DEFAULT NULL,
	// 				PRIMARY KEY (`topic_id`)
	// 			)
	// 			COLLATE='latin1_swedish_ci'
	// 			ENGINE=InnoDB
	// 			AUTO_INCREMENT=1;";

	// $wpdb->query($topics);


	$videos_table = "CREATE TABLE `{$wpdb->prefix}videos` (
						`video_id` INT(11) NOT NULL AUTO_INCREMENT,
						`youtube_id` VARCHAR(50) NOT NULL DEFAULT NULL,
						`channel_id` INT(11) NOT NULL DEFAULT NULL,
						`title` VARCHAR(50) NOT NULL,
						`description` TEXT NOT NULL,
						`tags` MEDIUMTEXT NOT NULL,
						`date` DATE NOT NULL,
						`last_updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`video_id`),
						UNIQUE INDEX `youtube_id` (`youtube_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					AUTO_INCREMENT=1;";

	$wpdb->query($videos_table);


	$video_views = "CREATE TABLE `{$wpdb->prefix}video_views` (
						`video_id` INT(11) NOT NULL,
						`view_count` INT(11) NOT NULL,
						`last_view` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`first_view` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`video_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB;";

	$wpdb->query($video_views);


	$watch_later = "CREATE TABLE `{$wpdb->prefix}watch_later` (
						`watch_id` INT(11) NOT NULL AUTO_INCREMENT,
						`user_id` VARCHAR(50) NOT NULL,
						`video_id` INT(11) NOT NULL,
						`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						PRIMARY KEY (`watch_id`),
						UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					AUTO_INCREMENT=1;";
	
	$wpdb->query($watch_later);

}

