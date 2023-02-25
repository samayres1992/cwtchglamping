<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_blog_style = explode('_', the_mounty_get_theme_option('blog_style'));
$the_mounty_columns = empty($the_mounty_blog_style[1]) ? 2 : max(2, $the_mounty_blog_style[1]);
$the_mounty_post_format = get_post_format();
$the_mounty_post_format = empty($the_mounty_post_format) ? 'standard' : str_replace('post-format-', '', $the_mounty_post_format);
$the_mounty_animation = the_mounty_get_theme_option('blog_animation');
$the_mounty_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($the_mounty_columns).' post_format_'.esc_attr($the_mounty_post_format) ); ?>
	<?php echo (!the_mounty_is_off($the_mounty_animation) ? ' data-animation="'.esc_attr(the_mounty_get_animation_classes($the_mounty_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($the_mounty_image[1]) && !empty($the_mounty_image[2])) echo intval($the_mounty_image[1]) .'x' . intval($the_mounty_image[2]); ?>"
	data-src="<?php if (!empty($the_mounty_image[0])) echo esc_url($the_mounty_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$the_mounty_image_hover = 'icon';
	if (in_array($the_mounty_image_hover, array('icons', 'zoom'))) $the_mounty_image_hover = 'dots';
	$the_mounty_components = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('meta_parts'));
	$the_mounty_counters = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('counters'));
	the_mounty_show_post_featured(array(
		'hover' => $the_mounty_image_hover,
		'thumb_size' => the_mounty_get_thumb_size( strpos(the_mounty_get_theme_option('body_style'), 'full')!==false || $the_mounty_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($the_mounty_components)
										? the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(
											'components' => $the_mounty_components,
											'counters' => $the_mounty_counters,
											'seo' => false,
											'echo' => false
											), $the_mounty_blog_style[0], $the_mounty_columns))
										: '')
								. '<div class="post_description_content">'
									. get_the_excerpt()
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'the-mounty') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>