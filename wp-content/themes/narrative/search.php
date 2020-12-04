<?php 
	get_header(); 

	$options = jb_get('options');
?>
<header class="woocommerce-products-header">
	
	<div id="taxonomy-featured">
		<div class="container">
			<h1 class="woocommerce-products-header__title page-title">Search Results</h1>
		</div>
	</div>
	<div id="taxonomy-search" class="container">
		<?php 
			jb_display_search_filters('', 'product');
		?>
	</div>

</header>
<main id="search-page" class="page">
	<div id="taxonomy-listing" class="container">

		<?php 
			
			if(have_posts()): 

				echo '<div class="program-list">';
				while(have_posts()): 
					the_post(); 
					
					//DO STUFF
					do_action( 'woocommerce_shop_loop' );

					jb_display_list_program();
				endwhile; 

				echo '</div>';
				
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

				echo '<h2>No Products Found.</h2>';
			endif; 
		?>

	</div>
</main>
<?php 
	get_footer();