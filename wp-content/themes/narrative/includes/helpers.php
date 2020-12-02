<?php 
/**
 * Return simple / constent data or provide other "helper" type functionality
 */

/**
 * Display the last couple errors from WPDB
 */
function sp_wpdb_errors($wpdb){
	sp_print($wpdb->last_query);
	sp_print($wpdb->last_error);
}
