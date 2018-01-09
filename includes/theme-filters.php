<?php
/**
*	Theme filters
*/
// Remove Toolset Types "Front-end Display" Metabox
add_filter('types_information_table', '__return_false');
// Remove Empty Paragraphs
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content){
	$array = array (
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']'
	);
	$content = strtr( $content, $array );
	return $content;
}
// Adding taxonomy filters in admin area
add_filter('parse_query', 'my_convert_restrict');
function my_convert_restrict($query) {
	global $pagenow;
	global $typenow;
	if ($pagenow == 'edit.php') {
		$filters = get_object_taxonomies($typenow);
		foreach ($filters as $tax_slug) {
			$var = &$query->query_vars[$tax_slug];
			if ( isset($var) ) {
				$term = get_term_by('id', $var, $tax_slug);
				$var = isset($term->slug) ? $term->slug : null;
			}
		}
	}
}
// Modifying post css-class output
add_filter('post_class', 'non_cherry_post_class');
function non_cherry_post_class($classes=array()){
	$format = get_post_format() ? : 'standard';
	switch( $format ){
		case 'standard':
			break;
		case 'aside':
			break;
		case 'chat':
			break;
		case 'gallery':
			break;
		case 'link':
			break;
		case 'image':
			break;
		case 'quote':
			break;
		case 'status':
			break;
		case 'video':
			break;
		case 'audio':
			break;
		default:
			$classes[]='post-holder';
			break;
	}
	$classes[]='post-holder';
	return $classes;
}
// Modifying wordpress gallery shortcode output
add_filter( 'post_gallery', 'non_cherry_gallery', 10, 3 );
function non_cherry_gallery( $output, $attr, $instance ){
	global $post;
	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );
	$id = intval( $atts['id'] );
	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
		if( !array_key_exists( get_post_thumbnail_id(), $attachments ) ){
			$attachments[get_post_thumbnail_id()] = get_post(get_post_thumbnail_id());
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		$post_thumbnail = get_post( get_post_thumbnail_id() );
		if( 1 === $instance && ! in_array( $post_thumbnail, $attachments ) ){
			$attachments[get_post_thumbnail_id()] = get_post(get_post_thumbnail_id());
		}
	}
	if ( empty( $attachments ) ) {
		return '';
	}
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}
	$selector = "gallery-{$instance}";
	ob_start();
	echo "<div id='{$selector}' class='gallery'>" ?>
		<div class="camera_wrap">
		<?php
			$i = 0;
			foreach ( $attachments as $id => $attachment ) :
				$image_src = wp_get_attachment_image_src( $attachment->ID, 'full' );
				$image_thumb_src = wp_get_attachment_image_src( $attachment->ID, 'small' );
				$image_title = get_the_title( $attachment->ID );
				$caption_format = '<div class="camera_caption">%1$s</div>';
				$item_format = '<div data-src="%1$s" data-thumb="%2$s">%3$s</div>';
				$caption = ''; //sprintf( $caption_format, $image_title );
				printf( $item_format, $image_src[0], $image_thumb_src[0], $caption );
			endforeach;
		?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#<?php echo $selector; ?> .camera_wrap').camera({});
			});
		</script>
	</div>
	<?php $output = ob_get_clean();
	return $output;
}
// Modifying comment css-class output
add_filter('comment_class', 'non_cherry_comment_class');
function non_cherry_comment_class($classes){
	//$classes[] = 'your-custom-class';
	return $classes;
}
// Overriding default templates filters
add_action('template_redirect', 'theme_template_redirect');
function theme_template_redirect(){
	$types = array( '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home', 'front_page', 'paged', 'search', 'single', 'singular', 'attachment');
	foreach ( $types as $type ) {
		add_filter( "{$type}_template_hierarchy", 'theme_templates_hierarchy_quene' );
		add_filter( "{$type}_template", 'theme_templates_quene' );
	}
}
function theme_templates_hierarchy_quene( $templates ){
	$current_filter =  current_filter();
	$file = preg_replace( "#_template_hierarchy#", '', $current_filter );
	$templates[] = "templates/{$file}.php";
	$templates[] = "templates-overrides/{$file}.php";
	return $templates;
}
// Updating default templates include quene
function theme_templates_quene( $template ){
	return $template;
}
// Updating other templates include quene
add_filter( 'template_include', 'theme_templates' );
function theme_templates($template){
	$file = basename($template);
	$templates = array();
	$templates[] = "templates/{$file}";
	$templates[] = "templates-overrides/{$file}";
	if( $template_override = locate_template( $templates ) )
		return $template_override;
	return $template;
}
require_once CHILD_DIR . '/includes/cherry-shortcode-filters.php';
?>
