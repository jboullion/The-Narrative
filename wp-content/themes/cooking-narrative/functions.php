<?php 

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 101 );
function my_theme_enqueue_styles() {
	wp_enqueue_style( 'cooking-style', get_stylesheet_uri(),
		array( 'narrative' )
	);
}