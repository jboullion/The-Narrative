<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

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

?>
<section id="filters" class="wrapper no-print">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-lg-6 offset-md-2 offset-md-3">
				<div class="d-flex justify-content-center">

					<form class="form-inline" method="get" action="">
						<button class="active btn btn-primary" name="order" value="<?php echo $order; ?>"><?php echo $sort; ?> <span>Title</span></button>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><?php echo fa_search_icon(); ?></span>
							</div>
							<input type="text" class="form-control" placeholder="Search" aria-label="search" name="s" value="<?php echo get_search_query(); ?>" />
						</div>
					</form>
				
				</div>
			</div>
		</div>
	</div>
</section>