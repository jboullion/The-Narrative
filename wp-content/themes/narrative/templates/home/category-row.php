<?php 
	$fields = jb_get('fields');
	$options = jb_get('options');

	$random_channels = jb_get_taxonomy_terms('channel', 6, true);
?>
<section class="category-row wrapper no-print">
	<div class="container-fluid">
		<?php 
			foreach($random_channels as $channel){
				jb_display_channel_row($channel);
			}
		?>
	</div>
</section>