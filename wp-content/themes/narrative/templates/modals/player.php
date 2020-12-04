<?php 
	$options = jb_get('options');
?>
<div id="player-modal" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">Attendee Information</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="//www.youtube.com/embed/YE7VzlLtp-4" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
				</div>
				<!-- <iframe id="cartoonVideo" width="560" height="315" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0" allowfullscreen></iframe> -->
			</div>
		</div>
	</div>
</div>