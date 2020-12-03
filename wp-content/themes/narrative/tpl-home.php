<?php
	/* Template Name: Homepage Template */
	get_header(); 
	the_post();

	$fields = get_fields();
	sp_set('fields', $fields);

	// sp_get_youtube_id($url);
?>
<main id="home-page" class="page">
	
	<?php get_template_part('templates/home/featured'); ?>

	<?php get_template_part('templates/home/channels'); ?>

</main>
<?php 
	get_footer();