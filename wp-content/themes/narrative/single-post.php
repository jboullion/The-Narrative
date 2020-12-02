<?php 
	get_header(); 
	the_post(); 

	$fields = get_fields();
	sp_set('fields', $fields);

	$URL = urlencode(get_the_permalink());
?>
<main id="announcement-post" class="page">
	<?php get_template_part('templates/common/featured'); ?>

	<?php get_template_part('templates/common/content'); ?>

	<hr />

	<div id="share">
		<p>Share this announcement:</p>
		<div class="social">
			<a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $URL;?>" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i></a>
			<a href="https://twitter.com/share?text=<?php echo $post->post_title;?>&url=<?php echo $URL;?>" target="_blank"  class="twitter"><i class="fab fa-twitter"></i></a>
			<a href="https://www.linkedin.com/shareArticle?url=<?php echo $URL;?>&title=<?php echo $post->post_title;?>" target="_blank" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
			<a href="mailto:?subject=<?php echo $post->post_title;?>&body=<?php echo $URL;?>" target="_blank"  class="email"><i class="fas fa-envelope"></i></a>
		</div>
	</div>
</main>
<?php
	get_footer();