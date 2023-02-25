<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('the_mounty_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'the_mounty_cf7_theme_setup9', 9 );
	function the_mounty_cf7_theme_setup9() {
		
		add_filter( 'the_mounty_filter_merge_scripts',	'the_mounty_cf7_merge_scripts');
		add_filter( 'the_mounty_filter_merge_styles',	'the_mounty_cf7_merge_styles' );

		if (the_mounty_exists_cf7()) {
			add_action( 'wp_enqueue_scripts',		'the_mounty_cf7_frontend_scripts', 1100 );
		}

		if (is_admin()) {
			add_filter( 'the_mounty_filter_tgmpa_required_plugins',	'the_mounty_cf7_tgmpa_required_plugins' );
		}
		
		add_filter('deprecated_function_trigger_error', function() { return false; } );
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'the_mounty_cf7_tgmpa_required_plugins' ) ) {
	
	function the_mounty_cf7_tgmpa_required_plugins($list=array()) {
		if (the_mounty_storage_isset('required_plugins', 'contact-form-7')) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> the_mounty_storage_get_array('required_plugins', 'contact-form-7'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if cf7 installed and activated
if ( !function_exists( 'the_mounty_exists_cf7' ) ) {
	function the_mounty_exists_cf7() {
		return class_exists('WPCF7');
	}
}

// Enqueue custom scripts
if ( !function_exists( 'the_mounty_cf7_frontend_scripts' ) ) {
	
	function the_mounty_cf7_frontend_scripts() {
		if (the_mounty_exists_cf7()) {
			if (the_mounty_is_on(the_mounty_get_theme_option('debug_mode')) && the_mounty_get_file_dir('plugins/contact-form-7/contact-form-7.js')!='')
				wp_enqueue_script( 'the-mounty-cf7', the_mounty_get_file_url('plugins/contact-form-7/contact-form-7.js'), array('jquery'), null, true );
		}
	}
}
	
// Merge custom scripts
if ( !function_exists( 'the_mounty_cf7_merge_scripts' ) ) {
	
	function the_mounty_cf7_merge_scripts($list) {
		if (the_mounty_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/contact-form-7.js';
		}
		return $list;
	}
}

// Merge custom styles
if ( !function_exists( 'the_mounty_cf7_merge_styles' ) ) {
	
	function the_mounty_cf7_merge_styles($list) {
		if (the_mounty_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/_contact-form-7.scss';
		}
		return $list;
	}
}
?>