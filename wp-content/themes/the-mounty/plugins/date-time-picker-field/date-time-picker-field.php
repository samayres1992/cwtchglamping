<?php
/* Date & Time Picker support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'the_mounty_date_time_picker_field_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'the_mounty_date_time_picker_field_theme_setup9', 9 );
	function the_mounty_date_time_picker_field_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'the_mounty_filter_tgmpa_required_plugins', 'the_mounty_date_time_picker_field_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'the_mounty_date_time_picker_field_tgmpa_required_plugins' ) ) {
		
		function the_mounty_date_time_picker_field_tgmpa_required_plugins( $list = array() ) {
		if ( the_mounty_storage_isset( 'required_plugins', 'date-time-picker-field' ) ) {
			$list[] = array(
				'name'     => the_mounty_storage_get_array( 'required_plugins', 'date-time-picker-field' ),
				'slug'     => 'date-time-picker-field',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'the_mounty_exists_date_time_picker_field' ) ) {
	function the_mounty_exists_date_time_picker_field() {
		return class_exists( 'CMoreira\\Plugins\\DateTimePicker\\Init' );
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'the_mounty_date_time_picker_field_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'the_mounty_date_time_picker_field_importer_set_options' );
	function the_mounty_date_time_picker_field_importer_set_options($options=array()) {
		if ( the_mounty_exists_date_time_picker_field() && in_array('date-time-picker-field', $options['required_plugins']) ) {
			if (is_array($options)) {
				$options['additional_options'][] = 'dtpicker';
			}
		}
		return $options;
	}
}
