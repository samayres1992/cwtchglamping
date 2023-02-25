<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$the_mounty_post_format = get_post_format();
$the_mounty_post_format = empty($the_mounty_post_format) ? 'standard' : str_replace('post-format-', '', $the_mounty_post_format);
$the_mounty_animation = the_mounty_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($the_mounty_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($the_mounty_post_format) ); ?>
	<?php echo (!the_mounty_is_off($the_mounty_animation) ? ' data-animation="'.esc_attr(the_mounty_get_animation_classes($the_mounty_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	the_mounty_show_post_featured(array(
		'thumb_size' => the_mounty_get_thumb_size($the_mounty_columns==1 ? 'big' : ($the_mounty_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($the_mounty_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(), 'sticky', $the_mounty_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>