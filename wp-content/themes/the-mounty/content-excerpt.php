<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_post_format = get_post_format();
$the_mounty_post_format = empty($the_mounty_post_format) ? 'standard' : str_replace('post-format-', '', $the_mounty_post_format);
$the_mounty_animation = the_mounty_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($the_mounty_post_format) ); ?>
	<?php echo (!the_mounty_is_off($the_mounty_animation) ? ' data-animation="'.esc_attr(the_mounty_get_animation_classes($the_mounty_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
    if (has_post_thumbnail( get_the_id() )) {
    ?><div class="post_featured_wrap"><?php
        // Post meta
        $the_mounty_show_date_in_featured = in_array($the_mounty_post_format, array('standard'));
        $the_mounty_components = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('meta_parts'));
        $the_mounty_counters = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('counters'));

        if (!empty($the_mounty_components) && (strpos($the_mounty_components, 'date') !== false) && $the_mounty_show_date_in_featured) { ?>
            <div class="post_featured_date">
                <div class="post_featured_date_d"><?php echo wp_kses_data(get_the_date('d', get_the_id())); ?></div>
                <div class="post_featured_date_m"><?php echo wp_kses_data(get_the_date('M', get_the_id())); ?></div>
            </div>
        <?php }
    }
    the_mounty_show_post_featured(array('thumb_size' => the_mounty_get_thumb_size(strpos(the_mounty_get_theme_option('body_style'), 'full') !== false ? 'full' : 'big')));
    if (has_post_thumbnail( get_the_id() )) {
        ?></div><?php
    }

	// Title and post meta
	if (get_the_title() != '') {
		?>
		<div class="post_header entry-header">
			<?php
            do_action('the_mounty_action_before_post_meta');

            // Post meta
            if (!empty($the_mounty_components))
                the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(
                        'components' => str_replace(array('date,', ',date', 'date'), '', $the_mounty_components),
                        'counters' => $the_mounty_counters,
                        'seo' => false
                    ), 'excerpt', 1)
                );

			do_action('the_mounty_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (the_mounty_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'the-mounty' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'the-mounty' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$the_mounty_show_learn_more = !in_array($the_mounty_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php
			// More button
			if ( $the_mounty_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'the-mounty'); ?></a></p><?php
			}

		}
	?></div><!-- .entry-content -->
</article>