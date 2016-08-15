<?php 
	
	$content = get_the_content();
	$pattern = "#((http|https)://)(www.)*.+#";
	$matches = preg_match( $pattern, $content, $maches_arr);
	$embed_code = '';

	if( $matches > 0 )
		$embed_code = wp_oembed_get( $maches_arr[0], array( 'width' => '1920px' ) );

	if(!empty($embed_code))
		printf( '<div class="embed-wrap">%1$s</div>', $embed_code );
	else
		get_template_part('includes/post-formats/post-thumb');

?>