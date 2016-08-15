<?php
	do_action('before_title_page');
	
	$default_title_format = '<h2 class="page-title">%1$s</h2>';
	$default_pagetitle_format = '<h2 class="page-title custom">%1$s</h2>';
	$default_pagedesc_format = '<h3 class="page-description">%1$s</h3>';

	$pagedesc = "";

	$title_format = apply_filters( 'page-title-format', $default_title_format );

	if ( is_home() ):

		$title = of_get_option( 'blog_text', false )?: __( 'Blog', 'non-cherry' );
	
	elseif ( is_page() ) :

		$pagetitle = get_post_meta( get_the_ID(), "page-title", true );
		$pagedesc = get_post_meta( get_the_ID(), "page-description", true );

		if( $pagetitle != "" ){

			$title_format = apply_filters( 'page-custom-title-format', $default_pagetitle_format );
			$title = $pagetitle;

		} else {

			$title = get_the_title();
			
		}

	elseif ( is_archive() ):

		$title = __( 'Blog Archives', 'non-cherry' );

		if ( is_category() ):

			$title = sprintf( __( 'Category Archives: %s', 'non-cherry' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			$pagedesc = category_description();

		elseif ( is_tag() ):

			$title = sprintf( __( 'Tag Archives: %s', 'non-cherry' ), '<span>' . single_tag_title( '', false ) . '</span>' );
			$pagedesc = tag_description();

		elseif ( is_day() ):

			$title = sprintf( __( 'Daily Archives: <span>%s</span>', 'non-cherry' ), get_the_date() ); 

		elseif ( is_month() ):

			$title = sprintf( __( 'Monthly Archives: <span>%s</span>', 'non-cherry' ), get_the_date('F Y') );

		elseif ( is_year() ):

			$title = sprintf( __( 'Yearly Archives: <span>%s</span>', 'non-cherry' ), get_the_date('Y') );

		endif;

	elseif ( is_search() ):

		$title =  __('Search for: ', 'non-cherry') . get_search_query();

	endif;

	printf( $title_format, $title );

	if( $pagedesc != "" ){

		$pagedesc_format = apply_filters( 'page-custom-description-format', $default_pagedesc_format );
		printf( $pagedesc_format, $pagedesc );
		
	}
	do_action('after_title_page');
?>