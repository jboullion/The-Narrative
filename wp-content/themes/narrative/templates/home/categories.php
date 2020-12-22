<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$genres = get_terms( array(
		'taxonomy' => 'genre',
		'hide_empty' => true,
	) );

?>
<section id="genres" class="wrapper no-print">
	<div class="container-fluid">
		<a href="/" class="genre active badge badge-pill badge-primary">All</a>
		<?php 
			if(! empty($genres)){
				foreach($genres as $genre){
					echo '<a href="'.get_term_link($genre).'" class="genre badge badge-pill badge-primary">'.$genre->name.'</a>';
				}
			}
		?>
	</div>
</section>
