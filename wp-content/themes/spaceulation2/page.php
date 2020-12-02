<?php 
	get_header(); 
	the_post(); 

	$fields = get_fields();
	sp_set('fields', $fields);
?>
<main id="default-page" class="page">
	<?php get_template_part('templates/common/featured'); ?>

	<?php get_template_part('templates/common/content'); ?>
</main>
<?php
	get_footer();