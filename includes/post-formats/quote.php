<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="col-xs-12">
		<?php get_template_part('includes/post-formats/post-title'); ?>

		<blockquote>
			<?php the_content(); ?>
		</blockquote>

		<div class="single-post-meta">
			<?php get_post_meta_info('author'); ?>
			<?php get_post_meta_info('date'); ?>
			<?php get_post_meta_info('categories'); ?>
			<?php get_post_meta_info('tags'); ?>
		</div>
	</div>
	<div class="clear"></div>
</div>