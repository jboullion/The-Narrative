<?php
/**
 * This script will setup everything we need for our individual API endpoints. Mostly the $wpdb object and the api-functions
 */

header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

header("Content-Type: application/json; charset=UTF-8");
header('Cache-Control: max-age=0'); //prevent returning cached data

date_default_timezone_set("America/Chicago");

//By using a SHORTINIT and loading WP we are ONLY loading our database object ($wpdb).
if(! empty($full_load)){
	define('WP_USE_THEMES', false);
}else{
	define('SHORTINIT', true);
}

require_once(dirname(__FILE__) .'/../wp-load.php');

// error_reporting(E_ALL ^ E_NOTICE);
// @ini_set('display_errors', 1);

require_once('api-functions.php');
// require_once('setup-jwt.php');

// NOTE: Could probably just load jwt not on full load, but would need to test to make sure not breaking anything
//if($full_load){
//	require_once('setup-jwt.php');
//}

global $blog_id, $wpdb, $yt_key;

$yt_key = 'AIzaSyAiXvrjHqYkVxC4y1U1neEYGsTFQE2rvzY';

$wpdb->channels = 'jb_channels';
$wpdb->videos = 'jb_videos';