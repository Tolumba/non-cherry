<?php
/**
 *
 * The template for displaying CPT Portfolio.
 *
 * @package Cherry_Portfolio
 * @since   1.0.0
 */
get_header(); ?>
	<?php do_action('before_loop') ?>
		<?php get_template_part('template-parts/title-page'); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
				$data = new Cherry_Portfolio_Data;
				$data->the_portfolio();
			?>
		</article>
		<?php get_template_part('includes/post-formats/post-nav'); ?>
	<?php do_action('after_loop') ?>
<?php get_footer(); ?>