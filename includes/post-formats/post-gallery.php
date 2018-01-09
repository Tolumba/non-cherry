<?php
	$post_content = get_the_content();
	$maches_count = preg_match( '#\[gallery(.+[^[])?\]#', $post_content, $maches_arr );
	if($maches_count <= 0){
		echo gallery_shortcode(array());
	}
?>
