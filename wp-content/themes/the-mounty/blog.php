<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$the_mounty_content = '';
$the_mounty_blog_archive_mask = '%%CONTENT%%';
$the_mounty_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $the_mounty_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($the_mounty_content = apply_filters('the_content', get_the_content())) != '') {
		if (($the_mounty_pos = strpos($the_mounty_content, $the_mounty_blog_archive_mask)) !== false) {
			$the_mounty_content = preg_replace('/(\<p\>\s*)?'.$the_mounty_blog_archive_mask.'(\s*\<\/p\>)/i', $the_mounty_blog_archive_subst, $the_mounty_content);
		} else
			$the_mounty_content .= $the_mounty_blog_archive_subst;
		$the_mounty_content = explode($the_mounty_blog_archive_mask, $the_mounty_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) the_mounty_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$the_mounty_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$the_mounty_args = the_mounty_query_add_posts_and_cats($the_mounty_args, '', the_mounty_get_theme_option('post_type'), the_mounty_get_theme_option('parent_cat'));
$the_mounty_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($the_mounty_page_number > 1) {
	$the_mounty_args['paged'] = $the_mounty_page_number;
	$the_mounty_args['ignore_sticky_posts'] = true;
}
$the_mounty_ppp = the_mounty_get_theme_option('posts_per_page');
if ((int) $the_mounty_ppp != 0)
	$the_mounty_args['posts_per_page'] = (int) $the_mounty_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($the_mounty_args);


// Add internal query vars in the new query!
if (is_array($the_mounty_content) && count($the_mounty_content) == 2) {
	set_query_var('blog_archive_start', $the_mounty_content[0]);
	set_query_var('blog_archive_end', $the_mounty_content[1]);
}

get_template_part('index');
?>