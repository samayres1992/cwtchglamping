<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('the_mounty_essential_grid_theme_setup9')) {
	add_action( 'after_setup_theme', 'the_mounty_essential_grid_theme_setup9', 9 );
	function the_mounty_essential_grid_theme_setup9() {
		
		add_filter( 'the_mounty_filter_merge_styles',						'the_mounty_essential_grid_merge_styles' );

		if (is_admin()) {
			add_filter( 'the_mounty_filter_tgmpa_required_plugins',		'the_mounty_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'the_mounty_essential_grid_tgmpa_required_plugins' ) ) {
	
	function the_mounty_essential_grid_tgmpa_required_plugins($list=array()) {
		if (the_mounty_storage_isset('required_plugins', 'essential-grid')) {
			$path = the_mounty_get_file_dir('plugins/essential-grid/essential-grid.zip');
			if (!empty($path) || the_mounty_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
						'name' 		=> the_mounty_storage_get_array('required_plugins', 'essential-grid'),
						'slug' 		=> 'essential-grid',
						'version'   => '3.0.16',
						'source'	=> !empty($path) ? $path : 'upload://essential-grid.zip',
						'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'the_mounty_exists_essential_grid' ) ) {
	function the_mounty_exists_essential_grid() {
		return defined('EG_PLUGIN_PATH') || defined( 'ESG_PLUGIN_PATH' );
	}
}
	
// Merge custom styles
if ( !function_exists( 'the_mounty_essential_grid_merge_styles' ) ) {
	
	function the_mounty_essential_grid_merge_styles($list) {
		if (the_mounty_exists_essential_grid()) {
			$list[] = 'plugins/essential-grid/_essential-grid.scss';
		}
		return $list;
	}
}
?>