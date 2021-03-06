<?php
/**
 * The archive index page for CPT Tesimonial.
 *
 * @package Cherry_Testimonials
 * @since   1.0.2
 */
global $wp_query;
get_header(); ?>
	<?php do_action('before_loop') ?>
		<?php get_template_part('template-parts/title-page');
		$args = array(
			'limit'        => Cherry_Testimonials_Page_Template::$posts_per_archive_page,
			'size'         => 100,
			'pager'        => 'true',
			'template'     => 'page.tmpl',
			'category'     => ! empty( $wp_query->query_vars['term'] ) ? $wp_query->query_vars['term'] : '',
			'custom_class' => 'testimonials-page testimonials-page_archive',
		);
		$data = new Cherry_Testimonials_Data;
		$data->the_testimonials( $args );
		get_template_part('includes/post-formats/post-nav'); ?>
	<?php do_action('after_loop') ?>
<?php get_footer(); ?>
