<?php
/**
 *
 * Template Name: Fullwidth Page
 *
 */
get_header(); ?>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
			<?php if( has_post_thumbnail() ):
				$format = '<figure class="thumbnail featured-thumbnail"><a href="%1$s">%2$s</a></figure>';
				$image = get_the_post_thumbnail();
				$link = get_the_permalink();
				printf( $format, $link, $image );
			endif; ?>
			<?php the_content(); ?>
			<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
		</div>
	<?php endwhile; ?>
<?php get_footer(); ?>
