<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

if(!function_exists('optionsframework_option_name')) {

	function optionsframework_option_name() {
		
		// This gets the theme name from the stylesheet (lowercase and without spaces)
		$themename = 'non-cherry';

		$optionsframework_settings = get_option('optionsframework');
		$optionsframework_settings['id'] = $themename;

		update_option( 'optionsframework', $optionsframework_settings );

	}
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *
 */
if(!function_exists('optionsframework_options')) {

	function optionsframework_options() {

		// Fonts
		$typography_mixed_fonts = array_merge( options_typography_get_os_fonts() , options_typography_get_google_fonts() );
		asort($typography_mixed_fonts);

		$font_faces = array( 'faces' => $typography_mixed_fonts );

		// Yes/No Array
		$yes_no_arr = array(
			"no"  => __("No", 'non-cherry'),
			"yes" => __("Yes", 'non-cherry'),
		);

		// True/False Array
		$true_false_arr = array(
			"true"  => __("Yes", 'non-cherry'),
			"false" => __("No", 'non-cherry'),
		);

		// Logo type
		$logo_type = array(
			"image_logo" => __("Image Logo", 'non-cherry'),
			"text_logo"  => __("Text Logo", 'non-cherry')
		);

		// Background Defaults
		$background_defaults = array(
			'color'      => '#212121',
			'image'      => '69',
			'repeat'     => 'repeat',
			'position'   => 'middle center',
			'attachment' => 'fixed'
		);
		$header_background_defaults = array(
			'color'      => '',
			'image'      => '69',
			'repeat'     => 'repeat',
			'position'   => 'middle center',
			'attachment' =>'normal'
		);

		// Superfish fade-in animation
		$sf_f_animation_array = array(
			"show" 	=> __("Enable fade-in animation", 'non-cherry'),
			"false" => __("Disable fade-in animation", 'non-cherry')
		);

		// Superfish slide-down animation
		$sf_sl_animation_array = array(
			"show" 	=> __("Enable slide-down animation", 'non-cherry'),
			"false" => __("Disable slide-down animation", 'non-cherry')
		);

		// Superfish animation speed
		$sf_speed_array = array(
			"slow" 		=> __("Slow", 'non-cherry'),
			"normal" 	=> __("Normal", 'non-cherry'),
			"fast" 		=> __("Fast", 'non-cherry')
		);

		$image_size_array = array_combine(get_intermediate_image_sizes(), get_intermediate_image_sizes());
		$image_size_array['full'] = __( 'Fullsize image', 'non-cherry');
		
		$meta_opts = apply_filters('post_meta_fields_array', array(
			'date' 			=> __('Date', 'non-cherry'),
			'author' 		=> __('Author', 'non-cherry'),
			'comments' 		=> __('Comments', 'non-cherry'),
			'categories' 	=> __('Categories', 'non-cherry'),
			'tags' 			=> __('Tags', 'non-cherry'),
		));

		// Slider effects
		// Flex slider
		$sl_flex_effect_array = array(
			'fade'  => 'fade',
			'slide' => 'slide',
		);
		
		// Camera slider
		$sl_camera_effect_array = array(
			'random' => 'random',
			'simpleFade' => 'simpleFade',
			'curtainTopLeft' => 'curtainTopLeft',
			'curtainTopRight' => 'curtainTopRight',
			'curtainBottomLeft' => 'curtainBottomLeft',
			'curtainBottomRight' => 'curtainBottomRight',
			'curtainSliceLeft' => 'curtainSliceLeft',
			'curtainSliceRight' => 'curtainSliceRight',
			'blindCurtainTopLeft' => 'blindCurtainTopLeft',
			'blindCurtainTopRight' => 'blindCurtainTopRight',
			'blindCurtainBottomLeft' => 'blindCurtainBottomLeft',
			'blindCurtainBottomRight' => 'blindCurtainBottomRight',
			'blindCurtainSliceBottom' => 'blindCurtainSliceBottom',
			'blindCurtainSliceTop' => 'blindCurtainSliceTop',
			'stampede' => 'stampede',
			'mosaic' => 'mosaic',
			'mosaicReverse' => 'mosaicReverse',
			'mosaicRandom' => 'mosaicRandom',
			'mosaicSpiral' => 'mosaicSpiral',
			'mosaicSpiralReverse' => 'mosaicSpiralReverse',
			'topLeftBottomRight' => 'topLeftBottomRight',
			'bottomRightTopLeft' => 'bottomRightTopLeft',
			'bottomLeftTopRight' => 'bottomLeftTopRight',
			'bottomLeftTopRight' => 'bottomLeftTopRight'
		);

		// Pull all the categories into an array
		$options_categories = array();

		$options_categories_obj = get_categories();
		foreach ($options_categories_obj as $category) {
			$options_categories[$category->cat_ID] = $category->cat_name;
		}

		// Pull all the availible post-types into an array
		$options_post_types = array();
		$args = array(
		   'public'          => true,
		   '_builtin'        => false,
		   'capability_type' => 'post'
		);

		$options_post_types['post'] = __('Posts', 'non-cherry');
		$post_types = get_post_types($args, 'objects');

		foreach ($post_types as $post_type) {
			$options_post_types[$post_type->name] = $post_type->labels->name;
		}

		// Pull all the pages into an array
		$options_pages = array();

		$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
		$options_pages[''] = __( 'Select a page: ', 'non-cherry');
		foreach ($options_pages_obj as $page) {
			$options_pages[$page->ID] = $page->post_title;
		}

		// If using image radio buttons, define a directory path
		$imagepath =  esc_url( get_template_directory_uri() ) . '/includes/images/';

		// Blog sidebar position options
		$blog_layout_opts = array(
			'none'  => $imagepath . '1col.png',
			'left'  => $imagepath . '2cl.png',
			'right' => $imagepath . '2cr.png',
		);

		$options = array();

	/*
	*	Tab General
	*/
		$options[] = array(
			"name" => __("General", 'non-cherry'),
			"type" => "heading"
		);

		$options['body_background'] = array(
			"name" => __("Body styling", 'non-cherry'),
			"desc" => __("Change the background style.", 'non-cherry'),
			"id"   => "body_background",
			"std"  => $background_defaults,
			"type" => "background"
		);

		$options['header_background'] = array(
			"name" => __("Header background color", 'non-cherry'),
			"desc" => __("Change the header background style.", 'non-cherry'),
			"id"   => "header_background",
			"std"  => $header_background_defaults,
			"type" => "background"
		);

		$options['links_color'] = array(
			"name" => __("Buttons and links color", 'non-cherry'),
			"desc" => __("Change the color of buttons and links.", 'non-cherry'),
			"id"   => "links_color",
			"std"  => "#dd3333",
			"type" => "color"
		);

		$options['links_color_hover'] = array(
			"name" => __("Buttons and links hover color", 'non-cherry'),
			"desc" => __("Change the hover color of buttons and links.", 'non-cherry'),
			"id"   => "links_color_hover",
			"std"  => "#333333",
			"type" => "color"
		);


		$options['sticky_header'] = array(
			"name"    => __("Use sticky header?", 'non-cherry'),
			"desc"    => __("Whether to use a sticky header.", 'non-cherry'),
			"id"      => "sticky_header",
			"type"    => "radio",
			"std"     => "yes",
			"options" => $yes_no_arr
		);

		$options['google_maps_key'] = array(
			"name" => __( "Google maps API key", 'non-cherry'),
			"desc" => __('You can generate key on <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">Get a Key page</a>', 'non-cherry'),
			"id"   => "google_maps_key",
			"std"  => "",
			"type" => "text",
		);

		$options['g_search_box_id'] = array(
			"name"    => __("Display search box?", 'non-cherry'),
			"desc"    => __("Display search box in the header?", 'non-cherry'),
			"id"      => "g_search_box_id",
			"type"    => "radio",
			"std"     => "yes",
			"options" => $yes_no_arr
		);

		$options[] = array(
			"name" => __("Custom CSS", 'non-cherry'),
			"desc" => __("Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}", 'non-cherry'),
			"id"   => "custom_css",
			"std"  => "",
			"type" => "textarea"
		);

	/*
	*	Tab Typography
	*/

		$options[] = array(
			"name" => __("Typography", 'non-cherry'),
			"type" => "heading",
		);

		$options['google_mixed_3'] = array(
			'name'    => __('Body Text', 'non-cherry'),
			'desc'    => __('Choose your prefered font for body text. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>', 'non-cherry'),
			'id'      => 'google_mixed_3',
			'std'     => array( 'size' => '14px', 'lineheight' => '24px', 'face' => 'Arial', 'color' => '#2d2d2d'),
			'type'    => 'typography',
			'options' => $font_faces,
		);
							
		$options['h1_heading'] = array(
			'name'    => __('H1 Heading', 'non-cherry'),
			'desc'    => __('Choose your prefered font for H1 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>', 'non-cherry'),
			'id'      => 'h1_heading',
			'std'     => array( 'size' => '32px', 'lineheight' => '36px', 'face' => 'Arial', 'color' => '#2d2d2d'),
			'type'    => 'typography',
			'options' => $font_faces,
		);
		
		$options['h2_heading'] = array(
			'name'    => __('H2 Heading', 'non-cherry'),
			'desc'    => __('Choose your prefered font for H2 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>', 'non-cherry'),
			'id'      => 'h2_heading',
			'std'     => array( 'size' => '32px', 'lineheight' => '36px', 'face' => 'Arial', 'color' => '#2d2d2d'),
			'type'    => 'typography',
			'options' => $font_faces,
		);
							
		$options['h3_heading'] = array(
			'name'    => __('H3 Heading', 'non-cherry'),
			'desc'    => __('Choose your prefered font for H3 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>', 'non-cherry'),
			'id'      => 'h3_heading',
			'std'     => array( 'size' => '17px', 'lineheight' => '24px', 'face' => 'Arial', 'color' => '#2d2d2d'),
			'type'    => 'typography',
			'options' => $font_faces,
		);
		
		$options['h4_heading'] = array(
			'name'    => __('H4 Heading', 'non-cherry'),
			'desc'    => __('Choose your prefered font for H4 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>', 'non-cherry'),
			'id'      => 'h4_heading',
			'std'     => array( 'size' => '20px', 'lineheight' => '25px', 'face' => 'Arial', 'color' => '#2d2d2d'),
			'type'    => 'typography',
			'options' => $font_faces,
		);
							
		$options['h5_heading'] = array(
			'name'    => __('H5 Heading', 'non-cherry'),
			'desc'    => __('Choose your prefered font for H5 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>', 'non-cherry'),
			'id'      => 'h5_heading',
			'std'     => array( 'size' => '14px', 'lineheight' => '22px', 'face' => 'Arial', 'color' => '#2d2d2d'),
			'type'    => 'typography',
			'options' => $font_faces,
		);
							
		$options['h6_heading'] = array(
			'name'    => __('H6 Heading', 'non-cherry'),
			'desc'    => __('Choose your prefered font for H6 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>', 'non-cherry'),
			'id'      => 'h6_heading',
			'std'     => array( 'size' => '10px', 'lineheight' => '18px', 'face' => 'Arial', 'color' => '#2d2d2d'),
			'type'    => 'typography',
			'options' => $font_faces,
		);

	/*
	*	Tab Logo & Favicon
	*/

		$options[] = array(
			"name" => __("Logo & Favicon", 'non-cherry'),
			"type" => "heading",
		);

		$options['logo_type'] = array(
			"name"    => __("What kind of logo?", 'non-cherry'),
			"desc"    => __("Select whether you want your main logo to be an image or text. If you select 'image' you can put in the image url in the next option, and if you select 'text' your Site Title will show instead.", 'non-cherry'),
			"id"      => "logo_type",
			"std"     => "image_logo",
			"type"    => "radio",
			"options" => $logo_type
		);

		$options['logo_url'] = array(
			"name" => __("Logo Image Path", 'non-cherry'),
			"desc" => __("Select an attachment to be used as your website logo.", 'non-cherry'),
			"id"   => "logo_url",
			"type" => "upload"
		);

		$options['footer_logo_url'] = array(
			"name" => __("Footer Logo Image Path", 'non-cherry'),
			"desc" => __("Select an attachment to be used as your website footer logo.", 'non-cherry'),
			"id"   => "footer_logo_url",
			"type" => "upload"
		);

		$options['favicon'] = array(
			"name" => __("Favicon", 'non-cherry'),
			"desc" => __("Select an attachment to be used as your website favicon.", 'non-cherry'),
			"id"   => "favicon",
			"type" => "upload"
		);

	/*
	*	Tab Navigation
	*/

		$options[] = array(
			"name" => __("Navigation", 'non-cherry'),
			"type" => "heading",
		);

		$options[] = array(
			"name"  => __("Delay", 'non-cherry'),
			"desc"  => __("miliseconds delay on mouseout.", 'non-cherry'),
			"id"    => "sf_delay",
			"std"   => "1000",
			"class" => "mini",
			"type"  => "text"
		);

		$options[] = array(
			"name"  => __("Delay", 'non-cherry'),
			"desc"  => __("miliseconds delay on mouseout.", 'non-cherry'),
			"id"    => "sf_delay",
			"std"   => "1000",
			"class" => "mini",
			"type"  => "text"
		);

		$options[] = array(
			"name"    => __("Fade-in animation", 'non-cherry'),
			"desc"    => __("Fade-in animation.", 'non-cherry'),
			"id"      => "sf_f_animation",
			"std"     => "show",
			"type"    => "radio",
			"options" => $sf_f_animation_array
		);

		$options[] = array(
			"name"    => __("Slide-down animation", 'non-cherry'),
			"desc"    => __("Slide-down animation.", 'non-cherry'),
			"id"      => "sf_sl_animation",
			"std"     => "show",
			"type"    => "radio",
			"options" => $sf_sl_animation_array
		);

		$options[] = array(
			"name"    => __("Speed", 'non-cherry'),
			"desc"    => __("Animation speed.", 'non-cherry'),
			"id"      => "sf_speed",
			"type"    => "select",
			"std"     => "normal",
			"class"   => "tiny",
			"options" => $sf_speed_array
		);

		$options[] = array(
			"name"    => __("Arrows markup", 'non-cherry'),
			"desc"    => __("Do you want to generate arrow mark-up?", 'non-cherry'),
			"id"      => "sf_arrows",
			"std"     => "yes",
			"type"    => "radio",
			"options" => $yes_no_arr
		);

		$options[] = array(
			"name" => __("Mobile navigation switch-point", 'non-cherry'),
			"desc" => __('Enter a value in pixels, after which the menu will switch to the "mobile" version.', 'non-cherry'),
			"id"   => "mobile_switch_point",
			"std"  => "768",
			"type" => "text",
		);

		$options['header_social_menu'] = array(
			"name"    => __("Display social in header?", 'non-cherry'),
			"desc"    => __("Display social in header.", 'non-cherry'),
			"id"      => "header_social_menu",
			"type"    => "radio",
			"std"     => "no",
			"options" => $yes_no_arr
		);

		$options['footer_social_menu'] = array(
			"name"    => __("Display social in footer?", 'non-cherry'),
			"desc"    => __("Display social in footer.", 'non-cherry'),
			"id"      => "footer_social_menu",
			"type"    => "radio",
			"std"     => "yes",
			"options" => $yes_no_arr
		);

	/*
	*	Tab Slider
	*/

		$options[] = array(
			"name" => __("Slider", 'non-cherry'),
			"type" => "heading"
		);

		$options['home_slider'] = array(
			"name" => __("Homepage slider", 'non-cherry'),
			"desc" => __("Display homepage slider", 'non-cherry'),
			"id"   => "home_slider",
			"std"  => "1", // accepted values 1, 0 or empty;
			"type" => "checkbox"
		);

		$options['sl_posts'] = array(
			"name"    => __("Type of posts to be shown", 'non-cherry'),
			"desc"    => __("Select posts type", 'non-cherry'),
			"id"      => "sl_posts",
			"std"     => "slide", //If there is no such type of post, falls back to native type 'post'
			"type"    => "select",
			"class"   => "tiny", //mini, tiny, small
			"options" => $options_post_types,
		);

		$options['sl_posts_taxonomy'] = array(
			"name"    => __("Post taxonomy", 'non-cherry'),
			"desc"    => __("Select a taxonomy to be shown.", 'non-cherry'),
			"id"      => "sl_posts_taxonomy",
			"std"     => "slides-group",
			"type"    => "select",
			"class"   => "tiny", //mini, tiny, small
			"options" => generate_tax_array( of_get_option( "sl_posts", $options['sl_posts']['std'] ) ),
		);

		$options['sl_posts_term'] = array(
			"name"     => __("Post terms", 'non-cherry'),
			"desc"     => __("Select a terms to be shown. You can select multiple terms.", 'non-cherry'),
			"id"       => "sl_posts_term",
			"std"      => "homepage",
			"type"     => "multiselect",
			"class"    => "tiny", //mini, tiny, small
			"options"  => generate_terms_array( of_get_option( 'sl_posts_taxonomy', $options['sl_posts_taxonomy']['std'] ) ),
		);

		$options['sl_posts_number'] = array(
			"name"  => __("Number of posts to be shown", 'non-cherry'),
			"desc"  => __("Enter number of slides to be shown. Enter -1 to show all. You can also provide slide's ID's.", 'non-cherry'),
			"id"    => "sl_posts_number",
			"std"   => "5",
			"type"  => "text",
			"class" => "small", //mini, tiny, small;
		); 

		$options['sl_effect'] = array(
			"name"    => __("Sliding effect", 'non-cherry'),
			"desc"    => __("Select your animation type.", 'non-cherry'),
			"id"      => "sl_effect",
			"std"     => "simpleFade",
			"type"    => "select",
			"class"   => "tiny", //mini, tiny, small
			"options" => $sl_camera_effect_array
		);

		$options['sl_slideshow'] = array(
			"name"    => __("Auto slideshow", 'non-cherry'),
			"desc"    => __("Animate slider automatically?", 'non-cherry'),
			"id"      => "sl_slideshow",
			"std"     => "true",
			"type"    => "radio",
			"options" => $true_false_arr
		);

		$options['sl_pausetime'] = array(
			"name"  => __("Pause time", 'non-cherry'),
			"desc"  => __("Pause time (ms).", 'non-cherry'),
			"id"    => "sl_pausetime",
			"std"   => "7000",
			"class" => "mini",
			"type"  => "text"
		);

		$options['sl_animation_speed'] = array(
			"name"  => __("Animation speed", 'non-cherry'),
			"desc"  => __("Animation speed (ms).", 'non-cherry'),
			"id"    => "sl_animation_speed",
			"std"   => "700",
			"class" => "mini",
			"type"  => "text"
		);

		$options['sl_dir_nav'] = array(
			"name"    => __("Next & Prev navigation", 'non-cherry'),
			"desc"    => __("Create navigation for previous/next navigation?", 'non-cherry'),
			"id"      => "sl_dir_nav",
			"std"     => "false",
			"type"    => "radio",
			"options" => $true_false_arr
		);

		$options['sl_control_nav'] = array(
			"name"    => __("Pagination", 'non-cherry'),
			"desc"    => __("Create navigation for paging control of each clide? Note: Leave true for manualControls usage", 'non-cherry'),
			"id"      => "sl_control_nav",
			"std"     => "true",
			"type"    => "radio",
			"options" => $true_false_arr
		);

	/*
	*	Tab Blog
	*/

		$options[] = array(
			"name" => __("Blog", 'non-cherry'),
			"type" => "heading"
		);

		$options[] = array(
			"name" => __("Blog Title", 'non-cherry'),
			"desc" => __("Enter Your Blog Title used on Blog page.", 'non-cherry'),
			"id"   => "blog_text",
			"std"  => "Blog",
			"type" => "text"
		);

		$options[] = array(
			"name" => __("Related Posts Title", 'non-cherry'),
			"desc" => __("Enter Your Title used on Single Post page for related posts.", 'non-cherry'),
			"id"   => "blog_related",
			"std"  => "Related Posts",
			"type" => "text"
		);

		$options['blog_sidebar_pos'] = array(
			"name"    => __("Sidebar position", 'non-cherry'),
			"desc"    => __("Choose sidebar position.", 'non-cherry'),
			"id"      => "blog_sidebar_pos",
			"std"     => "right",
			"type"    => "images",
			"options" => $blog_layout_opts
		);

		$options['post_image_size'] = array(
			"name"    => __("Blog image size", 'non-cherry'),
			"desc"    => __("Featured image size on the blog.", 'non-cherry'),
			"id"      => "post_image_size",
			"type"    => "select",
			"std"     => "thumbnail",
			"class"   => "tiny", //mini, tiny, small
			"options" => $image_size_array
		);
		
		$options['single_image_size'] = array(
			"name"    => __("Single post image size", 'non-cherry'),
			"desc"    => __("Featured image size on the single page.", 'non-cherry'),
			"id"      => "single_image_size",
			"type"    => "select",
			"std"     => "medium_large",
			"class"   => "small", //mini, tiny, small
			"options" => $image_size_array
		);

		$options['post_meta'] = array(
			"name" => __("Enable Meta for blog posts?", 'non-cherry'),
			"desc" => __("Enable or Disable meta information for blog posts.", 'non-cherry'),
			"id"   => "post_meta",
			"std"  => "1",
			"type" => "checkbox"
		);

		$options['post_meta_options'] = array(
			"name"    => __("Select meta to display:", 'non-cherry'),
			"id"      => __("post_meta_options", 'non-cherry'),
			"std"     => array( 
				'date' 		 => "1",
				'author' 	 => "1",
				'comments' 	 => "1",
				'categories' => "1",
				'tags' 	     => "1",
			),
			"type"    => "multicheck",
			"options" => $meta_opts
		);

		$options['post_excerpt'] = array(
			"name" => __("Enable excerpt for blog posts?", 'non-cherry'),
			"desc" => __("Enable or Disable excerpt for blog posts.", 'non-cherry'),
			"id"   => "post_excerpt",
			"std"  => "1",
			"type" => "checkbox",
		);

		$options['post_excerpt_length'] = array(
			"name" => __("Enter desired excerpt length", 'non-cherry'),
			"desc" => __("Number of words in excerpt", 'non-cherry'),
			"id"   => "post_excerpt_length",
			"std"  => "35",
			"type" => "text",
		);

	/*
	*	Tab Footer
	*/

		$options[] = array(
			"name" => __("Footer", 'non-cherry'),
			"type" => "heading",
		);

		$options['footer_text'] = array(
			"name" => __("Footer copyright text", 'non-cherry'),
			"desc" => __("Enter text used in the right side of the footer. HTML tags are allowed.", 'non-cherry'),
			"id"   => "footer_text",
			"std"  => "",
			"type" => "textarea"
		);

		$options[] = array(
			"name" => __("Google Analytics Code", 'non-cherry'),
			"desc" => __("You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.", 'non-cherry'),
			"id"   => "ga_code",
			"std"  => "",
			"type" => "textarea"
		);

		$options['feed_url'] = array(
			"name" => __("Feedburner URL", 'non-cherry'),
			"desc" => __("Feedburner is a Google service that takes care of your RSS feed. Paste your Feedburner URL here to let readers see it in your website.", 'non-cherry'),
			"id"   => "feed_url",
			"std"  => "",
			"type" => "text"
		);

		return $options;

	}
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');
if( !function_exists('optionsframework_custom_scripts') ) {

	function optionsframework_custom_scripts() { ?>

		<script type="text/javascript">
		
			/*
			* "Hiding" some options.
			*/

			jQuery(document).ready(function($) {

				var togglers = [
						'#home_slider',
						'#post_excerpt',
						'#post_meta',
					],
					toggled = [
						'[id^="section-sl_"]',
						'#section-post_excerpt_length',
						'#section-post_meta_options',
					],
					speed = 400;

				function _init_toggle(){
					
					for( toggler in togglers ){

						var $toggler = $(togglers[toggler]),
							$toggled = $(toggled[toggler]),
							$checked = !!$( togglers[toggler]+':checked' ).length;

						$toggled.hide();
						if ($checked) {
							$toggled.show();
						}

						$toggler.on('click', '', $toggled, function(e){
							e.data.slideToggle(speed);
						});
					}
				}

				_init_toggle();

			});

			/**
			* "Activating" some fields
			*/
			jQuery(document).ready(function($){

				var primary = [
						'#sl_posts',
						'#sl_posts_taxonomy',
					],
					dependents = [
						'#sl_posts_taxonomy',
						'#sl_posts_term',
					],
					actions = [
						'generate_tax_list',
						'generate_terms_list',
					]

				function _init_dependents(){

					primary.forEach(function(item, index){

						var _item = $(item),
							_dependent = $(dependents[index]),
							_action = actions[index];

						if( !!_item.length ){

							_item.on( 'change select', function(e){

								// Disabling input while updating fields
								_dependent.prop("disabled", true);

								// AJAX request for a new fields
								$.post(
									ajaxurl,
									{
										'action': actions[index],
										'val': _item.val(),
									},
									function( data, status, jqXHR ){
										if( data ){

											// Holding current value
											var tmp_val = _dependent.val();

											// Applying new fields
											_dependent.html( data );
											// Trying to restore previous state
											_dependent.val( tmp_val );

											// If did not restored previous state, fallback to default
											if(!_dependent.val()){
												_dependent.val( '0' );
											};

											// Triggering change event
											_dependent.change();

											// Reactivating input
											_dependent.prop( "disabled", false );

										}else{

											_dependent.html( '<option value=""><?php _e( "No valid data", 'non-cherry' ); ?></option>' )

										}
									}
								);
							}).change();
						}
					});
				}
				_init_dependents();
			});
		</script>
	<?php
	}
}

/**
* Front End Customizer
* WordPress 3.4 Required
*/
add_action( 'customize_register', 'my_framework_register' );
if(!function_exists('my_framework_register')) {

	function my_framework_register($wp_customize) {
		/**
		 * This is optional, but if you want to reuse some of the defaults
		 * or values you already have built in the options panel, you
		 * can load them into $options for easy reference
		 */
		$options = optionsframework_options();

	/*-----------------------------------------------------------------------------------*/
	/*	General
	/*-----------------------------------------------------------------------------------*/
		$wp_customize->add_section( 'my_framework_header', array(
				'title'    => __( 'General', 'non-cherry' ),
				'priority' => 200
		));

		/* Background Image*/
		$wp_customize->add_setting( 'non_cherry[body_background][image]', array(
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'body_background_image', array(
					'label'    => __( 'Background Image', 'non-cherry' ),
					'section'  => 'my_framework_header',
					'settings' => 'non_cherry[body_background][image]'
		) ) );

		/* Background Color*/
		$wp_customize->add_setting( 'non_cherry[body_background][color]', array(
				'default'           => $options['body_background']['std']['color'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_background', array(
					'label'    => __( 'Background Color', 'non-cherry' ),
					'section'  => 'my_framework_header',
					'settings' => 'non_cherry[body_background][color]'
		) ) );

		/* Header Background Image */
		$wp_customize->add_setting( 'non_cherry[header_background][image]', array(
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'header_background_image', array(
					'label'    => __( 'Header Background Image', 'non-cherry' ),
					'section'  => 'my_framework_header',
					'settings' => 'non_cherry[header_background][image]'
		) ) );

		/* Header Background Color */
		$wp_customize->add_setting( 'non_cherry[header_background][color]', array(
				'default'           => $options['header_background']['std']['color'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background', array(
					'label'    => __( 'Header Background Color', 'non-cherry' ),
					'section'  => 'my_framework_header',
					'settings' => 'non_cherry[header_background][color]'
		) ) );

		/* Buttons and Links Color */
		$wp_customize->add_setting( 'non_cherry[links_color]', array(
				'default'           => $options['links_color']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'links_color', array(
					'label'    => $options['links_color']['name'],
					'section'  => 'my_framework_header',
					'settings' => 'non_cherry[links_color]'
		) ) );

		/* Google maps key */
		$wp_customize->add_setting( 'non_cherry[google_maps_key]', array(
				'default'           => $options['google_maps_key']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );

		$wp_customize->add_control( 'non_cherry[google_maps_key]', array(
				'label'    => $options['google_maps_key']['name'],
				'section'  => 'my_framework_header',
				'settings' => 'non_cherry[google_maps_key]',
				'type'     => 'text'
		) );

		/* Search Box */
		$wp_customize->add_setting( 'non_cherry[g_search_box_id]', array(
				'default'           => $options['post_excerpt']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );

		$wp_customize->add_control( 'my_framework_g_search_box_id', array(
				'label'    => $options['g_search_box_id']['name'],
				'section'  => 'my_framework_header',
				'settings' => 'non_cherry[g_search_box_id]',
				'type'     => $options['g_search_box_id']['type'],
				'choices'  => $options['g_search_box_id']['options']
		) );

	/*-----------------------------------------------------------------------------------*/
	/*	Logo
	/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'my_framework_logo', array(
				'title'    => __( 'Logo', 'non-cherry' ),
				'priority' => 201
		) );

		/* Logo Type */
		$wp_customize->add_setting( 'non_cherry[logo_type]', array(
				'default'           => $options['logo_type']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_logo_type', array(
				'label'    => $options['logo_type']['name'],
				'section'  => 'my_framework_logo',
				'settings' => 'non_cherry[logo_type]',
				'type'     => $options['logo_type']['type'],
				'choices'  => $options['logo_type']['options']
		) );

		/* Logo Path */
		$wp_customize->add_setting( 'non_cherry[logo_url]', array(
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'logo_url', array(
					'label'    => $options['logo_url']['name'],
					'section'  => 'my_framework_logo',
					'settings' => 'non_cherry[logo_url]'
		) ) );

	/*-----------------------------------------------------------------------------------*/
	/*	Slider
	/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'my_framework_slider', array(
				'title'    => __( 'Slider', 'non-cherry' ),
				'priority' => 202
		) );

		/* Auto slideshow */
		$wp_customize->add_setting( 'non_cherry[sl_slideshow]', array(
				'default'           => $options['sl_slideshow']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_sl_slideshow', array(
				'label'    => $options['sl_slideshow']['name'],
				'section'  => 'my_framework_slider',
				'settings' => 'non_cherry[sl_slideshow]',
				'type'     => $options['sl_slideshow']['type'],
				'choices'  => $options['sl_slideshow']['options']
		) );

		/* Pause time */
		$wp_customize->add_setting( 'non_cherry[sl_pausetime]', array(
				'default'           => $options['sl_pausetime']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_sl_pausetime', array(
				'label'    => $options['sl_pausetime']['name'],
				'section'  => 'my_framework_slider',
				'settings' => 'non_cherry[sl_pausetime]',
				'type'     => $options['sl_pausetime']['type']
		) );

		/* Slider Effect */
		$wp_customize->add_setting( 'non_cherry[sl_effect]', array(
				'default'           => $options['sl_effect']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_sl_effect', array(
				'label'    => $options['sl_effect']['name'],
				'section'  => 'my_framework_slider',
				'settings' => 'non_cherry[sl_effect]',
				'type'     => $options['sl_effect']['type'],
				'choices'  => $options['sl_effect']['options']
		) );

		/* Animation speed */
		$wp_customize->add_setting( 'non_cherry[sl_animation_speed]', array(
				'default'           => $options['sl_animation_speed']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_sl_animation_speed', array(
				'label'    => $options['sl_animation_speed']['name'],
				'section'  => 'my_framework_slider',
				'settings' => 'non_cherry[sl_animation_speed]',
				'type'     => $options['sl_animation_speed']['type']
		) );

		/* Display next & prev navigation? */
		$wp_customize->add_setting( 'non_cherry[sl_dir_nav]', array(
				'default'           => $options['sl_dir_nav']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_sl_dir_nav', array(
				'label'    => $options['sl_dir_nav']['name'],
				'section'  => 'my_framework_slider',
				'settings' => 'non_cherry[sl_dir_nav]',
				'type'     => $options['sl_dir_nav']['type'],
				'choices'  => $options['sl_dir_nav']['options']
		) );

		/* Show pagination? */
		$wp_customize->add_setting( 'non_cherry[sl_control_nav]', array(
				'default'           => $options['sl_control_nav']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_sl_control_nav', array(
				'label'    => $options['sl_control_nav']['name'],
				'section'  => 'my_framework_slider',
				'settings' => 'non_cherry[sl_control_nav]',
				'type'     => $options['sl_control_nav']['type'],
				'choices'  => $options['sl_control_nav']['options']
		) );

	/*-----------------------------------------------------------------------------------*/
	/*	Blog
	/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'my_framework_blog', array(
				'title'    => __( 'Blog', 'non-cherry' ),
				'priority' => 203
		) );

		/* Blog image size */
		$wp_customize->add_setting( 'non_cherry[post_image_size]', array(
				'default'           => $options['post_image_size']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_post_image_size', array(
				'label'    => $options['post_image_size']['name'],
				'section'  => 'my_framework_blog',
				'settings' => 'non_cherry[post_image_size]',
				'type'     => $options['post_image_size']['type'],
				'choices'  => $options['post_image_size']['options']
		) );

		/* Single post image size */
		$wp_customize->add_setting( 'non_cherry[single_image_size]', array(
				'default'           => $options['single_image_size']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_single_image_size', array(
				'label'    => $options['single_image_size']['name'],
				'section'  => 'my_framework_blog',
				'settings' => 'non_cherry[single_image_size]',
				'type'     => $options['single_image_size']['type'],
				'choices'  => $options['single_image_size']['options']
		) );

		/* Post Meta */
		$wp_customize->add_setting( 'non_cherry[post_meta]', array(
				'default'           => $options['post_meta']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_post_meta', array(
				'label'    => $options['post_meta']['name'],
				'section'  => 'my_framework_blog',
				'settings' => 'non_cherry[post_meta]',
				'type'     => $options['post_meta']['type']
		) );

		/* Post Excerpt */
		$wp_customize->add_setting( 'non_cherry[post_excerpt]', array(
				'default'           => $options['post_excerpt']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_post_excerpt', array(
				'label'    => $options['post_excerpt']['name'],
				'section'  => 'my_framework_blog',
				'settings' => 'non_cherry[post_excerpt]',
				'type'     => $options['post_excerpt']['type']
		) );

	/*-----------------------------------------------------------------------------------*/
	/*	Footer
	/*-----------------------------------------------------------------------------------*/

		$wp_customize->add_section( 'my_framework_footer', array(
				'title'    => __( 'Footer', 'non-cherry' ),
				'priority' => 204
		) );

		/* Footer Copyright Text */
		$wp_customize->add_setting( 'non_cherry[footer_text]', array(
				'default'           => $options['footer_text']['std'],
				'sanitize_callback' => 'esc_attr',
				'type'              => 'option'
		) );
		$wp_customize->add_control( 'my_framework_footer_text', array(
				'label'    => $options['footer_text']['name'],
				'section'  => 'my_framework_footer',
				'settings' => 'non_cherry[footer_text]',
				'type'     => 'textarea'
		) );
	};
}
