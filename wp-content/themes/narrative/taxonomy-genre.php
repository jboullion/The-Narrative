<?php
	get_header(); 
	//the_post();

	$fields = get_fields();
	jb_set('fields', $fields);

	// jb_get_youtube_id($url);
?>
<main id="genre-page" class="page">
	
	<?php //get_template_part('templates/home/featured'); ?>
	<?php get_template_part('templates/common/categories'); ?>
	<?php get_template_part('templates/common/channels'); ?>

</main>
<?php get_template_part('templates/modals/player'); ?>
<?php 
	get_footer();