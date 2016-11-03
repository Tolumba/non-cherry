<?php
/*	Register and load javascript
/*-----------------------------------------------------------------------------------*/
add_action('wp_enqueue_scripts', 'non_cherry_scripts', 0);
function non_cherry_scripts() {

	//For post formats
	wp_register_script('magnific-popup', CHILD_URL.'/includes/post-formats/js/jquery.magnific-popup.js', array('jquery'));

	// Styles
	wp_enqueue_style( 'reset', CHILD_URL.'/css/reset.css' );
	wp_enqueue_style( 'grid', CHILD_URL.'/css/grid.css' );
	wp_enqueue_style( 'owl-carousel', CHILD_URL.'/css/owl-carousel.css' );
	wp_enqueue_style( 'prettyPhoto', CHILD_URL.'/css/prettyPhoto.css' );
	wp_enqueue_style( 'flexslider', CHILD_URL.'/css/flexslider.css' );
	wp_enqueue_style( 'touchTouch', CHILD_URL.'/css/touchTouch.css' );
	wp_enqueue_style( 'animate', CHILD_URL.'/css/animate.css' );
	wp_enqueue_style( 'camera', CHILD_URL.'/css/camera.css' );
	wp_enqueue_style( 'ui', CHILD_URL.'/css/ui.totop.css' );

	wp_enqueue_style('contact-form', CHILD_URL.'/css/contact-form.css' );
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css');

	// Scripts
	wp_enqueue_script('simplr-smoothscroll', CHILD_URL.'/js/jquery.simplr.smoothscroll.min.js', array('jquery'));
	wp_enqueue_script('theme-mousewheel', CHILD_URL.'/js/jquery.mousewheel.min.js', array('jquery'));
	wp_enqueue_script('easing', CHILD_URL.'/js/jquery.easing.1.3.js', array('jquery'), '1.3');
	wp_enqueue_script('totop', CHILD_URL.'/js/jquery.ui.totop.js', array('jquery'));
	wp_enqueue_script('device.min', CHILD_URL.'/js/device.min.js', array('jquery'));
	wp_enqueue_script('cookie', CHILD_URL.'/js/jquery.cookie.js', array('jquery'));

	// Theme specific
	wp_enqueue_script('equalheights', CHILD_URL.'/js/jquery.equalheights.js', array('jquery'));
	wp_enqueue_script('touchSwipe', CHILD_URL.'/js/jquery.touchSwipe.min.js', array('jquery'));
	wp_enqueue_script('flexslider', CHILD_URL.'/js/jquery.flexslider.js', array('jquery'));
	wp_enqueue_script('touchTouch', CHILD_URL.'/js/touchTouch.js', array('jquery'));
	wp_enqueue_script('tmstickup', CHILD_URL.'/js/tmstickup.js', array('jquery'));
	wp_enqueue_script('unveil', CHILD_URL.'/js/jquery.unveil.js', array('jquery'));
	wp_enqueue_script('wow', CHILD_URL.'/js/wow/wow.js', array('jquery'));
	
	wp_enqueue_script('superfish',	CHILD_URL.'/js/superfish.js', array('jquery'), '1.4.8');
	//wp_enqueue_script('mobilemenu', CHILD_URL.'/js/jquery.mobilemenu.js', array('jquery'));
	wp_enqueue_script('rd-navbar', CHILD_URL.'/js/jquery.rd-navbar.js', array('jquery'));

	wp_enqueue_script('camera', CHILD_URL.'/js/camera.js', array('jquery'));

	wp_register_script('custom', CHILD_URL.'/js/custom.js', array('jquery'));
	wp_enqueue_script( 'custom' );
}

// Parsing options styles
add_action( 'wp_enqueue_scripts', 'framework_dynamic_styles', 1 );
function framework_dynamic_styles(){

	$css_file = CHILD_DIR . '/css/dynamic-styles.css';

	if( file_exists( $css_file ) ){
		if( !class_exists( 'WP_Filesyste' ) ){
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		global $wp_filesystem;
		if( !$wp_filesystem ){
			WP_Filesystem();
		}

		$dynamic_css = $wp_filesystem->get_contents( $css_file );
	}

	if( !$dynamic_css ) {
		return;
	}

	$pattern = '#(.+)\$([a-z_]+)(\[?([a-z_]*)\]?)(.+)#';
	$dynamic_css = preg_replace_callback( $pattern, 'parse_option', $dynamic_css );

	wp_add_inline_style ( 'reset', $dynamic_css );
	//echo "<style type='text/css'>{$dynamic_css}</style>";
	
}
function parse_option( $opts ){

	$result = $opts[1];

	$option = of_get_option( $opts[2], false );

	//var_dump( $opts );

	if( is_array( $option ) ){

		switch( $opts[4] ){
			case 'image':

				$url = wp_get_attachment_url( (int) $option[ $opts[4] ] );

				if( $url )
					$result .= $url;
				else
					return	$result = '';
				break;
			default:

				$result .= $option[ $opts[4] ];
				
				break;
		}


	}elseif( $option ){

		$result .= $option;

	}else{

		return	$result = '';

	}

	return $result . $opts[5];
}
add_action('wp_enqueue_scripts', 'non_cherry_main_style', 999);
function non_cherry_main_style(){

	// Theme stylesheet.
	wp_enqueue_style( 'wp-native',  CHILD_URL.'/css/wpnative.css' );
	wp_enqueue_style( 'main-style',  CHILD_URL.'/css/main.css' );
	wp_add_inline_style( 'main-style', of_get_option( 'custom_css', '') );
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );

}

/*	Register and load admin styles & javascript
/*-----------------------------------------------------------------------------------*/
add_action('admin_enqueue_scripts', 'non_cherry_admin_assets');
function non_cherry_admin_assets( $hook ) {
	
	wp_enqueue_style( 'theme-admin-styles',  CHILD_URL.'/admin/css/admin-styles.css' );

	if('post.php' === $hook || 'post-new.php' === $hook ){
		UI_Text::enqueue_assets();
		UI_Textarea::enqueue_assets();
		UI_Select::enqueue_assets();
		UI_Checkbox::enqueue_assets();
		UI_Radio::enqueue_assets();
		UI_Switcher::enqueue_assets();
		UI_Colorpicker::enqueue_assets();
		UI_Repeater::enqueue_assets();
		UI_Media::enqueue_assets();
		UI_Stepper::enqueue_assets();
		UI_Slider::enqueue_assets();
		UI_Range_Slider::enqueue_assets();
		UI_Background::enqueue_assets();
		UI_Typography::enqueue_assets();
		UI_Ace_Editor::enqueue_assets();
		UI_Layout_Editor::enqueue_assets();
		UI_Tooltip::enqueue_assets();
		UI_Webfont::enqueue_assets();

		wp_enqueue_script( 'editor');
		wp_enqueue_script( 'jquery-ui-dialog' );

		wp_enqueue_script( 'interface-builder', trailingslashit( CHERRY_URI ) . 'admin/assets/js/interface-builder.js', array( 'jquery' ), CHERRY_VERSION, true );

		wp_enqueue_style( 'interface-builder', trailingslashit( CHERRY_URI ) . 'admin/assets/css/interface-builder.css', array(), CHERRY_VERSION );
	}
}

?>