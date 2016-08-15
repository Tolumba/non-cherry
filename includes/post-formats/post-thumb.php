<?php 
	
	if( has_post_thumbnail() ):

		$thumb = get_post_thumbnail_id();
		$fullsize_image_src = wp_get_attachment_image_src( $thumb, 'full' );

		$default_format_single = '<div class="lazy-img thumbnail blog-image">
			<img data-src="%2$s" alt="" />
			<noscript><img src="%2$s" alt="" /></noscript>
		</div>';
		$default_format_loop = '<a class="lazy-img magnific-popup thumbnail blog-image" href="%1$s">
			<img data-src="%2$s" alt="" />
			<noscript><img src="%2$s" alt="" /></noscript>
		</a>';
		
		if( is_singular() ) :

			$single_image_size = of_get_option( 'single_image_size', 'thumbnail' );
			$single_image_src = wp_get_attachment_image_src( $thumb, $single_image_size );
			$thumb_format_single = apply_filters('loop-post-thumbnail-format', $default_format_single);

			printf( $thumb_format_single, $fullsize_image_src[0], $single_image_src[0] );

		else:

			$post_image_size = of_get_option( 'post_image_size', 'thumbnail' );
			$post_image_src = wp_get_attachment_image_src( $thumb, $post_image_size );
			$thumb_format_loop = apply_filters('single-post-thumbnail-format', $default_format_loop);
			wp_enqueue_script( 'magnific-popup' );

			printf( $thumb_format_loop, $fullsize_image_src[0], $post_image_src[0] );

		endif;

	endif;
	
?>