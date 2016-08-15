<?php 
	
	$content = get_the_content();
	$title = get_the_title();

	$pattern = "#((http|https)://)(www.)*.+#";
	$matches = preg_match( $pattern, $content, $maches_arr);

	if( $matches > 0 )
		printf( '<a class="post-link" href="%1$s"><i class="fa fa-link"></i>%1$s</a>', $maches_arr[0] );

?>