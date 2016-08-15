<?php if( function_exists('post_nav') ) : ?>

	<?php post_nav(); ?>

<?php else : ?>

	<nav class="oldernewer">
		<div class="older">
			<?php next_posts_link( __('&laquo; Older Entries', 'non-cherry') ) ?>
		</div><!--.older-->
		<div class="newer">
			<?php previous_posts_link( __('Newer Entries &raquo;', 'non-cherry') ) ?>
		</div><!--.newer-->
	</nav><!--.oldernewer-->

<?php endif; ?>
<!-- Posts navigation -->