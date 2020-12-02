<?php
	
	// Set default description meta when Yoast is activated if nothing is found.
	add_action('activate_wordpress-seo.php','sp_yoast_activated');
	function sp_yoast_activated(){
		$default = '%%excerpt%%';
		$titles = get_option('wpseo_titles');
		$titles['metadesc-page'] = empty($titles['metadesc-page']) ? $default : $titles['metadesc-page'];
		$titles['metadesc-post'] = empty($titles['metadesc-post']) ? $default : $titles['metadesc-post'];
		update_option( 'wpseo_titles', $titles, true );
	}

	// only run if yoast is active
	if(class_exists('WPSEO_Frontend')) {

		// prevents the SEO options from always displaying directly below the content editor
		add_filter('wpseo_metabox_prio', 'sp_wpseo_metabox_prio');
		function sp_wpseo_metabox_prio() {
			return 'low';
		}

	}