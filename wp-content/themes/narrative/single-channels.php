<?php
	get_header(); 
	the_post();

	$fields = get_fields();
	jb_set('fields', $fields);

?>
<main id="genre-page" class="page">
	<?php //get_template_part('templates/channel/featured'); ?>
	<?php get_template_part('templates/channel/channels'); ?>

</main>
<?php get_template_part('templates/modals/player'); ?>
<?php 
	get_footer();