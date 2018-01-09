<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( is_singular() ): ?>
		<div class="col-xs-12">
			<?php get_template_part('includes/post-formats/post-title'); ?>
			<?php get_template_part('includes/post-formats/post-gallery'); ?>
			<?php get_template_part('includes/post-formats/post-content-single'); ?>
			<div class="single-post-meta">
				<?php get_post_meta_info('author'); ?>
				<?php get_post_meta_info('date'); ?>
				<?php get_post_meta_info('categories'); ?>
				<?php get_post_meta_info('tags'); ?>
			</div>
		</div>
	<?php else: ?>
		<div class="col-xs-12">
			<?php get_template_part('includes/post-formats/post-thumb'); ?>
		</div>
		<div class="col-xs-12">
			<?php get_template_part('includes/post-formats/post-title'); ?>
			<?php get_template_part('includes/post-formats/post-meta'); ?>
			<?php get_template_part('includes/post-formats/post-content-loop'); ?>
		</div>
	<?php endif; ?>
	<div class="clear"></div>
</div>
