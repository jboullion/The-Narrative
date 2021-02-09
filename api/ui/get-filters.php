<?php 
/**
 * Get Taxonomies
 */

require_once('../api-setup.php');

	$styles = $wpdb->get_results("SELECT t.term_id, t.name from $wpdb->terms AS t
									INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
									WHERE tt.taxonomy = 'style'");

	$topics = $wpdb->get_results("SELECT t.term_id, t.name from $wpdb->terms AS t
									INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
									WHERE tt.taxonomy = 'topic'");



	echo json_encode(
		array(
			'styles' => $styles,
			'topics' => $topics
			)
	);
	exit;
