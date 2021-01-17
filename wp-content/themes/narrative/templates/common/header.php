<?php 
	$options = jb_get('options');
?>
<nav id="primary-nav" class="navbar navbar-expand-lg navbar-dark bg-primary">

	<!-- navbar-dark bg-primary -->
	<a class="navbar-brand" href="<?php echo home_url(); ?>"><?php echo get_bloginfo('name'); ?></a>
	<!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
		<?php //echo fa_bar_icon(); ?>
	</button> -->

	<button id="darkmode-toggle" type="button" aria-label="Toggle Darkmode" class="<?php echo $_COOKIE['darkmode']?'darkmode':''; ?>">
		<?php echo fa_sun(); ?>
		<?php echo fa_moon(); ?>
	</button>
</nav>