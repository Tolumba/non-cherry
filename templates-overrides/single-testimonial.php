<?php
/**
 * The Template for displaying single CPT Testimonial.
 *
 * @package Cherry_Testimonials
 * @since   1.0.0
 */

get_header(); ?>

	<?php do_action('before_loop') ?>
			
		<?php get_template_part('template-parts/title-page');

		while ( have_posts() ) : the_post();
			$args = array(
				'id'           => get_the_ID(),
				'size'         => 100,
				'template'     => 'single.tmpl',
				'custom_class' => 'testimonials-page-single',
			);
			$data = new Cherry_Testimonials_Data;
			$data->the_testimonials( $args );

		endwhile;

		get_template_part('includes/post-formats/post-nav'); ?>

	<?php do_action('after_loop') ?>

<?php get_footer(); ?>
