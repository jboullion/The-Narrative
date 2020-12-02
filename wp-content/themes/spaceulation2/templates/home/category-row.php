<?php 
	$fields = sp_get('fields');
	$options = sp_get('options');

	$random_channels = sp_get_taxonomy_terms('channel', 6, true);
?>
<section class="category-row wrapper no-print">
	<div class="container-fluid">
		<?php 
			foreach($random_channels as $channel){
				sp_display_channel_row($channel);
			}
		?>
	</div>
</section>