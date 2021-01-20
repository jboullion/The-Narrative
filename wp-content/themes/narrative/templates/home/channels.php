<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$channel_args = array(
		//'posts_per_page' => 1,
		'post_type' => 'channels',
		'orderby' => 'title', // rand
		'order' => 'ASC',
		'posts_per_page' => get_option( 'posts_per_page' ),
	);

	$channels = get_posts($channel_args);
?>

<section id="channels" class="wrapper no-print">
	<div class="container-fluid">
		<?php 
			if(! empty($channels)){
				foreach($channels as $channel_key => $channel){
					pk_display_channel($channel);
				}
			}
		?>
	</div>
</section>
