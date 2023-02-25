<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.14
 */
$the_mounty_header_video = the_mounty_get_header_video();
$the_mounty_embed_video = '';
if (!empty($the_mounty_header_video) && !the_mounty_is_from_uploads($the_mounty_header_video)) {
	if (the_mounty_is_youtube_url($the_mounty_header_video) && preg_match('/[=\/]([^=\/]*)$/', $the_mounty_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$the_mounty_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($the_mounty_header_video) . '[/embed]' ));
			$the_mounty_embed_video = the_mounty_make_video_autoplay($the_mounty_embed_video);
		} else {
			$the_mounty_header_video = str_replace('/watch?v=', '/embed/', $the_mounty_header_video);
			$the_mounty_header_video = the_mounty_add_to_url($the_mounty_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$the_mounty_embed_video = '<iframe src="' . esc_url($the_mounty_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php the_mounty_show_layout($the_mounty_embed_video); ?></div><?php
	}
}
?>