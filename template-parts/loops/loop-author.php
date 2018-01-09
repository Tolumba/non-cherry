<?php
	/**
	*
	*	Loop: Common Loop
	*
	*/
?>
<?php if (have_posts()) :
 	while (have_posts()) :
 		the_post();
		$format = get_post_format()?:'standard';
		get_template_part( 'includes/post-formats/'.$format );
	endwhile;
else: ?>
	<div class="no-results">
		<?php echo '<p><strong>' . __('No posts yet.', 'non-cherry') . '</strong></p>'; ?>
	</div><!--no-results-->
<?php endif; ?>
