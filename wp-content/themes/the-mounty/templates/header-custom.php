<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.06
 */

$the_mounty_header_css = '';
$the_mounty_header_image = get_header_image();
$the_mounty_header_video = the_mounty_get_header_video();
if (!empty($the_mounty_header_image) && the_mounty_trx_addons_featured_image_override(is_singular() || the_mounty_storage_isset('blog_archive') || is_category())) {
	$the_mounty_header_image = the_mounty_get_current_mode_image($the_mounty_header_image);
}

$the_mounty_header_id = str_replace('header-custom-', '', the_mounty_get_theme_option("header_style"));
if ((int) $the_mounty_header_id == 0) {
	$the_mounty_header_id = the_mounty_get_post_id(array(
												'name' => $the_mounty_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$the_mounty_header_id = apply_filters('the_mounty_filter_get_translated_layout', $the_mounty_header_id);
}
$the_mounty_header_meta = get_post_meta($the_mounty_header_id, 'trx_addons_options', true);
if (!empty($the_mounty_header_meta['margin']) != '') 
	the_mounty_add_inline_css(sprintf('.page_content_wrap{padding-top:%s}', esc_attr(the_mounty_prepare_css_value($the_mounty_header_meta['margin']))));

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($the_mounty_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($the_mounty_header_id)));
				echo !empty($the_mounty_header_image) || !empty($the_mounty_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($the_mounty_header_video!='') 
					echo ' with_bg_video';
				if ($the_mounty_header_image!='') 
					echo ' '.esc_attr(the_mounty_add_inline_css_class('background-image: url('.esc_url($the_mounty_header_image).');'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (the_mounty_is_on(the_mounty_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight the_mounty-full-height';
				if (!the_mounty_is_inherit(the_mounty_get_theme_option('header_scheme')))
					echo ' scheme_' . esc_attr(the_mounty_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($the_mounty_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('the_mounty_action_show_layout', $the_mounty_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>