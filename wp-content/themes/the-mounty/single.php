<?php
/**
 * The template to display single post
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

get_header();

while ( have_posts() ) { the_post();

	get_template_part( 'content', get_post_format() );

	// Related posts
	if ((int) the_mounty_get_theme_option('show_related_posts') && ($the_mounty_related_posts = (int) the_mounty_get_theme_option('related_posts')) > 0) {
		the_mounty_show_related_posts(array('orderby' => 'rand',
										'posts_per_page' => max(1, min(9, $the_mounty_related_posts)),
										'columns' => max(1, min(4, the_mounty_get_theme_option('related_columns')))
										),
									the_mounty_get_theme_option('related_style')
									);
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>