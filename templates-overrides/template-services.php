<?php
/**
 *
 * The template for displaying CPT Services.
 *
 * @package   Cherry_Services
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2015 Cherry Team
 */
?>
<?php get_header(); ?>
	<?php do_action('before_loop') ?>
		<?php get_template_part('template-parts/title-page');?>
		<?php if ( have_posts() ) :
			while ( have_posts() ) :
					the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							// Display a page content.
							the_content();
							$args = array(
								'template'     => 'page-services.tmpl',
								'before_title' => '<h4 class="cherry-services_title">',
								'after_title'  => '</h4>',
								'container'    => false,
								'linked_title' => 'yes',
								'size'         => 'cherry-thumb-s',
								'col_xs'       => '12',
								'col_sm'       => '6',
								'col_md'       => '6',
								'col_lg'       => 'none',
								'pager'        => true,
								'limit'        => Cherry_Services_Templater::get_posts_per_archive_page(),
							);
							$data = new Cherry_Services_Data;
							$data->the_services( $args );
						?>
					</article>
			<?php endwhile;
		endif; ?>
		<?php get_template_part('template-parts/page-nav'); ?>
	<?php do_action('after_loop') ?>
<?php get_footer(); ?>