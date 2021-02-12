<?php
// // includes all flags for certain theme support
// include('includes/theme-support.php');

// Include all our custom functionality
include('includes/setup.php');

// Functionality that runs when a channel is saved
include('includes/save-post.php');

// // Various functions which help with tasks around the site
// include('includes/helpers.php');

// // Get stuff
// include('includes/getters.php');

// // Modify queries
// include('includes/queries.php');


add_action('init', 'jb_register_cpts');
function jb_register_cpts() {

	jb_register_cpt(array('name' => 'channel', 'icon' => 'dashicons-id', 'position' => 30, 'public' => false )); // , 'show_in_rest' => true,
	//jb_register_cpt(array('name' => 'voice', 'icon' => 'dashicons-megaphone', 'position' => 31 ));
	
	jb_register_cpt(array('name' => 'video', 'icon' => 'dashicons-format-video', 'position' => 31, 'public' => false )); // , 'show_in_rest' => true,

	//jb_register_taxonomy('genre', array('channels', 'voices'), 'Genre');
	jb_register_taxonomy('style', array('channels'), 'Style');
	jb_register_taxonomy('topic', array('channels'), 'Topic');

	//unregister_taxonomy_for_object_type('post_tag', 'post');
	//unregister_taxonomy_for_object_type('product_tag', 'product');
}