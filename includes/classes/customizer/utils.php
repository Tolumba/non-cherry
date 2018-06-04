<?php
/**
* Utility class 
*/
namespace customizer;

class Utils{

	private static $_instance;

	private $_customize;

	public function __construct(){

		add_action( 'customize_register', array( $this, 'register_controls' ) );
		add_action( 'customize_preview_init', array( $this, 'preview_init' ) );
	}

	public function register_controls( $customize ){

		$fields = apply_filters( 'customizer/utils/fields', $this->_get_fields_data() );

		var_dump($fields);

	}

	public function preview_init(){

	}

	protected function _get_fields_data(){

		$theme_slug = get_option( 'stylesheet' );

		echo '<pre>';
		print_r( json_encode( get_option("non-cherry") ) );
		echo '</pre>';

		return false;
	}

	public static function instance(){

		if( null === self::$_instance ){
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}

if( !function_exists('customizer_utils') ){

	function customizer_utils(){
		return Utils::instance();
	}

	$GLOBALS['customizer_utils'] = customizer_utils();
}
