<?php 
	$options = jb_get('options');
?>
<nav id="primary-nav" class="navbar navbar-expand-lg navbar-dark bg-primary">
	<!-- navbar-dark bg-primary -->
	<a class="navbar-brand" href="<?php echo home_url(); ?>"><?php echo get_bloginfo('name'); ?></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
		<?php echo fa_bar_icon(); ?>
	</button>

	<button id="darkmode-toggle" type="button" aria-label="Toggle Darkmode">
		<?php echo fa_sun(); ?>
	</button>

	<div class="collapse navbar-collapse" id="navbarColor01">
		<div class="mr-auto"></div>
		<!-- <ul class="navbar-nav mr-auto">
			<li class="nav-item active">
			<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#">Features</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#">Pricing</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#">About</a>
			</li>
		</ul> -->

		<form class="form-inline">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search" aria-label="Search">
				<div class="input-group-append">
					<button class="btn " type="submit"><?php echo fa_search_icon(); ?></button>
				</div>
			</div>
		</form>

		

	</div>
</nav>