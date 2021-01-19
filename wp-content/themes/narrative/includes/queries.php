<?php 
/**
 * This script will be used to query for different programs
 */

add_action( 'pre_get_posts', 'jb_modify_query_order' );
function jb_modify_query_order( $query ) {
	if ( ($query->is_home() || $query->is_search() || $query->is_tax()) && $query->is_main_query() ) {
		$query->set( 'orderby', 'title' );

		if(empty($_GET['order'])){
			$query->set( 'order', 'ASC' );
		}
	}
}
