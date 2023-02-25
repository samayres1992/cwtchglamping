<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_link = get_permalink();
$the_mounty_post_format = get_post_format();
$the_mounty_post_format = empty($the_mounty_post_format) ? 'standard' : str_replace('post-format-', '', $the_mounty_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_'.esc_attr($the_mounty_post_format) ); ?>><?php
        // Featured image
        if (has_post_thumbnail( get_the_id() )) {
            ?>
            <div class="post_featured_wrap"><?php
            // Post meta
            if (in_array($the_mounty_post_format, array('standard'))) { ?>
                <div class="post_featured_date">
                    <div class="post_featured_date_d"><?php echo wp_kses_data(get_the_date('d', get_the_id())); ?></div>
                    <div class="post_featured_date_m"><?php echo wp_kses_data(get_the_date('M', get_the_id())); ?></div>
                </div>
            <?php }
            the_mounty_show_post_featured(array(
                    'thumb_size' => apply_filters('the_mounty_filter_related_thumb_size', the_mounty_get_thumb_size((int)the_mounty_get_theme_option('related_posts') == 1 ? 'huge' : 'big')),
                    'show_no_image' => the_mounty_get_theme_setting('allow_no_image'),
                    'singular' => false
                )
            );
            ?></div><?php
        }
        ?><div class="post_header entry-header"><?php
		if ( in_array(get_post_type(), array( 'post', 'attachment' ) ) ) {
			?><span class="post_date"><a href="<?php echo esc_url($the_mounty_link); ?>"><?php echo wp_kses_data(the_mounty_get_date()); ?></a></span><?php
		}
		?>
		<h6 class="post_title entry-title"><a href="<?php echo esc_url($the_mounty_link); ?>"><?php the_title(); ?></a></h6>
	</div>
</div>