<?php
// register plugin for TGM activator
require_once( PARENT_DIR . '/includes/classes/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'cherryone_register_plugins' );
function cherryone_register_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = array(
		array(
			'name'         => 'Cherry Shortcodes Templater',
			'slug'         => 'cherry-shortcodes-templater',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-shortcodes-templater',
		),
		array(
			'name'         => 'Cherry Shortcodes',
			'slug'         => 'cherry-shortcodes',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-shortcodes',
		),
		array(
			'name'         => 'Cherry Data Manager',
			'slug'         => 'cherry-data-manager',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-data-manager',
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => true
		),
		array(
			'name'         => 'Toolset Types',
			'slug'         => 'types',
			'required'     => true,
		),
		array(
			'name'         => 'Advanced Custom Fields',
			'slug'         => 'advanced-custom-fields',
			'required'     => true,
			'external_url' => 'https://wordpress.org/plugins/advanced-custom-fields/',
		),
		/*array(
			'name'         => 'Cherry Testimonials',
			'slug'         => 'cherry-testimonials',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-testimonials',
		),*/
		/*array(
			'name'         => 'Cherry Team',
			'slug'         => 'cherry-team',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-team',
		),*/
		/*array(
			'name'         => 'Cherry Social',
			'slug'         => 'cherry-social',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-social',
		),*/
		/*array(
			'name'         => 'Cherry Simple Slider',
			'slug'         => 'cherry-simple-slider',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-simple-slider',
		),*/
		/*array(
			'name'         => 'Cherry Portfolio',
			'slug'         => 'cherry-portfolio',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-portfolio',
		),*/
		/*array(
			'name'         => 'Cherry grid',
			'slug'         => 'cherry-grid',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-grid',
		),*/
		/*array(
			'name'         => 'Cherry Charts',
			'slug'         => 'cherry-charts',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-charts',
		),*/
		/*array(
			'name'         => 'Cherry Services',
			'slug'         => 'cherry-services',
			'source'       => 'cherry-free',
			'required'     => true,
			'external_url' => 'https://github.com/CherryFramework/cherry-services',
		),*/
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'non-cherry' ),
			'menu_title'                      => __( 'Install Plugins', 'non-cherry' ),
			'installing'                      => __( 'Installing Plugin: %s', 'non-cherry' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'non-cherry' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'non-cherry' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'non-cherry' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'non-cherry' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'non-cherry' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'non-cherry' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'non-cherry' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'non-cherry' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'non-cherry' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'non-cherry' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'non-cherry' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'non-cherry' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'non-cherry' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'non-cherry' ), // %s = dashboard link.
			'nag_type'                        => 'updated'
		)
	);

	tgmpa( $plugins, $config );

}