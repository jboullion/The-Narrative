<?php
	
	// if acf isn't enabled, get out
	if(!class_exists('acf')) { return; }

	foreach(glob(dirname(__FILE__).'/acf/*.php') as $filepath) { include_once $filepath; }

	// change where acf json files are saved
	add_filter('acf/settings/save_json', 'sp_acf_save_json');
	function sp_acf_save_json($path) { return get_stylesheet_directory().'/includes/acf-json'; }

	// add our custom folder to places acf json are loaded from
	add_filter('acf/settings/load_json', 'sp_acf_load_json');
	function sp_acf_load_json($paths) { return array_merge($paths, array(get_stylesheet_directory().'/includes/acf-json')); }

	// acf options pages
	if(function_exists('acf_add_options_page')) {
		acf_add_options_sub_page(array('title'=>'Website Options', 'parent'=>'themes.php', 'capability'=>'edit_theme_options'));
	}

	/*
	*  Return array of Font Awesome Icons to be used with the acf font awesome plugin
	*  Prevents us from having to add a bunch of domains to the CDN to use the plugin
	*  In the plugin settings, make sure you have version 5.x enabled and
	*  You check the box for "I have enabled this domain for CDN use." - NK
	*/
	add_filter('ACFFA_get_icons','sp_ACFFA_get_icons', 10, 1);
	function sp_ACFFA_get_icons($icons){
		$run = apply_filters('sp_ACFFA_get_icons_run',true);

		/*
		*  To get the latest list for hard coding:
		*  Add an acf field to a page and uncomment this snippet
		*  then copy paste the output on the admin page as the $sp_icons var 
		*  and make sure to return the right version from the FA site at the bottom
		*  We hardcode it because it tries to pull from your live account
		*  otherwise, and we're not setting that crap up
			$test = base64_encode(serialize(array('5.12.1' => $icons)));
			sp_print($test); die();
		*/	

		if(!$run){ return $icons; }


		return $sp_icons['5.12.1'];
	}