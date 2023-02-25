<?php
/* Tribe Events Calendar support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('the_mounty_tribe_events_theme_setup1')) {
	add_action( 'after_setup_theme', 'the_mounty_tribe_events_theme_setup1', 1 );
	function the_mounty_tribe_events_theme_setup1() {
		add_filter( 'the_mounty_filter_list_sidebars', 'the_mounty_tribe_events_list_sidebars' );
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('the_mounty_tribe_events_theme_setup3')) {
	add_action( 'after_setup_theme', 'the_mounty_tribe_events_theme_setup3', 3 );
	function the_mounty_tribe_events_theme_setup3() {
		if (the_mounty_exists_tribe_events()) {
		
			// Section 'Tribe Events'
			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'events' => array(
						"title" => esc_html__('Events', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the events pages', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_options_get_list_cpt_options('events')
			));
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('the_mounty_tribe_events_theme_setup9')) {
	add_action( 'after_setup_theme', 'the_mounty_tribe_events_theme_setup9', 9 );
	function the_mounty_tribe_events_theme_setup9() {
		
		add_filter( 'the_mounty_filter_merge_styles',							'the_mounty_tribe_events_merge_styles' );
		add_filter( 'the_mounty_filter_merge_styles_responsive',				'the_mounty_tribe_events_merge_styles_responsive' );

		if (the_mounty_exists_tribe_events()) {
			add_filter( 'the_mounty_filter_post_type_taxonomy',				'the_mounty_tribe_events_post_type_taxonomy', 10, 2 );
			if (!is_admin()) {
				add_filter( 'the_mounty_filter_detect_blog_mode',				'the_mounty_tribe_events_detect_blog_mode' );
				add_filter( 'the_mounty_filter_get_post_categories', 			'the_mounty_tribe_events_get_post_categories');
				add_filter( 'the_mounty_filter_get_post_date',		 			'the_mounty_tribe_events_get_post_date');
			}
		}
		if (is_admin()) {
			add_filter( 'the_mounty_filter_tgmpa_required_plugins',			'the_mounty_tribe_events_tgmpa_required_plugins' );
		}

	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'the_mounty_tribe_events_tgmpa_required_plugins' ) ) {
	
	function the_mounty_tribe_events_tgmpa_required_plugins($list=array()) {
		if (the_mounty_storage_isset('required_plugins', 'the-events-calendar')) {
			$list[] = array(
					'name' 		=> the_mounty_storage_get_array('required_plugins', 'the-events-calendar'),
					'slug' 		=> 'the-events-calendar',
					'required' 	=> false
				);
		}
		return $list;
	}
}


// Remove 'Tribe Events' section from Customizer
if (!function_exists('the_mounty_tribe_events_customizer_register_controls')) {
	add_action( 'customize_register', 'the_mounty_tribe_events_customizer_register_controls', 100 );
	function the_mounty_tribe_events_customizer_register_controls( $wp_customize ) {
		$wp_customize->remove_panel( 'tribe_customizer');
	}
}


// Check if Tribe Events is installed and activated
if ( !function_exists( 'the_mounty_exists_tribe_events' ) ) {
	function the_mounty_exists_tribe_events() {
		return class_exists( 'Tribe__Events__Main' );
	}
}

// Return true, if current page is any tribe_events page
if ( !function_exists( 'the_mounty_is_tribe_events_page' ) ) {
	function the_mounty_is_tribe_events_page() {
		$rez = false;
		if (the_mounty_exists_tribe_events())
			if (!is_search()) $rez = tribe_is_event() || tribe_is_event_query() || tribe_is_event_category() || tribe_is_event_venue() || tribe_is_event_organizer();
		return $rez;
	}
}

// Detect current blog mode
if ( !function_exists( 'the_mounty_tribe_events_detect_blog_mode' ) ) {
	
	function the_mounty_tribe_events_detect_blog_mode($mode='') {
		if (the_mounty_is_tribe_events_page())
			$mode = 'events';
		return $mode;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'the_mounty_tribe_events_post_type_taxonomy' ) ) {
	
	function the_mounty_tribe_events_post_type_taxonomy($tax='', $post_type='') {
		if (the_mounty_exists_tribe_events() && $post_type == Tribe__Events__Main::POSTTYPE)
			$tax = Tribe__Events__Main::TAXONOMY;
		return $tax;
	}
}

// Show categories of the current event
if ( !function_exists( 'the_mounty_tribe_events_get_post_categories' ) ) {
	
	function the_mounty_tribe_events_get_post_categories($cats='') {
		if (get_post_type() == Tribe__Events__Main::POSTTYPE)
			$cats = the_mounty_get_post_terms(', ', get_the_ID(), Tribe__Events__Main::TAXONOMY);
		return $cats;
	}
}

// Return date of the current event
if ( !function_exists( 'the_mounty_tribe_events_get_post_date' ) ) {
	
	function the_mounty_tribe_events_get_post_date($dt='') {
		if (get_post_type() == Tribe__Events__Main::POSTTYPE) {
			$dt = tribe_events_event_schedule_details( get_the_ID(), '', '' );
		}
		return $dt;
	}
}

// Merge custom styles
if ( !function_exists( 'the_mounty_tribe_events_merge_styles' ) ) {
	
	function the_mounty_tribe_events_merge_styles($list) {
		if (the_mounty_exists_tribe_events()) {
			$list[] = 'plugins/the-events-calendar/_the-events-calendar.scss';
		}
		return $list;
	}
}


// Merge responsive styles
if ( !function_exists( 'the_mounty_tribe_events_merge_styles_responsive' ) ) {
	
	function the_mounty_tribe_events_merge_styles_responsive($list) {
		if (the_mounty_exists_tribe_events()) {
			$list[] = 'plugins/the-events-calendar/_the-events-calendar-responsive.scss';
		}
		return $list;
	}
}



// Add Tribe Events specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( !function_exists( 'the_mounty_tribe_events_list_sidebars' ) ) {
	
	function the_mounty_tribe_events_list_sidebars($list=array()) {
		$list['tribe_events_widgets'] = array(
											'name' => esc_html__('Tribe Events Widgets', 'the-mounty'),
											'description' => esc_html__('Widgets to be shown on the Tribe Events pages', 'the-mounty')
											);
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (the_mounty_exists_tribe_events()) { require_once THE_MOUNTY_THEME_DIR . 'plugins/the-events-calendar/the-events-calendar-styles.php'; }
?>