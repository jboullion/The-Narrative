<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$subsites = get_sites(array(
		//'site__not_in' => array(1, 5),
		'deleted' => 0
	));

	$focuses = get_terms( array(
		'taxonomy' => 'focus',
		'hide_empty' => true,
	));

	$order = 'DESC';
	if(! empty($_GET['order'])){
		if($_GET['order'] == 'DESC'){
			$order = 'ASC';
		}else{
			$order = 'DESC';
		}
	}

	if('ASC' === $order){
		$sort = fa_sort_alpha_asc();
	}else{
		$sort = fa_sort_alpha_desc();
	}

	$g_focus = '';
	if(! empty($_GET['focus'])){
		$g_focus = $_GET['focus'];
	}

	$focus_id = get_queried_object_id();
?>
<section id="filters" class="wrapper no-print">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">

				<form class="form-inline d-flex  justify-content-center" method="get" action="">
					<div class="col-md-6 col-lg-5th mb-3">
						<select name="topic" class="form-control w-100">
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
					<div class="col-md-6 col-lg-5th mb-3">
						<select name="focus" class="form-control w-100">
							<?php 								
								if(! empty($focuses)){
									foreach($focuses as $focus){
										// /focus/tech/
										echo '<option value="'.$focus->term_id.'" '.($focus_id == $focus->term_id?'selected="selected"':'').'>'.$focus->name.'</option>';
									}
								}
							?>
						</select>
					</div>
					<div class="col-md-6 col-lg-5th mb-3">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><?php echo fa_search_icon(); ?></span>
							</div>
							<input type="text" class="form-control" placeholder="Search" aria-label="search" name="s" value="<?php echo get_search_query(); ?>" />
						</div>
					</div>
					<div class="col-md-6 col-lg-5th mb-3">
						<button type="button" class="active btn btn-primary" name="order" value="<?php echo $order; ?>"><?php echo $sort; ?> <span>Title</span></button>
					</div>
					<div class="col-md-6 col-lg-5th mb-3">
						<button type="submit" class="active btn btn-primary" name="find" value="1"><span>Find</span></button>
					</div>
				</form>
			
			</div>
		</div>
	</div>
</section>