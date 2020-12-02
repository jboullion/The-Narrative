<?php
	/* Template Name: Homepage Template */
	get_header(); 
	the_post();

	$fields = get_fields();
	sp_set('fields', $fields);
?>
<main id="home-page" class="page">
	<?php //get_template_part('templates/home/vue', 'test'); ?>

	<?php //get_template_part('templates/home/featured'); ?>

	<?php get_template_part('templates/home/category', 'row'); ?>

	<?php //get_template_part('templates/home/services'); ?>

	<?php //get_template_part('templates/home/upcoming'); ?>

	<?php //get_template_part('templates/home/announcements'); ?>

	<?php //get_template_part('templates/home/industries'); ?>
</main>
<?php 
	get_footer();