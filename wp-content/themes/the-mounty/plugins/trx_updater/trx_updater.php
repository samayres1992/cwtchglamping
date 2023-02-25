<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'the_mounty_trx_updater_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'the_mounty_trx_updater_theme_setup9', 9 );
    function the_mounty_trx_updater_theme_setup9() {
        if ( is_admin() ) {
            add_filter( 'the_mounty_filter_tgmpa_required_plugins', 'the_mounty_trx_updater_tgmpa_required_plugins', 8 );
        }
    }
}


// Filter to add in the required plugins list
if ( ! function_exists( 'the_mounty_trx_updater_tgmpa_required_plugins' ) ) {
    
    function the_mounty_trx_updater_tgmpa_required_plugins( $list = array() ) {
        if ( the_mounty_storage_isset( 'required_plugins', 'trx_updater' ) ) {
            $path = the_mounty_get_file_dir( 'plugins/trx_updater/trx_updater.zip' );
            if ( ! empty( $path ) || the_mounty_get_theme_setting( 'tgmpa_upload' ) ) {
                $list[] = array(
                    'name'     => the_mounty_storage_get_array( 'required_plugins', 'trx_updater' ),
                    'slug'     => 'trx_updater',
                    'version'  => '2.0.0',
                    'source'   => ! empty( $path ) ? $path : 'upload://trx_updater.zip',
                    'required' => false,
                );
            }
        }
        return $list;
    }
}


// Check if plugin installed and activated
if ( ! function_exists( 'the_mounty_exists_trx_updater' ) ) {
    function the_mounty_exists_trx_updater() {
        return defined( 'TRX_UPDATER_VERSION' );
    }
}
