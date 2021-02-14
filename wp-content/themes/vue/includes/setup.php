<?php 

// prints out an array with <pre> tags
function jb_print($input, $force = false) { 
	if(ENVIRONMENT != 'live' || $force === true){
		echo '<pre class="pk-print">'.print_r($input, true).'</pre>'; 
	}
}

// change where acf json files are saved
add_filter('acf/settings/save_json', 'jb_acf_save_json');
function jb_acf_save_json($path) { return get_template_directory().'/includes/acf-json'; }

// add our custom folder to places acf json are loaded from
add_filter('acf/settings/load_json', 'jb_acf_load_json');
function jb_acf_load_json($paths) { 
	return array_merge($paths, array(get_template_directory().'/includes/acf-json')); 
}

// acf options pages
if(function_exists('acf_add_options_page')) {
	acf_add_options_sub_page(array('title'=>'Website Options', 'parent'=>'themes.php', 'capability'=>'edit_theme_options'));
}



// register a custom post type: ex: jb_register_cpt(array('name' => 'FAQ', 'icon' => 'dashicons-format-status', 'position' => 5, 'is_singular' => true));
function jb_register_cpt($cpt_array = array()){ 
	$default_cpt = array( 'name' => '', 
						'icon' => 'dashicons-admin-post', 
						'position' => 4, 
						'description' => '', 
						'is_singular' => false, 
						'exclude_from_search' => false, 
						'supports' => array('title','editor','thumbnail','page-attributes'), 
						'taxonomies' => array(), 
						'has_archive' => false, 
						'rewrite' => array(), 
						'public' => true, 
						'show_in_rest' => false,
						'hierarchical' => false 
					);	
	if(! empty($cpt_array)){
		$cpt_array = wp_parse_args( $cpt_array, $default_cpt );
		$slug = strtolower($cpt_array['name']);
		$plural = (substr($slug, -1) == 's') ? 'es' : 's';
		
		if(substr($slug, -1) == 'y' && ! $cpt_array['is_singular']){
			$slug = rtrim($slug, 'y');
			$plural = 'ies';
		}
		
		$plural_slug = ($cpt_array['is_singular']) ? $slug : $slug.$plural;
		$plural_slug = str_replace(" ", "-", $plural_slug);
		$label = ucwords(str_replace("-", " ", $cpt_array['name']));

		$is_y = false;
		if(substr($label, -1) == 'y' && ! $cpt_array['is_singular']){
			$label = rtrim($label, 'y');
			$is_y = true;
		}

		$plural_label = ($cpt_array['is_singular']) ? $label : $label.$plural;
		
		//we removed the y from the label to put on an ies...now let's add the Y back.
		if($is_y){
			$label .= 'y';
		}
		
		register_post_type( $plural_slug, array(
							'label' => $plural_label,
							'description' => $cpt_array['description'],
							'public' => $cpt_array['public'],
							'show_in_rest' => $cpt_array['show_in_rest'],
							'show_ui' => true,
							'show_in_menu' => true,
							'exclude_from_search' => $cpt_array['exclude_from_search'],
							'capability_type' => 'post',
							'map_meta_cap' => true,
							'hierarchical' => $cpt_array['hierarchical'],
							'has_archive' => $cpt_array['has_archive'],
							'rewrite' => $cpt_array['rewrite'],
							'query_var' => true,
							'taxonomies' => $cpt_array['taxonomies'],
							'menu_position' => $cpt_array['position'],
							'menu_icon' => $cpt_array['icon'],
							'supports' => $cpt_array['supports'],
							'labels' => array (
								'name' => $plural_label,
								'singular_name' => $label,
								'menu_name' => $plural_label,
								'add_new' => 'Add '.$label,
								'add_new_item' => 'Add New '.$label,
								'edit' => 'Edit',
								'edit_item' => 'Edit '.$label,
								'new_item' => 'New '.$label,
								'view' => 'View '.$plural_label,
								'view_item' => 'View '.$label,
								'search_items' => 'Search '.$plural_label,
								'not_found' => 'No '.$plural_label.' Found',
								'not_found_in_trash' => 'No '.$plural_label.' Found in Trash',
								'parent' => 'Parent '.$label
							)
						)); 
	}
}

/**
 * Helper function for registering a taxonomy
 *
 * @param string $tax_name  	A url safe taxonomy name / slug
 * @param string $post_type 	What post type this taxonomy will be applied to
 * @param string $menu_title 	The title of the taxonomy. Human Readable.
 * @param array  $rewrite 	 	Overwrite the rewrite
 */
function jb_register_taxonomy($tax_name = '', $post_type = '', $menu_title = '', $public = true, $rewrite = array()){

	if(empty($rewrite)){
		$rewrite = array( 'slug' => $tax_name );
	}

	register_taxonomy(
		$tax_name,
		$post_type,
		array(
			'label' => __( $menu_title ),
			'rewrite' => $rewrite, 
			'capabilities' => array(
				'manage_terms' => 'manage_categories',
				'assign_terms' => 'manage_categories',
				'edit_terms' => 'manage_categories',
				'delete_terms' => 'manage_categories'
			),
			'hierarchical' => true,
			'publicly_queryable' => $public
		)
	);
}



add_action('wp_dashboard_setup', 'jb_create_dashboard_widgets');
function jb_create_dashboard_widgets() {
	global $wp_meta_boxes;
	
	wp_add_dashboard_widget('create_table_widget', 'Create Tables', 'jb_create_table_widget_function');
	//wp_add_dashboard_widget('add_channel_widget', 'Add Channel', 'jb_add_channel_widget_function');
}

function jb_create_table_widget_function() {
	global $wpdb;

	if(! empty($_POST['create-tables']) && $_POST['create-tables'] === 'Create'){
		jb_create_normal_tables();
	}

	$wpdb->get_results("SELECT channel_id FROM {$wpdb->prefix}channels LIMIT 1");

	if(! $wpdb->last_error){
		echo 'Tables Created!';
	}else{
		echo '<form method="post"><button name="create-tables" value="Create">Create Tables</button></form>';
	}
	
}


// function jb_add_channel_widget_function(){

// }


// /**
//  * Create all of our normalized tables for each new site
//  *
//  * @return void
//  */
// function jb_create_normal_tables(){
// 	global $wpdb;

// 	// $channel_table = "CREATE TABLE `{$wpdb->prefix}channels` (
// 	// 					`channel_id` INT(11) NOT NULL AUTO_INCREMENT,
// 	// 					`youtube_id` VARCHAR(50) NULL DEFAULT NULL,
// 	// 					`title` VARCHAR(100) NULL DEFAULT NULL,
// 	// 					`description` TEXT NULL,
// 	// 					`img_url` TEXT NULL,
// 	// 					`facebook` VARCHAR(255) NULL DEFAULT NULL,
// 	// 					`instagram` VARCHAR(255) NULL DEFAULT NULL,
// 	// 					`patreon` VARCHAR(255) NULL DEFAULT NULL,
// 	// 					`tiktok` VARCHAR(255) NULL DEFAULT NULL,
// 	// 					`twitter` VARCHAR(255) NULL DEFAULT NULL,
// 	// 					`twitch` VARCHAR(255) NULL DEFAULT NULL,
// 	// 					`website` VARCHAR(255) NULL DEFAULT NULL,
// 	// 					`tags` TEXT NULL,
// 	// 					`active` TINYINT(4) NULL DEFAULT NULL,
// 	// 					`last_updated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
// 	// 					`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
// 	// 					PRIMARY KEY (`channel_id`),
// 	// 					UNIQUE INDEX `youtube_id` (`youtube_id`)
// 	// 				)
// 	// 				COLLATE='latin1_swedish_ci'
// 	// 				ENGINE=InnoDB
// 	// 				AUTO_INCREMENT=1;";
	
// 	// $wpdb->query($channel_table);

// 	// $channel_styles = "CREATE TABLE `{$wpdb->prefix}channel_styles` (
// 	// 					`channel_id` INT(11) NULL DEFAULT NULL,
// 	// 					`style_id` INT(11) NULL DEFAULT NULL,
// 	// 					UNIQUE INDEX `channel_id_style_id` (`channel_id`, `style_id`)
// 	// 				)
// 	// 				COLLATE='latin1_swedish_ci'
// 	// 				ENGINE=InnoDB;";

// 	// $wpdb->query($channel_styles);

// 	// $channel_topics = "CREATE TABLE `{$wpdb->prefix}channel_topics` (
// 	// 					`channel_id` INT(11) NULL DEFAULT NULL,
// 	// 					`topic_id` INT(11) NULL DEFAULT NULL,
// 	// 					UNIQUE INDEX `channel_id_topic_id` (`channel_id`, `topic_id`)
// 	// 				)
// 	// 				COLLATE='latin1_swedish_ci'
// 	// 				ENGINE=InnoDB;";

// 	// $wpdb->query($channel_topics);


// 	// $styles = "CREATE TABLE `{$wpdb->prefix}styles` (
// 	// 			`style_id` INT(11) NOT NULL AUTO_INCREMENT,
// 	// 			`style_name` VARCHAR(50) NOT NULL,
// 	// 			PRIMARY KEY (`style_id`)
// 	// 		)
// 	// 		COLLATE='latin1_swedish_ci'
// 	// 		ENGINE=InnoDB
// 	// 		AUTO_INCREMENT=1;";

// 	// $wpdb->query($styles);


// 	// $topics = "CREATE TABLE `{$wpdb->prefix}topics` (
// 	// 				`topic_id` INT(11) NOT NULL AUTO_INCREMENT,
// 	// 				`topic_name` VARCHAR(255) NULL DEFAULT NULL,
// 	// 				PRIMARY KEY (`topic_id`)
// 	// 			)
// 	// 			COLLATE='latin1_swedish_ci'
// 	// 			ENGINE=InnoDB
// 	// 			AUTO_INCREMENT=1;";

// 	// $wpdb->query($topics);


// 	// $videos_table = "CREATE TABLE `{$wpdb->prefix}videos` (
// 	// 					`video_id` INT(11) NOT NULL AUTO_INCREMENT,
// 	// 					`youtube_id` VARCHAR(50) NULL DEFAULT NULL,
// 	// 					`channel_id` INT(11) NULL DEFAULT NULL,
// 	// 					`title` VARCHAR(50) NOT NULL,
// 	// 					`description` TEXT NOT NULL,
// 	// 					`tags` MEDIUMTEXT NOT NULL,
// 	// 					`date` DATE NOT NULL,
// 	// 					`last_updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
// 	// 					`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
// 	// 					PRIMARY KEY (`video_id`),
// 	// 					UNIQUE INDEX `youtube_id` (`youtube_id`)
// 	// 				)
// 	// 				COLLATE='latin1_swedish_ci'
// 	// 				ENGINE=InnoDB
// 	// 				AUTO_INCREMENT=1;";

// 	// $wpdb->query($videos_table);



// 	$channel_views = "CREATE TABLE `{$wpdb->prefix}channel_views` (
// 						`channel_id` INT(11) NOT NULL,
// 						`view_count` INT(11) NOT NULL,
// 						`last_view` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
// 						`first_view` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
// 						PRIMARY KEY (`channel_id`)
// 					)
// 					COLLATE='latin1_swedish_ci'
// 					ENGINE=InnoDB;";

// 	$wpdb->query($channel_views);


// 	$user_history = "CREATE TABLE `{$wpdb->prefix}history` (
// 						`history_id` INT(11) NOT NULL AUTO_INCREMENT,
// 						`user_id` VARCHAR(50) NOT NULL DEFAULT '0',
// 						`video_id` INT(11) NULL DEFAULT NULL,
// 						`last_watched` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
// 						`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
// 						PRIMARY KEY (`history_id`),
// 						UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
// 					)
// 					COLLATE='latin1_swedish_ci'
// 					ENGINE=InnoDB
// 					AUTO_INCREMENT=1;";
	
// 	$wpdb->query($user_history);


// 	$user_liked = "CREATE TABLE `{$wpdb->prefix}liked` (
// 					`liked_id` INT(11) NOT NULL AUTO_INCREMENT,
// 					`user_id` VARCHAR(50) NOT NULL DEFAULT '0',
// 					`video_id` INT(11) NOT NULL DEFAULT '0',
// 					`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
// 					PRIMARY KEY (`liked_id`),
// 					UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
// 				)
// 				COLLATE='latin1_swedish_ci'
// 				ENGINE=InnoDB
// 				AUTO_INCREMENT=1;";
	
// 	$wpdb->query($user_liked);



// 	$video_views = "CREATE TABLE `{$wpdb->prefix}video_views` (
// 						`video_id` INT(11) NOT NULL,
// 						`view_count` INT(11) NOT NULL,
// 						`last_view` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
// 						`first_view` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
// 						PRIMARY KEY (`video_id`)
// 					)
// 					COLLATE='latin1_swedish_ci'
// 					ENGINE=InnoDB;";

// 	$wpdb->query($video_views);


// 	$watch_later = "CREATE TABLE `{$wpdb->prefix}watch_later` (
// 						`watch_id` INT(11) NOT NULL AUTO_INCREMENT,
// 						`user_id` VARCHAR(50) NOT NULL,
// 						`video_id` INT(11) NOT NULL,
// 						`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
// 						PRIMARY KEY (`watch_id`),
// 						UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
// 					)
// 					COLLATE='latin1_swedish_ci'
// 					ENGINE=InnoDB
// 					AUTO_INCREMENT=1;";
	
// 	$wpdb->query($watch_later);

// }