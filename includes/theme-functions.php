<?php

function generate_tax_array( $post_type ){

	if( isset( $post_type ) ){

		$args = array(
			'public'   => true,
			'object_type'=> array($post_type),
		);

		$output = 'objects';
		$operator = 'and';
		$taxonomies = get_taxonomies( $args, $output, $operator );

		$tax_array = array();

		if ( $taxonomies ) {

			$tax_array[] = __( 'Any', 'non-cherry' );

			foreach ( $taxonomies  as $taxonomy ) {

				$tax_array[$taxonomy->name] = $taxonomy->labels->name;
				
			}

		}

		return $tax_array;
	}
}

function generate_terms_array( $taxonomy ){

	if( isset( $taxonomy ) ){

		$args = array(
			'taxonomy' => array($taxonomy),
			'hide_empty' => true,
		);

		$terms = get_terms( $args );

		$terms_array = array();

		if ( is_array($terms) ) {

			foreach ( $terms  as $term ) {

				$terms_array[$term->slug] = $term->name;
				
			}

		}

		return $terms_array;
	}
}

// The excerpt based on words
function my_string_limit_words($string, $word_limit){

  $words = explode(' ', $string, ($word_limit + 1));

  if(count($words) > $word_limit)
  	array_pop($words);

  return implode(' ', $words).'&hellip; ';
  
}

// The excerpt based on character
function my_string_limit_char($excerpt, $substr=0){

	$string = strip_tags(str_replace('.', '.', $excerpt));

	if ($substr>0) {
		$string = substr($string, 0, $substr);
	}

	return $string;
}

// Remove invalid tags
function remove_invalid_tags($str, $tags){

    foreach( $tags as $tag ){

    	$str = preg_replace('#^<\/'.$tag.'>|<'.$tag.'>$#', '', trim( $str ));

    }

    return $str;
}

//	Pagination
function pagination($pages = '', $range = 4){

    $showitems = ($range * 2)+1;

    global $paged, $wp_query;

    if(empty($paged))
    	$paged = 1;

    if(empty($pages)){

        $pages = $wp_query->max_num_pages;

        if(!$pages){

            $pages = 1;

        }
    }

    if( 1 != $pages ){

        echo '<div class="pagenavi nav-links">';

        if( ($paged > 2) && ($paged > $range+1) && ($showitems < $pages) )
        	echo '<a class="btn" href="'.get_pagenum_link(1).'">'.__('&laquo; First', 'non-cherry').'</a>';
        if( ($paged > 1) && ($showitems < $pages) )
        	echo '<a class="btn" href="'.get_pagenum_link($paged - 1).'">'.__('&lsaquo; Previous', 'non-cherry').'</a>';

        for ( $i=1; $i <= $pages; $i++ ) {

            if ( (1 != $pages) && ( !( ($i >= ($paged+$range+1)) || ($i <= ($paged-$range-1)) ) || ($pages <= $showitems) ) ){
            	echo ($paged == $i)? 
               		'<span class="current btn">'.$i.'</span>':
               		'<a class="inactive btn" href="'.get_pagenum_link($i).'">'.$i.'</a>';
            }
        }

        if ( ($paged < $pages) && ($showitems < $pages) )
        	echo '<a class="btn" href="'.get_pagenum_link($paged + 1).'">'.__('Next &rsaquo;', 'non-cherry').'</a>';

        if ( ($paged < $pages-1) && (($paged+$range-1) < $pages) && ($showitems < $pages) )
        	echo '<a class="btn" href="'.get_pagenum_link($pages).'">'.__('Last &raquo;', 'non-cherry').'</a>';

        echo '</div>';
    }
}

//	Post navigation
function post_nav(){

	$post_type = get_post_type();

	if ( ( 'page' === $post_type )
		|| ! is_singular( $post_type )
		|| is_attachment() ) {
		return;
	}

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	} ?>
	<nav class="navigation post-navigation col-sm-12" role="navigation">
		<div class="paging-navigation">
			<div class="nav-links">
				<?php
					previous_post_link( '<div class="nav-previous">%link</div>', '&laquo; %title' );
					next_post_link( '<div class="nav-next">%link</div>', '%title &raquo;' );
				?>
				<div class="clear"></div>
			</div>
		</div>
	</nav>
	<?php
} 

// Custom Commen Structure
function mytheme_comment($comment, $args, $depth) {

    $GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment->comment_author_email, 86 ); ?>
				<?php printf(__('<span class="author">%1$s</span>', 'non-cherry' ), get_comment_author_link()) ?>
			</div>

			<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.', 'non-cherry') ?></em>
			<?php endif; ?>

			<?php comment_text() ?>

			<div class="wrapper">
				<div class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
				<div class="comment-meta commentmetadata"><?php printf(__('%1$s', 'non-cherry' ), get_comment_date('F j, Y')) ?></div>
			</div>

		</div>
	</li>
<?php }

// Header wrapper classes
function header_classes( $str_classes='', $echo=true ){

	$classes = preg_split('#[, ]+#', $str_classes);
	$classes = apply_filters('header_classes', $classes);

	if($echo)
		echo implode(' ', $classes);
	else
		return implode(' ', $classes);
}

// Footer wrapper classes
function footer_classes( $str_classes='', $echo=true ){

	$classes = preg_split('#[, ]+#', $str_classes);
	$classes = apply_filters('footer_classes', $classes);

	if($echo)
		echo implode(' ', $classes);
	else
		return implode(' ', $classes);
}

// "Slider" wrapper classes
function slider_wrapper_classes( $str_classes='', $echo=true ){

	$classes = preg_split('#[, ]+#', $str_classes);
	$classes = apply_filters('slider_wrapper_classes', $classes);

	if($echo)
		echo implode(' ', $classes);
	else
		return implode(' ', $classes);
}

// "Blog" and "Default page" content wrapper classes
function loop_content_classes( $str_classes='', $echo=true ){

	$classes = preg_split('#[, ]+#', $str_classes);
	$classes = apply_filters('loop_content_classes', $classes);

	if($echo)
		echo implode(' ', $classes);
	else
		return implode(' ', $classes);
}

// "Blog" and "Default page" sidebar wrapper classes
function loop_sidebar_classes( $str_classes='', $echo=true ){

	$classes = preg_split('#[, ]+#', $str_classes);
	$classes = apply_filters('loop_sidebar_classes', $classes);

	if($echo)
		echo implode(' ', $classes);
	else
		return implode(' ', $classes);
}

// Default template (Blog) sidebar logic
function theme_sidebar_logic( $echo=true ){

	$sidebar_position = of_get_option('blog_sidebar_pos', 'right');
	$output = '';

	switch ($sidebar_position) {
		case 'right':
			$output = 'content_sidebar';
			break;
		case 'left':
			$output = 'sidebar_content';
			break;
		case 'none':
			$output = 'content_only';
			break;
		
		default:
			$output = 'content_sidebar';
			break;
	}

	if($echo)
		echo $output;
	else
		return $output;
}

// Generates a random string (for embedding flash)
function my_framework_random($length){

	srand( (double)microtime()*1000000 );

	$random_id = "";

	$char_list = "abcdefghijklmnopqrstuvwxyz";

	for( $i = 0; $i < $length; $i++ ) {

		$random_id .= substr( $char_list, (rand()%(strlen($char_list))), 1 );

	}

	return $random_id;
}

// Add Thumb Column into admin
if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {

	// for post and page
	add_theme_support('post-thumbnails', array( 'post', 'page' ) );

	// for posts
	add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );

	// for pages
	add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );

	function fb_AddThumbColumn($cols) {
		$cols['thumbnail'] = __('Thumbnail', 'non-cherry');
		return $cols;
	}

	function fb_AddThumbValue($column_name, $post_id) {

		if ( 'thumbnail' == $column_name ) {

			$size = array( 35, 35 );

			// thumbnail
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			// image from gallery
			$attachments = get_children( array(
				'post_parent' 		=> $post_id,
				'post_type' 		=> 'attachment',
				'post_mime_type' 	=> 'image'
			));
			
			if ($thumbnail_id){
				$thumb = wp_get_attachment_image( $thumbnail_id, $size, true );
			} elseif ($attachments) {
				foreach ( $attachments as $attachment_id => $attachment ) {
					$thumb = wp_get_attachment_image( $attachment_id, $size, true );
				}
			}

			if ( isset($thumb) && $thumb ) {
				echo $thumb;
			} else {
				echo __('None', 'non-cherry');
			}
		}
	}
}

// Generates favicon link tag
add_action( 'wp_head', 'generate_favicon', 0 );
function generate_favicon( $output ){

	$icon_url = wp_get_attachment_url( (int) of_get_option( 'favicon' ) );
	$icon_url = $icon_url ? $icon_url : CHILD_URL.'/images/favicon.ico';

	$format = apply_filters( 'theme_favicon_format', '<link rel="icon" href="%1$s" type="image/x-icon" />' );

	printf( $format, $icon_url );
}

// Show filter by categories for custom posts
add_action('restrict_manage_posts', 'my_restrict_manage_posts' );
function my_restrict_manage_posts() {
	global $typenow;

	$args = array( 'public' => true, '_builtin' => false );
	$post_types = get_post_types($args);

	if ( in_array($typenow, $post_types) ) {

		$filters = get_object_taxonomies($typenow);

		foreach ($filters as $tax_slug) {

			$tax_obj = get_taxonomy($tax_slug);

			wp_dropdown_categories(array(
				'show_option_all' => __( 'Show All ', 'non-cherry' ).$tax_obj->label,
				'taxonomy' => $tax_slug,
				'name' => $tax_obj->name,
				'orderby' => 'term_order',
				'selected' => isset($_GET[$tax_obj->query_var])?$_GET[$tax_obj->query_var]:'',
				'hierarchical' => $tax_obj->hierarchical,
				'show_count' => false,
				'hide_empty' => true
			));
		}
	}
}

// Getting post meta info output
if(! function_exists('get_post_meta_info')){

	function get_post_meta_info( $meta_type='author', $format=false, $anchors=true, $echo=true ){

		$post_meta = of_get_option('post_meta', false);

		if ( !$post_meta )
			return;

		$post_meta_options = of_get_option('post_meta_options', false);

		if( !( $post_meta_options && is_array($post_meta_options) ) )
			return;

		if( !( isset($post_meta_options[$meta_type]) && $post_meta_options[$meta_type]==='1' ) )
			return;

		global $post;

		$format_date = '<div class="meta-date"><i class="fa fa-calendar"></i>%1$s<time datetime="%2$s">%3$s</time></div>';
		$format_author = '<div class="meta-author"><i class="fa fa-user"></i>%1$s %2$s</div>';
		$format_comments = '<div class="meta-comments"><i class="fa fa-comments"></i>%1$s</div>';
		$format_categories = '<div class="meta-categories"><i class="fa fa-th"></i>%1$s</div>';
		$format_tags = '<div class="meta-tags"><i class="fa fa-tags"></i>%1$s</div>';

		$wrapper = $anchors? '<a href="%1$s">%2$s</a>': '%2$s';
		$output = '';

		switch( $meta_type ){
			
			case 'date':

				$_format = $format?: $format_date;
				$output = sprintf( $_format, __('Date: ', 'non-cherry'), get_the_time('c'), get_the_time('m / d / Y'));
				
				break;
			case 'author':

				$_format = $format?: $format_author;
				$_author = $anchors? get_the_author_posts_link(): get_the_author();
				$output = sprintf( $_format, __('Posted by ', 'non-cherry'), $_author);

				break;
			case 'comments':

				$_format = $format?: $format_comments;
				$_comments = $anchors? '<a href="'.get_comments_link().'">'.get_comments_number_text().'</a>': get_comments_number_text();

				if(!is_singular())
					$output = sprintf( $_format, $_comments);

				break;
			case 'categories':

				$_format = $format?: $format_categories;
				$categories =  wp_get_post_terms( get_the_ID(), 'category', array('fields' => 'ids') );
				$output_arr = array();

				foreach( $categories as $cat_id ){

					if( $anchors )
						$output_arr[] = '<a href="'.get_category_link($cat_id).'">'.get_cat_name($cat_id).'</a>';
					else
						$output_arr[] = get_cat_name($cat_id);

				};
				
				if(count($output_arr)){
					$output = sprintf( $_format, implode( ', ', $output_arr ) );
				}

				break;
			case 'tags':

				$_format = $format?: $format_tags;
				$tags = wp_get_post_terms( get_the_ID(), 'post_tag', array('fields' => 'ids'));
				$termlist = get_the_term_list( get_the_ID(), 'post_tag', '', ', ', '' );
				$taglist = get_the_tag_list( '', ', ', '' );
				$output_arr = array();

				foreach( $tags as $tag_id ){

					if( $anchors )
						$output_arr[] = '<a href="'.get_tag_link($tag_id).'">'.get_term_field('name', $tag_id).'</a>';
					else
						$output_arr[] = get_term_field('name', $tag_id);

				};

				if(count($output_arr)){
					$output = sprintf( $_format, implode( ', ', $output_arr ) );
				}

				break;
			default:

				return;

				break;
		}

		if($echo)
			echo $output;
		else
			return $output;

	}
}

require_once 'theme-filters.php';

// Add Taxonomy List widget
require_once( 'widgets/taxonomy-list.php' );

?>