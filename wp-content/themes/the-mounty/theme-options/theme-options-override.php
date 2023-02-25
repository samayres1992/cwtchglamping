<?php
/**
 * Theme Options and override-options support
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.29
 */


// -----------------------------------------------------------------
// -- Override-options
// -----------------------------------------------------------------

if ( !function_exists('the_mounty_init_override') ) {
	add_action( 'after_setup_theme', 'the_mounty_init_override' );
	function the_mounty_init_override() {
		if ( is_admin() ) {
			add_action("admin_enqueue_scripts", 'the_mounty_add_override_scripts');
			add_action('save_post',			'the_mounty_save_override');
			add_filter( 'the_mounty_filter_override_options', 'the_mounty_options_override_add_options' );

		}
	}
}

// Check if override options is allow
if (!function_exists('the_mounty_options_allow_override')) {
	function the_mounty_options_allow_override($post_type) {
		return apply_filters('the_mounty_filter_allow_override_options', in_array($post_type, array('page', 'post')), $post_type);
	}
}


// Load required styles and scripts for admin mode
if ( !function_exists( 'the_mounty_add_override_scripts' ) ) {
	add_action("admin_enqueue_scripts", 'the_mounty_add_override_scripts');
	function the_mounty_add_override_scripts() {
		// If current screen is 'Edit Page' - load font icons
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && the_mounty_options_allow_override(!empty($screen->post_type) ? $screen->post_type : $screen->id)) {
			wp_enqueue_style( 'fontello-icons',  the_mounty_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'the-mounty-options', the_mounty_get_file_url('theme-options/theme-options.js'), array('jquery'), null, true );
			wp_localize_script( 'the-mounty-options', 'the_mounty_dependencies', the_mounty_get_theme_dependencies() );
		}
	}
}


// Check if override options is allow
if (!function_exists('the_mounty_options_allow_override')) {
	function the_mounty_options_allow_override($post_type) {
		return apply_filters('the_mounty_filter_allow_override_options', in_array($post_type, array('page', 'post')), $post_type);
	}
}


// Add overriden options
if (!function_exists('the_mounty_options_override_add_options')) {
	add_filter('the_mounty_filter_override_options', 'the_mounty_options_override_add_options');
	function the_mounty_options_override_add_options($list) {
        global $post_type;
        if (the_mounty_options_allow_override($post_type)) {
            $list[] = array(sprintf('the_mounty_override_options_%s', $post_type),
                esc_html__('Theme Options', 'the-mounty'),
                'the_mounty_show_override',
                $post_type,
                $post_type=='post' ? 'side' : 'advanced',
                'default'
            );
        }
        return $list;
    }
}

// Callback function to show fields in override options
if (!function_exists('the_mounty_show_override')) {
	function the_mounty_show_override($post=false, $args=false) {
		if (empty($post) || !is_object($post) || empty($post->ID)) {
			global $post, $post_type;
			$mb_post_id = $post->ID;
			$mb_post_type = $post_type;
		} else {
			$mb_post_id = $post->ID;
			$mb_post_type = $post->post_type;
		}
		if (the_mounty_options_allow_override($mb_post_type)) {
			// Load saved options 
			$meta = get_post_meta($mb_post_id, 'the_mounty_options', true);
			$tabs_titles = $tabs_content = array();
			global $THE_MOUNTY_STORAGE;
			// Refresh linked data if this field is controller for the another (linked) field
			// Do this before show fields to refresh data in the $THE_MOUNTY_STORAGE
			foreach ($THE_MOUNTY_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $mb_post_type)===false) continue;
				if (!empty($v['linked'])) {
					$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
					if (!empty($v['val']) && !the_mounty_is_inherit($v['val']))
						the_mounty_refresh_linked_data($v['val'], $v['linked']);
				}
			}
			// Show fields
			foreach ($THE_MOUNTY_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $mb_post_type)===false || $v['type'] == 'hidden') continue;
				if (empty($v['override']['section']))
					$v['override']['section'] = esc_html__('General', 'the-mounty');
				if (!isset($tabs_titles[$v['override']['section']])) {
					$tabs_titles[$v['override']['section']] = $v['override']['section'];
					$tabs_content[$v['override']['section']] = '';
				}
				$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
				$tabs_content[$v['override']['section']] .= the_mounty_options_show_field($k, $v, $mb_post_type);
			}
			if (count($tabs_titles) > 0) {
				?>
				<div class="the_mounty_options the_mounty_override">
					<input type="hidden" name="override_options_post_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
					<input type="hidden" name="override_options_post_type" value="<?php echo esc_attr($mb_post_type); ?>" />
					<div id="the_mounty_options_tabs" class="the_mounty_tabs">
						<ul><?php
							$cnt = 0;
							foreach ($tabs_titles as $k=>$v) {
								$cnt++;
								?><li><a href="#the_mounty_options_<?php echo esc_attr($cnt); ?>"><?php echo esc_html($v); ?></a></li><?php
							}
						?></ul>
						<?php
							$cnt = 0;
							foreach ($tabs_content as $k=>$v) {
								$cnt++;
								?>
								<div id="the_mounty_options_<?php echo esc_attr($cnt); ?>" class="the_mounty_tabs_section the_mounty_options_section">
									<?php the_mounty_show_layout($v); ?>
								</div>
								<?php
							}
						?>
					</div>
				</div>
				<?php		
			}
		}
	}
}


// Save data from override options
if (!function_exists('the_mounty_save_override')) {
	
	function the_mounty_save_override($post_id) {

		// verify nonce
		if ( !wp_verify_nonce( the_mounty_get_value_gp('override_options_post_nonce'), admin_url() ) )
			return $post_id;

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		$post_type = wp_kses_data(wp_unslash(isset($_POST['override_options_post_type']) ? $_POST['override_options_post_type'] : $_POST['post_type']));

		// check permissions
		$capability = 'page';
		$post_types = get_post_types( array( 'name' => $post_type), 'objects' );
		if (!empty($post_types) && is_array($post_types)) {
			foreach ($post_types  as $type) {
				$capability = $type->capability_type;
				break;
			}
		}
		if (!current_user_can('edit_'.($capability), $post_id)) {
			return $post_id;
		}

		// Save meta
		$meta = array();
		$options = the_mounty_storage_get('options');
		foreach ($options as $k=>$v) {
			// Skip not overriden options
			if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
			// Skip inherited options
			if (!empty($_POST["the_mounty_options_inherit_{$k}"])) continue;
			// Skip hidden options
			if (!isset($_POST["the_mounty_options_field_{$k}"]) && $v['type']=='hidden') continue;
			// Get option value from POST
			$meta[$k] = isset($_POST["the_mounty_options_field_{$k}"])
							? the_mounty_get_value_gp("the_mounty_options_field_{$k}")
							: ($v['type']=='checkbox' ? 0 : '');
		}
		$meta = apply_filters( 'the_mounty_filter_update_post_meta', $meta, $post_id );
		update_post_meta($post_id, 'the_mounty_options', $meta);
		
		// Save separate meta options to search template pages
		if ($post_type=='page' && !empty($_POST['page_template']) && $_POST['page_template']=='blog.php') {
			update_post_meta($post_id, 'the_mounty_options_post_type', isset($meta['post_type']) ? $meta['post_type'] : 'post');
			update_post_meta($post_id, 'the_mounty_options_parent_cat', isset($meta['parent_cat']) ? $meta['parent_cat'] : 0);
		}
	}
}
?>