<?php
/**
 * The Template for displaying single CPT Team.
 *
 * @package   Cherry_Team
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
				<br><br>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
					$args = array(
						'id'           => get_the_ID(),
						'template'     => 'single-team.tmpl',
						'custom_class' => 'team-page-single',
						'size'         => 'thumbnail',
						'container'    => false,
						'item_class'   => 'team-single-item',
					);
					$data = new Cherry_Team_Data;
					$data->the_team( $args );
					$data->microdata_markup();
				?>
				</article>
		<?php endwhile;
		get_template_part('includes/post-formats/post-nav'); ?>
	<?php do_action('after_loop') ?>
<?php get_footer(); ?>