<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url(); ?>">
	<label class="sr-only">Search</label>
	<div class="input-group">
		<input type="search" id="search-field" class="search-field form-control" value="<?php echo get_search_query(); ?>" name="s" title="Search" placeholder="Search" required />
		<div class="input-group-append">
			<button type="submit" class="btn btn-outline-secondary"><?php echo jb_search_icon(); ?></button>
		</div>
	</div>
</form>