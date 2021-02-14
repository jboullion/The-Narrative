<?php

//Add Featured Image Support
add_theme_support( 'post-thumbnails' ); 

// // Some functions used in our API and elsewhere
// include('/api/api-functions.php');

// Include all our custom functionality
include('includes/setup.php');

// Functionality that runs when a channel is saved
include('includes/save-post.php');

// Various functions which help with tasks around the site
include('includes/normalize-functions.php');



// // Get stuff
// include('includes/getters.php');

// // Modify queries
// include('includes/queries.php');


add_action('init', 'jb_register_cpts');
function jb_register_cpts() {

	jb_setup_wpdb_tables();

	jb_register_cpt(array('name' => 'channel', 'icon' => 'dashicons-id', 'position' => 30, 'public' => false )); // , 'show_in_rest' => true,
	//jb_register_cpt(array('name' => 'voice', 'icon' => 'dashicons-megaphone', 'position' => 31 ));
	
	//jb_register_cpt(array('name' => 'video', 'icon' => 'dashicons-format-video', 'position' => 31, 'public' => false )); // , 'show_in_rest' => true,

	//jb_register_taxonomy('genre', array('channels', 'voices'), 'Genre');
	jb_register_taxonomy('style', array('channels'), 'Style');
	jb_register_taxonomy('topic', array('channels'), 'Topic');
	jb_register_taxonomy('tags', array('channels'), 'Tags');

	//unregister_taxonomy_for_object_type('post_tag', 'post');
	//unregister_taxonomy_for_object_type('product_tag', 'product');
}


function jb_setup_wpdb_tables(){
	global $wpdb;

	$wpdb->channels = $wpdb->prefix.'channels';
	$wpdb->videos = $wpdb->prefix.'videos';
	$wpdb->history = $wpdb->prefix.'history';
	$wpdb->liked = $wpdb->prefix.'liked';
	$wpdb->styles = $wpdb->prefix.'styles';
	$wpdb->topics = $wpdb->prefix.'topics';
	$wpdb->channel_styles = $wpdb->prefix.'channel_styles';
	$wpdb->channel_topics = $wpdb->prefix.'channel_topics';
	$wpdb->channel_views = $wpdb->prefix.'channel_views';
	$wpdb->video_views = $wpdb->prefix.'video_views';
	$wpdb->watch_later = $wpdb->prefix.'watch_later';
}

/**
 * Seach a text string and convert all urls with links
 *
 * @param string $s
 * @return string
 */
function displayTextWithLinks($s) {
	return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank" rel="nofollow">$1</a>', $s);
}