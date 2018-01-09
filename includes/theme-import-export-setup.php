<?php
/**
* Actions, filters, and functiotions required for data import/export
*/
add_filter('cherry_data_manager_export_options', 'theme_data_manager_export_options');
function theme_data_manager_export_options( $opts = array() ){
	return $opts;
}
// Adding import/export operations for Types plugin
add_action( 'admin_init', 'theme_setup_import_export' );
function theme_setup_import_export(){
	if( !( is_plugin_active('cherry-data-manager/cherry-data-manager.php') && is_plugin_active('types/wpcf.php') ) )
		return;
	add_action( 'wp_ajax_cherry_data_manager_export', 'theme_types_export', 0 );
	add_action( 'wp_ajax_import_xml', 'theme_types_import', 0);
}
// Export Types
function theme_types_export(){
	require_once WPCF_EMBEDDED_INC_ABSPATH . '/import-export.php';
	$data = wpcf_admin_export_selected_data( array(), 'all', 'xml' );
	$upload_dir      = wp_upload_dir();
	$upload_base_dir = $upload_dir['basedir'];
	$data_path = $upload_base_dir . '/types_data.dat';
	global $wp_filesystem;
	if( !$wp_filesystem ){
		WP_Filesystem();
	}
	$wp_filesystem->put_contents($data_path, $data, 'w');
}
// Import Types
function theme_types_import(){
	require_once WPCF_EMBEDDED_INC_ABSPATH . '/module-manager.php';
	require_once WPCF_EMBEDDED_INC_ABSPATH . '/import-export.php';
	$upload_dir  = wp_upload_dir();
	$upload_path = $upload_dir['path'];
	$data_path = $upload_path . '/types_data.dat';
	if( file_exists( $data_path ) ){
		global $wp_filesystem;
		if( !$wp_filesystem ){
			WP_Filesystem();
		}
		$data = $wp_filesystem->get_contents($data_path);
		theme_import_wpcf_data( $data );
	}
}
// Parsing Types data(XML)
function theme_import_wpcf_data( $data = '' ){
	global $wpdb;
	libxml_use_internal_errors( true );
	$data = simplexml_load_string( $data );
	if ( !$data ) {
		echo '<div class="message error"><p>' . __( 'Error parsing XML', 'non-cherry' ) . '</p></div>';
		foreach ( libxml_get_errors() as $error ) {
			echo '<div class="message error"><p>' . $error->message . '</p></div>';
		}
		libxml_clear_errors();
		return false;
	}
	/**
	* Process settings
	*/
	if ( isset( $data->settings ) ) {
		$wpcf_settings = wpcf_get_settings();
		foreach( wpcf_admin_import_export_simplexml2array( $data->settings ) as $key => $value ) {
			$wpcf_settings[$key] =  $value;
		}
		wpcf_save_settings( $wpcf_settings );
	}
	/**
	* Process groups
	*/
	$groups_check = array();
	if ( !empty( $data->groups ) ) {
		$groups = array();
		/**
		* Set insert data from XML
		*/
		foreach ( $data->groups->group as $group ) {
			$group = wpcf_admin_import_export_simplexml2array( $group );
			$groups[$group['ID']] = $group;
		}
		foreach ( $groups as $group_id => $group ) {
			$groups[$group_id]['add'] = true;
			$groups[$group_id]['update'] = true;
		}
		/**
		* Insert groups
		*/
		$show_import_fail_version_message = true;
		foreach ( $groups as $group_id => $group ) {
			$post = array(
				'post_status' => $group['post_status'],
				'post_type' => TYPES_CUSTOM_FIELD_GROUP_CPT_NAME,
				'post_title' => $group['post_title'],
				'post_content' => !empty( $group['post_content'] ) ? $group['post_content'] : '',
			);
			if ( array_key_exists( '__types_id', $group ) ) {
				$post['post_name'] = $group['__types_id'];
			}
			$post_to_update = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = %s", $group['post_title'], TYPES_CUSTOM_FIELD_GROUP_CPT_NAME ));
			// Update (may be forced by bulk action)
			if ( !empty( $post_to_update ) ) {
				$post['ID'] = $post_to_update;
				$group_wp_id = wp_update_post( $post );
			} else {
				$group_wp_id = wp_insert_post( $post, true );
			}
			// Update meta
			if ( !empty( $group['meta'] ) ) {
				foreach ( $group['meta'] as $meta_key => $meta_value ) {
					if ( '_wpcf_conditional_display' == $meta_key ) {
						if ( !empty($meta_value) ) {
							$meta_value = wpcf_admin_import_export_simplexml2array( $meta_value );
						}
					}
					update_post_meta( $group_wp_id, $meta_key, $meta_value );
				}
			}
		}
	}
	/**
	* Process fields
	*/
	$fields_existing = wpcf_admin_fields_get_fields();
	$fields = array();
	if ( !empty( $data->fields ) ) {
		// Set insert data from XML
		foreach ( $data->fields->field as $field ) {
			$field = wpcf_admin_import_export_simplexml2array( $field );
			$fields[$field['id']] = $field;
		}
		// Insert fields
		foreach ( $fields as $field_id => $field ) {
			if ( empty( $field['id'] ) || empty( $field['name'] ) || empty( $field['slug'] ) ) {
				continue;
			}
			$field_data = array();
			$field_data['description'] = isset( $field['description'] ) ? $field['description'] : '';
			$field_data['data'] = (isset( $field['data'] ) && is_array( $field['data'] )) ? $field['data'] : array();
			foreach( array( 'id', 'name', 'type', 'slug', 'meta_key', 'meta_type' ) as $key ) {
				if ( array_key_exists( $key, $field ) ) {
					$field_data[$key] = $field[$key];
				}
			}
			$fields_existing[$field_id] = $field_data;
			// WPML
			global $iclTranslationManagement;
			if ( !empty( $iclTranslationManagement ) && isset( $field['wpml_action'] ) ) {
				$iclTranslationManagement->settings['custom_fields_translation'][wpcf_types_get_meta_prefix( $field ) . $field_id] = $field['wpml_action'];
				$iclTranslationManagement->save_settings();
			}
		}
	}
	update_option( 'wpcf-fields', $fields_existing );
	/**
	* Process user groups
	*/
	if ( !empty( $data->user_groups ) && isset( $data->user_groups->group) ) {
		$groups = array();
		// Set insert data from XML
		foreach ( $data->user_groups->group as $group ) {
			$group = wpcf_admin_import_export_simplexml2array( $group );
			$groups[$group['ID']] = $group;
		}
		// Insert groups
		foreach ( $groups as $group_id => $group ) {
			$post = array(
				'post_status' => $group['post_status'],
				'post_type' => TYPES_USER_META_FIELD_GROUP_CPT_NAME,
				'post_title' => $group['post_title'],
				'post_content' => !empty( $group['post_content'] ) ? $group['post_content'] : '',
			);
			$post_to_update = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = %s", $group['post_title'], TYPES_USER_META_FIELD_GROUP_CPT_NAME ));
			// Update
			if ( !empty( $post_to_update ) ) {
				$post['ID'] = $post_to_update;
				$group_wp_id = wp_update_post( $post );
			} else {
				$group_wp_id = wp_insert_post( $post, true );
			}
			// Update meta
			if ( !empty( $group['meta'] ) ) {
				foreach ( $group['meta'] as $meta_key => $meta_value ) {
					update_post_meta( $group_wp_id, $meta_key, wpcf_admin_import_export_simplexml2array( $meta_value ) );
				}
			}
		}
	}
	/**
	* Process fields
	*/
	$fields_existing = wpcf_admin_fields_get_fields( false, false, false, 'wpcf-usermeta' );
	if ( !empty( $data->user_fields ) ) {
		$fields = array();
		// Set insert data from XML
		foreach ( $data->user_fields->field as $field ) {
			$field = wpcf_admin_import_export_simplexml2array( $field );
			$fields[$field['id']] = $field;
		}
		// Insert fields
		foreach ( $fields as $field_id => $field ) {
			if ( empty( $field['id'] ) || empty( $field['name'] ) || empty( $field['slug'] ) ) {
				continue;
			}
			$field_data = array();
			$field_data['id'] = $field['id'];
			$field_data['name'] = $field['name'];
			$field_data['description'] = isset( $field['description'] ) ? $field['description'] : '';
			$field_data['type'] = $field['type'];
			$field_data['slug'] = $field['slug'];
			$field_data['data'] = (isset( $field['data'] ) && is_array( $field['data'] )) ? $field['data'] : array();
			$fields_existing[$field_id] = $field_data;
			// WPML
			global $iclTranslationManagement;
			if ( !empty( $iclTranslationManagement ) && isset( $field['wpml_action'] ) ) {
				$iclTranslationManagement->settings['custom_fields_translation'][wpcf_types_get_meta_prefix( $field ) . $field_id] = $field['wpml_action'];
				$iclTranslationManagement->save_settings();
			}
		}
	}
	update_option( 'wpcf-usermeta', $fields_existing );
	/**
	* Process types
	*/
	$types_existing = get_option( WPCF_OPTION_NAME_CUSTOM_TYPES, array() );
	if ( !empty($data->types) && isset($data->types->type) ) {
		$types = array();
		// Set insert data from XML
		foreach ( $data->types->type as $type ) {
			$type = wpcf_admin_import_export_simplexml2array( $type );
			$types[$type['id']] = $type;
		}
		// Insert types
		foreach ( $types as $type_id => $type ) {
			$types_existing[$type_id] = $type;
		}
	}
	update_option( WPCF_OPTION_NAME_CUSTOM_TYPES, $types_existing );
	/**
	* Process taxonomies
	*/
	$taxonomies_existing = get_option( WPCF_OPTION_NAME_CUSTOM_TAXONOMIES, array() );
	if ( !empty( $data->taxonomies ) && isset( $data->taxonomies->taxonomy )) {
		$taxonomies = array();
		// Set insert data from XML
		foreach ( $data->taxonomies->taxonomy as $taxonomy ) {
			$taxonomy = wpcf_admin_import_export_simplexml2array( $taxonomy );
			$taxonomy = apply_filters( 'wpcf_filter_import_custom_taxonomy', $taxonomy );
			$taxonomies[$taxonomy['id']] = $taxonomy;
		}
		// Insert taxonomies
		foreach ( $taxonomies as $taxonomy_id => $taxonomy ) {
			$taxonomies_existing[$taxonomy_id] = $taxonomy;
		}
	}
	/**
	 * reset TOOLSET_EDIT_LAST
	 */
	if ( $data_installer ) {
		$data_installer->reset_toolset_edit_last();
	}
	update_option( WPCF_OPTION_NAME_CUSTOM_TAXONOMIES, $taxonomies_existing );
	/**
	* Add relationships
	*/
	if ( !empty( $data->post_relationships ) ) {
		$relationship_existing = get_option( 'wpcf_post_relationship', array() );
		/**
		 * be sure, $relationship_existing is a array!
		 */
		if ( !is_array( $relationship_existing ) ) {
			$relationship_existing = array();
		}
		$relationship = json_decode( $data->post_relationships->data, true );
		if ( is_array( $relationship ) ) {
			$relationship = array_merge( $relationship_existing, $relationship );
			update_option( 'wpcf_post_relationship', $relationship );
		}
	}
	// WPML bulk registration
	if ( wpcf_get_settings( 'register_translations_on_import' ) ) {
		wpcf_admin_bulk_string_translation();
	}
	// Flush rewrite rules
	wpcf_init_custom_types_taxonomies();
	flush_rewrite_rules();
}
