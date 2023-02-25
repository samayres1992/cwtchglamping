<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr(the_mounty_get_theme_option('menu_mobile_fullscreen') > 0 ? 'fullscreen' : 'narrow'); ?> scheme_default">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a><?php

		// Logo
		set_query_var('the_mounty_logo_args', array('type' => 'mobile'));
		get_template_part( 'templates/header-logo' );
		set_query_var('the_mounty_logo_args', array());

		// Mobile menu
		$the_mounty_menu_mobile = the_mounty_get_nav_menu('menu_mobile');
		if (empty($the_mounty_menu_mobile)) {
			$the_mounty_menu_mobile = apply_filters('the_mounty_filter_get_mobile_menu', '');
			if (empty($the_mounty_menu_mobile)) $the_mounty_menu_mobile = the_mounty_get_nav_menu('menu_main');
			if (empty($the_mounty_menu_mobile)) $the_mounty_menu_mobile = the_mounty_get_nav_menu();
		}
		if (!empty($the_mounty_menu_mobile)) {
			if (!empty($the_mounty_menu_mobile))
				$the_mounty_menu_mobile = str_replace(
					array('menu_main', 'id="menu-', 'sc_layouts_menu_nav', 'sc_layouts_hide_on_mobile', 'hide_on_mobile'),
					array('menu_mobile', 'id="menu_mobile-', '', '', ''),
					$the_mounty_menu_mobile
					);
			if (strpos($the_mounty_menu_mobile, '<nav ')===false)
				$the_mounty_menu_mobile = sprintf('<nav class="menu_mobile_nav_area">%s</nav>', $the_mounty_menu_mobile);
			the_mounty_show_layout(apply_filters('the_mounty_filter_menu_mobile_layout', $the_mounty_menu_mobile));
		}

		// Search field
		do_action('the_mounty_action_search', 'normal', 'search_mobile', false);
		
		// Social icons
		the_mounty_show_layout(the_mounty_get_socials_links(), '<div class="socials_mobile">', '</div>');
		?>
	</div>
</div>
