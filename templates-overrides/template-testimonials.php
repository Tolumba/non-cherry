<?php
/**
 *
 * The template for displaying CPT Testimonials.
 *
 * @package Cherry_Testimonials
 * @since   1.0.0
 */
 get_header(); ?>
	<?php do_action('before_loop'); ?>
		<?php get_template_part('template-parts/title-page'); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					$args = array(
						'limit'        => 4,
						'size'         => 100,
						'pager'        => 'true',
						'template'     => 'page.tmpl',
						'custom_class' => 'testimonials-page',
					);
					$data = new Cherry_Testimonials_Data;
					$data->the_testimonials( $args );
				endwhile;
			endif; ?>
		</article>
	<?php do_action('after_loop'); ?>
<?php get_footer(); ?>
