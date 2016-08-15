<div class="col-xs-12">
	<?php 
	$link_format = apply_filters('search-link-format', '<p class="search-link"><i class="fa fa-icon fa-link"></i><strong><a href="%1$s">%2$s</a></strong></p>');
 	$content_format = apply_filters('search-content-format', '<p class="page-excerpt">%1$s</p>');

 		printf( $link_format, get_the_permalink(), get_the_title());
 		printf( $content_format, get_the_excerpt() );

	?>
</div>
<div class="clear"></div>