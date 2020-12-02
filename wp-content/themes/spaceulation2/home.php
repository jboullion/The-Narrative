<?php 
	get_header(); 
?>
<main id="announcements-page" class="page">
	<?php 
		get_template_part('templates/common/featured'); 

		get_template_part('templates/announcements/search'); 

		get_template_part('templates/announcements/list'); 
	?>
</main>

<?php 
	get_footer();
