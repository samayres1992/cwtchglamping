<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_args = get_query_var('the_mounty_logo_args');

// Site logo
$the_mounty_logo_type   = isset($the_mounty_args['type']) ? $the_mounty_args['type'] : '';
$the_mounty_logo_image  = the_mounty_get_logo_image($the_mounty_logo_type);
$the_mounty_logo_text   = the_mounty_is_on(the_mounty_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$the_mounty_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($the_mounty_logo_image) || !empty($the_mounty_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url(home_url('/')); ?>"><?php
		if (!empty($the_mounty_logo_image)) {
			if (empty($the_mounty_logo_type) && function_exists('the_custom_logo') && is_numeric( $the_mounty_logo_image ) && $the_mounty_logo_image > 0 ) {
				the_custom_logo();
			} else {
				$the_mounty_attr = the_mounty_getimagesize($the_mounty_logo_image);
				echo '<img src="'.esc_url($the_mounty_logo_image).'" alt="'.esc_attr($the_mounty_logo_text).'"'.(!empty($the_mounty_attr[3]) ? ' '.wp_kses_data($the_mounty_attr[3]) : '').'>';
			}
		} else {
			the_mounty_show_layout(the_mounty_prepare_macros($the_mounty_logo_text), '<span class="logo_text">', '</span>');
			the_mounty_show_layout(the_mounty_prepare_macros($the_mounty_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>