<?php
	
	// if we aren't in admin, get out
	if(!is_admin()) { return; }
	
	// removes unnessary WordPress dashboard widgets
	add_action('wp_dashboard_setup', 'jb_remove_dashboard_widgets');
	function jb_remove_dashboard_widgets() {
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
		remove_meta_box('dashboard_primary', 'dashboard', 'side');
		remove_meta_box('dashboard_secondary', 'dashboard', 'side');
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
	}

	//Admin footer modification - Replaces the "Thank you for developing with Wordpress" message at the bottom of the screen in admin
	function remove_footer_admin () 
	{
	   echo '<span id="footer-thankyou">Developed by <a href="https://www.powderkegwebdesign.com" target="_blank">Powderkeg</a></span>';
	}
	add_filter('admin_footer_text', 'remove_footer_admin');
	
	// displays custom error message whenever passed via the URL string variable 'pke'
	add_action('admin_notices', 'jb_custom_messages');
	function jb_custom_messages() {
		if($_GET['pke']) {
			echo '<div class="error"><p>'.$_GET['pke'].'</p></div>';
		}
		if($_GET['pkm_success']) {
			echo '<div class="updated"><p>'.$_GET['pkm_success'].'</p></div>';
		}
	}
	
	// restrict admins from being edited by the common folk
	add_action('admin_head', 'jb_restrict_user_edit');
	function jb_restrict_user_edit() {
		global $current_screen;
		
		$error_key = '';
		$edit_user_id = 0;
		
		// determine which screen they're trying to access
		if($current_screen->base == 'user-edit') {
			$edit_user_id = $_GET['user_id'];
			$error_key = 'edit';
		} elseif($current_screen->base == 'users' && $_GET['action'] == 'delete') {
			$edit_user_id = $_GET['user'];
			$error_key = 'delete';
		}
		
		if($edit_user_id) {
			if(!jb_is_admin()) {
				$edit_user = get_userdata($edit_user_id);
				if(in_array('administrator', $edit_user->roles)) {
					header('Location: /wp-admin/users.php?pke='.urlencode('You do not have the required permissions to '.$error_key.' that user.')); exit();
				}
			}
		}
	}
	
	// removes the role of administrator from the user role dropdown
	add_action('editable_roles', 'jb_update_roles_dropdown');
	function jb_update_roles_dropdown($roles){
		ksort($roles);
		
		if(!jb_is_admin()) {
			unset($roles['administrator']);
		}
		
		return $roles;
	}
	
	// enqueue scripts and css files for the back end here
	add_action('admin_enqueue_scripts', 'jb_admin_enqueue_scripts');
	function jb_admin_enqueue_scripts() {
	
		wp_enqueue_style('pk.style.admin', get_stylesheet_directory_uri().'/styles/admin.css');
	}

	/**
	 * Loop through all post types (skip post and page) and see if it has a font awesome unicode, if so setup the correct styles
	 *
	 * This requires the post type to be registered with the unicode for the menu_icon (ex: f107)
	 */
	//add_action('admin_head', 'jb_fontawesome_dashboard_setup');
	function jb_fontawesome_dashboard_setup(){
		
		//don't get the built in post types
		$args = array(
		   '_builtin' => false
		);

		//we want the post object and not just the names
		$output = 'objects';

		$post_types = get_post_types( $args, $output );

		foreach ( $post_types as $post_name => $post_type ) {
			//don't worry about acf- or tribe_ post types...for obvious reasons
			if (strpos($post_name, 'acf-') !== false || strpos($post_name, 'tribe_') !== false ) { continue; }
			
			//if the menu icon is not empty and it is 4 characters in length we will assume it is a unicode icon
			if (! empty($post_type->menu_icon) && strlen($post_type->menu_icon) == 4) {
				echo '<style type="text/css" media="screen">
		               #adminmenu #menu-posts-'.$post_name.' div.wp-menu-image:before {
		               font-family:"FontAwesome" !important;
		               font-size: 16px;
		               content:"\\'.$post_type->menu_icon.'"; }   
		             </style>';
			}
			
		}

	}