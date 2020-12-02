<?php 
/**
 * This script will find any channel categories that do not have an image set and it will attempt to find and upload the image for that channel from youtube
 * 
 * TODO: Need to download + upload the channel images since cannot reliably get from youtube
 *
 */

die('Already Run');
define('ALLOW_UNFILTERED_UPLOADS', true);
define('WP_USE_THEMES', false);
require_once('../wp-load.php');

include_once( ABSPATH . 'wp-admin/includes/admin.php' );
require_once(ABSPATH . "wp-admin" . '/includes/image.php');

global $wpdb;

$taxonomy = 'channel';

$terms = get_terms( array(
	'taxonomy' => $taxonomy,
	'hide_empty' => false,
) );


if(! empty($terms)){
	foreach($terms as $term){
		$term_string = $taxonomy.'_'.$term->term_id;

		//$channel_image = get_field('channel_image', $term_string);

		//if(empty($channel_image)){
			$channel_id = get_field('channel_id', $term_string);

			$channel_info = sp_get_yt_channel_info($channel_id);

			if(! empty($channel_info)){
				if(! empty($channel_info->items)){
					if(! empty($channel_info->items[0]->snippet->thumbnails->default->url)){
						// update our channel image with the thumbnail url

						// $file = $channel_info->items[0]->snippet->thumbnails->default->url;
						// $filename = $channel_info->items[0]->snippet->title;

						// $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
						// sp_print($upload_file);
						// if (!$upload_file['error']) {
						// 	$wp_filetype = wp_check_filetype($filename, null );
						// 	$attachment = array(
						// 		'post_mime_type' => $wp_filetype['type'],
						// 		'post_parent' => $parent_post_id,
						// 		'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
						// 		'post_content' => '',
						// 		'post_status' => 'inherit'
						// 	);
						// 	$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
						// 	if (!is_wp_error($attachment_id)) {
								
						// 		$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
						// 		wp_update_attachment_metadata( $attachment_id,  $attachment_data );

						// 		update_field('field_5f1d0fda2cc84', $attachment_id, $term_string);
						// 	}
						// }

						// $file = array();
						// $file['name'] = $channel_info->items[0]->snippet->title;
						// // sizes: default 88, medium 240, high 800
						// $file['tmp_name'] = download_url($channel_info->items[0]->snippet->thumbnails->default->url);
						// sp_print( $file );
						$attachmentId = somatic_attach_external_image($channel_info->items[0]->snippet->thumbnails->default->url, 1, false, $channel_info->items[0]->snippet->title);
						
						sp_print( $attachmentId );
						if ( ! is_wp_error( $attachmentId ) ) {
							update_field('field_5f1d0fda2cc84', $attachmentId, $term_string);
						}
						
					}

				}
			}
			
			sp_print($term);
			sp_print($channel_info);
			die();
			// die();
		//}
	}
}

function sp_get_yt_channel_info($channel_id){
	$apiKey = sp_get('yt-api-key');

	$requestUrl = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,topicDetails&id='.$channel_id.'&key='.$apiKey;
	$response = file_get_contents( $requestUrl );

	// TODO: setup check on what we return?
	return json_decode( $response );
	
}


/**
 * Download an image from the specified URL and attach it to a post.
 * Modified version of core function media_sideload_image() in /wp-admin/includes/media.php  (which returns an html img tag instead of attachment ID)
 * Additional functionality: ability override actual filename, and to pass $post_data to override values in wp_insert_attachment (original only allowed $desc)
 *
 * @since 1.4 Somatic Framework
 *
 * @param string $url (required) The URL of the image to download
 * @param int $post_id (required) The post ID the media is to be associated with
 * @param bool $thumb (optional) Whether to make this attachment the Featured Image for the post (post_thumbnail)
 * @param string $filename (optional) Replacement filename for the URL filename (do not include extension)
 * @param array $post_data (optional) Array of key => values for wp_posts table (ex: 'post_title' => 'foobar', 'post_status' => 'draft')
 * @return int|object The ID of the attachment or a WP_Error on failure
 */
function somatic_attach_external_image( $url = null, $post_id = null, $thumb = null, $filename = null, $post_data = array() ) {
    if ( !$url || !$post_id ) return new WP_Error('missing', "Need a valid URL and post ID...");
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    // Download file to temp location, returns full server path to temp file, ex; /home/user/public_html/mysite/wp-content/26192277_640.tmp
    $tmp = download_url( $url );

    // If error storing temporarily, unlink
    if ( is_wp_error( $tmp ) ) {
        @unlink($file_array['tmp_name']);   // clean up
        $file_array['tmp_name'] = '';
        return $tmp; // output wp_error
    }

    preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $url, $matches);    // fix file filename for query strings
    $url_filename = basename($matches[0]);                                                  // extract filename from url for title
    $url_type = wp_check_filetype($url_filename);                                           // determine file type (ext and mime/type)

    // override filename if given, reconstruct server path
    if ( !empty( $filename ) ) {
        $filename = sanitize_file_name($filename);
        $tmppath = pathinfo( $tmp );                                                        // extract path parts
        $new = $tmppath['dirname'] . "/". $filename . "." . $tmppath['extension'];          // build new path
        rename($tmp, $new);                                                                 // renames temp file on server
        $tmp = $new;                                                                        // push new filename (in path) to be used in file array later
    }

    // assemble file data (should be built like $_FILES since wp_handle_sideload() will be using)
    $file_array['tmp_name'] = $tmp;                                                         // full server path to temp file

    if ( !empty( $filename ) ) {
        $file_array['name'] = $filename . "." . $url_type['ext'];                           // user given filename for title, add original URL extension
    } else {
        $file_array['name'] = $url_filename;                                                // just use original URL filename
    }

    // set additional wp_posts columns
    if ( empty( $post_data['post_title'] ) ) {
        $post_data['post_title'] = basename($url_filename, "." . $url_type['ext']);         // just use the original filename (no extension)
    }

    // make sure gets tied to parent
    if ( empty( $post_data['post_parent'] ) ) {
        $post_data['post_parent'] = $post_id;
    }

    // required libraries for media_handle_sideload
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // do the validation and storage stuff
    $att_id = media_handle_sideload( $file_array, $post_id, null, $post_data );             // $post_data can override the items saved to wp_posts table, like post_mime_type, guid, post_parent, post_title, post_content, post_status

    // If error storing permanently, unlink
    if ( is_wp_error($att_id) ) {
        @unlink($file_array['tmp_name']);   // clean up
        return $att_id; // output wp_error
    }

    // set as post thumbnail if desired
    if ($thumb) {
        set_post_thumbnail($post_id, $att_id);
    }

    return $att_id;
}