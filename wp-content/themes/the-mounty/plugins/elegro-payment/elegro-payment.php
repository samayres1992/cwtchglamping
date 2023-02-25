<?php
/* elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'the_mounty_elegro_payment_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'the_mounty_elegro_payment_theme_setup9', 9 );
    function the_mounty_elegro_payment_theme_setup9() {
        if ( is_admin() ) {
            add_filter( 'the_mounty_filter_tgmpa_required_plugins', 'the_mounty_elegro_payment_tgmpa_required_plugins' );
        }
        if ( the_mounty_exists_elegro_payment() ) {
            add_filter( 'the_mounty_filter_merge_styles', 'the_mounty_elegro_payment_merge_styles' );
        }
    }
}


// Filter to add in the required plugins list
if ( ! function_exists( 'the_mounty_elegro_payment_tgmpa_required_plugins' ) ) {
	
	function the_mounty_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( the_mounty_storage_isset( 'required_plugins', 'elegro-payment' ) ) {
			$list[] = array(
				'name'     => the_mounty_storage_get_array( 'required_plugins', 'elegro-payment' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'the_mounty_exists_elegro_payment' ) ) {
    function the_mounty_exists_elegro_payment() {
        return class_exists( 'WC_Elegro_Payment' );
    }
}

// Merge custom styles
if ( !function_exists( 'the_mounty_elegro_payment_merge_styles' ) ) {
    
    function the_mounty_elegro_payment_merge_styles($list) {
        if (the_mounty_exists_elegro_payment()) {
            $list[] = 'plugins/elegro-payment/_elegro-payment.scss';
        }
        return $list;
    }
}