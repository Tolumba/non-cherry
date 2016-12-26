<?php
/**
 * The Template for displaying single CPT Testimonial.
 *
 * @package   Cherry_Services
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2015 Cherry Team
 */
get_header(); ?>
	<?php do_action('before_loop') ?>
		<?php get_template_part('template-parts/title-page');
		while ( have_posts() ) :
				the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
					$args = array(
						'id'           => get_the_id(),
						'template'     => 'single-service.tmpl',
						'linked_title' => 'no',
						'before_title' => '<h3 class="cherry-services_title">',
						'after_title'  => '</h3>',
						'container'    => false,
						'size'         => 'cherry-thumb-s',
						'pager'        => true,
					);
					$data = new Cherry_Services_Data;
					$data->the_services( $args );
				?>
				</article>
		<?php endwhile;
		get_template_part('includes/post-formats/post-nav'); ?>
	<?php do_action('after_loop') ?>
<?php get_footer(); ?>
