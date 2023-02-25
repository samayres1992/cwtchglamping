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
$the_mounty_columns = empty($the_mounty_blog_style[1]) ? 1 : max(1, $the_mounty_blog_style[1]);
$the_mounty_expanded = !the_mounty_sidebar_present() && the_mounty_is_on(the_mounty_get_theme_option('expand_content'));
$the_mounty_post_format = get_post_format();
$the_mounty_post_format = empty($the_mounty_post_format) ? 'standard' : str_replace('post-format-', '', $the_mounty_post_format);
$the_mounty_animation = the_mounty_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($the_mounty_columns).' post_format_'.esc_attr($the_mounty_post_format) ); ?>
	<?php echo (!the_mounty_is_off($the_mounty_animation) ? ' data-animation="'.esc_attr(the_mounty_get_animation_classes($the_mounty_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($the_mounty_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.the_title_attribute( array( 'echo' => false ) ).'" icon="'.esc_attr(the_mounty_get_post_icon()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	the_mounty_show_post_featured( array(
											'class' => $the_mounty_columns == 1 ? 'the_mounty-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => the_mounty_get_thumb_size(
																	strpos(the_mounty_get_theme_option('body_style'), 'full')!==false
																		? ( $the_mounty_columns > 1 ? 'huge' : 'original' )
																		: (	$the_mounty_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('the_mounty_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('the_mounty_action_before_post_meta'); 

			// Post meta
			$the_mounty_components = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('meta_parts'));
			$the_mounty_counters = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('counters'));
			$the_mounty_post_meta = empty($the_mounty_components) 
										? '' 
										: the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(
												'components' => $the_mounty_components,
												'counters' => $the_mounty_counters,
												'seo' => false,
												'echo' => false
												), $the_mounty_blog_style[0], $the_mounty_columns)
											);
			the_mounty_show_layout($the_mounty_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$the_mounty_show_learn_more = !in_array($the_mounty_post_format, array('link', 'aside', 'status', 'quote'));
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
				} else if (substr(get_the_content(), 0, 4)!='[vc_') {
					the_excerpt();
				}
				?>
			</div>
			<?php
			// Post meta
			if (in_array($the_mounty_post_format, array('link', 'aside', 'status', 'quote'))) {
				the_mounty_show_layout($the_mounty_post_meta);
			}
			// More button
			if ( $the_mounty_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'the-mounty'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>