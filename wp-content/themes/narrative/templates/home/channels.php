<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$channel_args = array(
		//'posts_per_page' => 1,
		'post_type' => 'channels',
		'orderby' => 'title',
		'order' => 'ASC',
		'posts_per_page' => get_option( 'posts_per_page' ),
	);

	if(is_tax( 'genre' )){
		$genre_tax = get_queried_object();

		if(! empty($genre_tax)){
			$channel_args['tax_query'] = array(
				array(
					'taxonomy' => 'genre',
					'field'    => 'term_id',
					'terms'    => $genre_tax->term_id,
				)
			);
		}
	}

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
