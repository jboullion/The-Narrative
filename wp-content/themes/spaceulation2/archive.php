<?php 
	get_header(); 

?>
<header class="woocommerce-products-header">
	
	<?php 
		// Featured Area
		get_template_part('templates/woocommerce/taxonomy','featured'); 
	?>

</header>
<main id="search-page" class="page">
	<div class="container">

		<?php 
			
			if(have_posts()): 

				while(have_posts()): 
					the_post(); 
					
					//DO STUFF
					do_action( 'woocommerce_shop_loop' );

					sp_display_list_program();
				endwhile; 
				
				echo '<div class="pagination">';

				echo '<div class="page-numbers">';

				echo paginate_links( array(
					'format' => 'page/%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'prev_text' => __('<i class="far fa-angle-left"></i>'),
					'next_text' => __('<i class="far fa-angle-right"></i>')
				) );
				
				echo '</div></div>';

			else:

				echo '<h2>No Results Found.</h2>';
			endif; 
		?>

	</div>
</main>

<?php 
	get_footer();
