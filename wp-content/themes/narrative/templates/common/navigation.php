<?php 
	$options = jb_get('options');
?>
<div id="navigation">
	<button type="button" id="nav-close" class="btn">
		<i class="fas fa-times fa-fw"></i>
	</button>

	<nav class="main-navigation" role="navigation">
		<?php 
			wp_nav_menu(
				array(
					'container' => false, 
					'depth'=>1, 
					'menu_class'=>'nav navbar-nav', 
					'theme_location'  => 'main_navigation' 
				)
			); 
		?>
	</nav>
</div>