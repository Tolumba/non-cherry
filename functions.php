<?php
	/**
	*
	*	Theme fuctions
	*
	*/
	/*-----------------------------------------------------------------------------------*/
	/* Set Proper Parent/Child theme paths for inclusion
	/*-----------------------------------------------------------------------------------*/
	@define( 'PARENT_DIR', get_template_directory() );
	@define( 'CHILD_DIR', get_stylesheet_directory() );
	@define( 'PARENT_URL', get_template_directory_uri() );
	@define( 'CHILD_URL', get_stylesheet_directory_uri() );
	// Loading theme textdomain
	load_theme_textdomain( 'non-cherry', PARENT_DIR . '/languages' );
	@define( 'CURRENT_THEME', wp_get_theme()->get('TextDomain') );
	// Loading jQuery and Scripts
	require_once PARENT_DIR . '/includes/theme-scripts.php';
	// Widget and Sidebar
	require_once PARENT_DIR . '/includes/sidebar-init.php';
	// Theme initialization
	require_once PARENT_DIR . '/includes/theme-init.php';
	//Additional function
	require_once PARENT_DIR . '/includes/theme-functions.php';
	//Import/export data functions and actions
	require_once PARENT_DIR . '/includes/theme-import-export-setup.php';
	// Loading options.php for theme customizer
	include_once(PARENT_DIR . '/options.php');
	// Required plugins
	require_once( PARENT_DIR . '/includes/theme-plugins-config.php' );
	/*
	* Loads the Options Panel
	*
	* If you're loading from a child theme use stylesheet_directory
	* instead of template_directory
	*/
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', PARENT_URL . '/admin/' );
		include_once( PARENT_DIR . '/admin/options-framework.php' );
	}
	// Removes Trackbacks from the comment count
	if (!function_exists('comment_count')) {
		add_filter('get_comments_number', 'comment_count', 0);
		function comment_count( $count ) {
			if ( ! is_admin() ) {
				global $id;
				$comments = get_comments( 'status=approve&post_id=' . $id );
				$comments_by_type = separate_comments( $comments );
				return count( $comments_by_type['comment'] );
			}
			return $count;
		}
	}
	if ( ! isset( $content_width ) ) {
		$content_width = 900;
	}
	$modules = array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	);
	add_theme_support( 'html5', $modules );
	// Adding Post Formats support
	$formats = array(
		'aside',
		'gallery',
		'link',
		'image',
		'quote',
		'audio',
		'video',
	);
	add_theme_support( 'post-formats', $formats );
	add_post_type_support( 'post', 'post-formats' );
	function theme_slug_setup() {
	   add_theme_support( 'title-tag' );
	}
	add_action( 'after_setup_theme', 'theme_slug_setup' );
	if ( ! function_exists( '_wp_render_title_tag' ) ) :
		function theme_slug_render_title() { ?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
			<?php
		}
		add_action( 'wp_head', 'theme_slug_render_title' );
	endif;
	// Custom excerpt length
	if(!function_exists('new_excerpt_length')) {
		add_filter( 'excerpt_length', 'new_excerpt_length' );
		function new_excerpt_length($length) {
			if(!of_get_option('post_excerpt', false))
				return $lenght;
			return (int) of_get_option( 'post_excerpt_length', $length );
		}
	}
	// no more jumping for read more link
	if(!function_exists('no_more_jumping')) {
		add_filter('excerpt_more', 'no_more_jumping');
		function no_more_jumping( $output ) {
			return '&nbsp;<a href="'.get_permalink( get_the_ID() ).'" class="read-more">'.__('Continue Reading', 'non-cherry').'</a>';
			return $output;
		}
	}
	// category id in body and post class
	if( !function_exists('category_id_class') ) {
		add_filter('post_class', 'category_id_class');
		add_filter('body_class', 'category_id_class');
		function category_id_class($classes) {
			global $post;
			if( !isset($post) )
				return $classes;
			foreach((get_the_category($post->ID)) as $category)
				$classes [] = 'cat-id-' . $category->cat_ID;
			return $classes;
		}
	}
	// enable shortcodes in sidebar
	add_filter('widget_text', 'do_shortcode');

locate_template( 'extensions/woocommerce/main.php', true );
