<?php 
	$fields = sp_get('fields');
	$options = sp_get('options');
	
	if(is_home()){
		$title = 'Important Announcements & News';
	}else if(is_singular('post')){
		$a_cats = get_the_terms($post->ID, 'category');
		$announcement_date = get_the_date( 'F j', $post->ID );

		// Let's get the name of our program type
		if(! empty($a_cats)){
			$cat_string = $a_cats[0]->name;
		}else{
			$cat_string = 'Announcements';
		}

		$title = get_the_title();
	}elseif (is_404()){
		$title = $options['404_title'];
	}else{
		$title = get_the_title();
	}
?>
<section id="featured" class="wrapper no-print">
	<div class="overlay" ></div>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php 
					if(is_singular('post')){
						echo '<h6 class="subtitle">'.$cat_string.' <span class="date">'.$announcement_date.'</span></h6>';
					}
				?>
				<h1><?php echo $title; ?></h1>
			</div>
		</div>
	</div>
</section>