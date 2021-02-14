<?php
/**
 * This script will setup everything we need for our individual API endpoints. Mostly the $wpdb object and the api-functions
 */
// error_reporting(E_ALL ^ E_NOTICE);
// @ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

header('Cache-Control: max-age=0'); //prevent returning cached data

header("Content-Type: application/json; charset=UTF-8");


//By using a SHORTINIT and loading WP we are ONLY loading our database object ($wpdb).
if(! empty($full_load)){
	//define('DOING_AJAX', true);
	define('WP_USE_THEMES', false);
}else{
	define('SHORTINIT', true);
}

require_once dirname(__FILE__) .'/../wp-load.php';




//  require( ABSPATH . WPINC . '/class-wp-user.php' );
//  require( ABSPATH . WPINC . '/class-wp-query.php' );
//  require( ABSPATH . WPINC . '/query.php' );
//  require( ABSPATH . WPINC . '/user.php' );
//  require( ABSPATH . WPINC . '/post.php' );
//  require( ABSPATH . WPINC . '/class-wp-post-type.php' );
//  require( ABSPATH . WPINC . '/class-wp-post.php' );
//  require( ABSPATH . WPINC . '/category.php' );
//  require( ABSPATH . WPINC . '/taxonomy.php' );
//  require( ABSPATH . WPINC . '/class-wp-taxonomy.php' );
//  require( ABSPATH . WPINC . '/class-wp-term.php' );
//  require( ABSPATH . WPINC . '/class-wp-term-query.php' );
//  require( ABSPATH . WPINC . '/class-wp-tax-query.php' );




require_once dirname(__FILE__).'/vendor/autoload.php';

date_default_timezone_set("America/Chicago");

require_once('api-functions.php');

global $blog_id, $wpdb, $yt_key;

$yt_key = 'AIzaSyAiXvrjHqYkVxC4y1U1neEYGsTFQE2rvzY';


// $wpdb->channels = 'jb_channels';
// $wpdb->videos = 'jb_videos';
// $wpdb->history = 'jb_history';
// $wpdb->liked = 'jb_liked';
// $wpdb->styles = 'jb_styles';
// $wpdb->topics = 'jb_topics';
// $wpdb->channel_styles = 'jb_channel_styles';
// $wpdb->channel_topics = 'jb_channel_topics';
// $wpdb->channel_views = 'jb_channel_views';
// $wpdb->video_views = 'jb_video_views';
// $wpdb->watch_later = 'jb_watch_later';

jb_setup_wpdb_tables();


// The default number of videos to return when loading
$DEFAULT_VID_LIMIT = 30;