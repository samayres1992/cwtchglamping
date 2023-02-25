<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

$the_mounty_seo = the_mounty_is_on(the_mounty_get_theme_option('seo_snippets'));
$the_mounty_components = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('meta_parts'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($the_mounty_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="//schema.org/<?php echo esc_attr(the_mounty_get_markup_schema()); ?>"
			   itemid="<?php echo esc_url(get_the_permalink()); ?>"
			   content="<?php the_title_attribute(); ?>"<?php
		}
?>><?php

	do_action('the_mounty_action_before_post_data'); 

	// Structured data snippets
	if ($the_mounty_seo)
		get_template_part('templates/seo');

	// Featured image
	if ( the_mounty_is_off(the_mounty_get_theme_option('hide_featured_on_single'))
			&& !the_mounty_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('the_mounty_action_before_post_featured');
        if (has_post_thumbnail( get_the_id() )) {
            ?>
            <div class="post_featured_wrap"><?php
            // Post meta
            $the_mounty_components = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('meta_parts'));
            if (!empty($the_mounty_components) && (strpos($the_mounty_components, 'date') !== false) && the_mounty_is_on(the_mounty_get_theme_option('show_post_meta'))) { ?>
                <div class="post_featured_date">
                    <div class="post_featured_date_d"><?php echo wp_kses_data(get_the_date('d', get_the_id())); ?></div>
                    <div class="post_featured_date_m"><?php echo wp_kses_data(get_the_date('M', get_the_id())); ?></div>
                </div>
            <?php }
            the_mounty_show_post_featured();
            ?></div><?php
        }
		do_action('the_mounty_action_after_post_featured'); 
	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="//schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}

	// Title and post meta
	if ( (!the_mounty_sc_layouts_showed('title') || !the_mounty_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('the_mounty_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!the_mounty_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.($the_mounty_seo ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			?>
		</div><!-- .post_header -->
		<?php
		do_action('the_mounty_action_after_post_title'); 
	}

	do_action('the_mounty_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
        do_action('the_mounty_action_before_post_meta');

        // Post meta
        if (!empty($the_mounty_components) && the_mounty_is_on(the_mounty_get_theme_option('show_post_meta')))
            the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(
                    'components' => str_replace(array('date,', ',date', 'date'), '', $the_mounty_components),
                    'counters' => the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('counters')),
                    'seo' => the_mounty_is_on(the_mounty_get_theme_option('seo_snippets'))
                ), 'single', 1)
            );

		the_content( );

		do_action('the_mounty_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'the-mounty' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'the-mounty' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {
			
			do_action('the_mounty_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'the-mounty').'</span> ', ', ', '</span>' );

				// Share
				if (the_mounty_is_on(the_mounty_get_theme_option('show_share_links'))) {
					the_mounty_show_share_links(array(
							'type' => 'block',
							'caption' => '',
							'before' => '<span class="post_meta_item post_share">',
							'after' => '</span>'
						));
				}
			?></div><?php

			do_action('the_mounty_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('the_mounty_action_after_post_content'); 

	// Author bio.
	if ( the_mounty_get_theme_option('show_author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
		do_action('the_mounty_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('the_mounty_action_after_post_author'); 
	}

	do_action('the_mounty_action_after_post_data'); 
	?>
</article>
