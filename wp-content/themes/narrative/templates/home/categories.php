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
<section id="filters" class="wrapper no-print">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-lg-6 offset-md-2 offset-md-3">
				<div class="d-flex">

					<a href="/" class="active btn btn-primary"><?php echo fa_sort_up(); ?> <span>Title</span></a>

					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1"><?php echo fa_search_icon(); ?></span>
						</div>
						<input type="text" class="form-control" placeholder="Search" aria-label="search">
					</div>
				
				</div>
			</div>
		</div>
	</div>
</section>
