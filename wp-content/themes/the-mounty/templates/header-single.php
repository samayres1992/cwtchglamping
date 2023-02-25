<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

if ( get_query_var('the_mounty_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$the_mounty_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if (!empty($the_mounty_src[0])) {
		the_mounty_sc_layouts_showed('featured', true);
		?><div class="sc_layouts_featured with_image without_content <?php echo esc_attr(the_mounty_add_inline_css_class('background-image:url('.esc_url($the_mounty_src[0]).');')); ?>"></div><?php
	}
}
?>