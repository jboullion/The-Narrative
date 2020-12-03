<?php 
	$fields = sp_get('fields');
	$options = sp_get('options');

	// $featured_image = sp_get_featured_image();
	// if(empty($featured_image)){
	// 	$featured_image = $options['default_featured_image']['url'];
	// }

	// $args = array(
	// 	'posts_per_page' => 3,
	// 	'post_type' => 'videos',
	// 	'orderby' => 'date'
	// );

	// $videos = get_posts($args);

?>
<section id="featured" class="wrapper no-print">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="featured-slider">
			
					<div class="featured-slide">
						<div class="row">
							
							<div class="col-lg-9 col-md-12">
								<img src="https://img.youtube.com/vi/OpSmCKe27WE/maxresdefault.jpg" alt="Image Title">
							</div>
							<div class="col-lg-3 col-md-12">
								<div class="title-card">
									<img src="https://yt3.ggpht.com/ytc/AAUvwniXNmPnZ3ngeNhVvkYCsugH81w4E1OxtTuX_A5nbg=s48-c-k-c0xffffffff-no-rj" />
									<h4>Lex Friedman</h4>
									<p>Lex talks about life and stuff</p>
								</div>
							</div>
						</div>
					</div>
					<div class="featured-slide">
						<div class="row">
							
							<div class="col-lg-9 col-md-12">
								<img src="https://img.youtube.com/vi/yuVqfKYbGvE/maxresdefault.jpg" alt="Image Title">
							</div>
							<div class="col-lg-3 col-md-12">
								<div class="title-card">
									<img src="https://yt3.ggpht.com/ytc/AAUvwnjtuSqZGv6oDCr6AiYoflFufDyLl8RgMGJJ-S_z=s88-c-k-c0x00ffffff-no-rj" />
									<h4>The Origins Podcast</h4>
									<p>Lawrance Krauss talks about life and stuff</p>
								</div>
							</div>
						</div>
					</div>
					<div class="featured-slide">
						<div class="row">
							
							<div class="col-lg-9 col-md-12">
								<img src="https://img.youtube.com/vi/-t1_ffaFXao/maxresdefault.jpg" alt="Image Title">
							</div>
							<div class="col-lg-3 col-md-12">
								<div class="title-card">
									<img src="https://yt3.ggpht.com/ytc/AAUvwniXNmPnZ3ngeNhVvkYCsugH81w4E1OxtTuX_A5nbg=s48-c-k-c0xffffffff-no-rj" />
									<h4>Lex Friedman</h4>
									<p>Lex talks about life and stuff</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
<script>
	var featuredSlider = tns({
		container: '.featured-slider',
		//center: true,
		//mouseDrag: true,
		nav: false,
		loop: true,
		items: 1,
		controlsText: ["&lsaquo;", "&rsaquo;"]
	});
</script>