<?php

/* Text */
add_filter( 'of_sanitize_text', 'sanitize_text_field' );

/* Textarea */
add_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
function of_sanitize_textarea( $input ) {

	global $allowedposttags;

	$output = wp_kses( $input, $allowedposttags );

	return $output;
}

/* Select */
add_filter( 'of_sanitize_select', 'of_sanitize_select', 10, 2 );
add_filter( 'of_sanitize_multiselect', 'of_sanitize_select', 10, 2 );

function of_sanitize_select( $input, $option ){

	if( is_array( $input ) )
		$input = implode( ", ", $input );

	$output = esc_attr( $input );

	return $output;

}

/* Radio */
add_filter( 'of_sanitize_radio', 'of_sanitize_enum', 10, 2);

/* Images */
add_filter( 'of_sanitize_images', 'of_sanitize_enum', 10, 2);

/* Check that the key value sent is valid */
function of_sanitize_enum( $input, $option ) {

	$output = '';

	if ( array_key_exists( $input, $option['options'] ) ) {

		$output = $input;

	}

	return $output;
}

/* Checkbox */
add_filter( 'of_sanitize_checkbox', 'of_sanitize_checkbox' );
function of_sanitize_checkbox( $input ) {

	if ( $input ) {

		$output = '1';

	} else {

		$output = false;

	}

	return $output;
}

/* Multicheck */
add_filter( 'of_sanitize_multicheck', 'of_sanitize_multicheck', 10, 2 );
function of_sanitize_multicheck( $input, $option ) {

	$output = '';

	if ( is_array( $input ) ) {

		foreach( $option['options'] as $key => $value ) {

			$output[$key] = "0";

		}

		foreach( $input as $key => $value ) {

			if ( array_key_exists( $key, $option['options'] ) && $value ) {

				$output[$key] = "1";

			}
		}
	}

	return $output;
}

/* Color Picker */

add_filter( 'of_sanitize_color', 'sanitize_hex_color' );

/* Uploader */
add_filter( 'of_sanitize_upload', 'of_sanitize_upload' );
function of_sanitize_upload( $input ) {

	$output = '';

	$filetype = wp_check_filetype($input);

	if ( is_numeric( $input ) ) {

		$output = $input;

	}

	return $output;
}

/* Editor */
add_filter( 'of_sanitize_editor', 'of_sanitize_editor' );
function of_sanitize_editor($input) {

	if ( current_user_can( 'unfiltered_html' ) ) {

		$output = $input;

	} else {

		global $allowedtags;
		$output = wpautop( wp_kses( $input, $allowedtags ) );

	}

	return $output;
}

/* Allowed Tags */
function of_sanitize_allowedtags($input) {

	global $allowedtags;

	$output = wpautop(wp_kses( $input, $allowedtags));

	return $output;
}

/* Allowed Post Tags */
add_filter( 'of_sanitize_info', 'of_sanitize_allowedposttags' );
function of_sanitize_allowedposttags($input) {

	global $allowedposttags;

	$output = wpautop( wp_kses( $input, $allowedposttags ) );

	return $output;
}

/* Background */
add_filter( 'of_sanitize_background', 'of_sanitize_background' );
function of_sanitize_background( $input ) {

	$output = wp_parse_args( $input, array(
		'color' => '',
		'image'  => '',
		'repeat'  => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	) );

	$output['color'] = apply_filters( 'of_validate_hex', $input['color'] );
	$output['image'] = apply_filters( 'of_sanitize_upload', $input['image'] );
	$output['repeat'] = apply_filters( 'of_background_repeat', $input['repeat'] );
	$output['position'] = apply_filters( 'of_background_position', $input['position'] );
	$output['attachment'] = apply_filters( 'of_background_attachment', $input['attachment'] );

	return $output;
}

add_filter( 'of_background_repeat', 'of_sanitize_background_repeat' );
function of_sanitize_background_repeat( $value ) {

	$recognized = of_recognized_background_repeat();

	if ( array_key_exists( $value, $recognized ) ) {

		return $value;

	}

	return apply_filters( 'of_default_background_repeat', current( $recognized ) );
}


add_filter( 'of_background_position', 'of_sanitize_background_position' );
function of_sanitize_background_position( $value ) {

	$recognized = of_recognized_background_position();

	if ( array_key_exists( $value, $recognized ) ) {

		return $value;

	}

	return apply_filters( 'of_default_background_position', current( $recognized ) );
}

add_filter( 'of_background_attachment', 'of_sanitize_background_attachment' );
function of_sanitize_background_attachment( $value ) {

	$recognized = of_recognized_background_attachment();

	if ( array_key_exists( $value, $recognized ) ) {

		return $value;

	}

	return apply_filters( 'of_default_background_attachment', current( $recognized ) );
}


/* Typography */
add_filter( 'of_sanitize_typography', 'of_sanitize_typography', 10, 2 );
function of_sanitize_typography( $input, $option ) {

	$output = wp_parse_args( $input, array(
		'size'  => 'inherit',
		'face'  => 'inherit',
		'style' => 'inherit',
		'weight' => 'inherit',
		'lineheight' => 'inherit',
		'color' => 'inherit'
	));

	if ( isset( $option['options']['faces'] ) && isset( $input['face'] ) ) {

		if ( ! ( array_key_exists( $input['face'], $option['options']['faces'] ) ) ) {

			$output['face'] = 'inherit';

		}

	} else {

		$output['face']  = apply_filters( 'of_font_face', $output['face'] );

	}

	$output['size']  = apply_filters( 'of_font_size', $output['size'] );
	$output['style'] = apply_filters( 'of_font_style', $output['style'] );
	$output['color'] = apply_filters( 'of_sanitize_color', $output['color'] );
	$output['lineheight'] = apply_filters( 'of_sanitize_lineheight', $output['lineheight'] );

	return $output;
}

add_filter( 'of_font_size', 'of_sanitize_font_size' );
function of_sanitize_font_size( $value ) {

	$recognized = of_recognized_font_sizes();
	$value_check = preg_replace('/px/','', $value);

	if ( in_array( (int) $value_check, $recognized ) ) {

		return $value;

	}

	return apply_filters( 'of_default_font_size', $recognized );
}


add_filter( 'of_font_style', 'of_sanitize_font_style' );
function of_sanitize_font_style( $value ) {

	$recognized = of_recognized_font_styles();

	if ( array_key_exists( $value, $recognized ) ) {

		return $value;

	}

	return apply_filters( 'of_default_font_style', current( $recognized ) );
}


add_filter( 'of_font_weight', 'of_sanitize_font_weight' );
function of_sanitize_font_weight( $value ) {

	$recognized = of_recognized_font_weights();

	if ( array_key_exists( $value, $recognized ) ) {

		return $value;

	}

	return apply_filters( 'of_default_font_weight', current( $recognized ) );
}


add_filter( 'of_font_lineheight', 'of_sanitize_font_lineheight' );
function of_sanitize_font_lineheight( $value ) {

	$recognized = of_recognized_font_lineheight();

	if ( array_key_exists( $value, $recognized ) ) {

		return $value;

	}

	return apply_filters( 'of_default_font_lineheight', current( $recognized ) );
}


add_filter( 'of_font_face', 'of_sanitize_font_face' );
function of_sanitize_font_face( $value ) {
	
	$recognized = of_recognized_font_faces();

	if ( array_key_exists( $value, $recognized ) ) {

		return $value;

	}

	return apply_filters( 'of_default_font_face', current( $recognized ) );
}

/**
 * Get recognized background repeat settings
 *
 * @return   array
 *
 */
function of_recognized_background_repeat() {
	$default = array(
		'no-repeat' => __('No Repeat', 'non-cherry'),
		'repeat-x'  => __('Repeat Horizontally', 'non-cherry'),
		'repeat-y'  => __('Repeat Vertically', 'non-cherry'),
		'repeat'    => __('Repeat All', 'non-cherry'),
	);

	return apply_filters( 'of_recognized_background_repeat', $default );
}

/**
 * Get recognized background positions
 *
 * @return   array
 *
 */
function of_recognized_background_position() {
	$default = array(
		'top left'      => __('Top Left', 'non-cherry'),
		'top center'    => __('Top Center', 'non-cherry'),
		'top right'     => __('Top Right', 'non-cherry'),
		'center left'   => __('Middle Left', 'non-cherry'),
		'center center' => __('Middle Center', 'non-cherry'),
		'center right'  => __('Middle Right', 'non-cherry'),
		'bottom left'   => __('Bottom Left', 'non-cherry'),
		'bottom center' => __('Bottom Center', 'non-cherry'),
		'bottom right'  => __('Bottom Right', 'non-cherry')
	);

	return apply_filters( 'of_recognized_background_position', $default );
}

/**
 * Get recognized background attachment
 *
 * @return   array
 *
 */
function of_recognized_background_attachment() {
	$default = array(
		'scroll' => __('Scroll Normally', 'non-cherry'),
		'fixed'  => __('Fixed in Place', 'non-cherry')
	);

	return apply_filters( 'of_recognized_background_attachment', $default );
}

/**
 * Sanitize a color represented in hexidecimal notation.
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @param    string    The value that this function should return if it cannot be recognized as a color.
 * @return   string
 *
 */
function of_sanitize_hex( $hex, $default = '' ) {
	if ( of_validate_hex( $hex ) ) {
		return $hex;
	}

	return $default;
}

/**
 * Get recognized font sizes.
 *
 * Returns an indexed array of all recognized font sizes.
 * Values are integers and represent a range of sizes from
 * smallest to largest.
 *
 * @return   array
 */
function of_recognized_font_sizes() {

	$sizes = range( 9, 71 );
	$sizes = apply_filters( 'of_recognized_font_sizes', $sizes );
	$sizes = array_map( 'absint', $sizes );

	return $sizes;
}

/**
 * Get recognized font faces.
 *
 * Returns an array of all recognized font faces.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function of_recognized_font_faces() {

	$default = array(
		'arial'     => 'Arial',
		'verdana'   => 'Verdana, Geneva',
		'trebuchet' => 'Trebuchet',
		'georgia'   => 'Georgia',
		'times'     => 'Times New Roman',
		'tahoma'    => 'Tahoma, Geneva',
		'palatino'  => 'Palatino',
		'helvetica' => 'Helvetica*'
	);

	return apply_filters( 'of_recognized_font_faces', $default );
}

/**
 * Get recognized font styles.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function of_recognized_font_styles() {

	$default = array(
		'inherit' 		=> __('Inherit', 'non-cherry'),
		'normal' 		=> __('Normal', 'non-cherry'),
		'italic' 		=> __('Italic', 'non-cherry'),
		'oblique' 		=> __('Oblique', 'non-cherry'),
	);

	return apply_filters( 'of_recognized_font_styles', $default );
}

/**
 * Get recognized font styles.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function of_recognized_font_weights() {

	$default = array(
		'inherit' 		=> __('Inherit', 'non-cherry'),
		'normal' 		=> __('Normal', 'non-cherry'),
		'bold' 			=> __('Bold', 'non-cherry'),
		'bolder' 		=> __('Bolder', 'non-cherry'),
		'light' 		=> __('Light', 'non-cherry'),
		'lighter' 	    => __('Lighter', 'non-cherry'),
	);

	return apply_filters( 'of_recognized_font_weights', $default );
}

/**
 * Get lineheights.
 *
 * Returns an array of all recognized font styles.
 * Keys are intended to be stored in the database
 * while values are ready for display in in html.
 *
 * @return   array
 *
 */
function of_recognized_font_lineheight() {

	$default = array(
		'inherit' 	=> __('inherit', 'non-cherry'),
		'1' 		=> __('1', 'non-cherry'),
		'1.2' 		=> __('1.2', 'non-cherry'),
		'1.5' 		=> __('1.5', 'non-cherry'),
		'2' 		=> __('2', 'non-cherry'),
	);

	return apply_filters( 'of_recognized_font_lineheight', $default );
}

/**
 * Returns an array of system fonts
 * Feel free to edit this, update the font fallbacks, etc.
 */
function options_typography_get_os_fonts() {

    // OS Font Defaults
    $os_faces = array(
        'inherit' 												=> 'inherit',
        'Arial, Helvetica, sans-serif' 							=> 'Arial',
		'Verdana, Geneva, sans-serif' 							=> 'Verdana',
		'"Trebuchet MS", Arial, Helvetica, sans-serif' 			=> 'Trebuchet MS',
		'Georgia, "Times New Roman", Times, serif' 				=> 'Georgia',
		'"Times New Roman", Times, serif' 						=> 'Times New Roman',
		'Tahoma, Geneva, sans-serif' 							=> 'Tahoma',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif'  => 'Palatino',
		'Helvetica*' 											=> 'Helvetica',
    );

    return $os_faces;
}

/**
 * Returns a select list of Google fonts
 * Feel free to edit this, update the fallbacks, etc.
 */
function options_typography_get_google_fonts() {

    // Google Font Defaults
    $google_faces = array(
        'Arvo, serif' 						=> 'Arvo *',
        'Copse, sans-serif' 				=> 'Copse *',
        'Droid Sans, sans-serif' 			=> 'Droid Sans *',
        'Droid Serif, serif' 				=> 'Droid Serif *',
        'Lobster, cursive' 					=> 'Lobster *',
        'Nobile, sans-serif' 				=> 'Nobile *',
        'Open Sans, sans-serif' 			=> 'Open Sans *',
        'Oswald, sans-serif' 				=> 'Oswald *',
        'Pacifico, cursive' 				=> 'Pacifico *',
        'Rokkitt, serif' 					=> 'Rokkit *',
        'PT Sans, sans-serif' 				=> 'PT Sans *',
        'Tinos, serif' 						=> 'Tinos *',
        'Quattrocento, serif' 				=> 'Quattrocento *',
        'Raleway, cursive' 					=> 'Raleway *',
        'Ubuntu, sans-serif' 				=> 'Ubuntu *',
        'Yanone Kaffeesatz, sans-serif' 	=> 'Yanone Kaffeesatz *',
    );

    return $google_faces;

}


/**
 * Checks font options to see if a Google font is selected.
 * If so, options_typography_enqueue_google_font is called to enqueue the font.
 * Ensures that each Google font is only enqueued once.
 */
if ( !function_exists( 'options_typography_google_fonts' ) ) {

    function options_typography_google_fonts() {

        $all_google_fonts = array_keys( options_typography_get_google_fonts() );

        // Define all the options that possibly have a unique Google font
        $h1_heading = of_get_option('h1_heading', 'inherit');
		$h2_heading = of_get_option('h2_heading', 'inherit');
		$h3_heading = of_get_option('h3_heading', 'inherit');
		$h4_heading = of_get_option('h4_heading', 'inherit');
		$h5_heading = of_get_option('h5_heading', 'inherit');
		$h6_heading = of_get_option('h6_heading', 'inherit');
		$google_mixed_3 = of_get_option('google_mixed_3', 'inherit');

        // Get the font face for each option and put it in an array

    }
}

/**
 * Enqueues the Google $font that is passed
 */
add_action( 'wp_enqueue_scripts', 'options_typography_google_fonts' );
function options_typography_enqueue_google_font($font) {

    $font = explode(',', $font);
    $font = $font[0];
    // Certain Google fonts need slight tweaks in order to load properly
    // Like our friend "Raleway"

    if ( $font == 'Raleway' ){
    	$font = 'Raleway:100';
    }

    $font = str_replace(" ", "+", $font);

    wp_enqueue_style( "options_typography_$font", "//fonts.googleapis.com/css?family=$font", false, null, 'all' );
}

/*
 * Outputs the selected option panel styles inline into the <head>
 */
add_action( 'wp_head', 'options_typography_styles', 2 );
function options_typography_styles() {

    $output = '';
    $input = '';

	if ( of_get_option('h1_heading') ) {
		$input = of_get_option('h1_heading');
		$output .= options_typography_font_styles( of_get_option('h1_heading') , 'h1, .h1');
	}
	if ( of_get_option('h2_heading') ) {
		$input = of_get_option('h2_heading');
		$output .= options_typography_font_styles( of_get_option('h2_heading') , 'h2, .h2');
	}

	if ( of_get_option('h3_heading') ) {
		$input = of_get_option('h3_heading');
		$output .= options_typography_font_styles( of_get_option('h3_heading') , 'h3, .h3');
	}

	if ( of_get_option('h4_heading') ) {
		$input = of_get_option('h4_heading');
		$output .= options_typography_font_styles( of_get_option('h4_heading') , 'h4, .h4');
	}

	if ( of_get_option('h5_heading') ) {
		$input = of_get_option('h5_heading');
		$output .= options_typography_font_styles( of_get_option('h5_heading') , 'h5, .h5');
	}

	if ( of_get_option('h6_heading') ) {
		$input = of_get_option('h6_heading');
		$output .= options_typography_font_styles( of_get_option('h6_heading') , 'h6, .h6');
	}


	if ( of_get_option('google_mixed_3') ) {
		$input = of_get_option('google_mixed_3');
		$output .= options_typography_font_styles_body( of_get_option('google_mixed_3') , 'body');
	}

	if ( $output != '' ) {
		$output = "\n<style id='theme_text_styles' type='text/css' media='all'>\n" . $output . "</style>\n";
		echo $output;
	}
}

/*
 * Returns a typography option in a format that can be outputted as inline CSS
 */
function options_typography_font_styles( $option, $selectors ) {

	$output = $selectors . " {\n";
	$output .= 'font-family: ' . $option['face'] . ";\n";
	$output .= 'font-weight: ' . $option['weight'] . ";\n";
	$output .= 'font-style: ' . $option['style'] . ";\n";
	$output .= 'font-size: ' . $option['size'] . ";\n";
	$output .= 'line-height: ' . $option['lineheight'] . ";\n";
	$output .= 'color:' . $option['color'] .";\n";
	$output .= "}\n";

	return $output;
}

/*
 * This is one the same but for body
 */
function options_typography_font_styles_body( $option, $selectors ) {

	$output = $selectors . " {\n";
	$output .= 'font-family: ' . $option['face'] . ";\n";
	$output .= 'font-weight: ' . $option['weight'] . ";\n";
	$output .= 'font-style: ' . $option['style'] . ";\n";
	$output .= 'font-size: ' . $option['size'] . ";\n";
	$output .= 'line-height: ' . $option['lineheight'] . ";\n";
	$output .= 'color:' . $option['color'] .";\n";
	$output .= "}\n";

	return $output;
}

/**
 * Is a given string a color formatted in hexidecimal notation?
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @return   bool
 *
 */

function of_validate_hex( $hex ) {

	$hex = trim( $hex );

	/* Strip recognized prefixes. */
	if ( 0 === strpos( $hex, '#' ) ) {

		$hex = substr( $hex, 1 );

	} elseif ( 0 === strpos( $hex, '%23' ) ) {

		$hex = substr( $hex, 3 );

	}

	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {

		return false;

	} else {

		return true;

	}

}

if ( ! function_exists( 'sanitize_hex_color' ) ) {
    function sanitize_hex_color( $color ) {
        if ( '' === $color )
            return '';

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
            return $color;

        return null;
    }
}