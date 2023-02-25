<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_blog_style = explode('_', the_mounty_get_theme_option('blog_style'));
$the_mounty_columns = empty($the_mounty_blog_style[1]) ? 2 : max(2, $the_mounty_blog_style[1]);
$the_mounty_expanded = !the_mounty_sidebar_present() && the_mounty_is_on(the_mounty_get_theme_option('expand_content'));
$the_mounty_post_format = get_post_format();
$the_mounty_post_format = empty($the_mounty_post_format) ? 'standard' : str_replace('post-format-', '', $the_mounty_post_format);
$the_mounty_animation = the_mounty_get_theme_option('blog_animation');
$the_mounty_components = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('meta_parts'));
$the_mounty_counters = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('counters'));

?><div class="<?php echo 'classic' == $the_mounty_blog_style[0] ? 'column' : 'masonry_item masonry_item'; ?>-1_<?php echo esc_attr($the_mounty_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_format_'.esc_attr($the_mounty_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($the_mounty_columns)
					. ' post_layout_'.esc_attr($the_mounty_blog_style[0]) 
					. ' post_layout_'.esc_attr($the_mounty_blog_style[0]).'_'.esc_attr($the_mounty_columns)
					); ?>
	<?php echo (!the_mounty_is_off($the_mounty_animation) ? ' data-animation="'.esc_attr(the_mounty_get_animation_classes($the_mounty_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	the_mounty_show_post_featured( array( 'thumb_size' => the_mounty_get_thumb_size($the_mounty_blog_style[0] == 'classic'
													? (strpos(the_mounty_get_theme_option('body_style'), 'full')!==false 
															? ( $the_mounty_columns > 2 ? 'big' : 'huge' )
															: (	$the_mounty_columns > 2
																? ($the_mounty_expanded ? 'med' : 'small')
																: ($the_mounty_expanded ? 'big' : 'med')
																)
														)
													: (strpos(the_mounty_get_theme_option('body_style'), 'full')!==false 
															? ( $the_mounty_columns > 2 ? 'masonry-big' : 'full' )
															: (	$the_mounty_columns <= 2 && $the_mounty_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($the_mounty_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('the_mounty_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('the_mounty_action_before_post_meta'); 

			// Post meta
			if (!empty($the_mounty_components))
				the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(
					'components' => $the_mounty_components,
					'counters' => $the_mounty_counters,
					'seo' => false
					), $the_mounty_blog_style[0], $the_mounty_columns)
				);

			do_action('the_mounty_action_after_post_meta'); 
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$the_mounty_show_learn_more = false;
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($the_mounty_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($the_mounty_post_format == 'quote') {
				if (($quote = the_mounty_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					the_mounty_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 4)!='[vc_' && substr(get_the_content(), 3, 4)!='[vc_') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($the_mounty_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($the_mounty_components))
				the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(
					'components' => $the_mounty_components,
					'counters' => $the_mounty_counters
					), $the_mounty_blog_style[0], $the_mounty_columns)
				);
		}
		// More button
		if ( $the_mounty_show_learn_more ) {
			?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'the-mounty'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>