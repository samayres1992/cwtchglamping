<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_header_css = '';
$the_mounty_header_image = get_header_image();
$the_mounty_header_video = the_mounty_get_header_video();
if (!empty($the_mounty_header_image) && the_mounty_trx_addons_featured_image_override(is_singular() || the_mounty_storage_isset('blog_archive') || is_category())) {
	$the_mounty_header_image = the_mounty_get_current_mode_image($the_mounty_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($the_mounty_header_image) || !empty($the_mounty_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($the_mounty_header_video!='') echo ' with_bg_video';
					if ($the_mounty_header_image!='') echo ' '.esc_attr(the_mounty_add_inline_css_class('background-image: url('.esc_url($the_mounty_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (the_mounty_is_on(the_mounty_get_theme_option('header_fullheight'))) echo ' header_fullheight the_mounty-full-height';
					if (!the_mounty_is_inherit(the_mounty_get_theme_option('header_scheme')))
						echo ' scheme_' . esc_attr(the_mounty_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($the_mounty_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (the_mounty_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Mobile header
	if (the_mounty_is_on(the_mounty_get_theme_option("header_mobile_enabled"))) {
		get_template_part( 'templates/header-mobile' );
	}
	
	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

?></header>