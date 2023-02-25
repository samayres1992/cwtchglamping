<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_link = get_permalink();
$the_mounty_post_format = get_post_format();
$the_mounty_post_format = empty($the_mounty_post_format) ? 'standard' : str_replace('post-format-', '', $the_mounty_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($the_mounty_post_format) ); ?>><?php
	the_mounty_show_post_featured(array(
		'thumb_size' => apply_filters('the_mounty_filter_related_thumb_size', the_mounty_get_thumb_size( (int) the_mounty_get_theme_option('related_posts') == 1 ? 'huge' : 'big' )),
		'show_no_image' => the_mounty_get_theme_setting('allow_no_image'),
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">'.wp_kses(the_mounty_get_post_categories(''), 'the_mounty_kses_content').'</div>'
							. '<h6 class="post_title entry-title"><a href="'.esc_url($the_mounty_link).'">'.esc_html(get_the_title()).'</a></h6>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="'.esc_url($the_mounty_link).'">'.wp_kses_data(the_mounty_get_date()).'</a></span>'
									: '')
						. '</div>'
		)
	);
?></div>