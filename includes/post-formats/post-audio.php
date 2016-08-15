<?php 
	
	$content = get_the_content();
	$patern_shortcode = "#\[audio.*\](\[/audio\])*#";
	$pattern_url = "#((http|https)://)(www.)*.+#";
	$output = '';


	if( preg_match( $patern_shortcode, $content, $maches_arr ) > 0 ){

		$output = do_shortcode( $maches_arr[0] );

	}elseif( preg_match( $pattern_url, $content, $maches_arr ) > 0 ){

		$ext = trim( pathinfo( $maches_arr[0] )['extension'] );
		$valid_ext = array( "mp3", "m4a", "ogg", "wav", "wma" );
		$src = in_array( $ext, $valid_ext )? $ext: 'src';

		$code = '[audio '.$src.'="'.$maches_arr[0].'"][/audio]';

		$output = do_shortcode( $code );

	}

	echo $output;

?>