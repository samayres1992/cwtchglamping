<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

the_mounty_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	the_mounty_show_layout(get_query_var('blog_archive_start'));

	$the_mounty_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$the_mounty_sticky_out = the_mounty_get_theme_option('sticky_style')=='columns' 
							&& is_array($the_mounty_stickies) && count($the_mounty_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($the_mounty_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$the_mounty_sticky_out) {
		?><div class="chess_wrap posts_container"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($the_mounty_sticky_out && !is_sticky()) {
			$the_mounty_sticky_out = false;
			?></div><div class="chess_wrap posts_container"><?php
		}
		get_template_part( 'content', $the_mounty_sticky_out && is_sticky() ? 'sticky' :'chess' );
	}
	
	?></div><?php

	the_mounty_show_pagination();

	the_mounty_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>