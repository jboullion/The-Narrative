<?php 
	$options = sp_get('options');
?>
<nav id="header" class="navbar navbar-expand-lg">
	<div class="container-fluid">
		<?php 
			if(! empty($options['s_logo'])){
				echo '<a href="/" class="navbar-brand"> <img class="d-inline-block align-top" width="30" height="30" src="'.$options['s_logo']['url'].'" alt="'.get_bloginfo('name').'"  /></a>';
			}
		?>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
			<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img" focusable="false"><title>Menu</title><path stroke="#ffffff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor02">
			<ul class="navbar-nav mr-auto">
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
			</ul>
			
			<?php echo get_search_form(); ?>
		</div>
	</div>
</nav>
