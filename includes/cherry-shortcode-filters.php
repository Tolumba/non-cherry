<?php
/**
*	Cherry Shortcodes Plugin filters
*/

/**
* 
*    Google API-key integration for cherry shortcodes plugin
*
*/
add_filter( 'cherry_shortcodes_google_map_url_query', 'non_cherry_map_api_key' );
function non_cherry_map_api_key( $args=array() ){

	$key = of_get_option( 'google_maps_key', false );
	if( $key ){
		$args['key'] = $key;
	}

	return $args;
}

//List shortcode filter
add_filter( 'cherry_shortcodes_list_classes', 'theme_shortcodes_list_classes' );
function theme_shortcodes_list_classes( $classes=array(), $atts=array() ){

	if( empty($atts) )
		unset( $classes[1] );

	return $classes;
}

// Registering custom buttons for shortcode templater
add_filter( 'cherry_templater_macros_buttons', 'non_cherry_banner_buttons', 10 , 2 );
function non_cherry_banner_buttons($buttons, $shortcode=''){

	if($shortcode === 'banner'){
		$buttons['title_text'] = array(
			'id'    => 'cherry_title_text',
			'value' => __( 'Title text', 'non-cherry' ),
			'open'  => '%%TITLE_TEXT%%',
			'close' => '',
		);
	}

	$buttons['imageurl'] = array(
		'id'    => 'imageurl',
		'value' => __( 'Post thumbnail url', 'non-cherry' ),
		'open'  => '%%IMAGEURL%%',
		'close' => '',
	);

	$buttons['types_field'] = array(
		'id'    => 'types_field',
		'value' => __( 'Types plugin field', 'non-cherry' ),
		'open'  => '%%TYPES_FIELD="slug"%%',
		'close' => '',
		'title' => __( 'Set Toolset Types field "slug" value', 'non-cherry' ),
	);

	$buttons['custommeta'] = array(
		'id'    => 'custommeta',
		'value' => 'Custom meta',
		'open'  => '%%CUSTOMMETA="meta_tag"%%',
		'close' => '',
		'title' => __( 'Set custom meta "slug" value', 'non-cherry' ),
	);

	$buttons['custommetavalue'] = array(
		'id'    => 'custommetavalue',
		'value' => 'Custom meta value',
		'open'  => '%%CUSTOMMETAVALUE="meta_tag"%%',
		'close' => '',
		'title' => __( 'Set custom meta "slug" value', 'non-cherry' ),
	);
	
	return $buttons;
}

// Title text shortcode output
add_filter( 'cherry_shortcodes_output', 'non_cherry_banner_shortcode', 10, 3 );
function non_cherry_banner_shortcode( $result, $atts=array(), $shortcode='' ){

	if( $shortcode === 'banner' ){
		$pattern = '/%%TITLE_TEXT%%/';
		$result = preg_replace( $pattern, $atts['title'], $result );
	}

	if( $shortcode === 'button' ){
        $style = isset( $atts['style'] )? $atts['style']: '';
        $fluid = isset( $atts['fluid'] )? 'yes' == $atts['fluid']: false;
        $fluid_position = isset( $atts['fluid_position'] )? $atts['fluid_position']: 'left';
		
        if( $style === 'primary' ){
            $format = '<a href="%1$s" class="%2$s">%3$s</a>';
			
            if( $fluid ){
                $format = "<div class=\"fluid-button-{$fluid_position}\">{$format}</div>";
            }
            $result = sprintf( $format, $atts['url'], $atts['class'], $atts['text'] );
        }
    }

	return $result;
}

if(class_exists('Cherry_Shortcodes_Handler')){
	Cherry_Shortcodes_Handler::$macros_pattern = '/%%([a-zA-Z_]+)(\s)?([^%]+)?%%/';
}

add_filter( 'cherry-shortcode-swiper-carousel-postdata', 'non_cherry_shortcode_postdata', 10, 3 );
add_filter( 'cherry_shortcode_posts_postdata', 'non_cherry_shortcode_postdata', 10, 3 );
function non_cherry_shortcode_postdata( $data, $post_id=null, $atts=array() ){

	// This activates liteboxes for images
	if( isset( $atts['lightbox_image'] ) && ( 'yes' === $atts['lightbox_image'] ) )
		wp_enqueue_script( 'magnific-popup' );

	$data['imageurl'] = 'non_cherry_imageurl_callback';
	$data['custommeta'] = 'non_cherry_custom_meta_callback';
	$data['custommetavalue'] = 'non_cherry_custom_meta_value_callback';
	$data['imageurl'] = 'non_cherry_imageurl_callback';
	$data['title_text'] = 'non_cherry_title_text_callback';
	$data['types_field'] = 'non_cherry_render_types_field';

	return $data;
}

add_filter( 'cherry_shortcodes_data_callbacks', 'non_cherry_grid_shortcode_data_callbacks' , 10, 2 );
add_filter( 'cherry_grid_shortcode_data_callbacks', 'non_cherry_grid_shortcode_data_callbacks', 10, 2 );
function non_cherry_grid_shortcode_data_callbacks( $data, $atts=array() ){
	
	if( !class_exists('Cherry_Shortcodes_Handler'))
		return;

	if( Cherry_Shortcodes_Handler::get_shortcode_name() == 'grid' ){
		$data['image'] = 'non_cherry_grid_image_callback';
	}

	$data['title_text'] = 'non_cherry_title_text_callback';
	$data['imageurl'] = 'non_cherry_imageurl_callback';
	$data['custommeta'] = 'non_cherry_custom_meta_callback';
	$data['custommetavalue'] = 'non_cherry_custom_meta_value_callback';
	$data['imageurl'] = 'non_cherry_imageurl_callback';
	$data['types_field'] = 'non_cherry_render_types_field';

	return $data;
}

function non_cherry_title_text_callback( $params=null ){

	if( 'banner' === Cherry_Shortcodes_Handler::get_shortcode_name()){
		return '%%TITLE_TEXT%%';
	}

	$title = get_the_title();

	if( !empty( $title ) ){
		return $title;
	}
}

// Callback function for %%IMAGEURL%% macros
function non_cherry_imageurl_callback( $params='post-thumbnail' ){

	global $post;

	$post_type = get_post_type( $post->ID );

	if ( ! post_type_supports( $post_type, 'thumbnail' ) ) {
		return;
	}

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$size = is_numeric( $params ) ? array($params, $params): $params;
	
	$thumb = get_post_thumbnail_id();
	$img_src = wp_get_attachment_image_src( $thumb, $size );

	if(is_array($img_src)){
		return $img_src[0];
	}

	return false;
}

// Callback function for %%IMAGE%% macros
function non_cherry_grid_image_callback( $params='post-thumbnail' ){

	global $post;
	$post_type = get_post_type( $post->ID );

	if ( ! post_type_supports( $post_type, 'thumbnail' ) ) {
		return;
	}

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$grid_meta = get_post_meta( $post->ID, '_cherry_grid', true );
	
	if ( isset( $grid_meta['show_thumb'] ) && 'no' == $grid_meta['show_thumb'] ) {
		return;
	}

	$size = is_numeric( $params ) ? array($params, $params): $params;
	$format = '<a href="%2$s">%1$s</a>';

	$thumb = get_post_thumbnail_id();
	$img_src = wp_get_attachment_image_src( $thumb, $size );

	if(is_array($img_src)){
		$image = '<img src="'.$img_src[0].'" alt="'.get_the_title($post).'">';
	}else{
		$image = '';
	}

	return sprintf( $format, $image, get_the_permalink($post) );
}

function non_cherry_custom_meta_callback( $meta_tag=null ){

	if( !$meta_tag )
		return;

	$meta_tag_arr = preg_split( "#[, ;]+#", $meta_tag );
	$format = apply_filters( 'custom-meta-format', '<div class="meta-box %1$s">%2$s</div>' );

	//var_dump(get_post_custom(get_the_ID()));

	if( count( $meta_tag_arr ) > 1 ){

		$meta_tag_value = get_post_meta( get_the_ID(), $meta_tag_arr[0], true );

		if( is_array( $meta_tag_value ) ){

			$value = isset( $meta_tag_value[ $meta_tag_arr[1] ] ) ? $meta_tag_value[ $meta_tag_arr[1] ] : false;

			return sprintf( $format, $meta_tag_arr[1], $value );

		}

	}else{
		
		$meta_tag_value = get_post_meta( get_the_ID(), $meta_tag_arr[0], false );

		if( is_array($meta_tag_value) ){

			$output = '';

			foreach ($meta_tag_value as $key => $value) {

				if($value)
					$output .= sprintf( $format, $meta_tag_arr[0], $value );

			}

			return $output;

		}

		if( $meta_tag_value )
			return sprintf( $format, $meta_tag, $meta_tag_value );
	}
}

function non_cherry_custom_meta_value_callback( $meta_tag=null ){

	if( !$meta_tag )
		return;

	$meta_tag_arr = preg_split( "#[, ;]+#", $meta_tag );

	if( count( $meta_tag_arr ) > 1 ){

		$meta_tag_value = get_post_meta( get_the_ID(), $meta_tag_arr[0], true );

		if( is_array( $meta_tag_value ) ){

			$value = isset( $meta_tag_value[ $meta_tag_arr[1] ] ) ? $meta_tag_value[ $meta_tag_arr[1] ] : '';

			return (string) $value;

		}

	}else{
		
		$meta_tag_value = get_post_meta( get_the_ID(), $meta_tag_arr[0], false );

		if( is_array($meta_tag_value) ){

			return implode( ', ', $meta_tag_value );

		}

		if( $meta_tag_value )
			return (string) $meta_tag_value;

	}
}

/**
* Help on params https://wp-types.com/documentation/functions/
*/
function non_cherry_render_types_field( $params=null ){

	if( !$params )
		return;

	$meta_tag_pattern = '#^=[\'\"]([a-z_-]+)[\'\"][,;]?#';
	preg_match( $meta_tag_pattern, $params, $maches );
	$meta_tag = count($maches)?$maches[1]:'';

	$params = preg_replace( $meta_tag_pattern, '', $params );
	$params_array = preg_split('#[\'\"][,;] #', $params);
	$args = array();

	foreach ($params_array as $key => $value) {
		$pair = preg_split( '/=/', $value );

		if( 2 == count($pair) ){
			$args[trim($pair[0])] = trim( $pair[1], '\'"' );
		}else{
			continue;
		}
	}

	//var_dump(array( 'meta_tag' => $meta_tag, 'args' => $args ));

	$before = isset($args['before'])?$args['before']:'';
	$after = isset($args['after'])?$args['after']:'';
	$field = types_render_field( $meta_tag, $args );

	if( empty($field) )
		return;

	return $before . $field . $after;
}

// Setting 'posts_per_archive_page' value for Cherry Team plugin
if( class_exists('Cherry_Team_Templater') )
	Cherry_Team_Templater::$posts_per_archive_page = get_option( 'posts_per_page', 8 );

// Modifying Cherry Portfolio query vars
add_filter('cherry_the_portfolio_default_query_args', 'non_cherry_the_portfolio_default_query_args');
function non_cherry_the_portfolio_default_query_args( $params=null ){

	$params['posts_per_page'] = get_option( 'posts_per_page', 12 );
	$params['offset'] = null;

	return $params;
}

// Overriding portfolio loop post data
add_filter( 'cherry-shortcode-portfolio-postdata', 'non_cherry_portfolio_postdata', 10, 2);
function non_cherry_portfolio_postdata( $_postdata, $post_id = null ){

	if( !$post_id )
		return $_postdata;

	$post_meta = get_post_meta( $post_id, CHERRY_PORTFOLIO_POSTMETA, true );

	$image_full_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) , 'full', false );
	$image_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) , 'portfolio-loop-thumbnail', false );

	$external_link = !empty( $post_meta['external-link-url'] ) ? $post_meta['external-link-url']:'';
	$external_link_text = !empty( $post_meta['external-link-text'] ) ? $post_meta['external-link-text']: __( 'Externa link', 'non-cherry');
	$external_link_target =  !empty( $post_meta['external-link-target'] ) ? $post_meta['external-link-target'] : '_blank';

	$client_name = get_post_meta( $post_id, 'client', true);
	$client_link = get_post_meta( $post_id, 'client-link', true);

	$data = new Cherry_Portfolio_Data();
	$category_name_list = $data->get_taxonomy_list( $post_id, 'category' );
	$tag_name_list = $data->get_taxonomy_list( $post_id, 'tag' );

	$image_format = '<figure><a class="thumbnail magnific-popup-zoom" href="%1$s"><img src="%2$s"/></a></figure>';
	$external_link_format = '<div class="meta-link"><i class="fa fa-external-link-square"></i>'. __('URL: ', 'non-cherry'). '<a href="%1$s" target="%3$s">%2$s</a></div>';

	$client_format_linked = '<div class="meta-client"><i class="fa fa-user"></i>'. __('Client: ', 'non-cherry') . '<a href="%1$s">%2$s</a></div>';
	$client_format = '<div class="meta-client"><i class="fa fa-user"></i>'. __('Client: ', 'non-cherry') . '%2$s</div>';
	$client_format = !empty($client_link) ? $client_format_linked: $client_format;

	$_postdata['image'] = sprintf( $image_format, $image_full_src[0], $image_thumb_src[0] );
	$_postdata['client'] = !empty( $client_name ) ? sprintf( $client_format, $client_link, $client_name ) : '';
	$_postdata['externallink'] = !empty( $external_link ) ? sprintf( $external_link_format, $external_link, $external_link_text, $external_link_target ) : '';
	$_postdata['taxonomy'] = preg_replace( '#Tags#', __( 'Features', 'non-cherry'), sprintf( '%1$s', $tag_name_list ) );

	return $_postdata;
};

?>
