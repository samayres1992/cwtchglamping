<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($the_mounty_columns).' post_format_'.esc_attr($the_mounty_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!the_mounty_is_off($the_mounty_animation) ? ' data-animation="'.esc_attr(the_mounty_get_animation_classes($the_mounty_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$the_mounty_image_hover = the_mounty_get_theme_option('image_hover');
	// Featured image
	the_mounty_show_post_featured(array(
		'thumb_size' => the_mounty_get_thumb_size(strpos(the_mounty_get_theme_option('body_style'), 'full')!==false || $the_mounty_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $the_mounty_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $the_mounty_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>