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
	}

	public function register_option( $id, $args=array() ){
		global $wp_customize;
		var_dump($wp_customize);
	}

	public function register_controls( $customize ){

	}

	public static function instance(){

		if( null === self::$_instance ){
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}

$GLOBALS['theme_CU'] = Utils::instance();