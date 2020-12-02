<?php 
	$fields = sp_get('fields');
	$options = sp_get('options');

	$featured_image = sp_get_featured_image();
	if(empty($featured_image)){
		$featured_image = $options['default_featured_image']['url'];
	}

	$args = array(
		'posts_per_page' => 3,
		'post_type' => 'videos',
		'orderby' => 'date'
	);

	$videos = get_posts($args);

?>
<section id="featured" class="wrapper no-print setup-background" style="background-image: url(<?php echo $featured_image; ?>);">
	<div class="container-fluid">
		<div class="row channel">
			<div class="col-xl-9">
				<h2>Recommended</h2>
				<div id="featured-carousel" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<?php 
							if(! empty($videos)){
								foreach($videos as $vkey => $video){
									echo '<li data-target="#featured-carousel" data-slide-to="'.$vkey.'" class="'.($vkey===0?'active':'').'"></li>';
								}
							}
						?>
					</ol>
					<div class="carousel-inner">
						<?php 
							if(! empty($videos)){
								foreach($videos as $vkey => $video){
									sp_display_video_slide($video, ($vkey===0));
								}
							}
						?>
					</div>
					<a class="carousel-control-prev" href="#featured-carousel" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#featured-carousel" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
			<div class="col-xl-3 d-none d-xl-block">
				<div class="list-group">
					<a href="#" class="list-group-item list-group-item-action active">
						Cras justo odio
					</a>
					<a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
					<a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
					<a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
					<a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">Vestibulum at eros</a>
				</div>
			</div>
		</div>
	</div>
</section>