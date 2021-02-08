<?php 

require_once('../api-setup.php');

if(empty($_POST['user_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$darkmode = $wpdb->get_var($wpdb->prepare("SELECT  meta_value AS darkmode FROM {$wpdb->usermeta} WHERE meta_key = 'darkmode' AND `user_id` = %d", $_POST['user_id']));

$wpdb->update(
	$wpdb->usermeta, 
	array(
		'meta_value' => $darkmode==1?0:1
	),
	array(
		'meta_key' => 'darkmode',
		'user_id' => $_POST['user_id']
	)
);

echo $darkmode;
exit;