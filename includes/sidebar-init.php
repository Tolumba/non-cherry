<?php
function non_cherry_widgets_init() {
	register_sidebar(array(
		'name' 			=> __( 'Main sidebar', 'non-cherry' ),
		'id' 			=> 'main-sidebar',
		'description'   => __( 'Located at the right side of pages.', 'non-cherry' ),
		'before_widget' => '<div id="%1$s" class="widget">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3>',
		'after_title' 	=> '</h3>',
	));
	register_sidebar(array(
		'name'			=> __( 'Footer sidebar', 'non-cherry' ),
		'id' 			=> 'footer-sidebar',
		'description'   => __( 'Located at the bottom of pages.', 'non-cherry' ),
		'before_widget' => '<div id="%1$s" class="footer-widget">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h5>',
		'after_title' 	=> '</h5>',
	));
}
/** Register sidebars by running non_cherry_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'non_cherry_widgets_init' );
?>