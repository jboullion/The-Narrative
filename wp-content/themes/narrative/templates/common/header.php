<?php 
	$options = jb_get('options');
	$subsites = get_sites(array(
		//'site__not_in' => array(1, 5),
		'deleted' => 0
	));

	$darkmode = get_user_meta( get_current_user_id(), 'darkmode', true );
	$current_blog_id = get_current_blog_id();
?>
<nav id="primary-nav" class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-between">

	<!-- navbar-dark bg-primary -->
	<a class="navbar-brand" href="<?php echo home_url(); ?>"><?php echo get_bloginfo('name'); ?></a>
	<!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
		<?php //echo fa_bar_icon(); ?>
	</button> -->

	<button id="darkmode-toggle" type="button" aria-label="Toggle Darkmode" class="<?php echo $darkmode?'darkmode':''; ?>">
		<?php echo fa_sun(); ?>
		<?php echo fa_moon(); ?>
	</button>

	<div class="jb-select">
		<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
			<?php 
				foreach( $subsites as $subsite ) {
					//jb_print($subsite);
					if($subsite->blog_id == 1) continue;
					$subsite_details = get_blog_details($subsite->blog_id);
					echo '<option value="http://'.$subsite->domain.'" '.($current_blog_id == $subsite->blog_id?'selected="selected"':'').'>'.$subsite_details->blogname.'</option>';
				}
			?>
		</select>
	</div>
</nav>