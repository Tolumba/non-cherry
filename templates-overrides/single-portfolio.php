<?php
/**
 * The Template for displaying single CPT Portfolio.
 *
 */
get_header(); ?>
	<?php do_action('before_loop') ?>
		<?php get_template_part('template-parts/title-page');?>
		<?php while ( have_posts() ) :
				the_post(); ?>
				<article <?php post_class(); ?> >
					<?php
						$data = new Cherry_Portfolio_Data;
						Cherry_Portfolio_Data::$default_options['post_format_standart_template'] = 'theme-post-format-standart.tmpl';
						Cherry_Portfolio_Data::$default_options['post_format_image_template'] = 'theme-post-format-image.tmpl';
						Cherry_Portfolio_Data::$default_options['post_format_gallery_template'] = 'theme-post-format-gallery.tmpl';
						Cherry_Portfolio_Data::$default_options['post_format_audio_template'] = 'theme-post-format-audio.tmpl';
						Cherry_Portfolio_Data::$default_options['post_format_video_template'] = 'theme-post-format-video.tmpl';
						Cherry_Portfolio_Data::$default_options['image_crop_width'] = 670;
						Cherry_Portfolio_Data::$default_options['image_crop_height'] = 342;
						$data->portfolio_single_data();
					?>
					<div class="clear"></div>
				</article>
		<?php endwhile; ?>
		<?php get_template_part( 'includes/post-formats/post-nav' ); ?>
	<?php do_action('after_loop') ?>
<?php get_footer(); ?>