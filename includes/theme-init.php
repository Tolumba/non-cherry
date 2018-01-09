<?php
if ( !function_exists( 'non_cherry_setup' ) ):
	add_action( 'after_setup_theme', 'non_cherry_setup' );
	function non_cherry_setup() {
		// Parsing themes options into theme's scripts
		add_action( 'wp_enqueue_scripts', 'localize_theme_scripts' );
		function localize_theme_scripts(){
			// Localise custom.js output
			$script_data = array(
				'mobileMenu_defaultText' => __( 'Navigate to&hellip;', 'non-cherry' ),
				'mobile_switch_point' => (int) of_get_option( 'mobile_switch_point', 768 ),
				'sticky_header' => of_get_option( 'sticky_header' ),
				'google_maps_key' => of_get_option( 'google_maps_key' ),
			);
			wp_localize_script( 'custom', 'localize_data', $script_data );
			wp_enqueue_script( 'custom' );
		}
		// This theme uses post thumbnails
		if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
			add_theme_support( 'post-thumbnails' );
			add_image_size( 'slider-post-thumbnail', 1980, 936, true );
		}
		// custom menu support
		add_theme_support( 'menus' );
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus(
				array(
					'header_menu' => __( 'Header Menu', 'non-cherry' ),
					'social_menu' => __( 'Social Menu', 'non-cherry' ),
				)
			);
		}
		// Header container wrappers
		add_action('before_header', 'non_cherry_before_header', 0);
		add_action('after_header', 'non_cherry_after_header', 999);
		function non_cherry_before_header(){
			ob_start(); ?>
			<header id="header" class="header"><div id="stuck_container" class="stuck_container">
					<div class="container">
						<div class="row">
							<div class="<?php header_classes('col-xs-12'); ?>">
			<?php echo apply_filters( 'before_header_output', ob_get_clean() );
		}
		function non_cherry_after_header(){
			ob_start(); ?>
							</div>
						</div>
					</div>
				</div>
				<?php if( is_front_page() ) { ?>
					<?php get_template_part('template-parts/sliders/slider-camera'); ?>
				<?php } ?>
			</header>
			<?php echo apply_filters( 'after_header_output', ob_get_clean() );
		}
		// Page Title wrapper
		add_action('before_title_page', 'non_cherry_before_title_page', 0);
		add_action('after_title_page', 'non_cherry_after_title_page', 999);
		function non_cherry_before_title_page(){
			echo '<div class="col-md-12">';
		}
		function non_cherry_after_title_page(){
			echo '</div><div class="clear"></div>';
		}
		// Loop container wrappers
		add_action('before_loop', 'non_cherry_before_loop', 0);
		add_action('after_loop', 'non_cherry_after_loop', 999);
		function non_cherry_before_loop(){
			ob_start(); ?>
			<section id="content">
				<div class="container">
					<div class="<?php theme_sidebar_logic(); ?>">
						<div id="primary" class="<?php loop_content_classes('row'); ?>">
			<?php echo apply_filters('before_loop_output', ob_get_clean());
		}
		function non_cherry_after_loop(){
			ob_start(); ?>
						</div><!--#primary-->
						<?php get_sidebar(); ?>
					</div><!--sidebar_logic-->
				</div><!--.container-->
			</section><!--#content-->
			<?php echo apply_filters('after_loop_output', ob_get_clean());
		}
		// Setting header wrapper classes
		add_filter('header_classes', 'non_cherry_header_classes');
		function non_cherry_header_classes($classes){
			// $classes[] =  '';
			return $classes;
		}
		// Setting footer wrapper classes
		add_filter('footer_classes', 'non_cherry_footer_classes');
		function non_cherry_footer_classes($classes){
			$classes[] =  'footer';
			return $classes;
		}
		// Setting slider wrapper classes
		add_filter('slider_wrapper_classes', 'non_cherry_slider_wrapper_classes');
		function non_cherry_slider_wrapper_classes($classes){
			// $classes[] =  '';
			return $classes;
		}
		// Setting content wrapper classes
		add_filter('loop_content_classes', 'non_cherry_loop_content_classes');
		function non_cherry_loop_content_classes($classes){
			$str_classes = '';
			$classes = array_merge( preg_split('#[, ]+#', $str_classes), $classes ) ;
			return $classes;
		}
		// Setting sidebar wrapper classes
		add_filter('loop_sidebar_classes', 'non_cherry_loop_sidebar_classes');
		function non_cherry_loop_sidebar_classes($classes){
			$str_classes = '';
			$classes = array_merge( preg_split('#[, ]+#', $str_classes), $classes ) ;
			return $classes;
		}
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
	}
endif; ?>
