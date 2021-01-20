<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$focuses = get_terms( array(
		'taxonomy' => 'focus',
		'hide_empty' => true,
	) );

?>
<section id="focuses" class="wrapper no-print">
	<div class="container-fluid">
		<a href="/" class="focuses badge badge-pill badge-primary <?php echo ! is_tax()?'active':''; ?>">All</a>
		<?php 
			if(! empty($focuses)){
				foreach($focuses as $focus){
					echo '<a href="'.get_term_link($focus).'" class="focuses badge badge-pill badge-primary '.(get_queried_object_id()===$focus->term_id?'active':'').'">'.$focus->name.'</a>';
				}
			}
		?>
	</div>
</section>
<?php get_template_part('templates/common/filters'); ?>
