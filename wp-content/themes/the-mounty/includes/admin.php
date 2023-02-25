<?php
/**
 * Admin utilities
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.1
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

// Theme init priorities:
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)

if ( !function_exists('the_mounty_admin_theme_setup') ) {
	add_action( 'after_setup_theme', 'the_mounty_admin_theme_setup' );
	function the_mounty_admin_theme_setup() {
		// Add theme icons
		add_action('admin_footer',	 						'the_mounty_admin_footer');

		// Enqueue scripts and styles for admin
		add_action("admin_enqueue_scripts",					'the_mounty_admin_scripts');
		add_action("admin_footer",							'the_mounty_admin_localize_scripts');
		
		// Show admin notice with control panel
		add_action('admin_notices',							'the_mounty_admin_notice');
		add_action('wp_ajax_the_mounty_hide_admin_notice',		'the_mounty_callback_hide_admin_notice');

		// Show admin notice with "Rate Us" panel
		add_action('after_switch_theme',					'the_mounty_save_activation_date');
		add_action('admin_notices',							'the_mounty_rate_notice');
		add_action('wp_ajax_the_mounty_hide_rate_notice',		'the_mounty_callback_hide_rate_notice');

		// TGM Activation plugin
		add_action('tgmpa_register',						'the_mounty_register_plugins');
	
		// Init internal admin messages
		the_mounty_init_admin_messages();
	}
}


//-------------------------------------------------------
//-- Welcome notice
//-------------------------------------------------------

// Show admin notice
if ( !function_exists( 'the_mounty_admin_notice' ) ) {
	
	function the_mounty_admin_notice() {
		if (in_array(the_mounty_get_value_gp('action'), array('vc_load_template_preview'))) return;
		if (the_mounty_get_value_gp('page') == 'the_mounty_about') return;
		if (!current_user_can('edit_theme_options')) return;
		$show = get_option('the_mounty_admin_notice');
		if ($show !== false && (int) $show == 0) return;
		get_template_part('templates/admin-notice');
	}
}

// Hide admin notice
if ( !function_exists( 'the_mounty_callback_hide_admin_notice' ) ) {
	
	function the_mounty_callback_hide_admin_notice() {
		update_option('the_mounty_admin_notice', '0');
		exit;
	}
}


//-------------------------------------------------------
//-- "Rate Us" notice
//-------------------------------------------------------

// Save activation date
if (!function_exists('the_mounty_save_activation_date')) {
	
	function the_mounty_save_activation_date() {
		$theme_time = (int) get_option( 'the_mounty_theme_activated' );
		if ($theme_time == 0) {
			$theme_slug = get_option( 'template' );
			$stylesheet_slug = get_option( 'stylesheet' );
			if ($theme_slug == $stylesheet_slug) {
				update_option('the_mounty_theme_activated', time());
			}
		}
	}
}

// Show Rate Us notice
if ( !function_exists( 'the_mounty_rate_notice' ) ) {
	
	function the_mounty_rate_notice() {
		if (in_array(the_mounty_get_value_gp('action'), array('vc_load_template_preview'))) return;
		if (!current_user_can('edit_theme_options')) return;
		// Display the message only on specified screens
		$allowed = array('dashboard', 'theme_options', 'trx_addons_options');
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if ( ( is_object($screen) && !empty($screen->id) && in_array($screen->id, $allowed) ) || in_array(the_mounty_get_value_gp('page'), $allowed) ) {
			$show = get_option('the_mounty_rate_notice');
			$start = get_option('the_mounty_theme_activated');
			if ( ($show !== false && (int) $show == 0) || ($start > 0 && (time()-$start)/(24*3600) < 14) ) return;
			get_template_part('templates/admin-rate');
		}
	}
}

// Hide rate notice
if ( !function_exists( 'the_mounty_callback_hide_rate_notice' ) ) {
	
	function the_mounty_callback_hide_rate_notice() {
		update_option('the_mounty_rate_notice', '0');
		exit;
	}
}


//-------------------------------------------------------
//-- Internal messages
//-------------------------------------------------------

// Init internal admin messages
if ( !function_exists( 'the_mounty_init_admin_messages' ) ) {
	function the_mounty_init_admin_messages() {
		$msg = get_option('the_mounty_admin_messages');
		if (is_array($msg))
			update_option('the_mounty_admin_messages', '');
		else
			$msg = array();
		the_mounty_storage_set('admin_messages', $msg);
	}
}

// Add internal admin message
if ( !function_exists( 'the_mounty_add_admin_message' ) ) {
	function the_mounty_add_admin_message($text, $type='success', $cur_session=false) {
		if (!empty($text)) {
			$new_msg = array('message' => $text, 'type' => $type);
			if ($cur_session) {
				the_mounty_storage_push_array('admin_messages', '', $new_msg);
			} else {
				$msg = get_option('the_mounty_admin_messages');
				if (!is_array($msg)) $msg = array();
				$msg[] = $new_msg;
				update_option('the_mounty_admin_messages', $msg);
			}
		}
	}
}

// Show internal admin messages
if ( !function_exists( 'the_mounty_show_admin_messages' ) ) {
	function the_mounty_show_admin_messages() {
		$msg = the_mounty_storage_get('admin_messages');
		if (!is_array($msg) || count($msg) == 0) return;
		?><div class="the_mounty_admin_messages"><?php
			foreach ($msg as $m) {
				?><div class="the_mounty_admin_message_item <?php echo esc_attr(str_replace('success', 'updated', $m['type'])); ?>">
					<p><?php echo wp_kses_data($m['message']); ?></p>
				</div><?php
			}
		?></div><?php
	}
}


//-------------------------------------------------------
//-- Styles and scripts
//-------------------------------------------------------
	
// Load inline styles
if ( !function_exists( 'the_mounty_admin_footer' ) ) {
	
	function the_mounty_admin_footer() {
		// Get current screen
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id=='nav-menus') {
			the_mounty_show_layout(the_mounty_show_custom_field('the_mounty_icons_popup',
													array(
														'type'	=> 'icons',
														'style'	=> the_mounty_get_theme_setting('icons_type'),
														'button'=> false,
														'icons'	=> true
													),
													null)
								);
		}
	}
}
	
// Load required styles and scripts for admin mode
if ( !function_exists( 'the_mounty_admin_scripts' ) ) {
	
	function the_mounty_admin_scripts() {

		// Add theme styles
		wp_enqueue_style(  'the-mounty-admin',  the_mounty_get_file_url('css/admin.css'), array(), null );

		// Links to selected fonts
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen)) {
			if (the_mounty_options_allow_override(!empty($screen->post_type) ? $screen->post_type : $screen->id)) {
				// Load font icons
				wp_enqueue_style(  'fontello-icons', the_mounty_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
				wp_enqueue_style(  'fontello-icons-animation', the_mounty_get_file_url('css/font-icons/css/animation.css'), array(), null );
				// Load theme fonts
				$links = the_mounty_theme_fonts_links();
				if (count($links) > 0) {
					foreach ($links as $slug => $link) {
						wp_enqueue_style( sprintf('the-mounty-font-%s', $slug), $link, array(), null );
					}
				}
			} else if (apply_filters('the_mounty_filter_allow_theme_icons', is_customize_preview() || $screen->id=='nav-menus', !empty($screen->post_type) ? $screen->post_type : $screen->id)) {
				// Load font icons
				wp_enqueue_style(  'fontello-icons', the_mounty_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			}
		}

		// Add theme scripts
		wp_enqueue_script( 'the-mounty-utils', the_mounty_get_file_url('js/theme-utils.js'), array('jquery'), null, true );
		wp_enqueue_script( 'the-mounty-admin', the_mounty_get_file_url('js/theme-admin.js'), array('jquery'), null, true );
	}
}
	
// Add variables in the admin mode
if ( !function_exists( 'the_mounty_admin_localize_scripts' ) ) {
	
	function the_mounty_admin_localize_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		wp_localize_script( 'the-mounty-admin', 'THE_MOUNTY_STORAGE', apply_filters( 'the_mounty_filter_localize_script_admin', array(
			'admin_mode' => true,
			'screen_id' => is_object($screen) ? esc_attr($screen->id) : '',
			'ajax_url' => esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce' => esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			'ajax_error_msg' => esc_html__('Server response error', 'the-mounty'),
			'icon_selector_msg' => esc_html__('Select the icon for this menu item', 'the-mounty'),
			'scheme_reset_msg' => esc_html__('Reset all changes of the current color scheme?', 'the-mounty'),
			'scheme_copy_msg' => esc_html__('Enter the name for a new color scheme', 'the-mounty'),
			'scheme_delete_msg' => esc_html__('Do you really want to delete the current color scheme?', 'the-mounty'),
			'scheme_delete_last_msg' => esc_html__('You cannot delete the last color scheme!', 'the-mounty'),
			'scheme_delete_internal_msg' => esc_html__('You cannot delete the built-in color scheme!', 'the-mounty'),
			'user_logged_in' => true
			))
		);
	}
}



//-------------------------------------------------------
//-- Third party plugins
//-------------------------------------------------------

// Register optional plugins
if ( !function_exists( 'the_mounty_register_plugins' ) ) {
	
	function the_mounty_register_plugins() {
		tgmpa(	apply_filters('the_mounty_filter_tgmpa_required_plugins', array(
				// Plugins to include in the autoinstall queue.
				)),
				array(
					'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
					'default_path' => '',                      // Default absolute path to bundled plugins.
					'menu'         => 'tgmpa-install-plugins', // Menu slug.
					'parent_slug'  => 'themes.php',            // Parent menu slug.
					'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
					'has_notices'  => true,                    // Show admin notices or not.
					'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
					'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
					'is_automatic' => false,                   // Automatically activate plugins after installation or not.
					'message'      => ''                       // Message to output right before the plugins table.
				)
			);
	}
}
?>