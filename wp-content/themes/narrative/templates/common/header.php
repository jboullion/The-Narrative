<?php 
	$options = sp_get('options');
?>
<nav id="primary-nav" class="navbar navbar-expand-lg navbar-dark bg-primary">
	<a class="navbar-brand" href="#"><?php echo get_bloginfo('name'); ?></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
		<?php echo bs_bar_icon(); ?>
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
					<button class="btn " type="submit"><?php echo bs_search_icon(); ?></button>
				</div>
			</div>
		</form>

		

	</div>
</nav>