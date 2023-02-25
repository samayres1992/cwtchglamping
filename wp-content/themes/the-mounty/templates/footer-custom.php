<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.10
 */

$the_mounty_footer_id = str_replace('footer-custom-', '', the_mounty_get_theme_option("footer_style"));
if ((int) $the_mounty_footer_id == 0) {
	$the_mounty_footer_id = the_mounty_get_post_id(array(
												'name' => $the_mounty_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$the_mounty_footer_id = apply_filters('the_mounty_filter_get_translated_layout', $the_mounty_footer_id);
}
$the_mounty_footer_meta = get_post_meta($the_mounty_footer_id, 'trx_addons_options', true);
if (!empty($the_mounty_footer_meta['margin']) != '')
	the_mounty_add_inline_css(sprintf('.page_content_wrap{padding-bottom:%s}', esc_attr(the_mounty_prepare_css_value($the_mounty_footer_meta['margin']))));
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($the_mounty_footer_id);
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($the_mounty_footer_id)));
						if (!the_mounty_is_inherit(the_mounty_get_theme_option('footer_scheme')))
							echo ' scheme_' . esc_attr(the_mounty_get_theme_option('footer_scheme'));
						?>">
	<?php
    // Custom footer's layout
    do_action('the_mounty_action_show_layout', $the_mounty_footer_id);
	?>
</footer><!-- /.footer_wrap -->
