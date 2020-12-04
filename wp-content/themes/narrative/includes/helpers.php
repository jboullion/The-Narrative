<?php 
/**
 * Return simple / constent data or provide other "helper" type functionality
 */

/**
 * Display the last couple errors from WPDB
 */
function jb_wpdb_errors($wpdb){
	jb_print($wpdb->last_query);
	jb_print($wpdb->last_error);
}
