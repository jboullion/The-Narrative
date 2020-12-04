<?php 
	get_header(); 

	$fields = get_fields();
	jb_set('fields', $fields);

	$options = jb_get('options');
?>
<main id="default-page" class="page">
	<?php get_template_part('templates/common/featured'); ?>

	<section id="content" class="wrapper">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php echo apply_filters('the_content', $options['404_content']); ?>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
	get_footer();