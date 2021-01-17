<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');
?>
<section id="channels" class="wrapper no-print">
	<div class="container-fluid">
		<?php 
			if ( have_posts() ) : 
				while ( have_posts() ) : 
					the_post(); 
					// Display post content
					pk_display_channel($post);
				endwhile; 
			endif; 
		?>
	</div>
</section>
