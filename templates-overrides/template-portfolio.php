<?php
/**
 * 
 * The template for displaying CPT Portfolio.
 *
 * @package Cherry_Portfolio
 * @since   1.0.0
 */
?>
<?php get_header(); ?>
	<?php do_action('before_loop') ?>
			
		<?php get_template_part('template-parts/title-page');?>
				<?php if ( have_posts() ) :
					while ( have_posts() ) :
							the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php the_content();
									$data = new Cherry_Portfolio_Data;
									Cherry_Portfolio_Data::$default_options['justified_template'] = 'theme-justified-default.tmpl';
									Cherry_Portfolio_Data::$default_options['masonry_template'] = 'theme-masonry-default.tmpl';
									Cherry_Portfolio_Data::$default_options['grid_template'] = 'theme-grid-default.tmpl';
									Cherry_Portfolio_Data::$default_options['list_template'] = 'theme-list-default.tmpl';
									Cherry_Portfolio_Data::$default_options['post_format_standart_template'] = 'theme-post-format-standart.tmpl';
									Cherry_Portfolio_Data::$default_options['post_format_image_template'] = 'theme-post-format-image.tmpl';
									Cherry_Portfolio_Data::$default_options['post_format_gallery_template'] = 'theme-post-format-gallery.tmpl';
									Cherry_Portfolio_Data::$default_options['post_format_audio_template'] = 'theme-post-format-audio.tmpl';
									Cherry_Portfolio_Data::$default_options['post_format_video_template'] = 'theme-post-format-video.tmpl';
									Cherry_Portfolio_Data::$default_options['listing_layout'] = 'list-layout';
									Cherry_Portfolio_Data::$default_options['is_image_crop'] = 'true';
									Cherry_Portfolio_Data::$default_options['image_crop_width'] = 670;
									Cherry_Portfolio_Data::$default_options['image_crop_height'] = 342;
									Cherry_Portfolio_Data::$default_options['posts_per_page'] = 4;
									Cherry_Portfolio_Data::$default_options['template'] = 'theme-list-default.tmpl';
									$data->the_portfolio();
								?>
					
								<div class="clear"></div>
							</article>
					<?php endwhile; endif; ?>
	<?php do_action('after_loop') ?>
<?php get_footer(); ?>