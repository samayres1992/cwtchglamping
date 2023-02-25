<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

// Page (category, tag, archive, author) title

if ( the_mounty_need_page_title() ) {
	the_mounty_sc_layouts_showed('title', true);
	the_mounty_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(
									'components' => the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('meta_parts')),
									'counters' => the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('counters')),
									'seo' => the_mounty_is_on(the_mounty_get_theme_option('seo_snippets'))
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$the_mounty_blog_title = the_mounty_get_blog_title();
							$the_mounty_blog_title_text = $the_mounty_blog_title_class = $the_mounty_blog_title_link = $the_mounty_blog_title_link_text = '';
							if (is_array($the_mounty_blog_title)) {
								$the_mounty_blog_title_text = $the_mounty_blog_title['text'];
								$the_mounty_blog_title_class = !empty($the_mounty_blog_title['class']) ? ' '.$the_mounty_blog_title['class'] : '';
								$the_mounty_blog_title_link = !empty($the_mounty_blog_title['link']) ? $the_mounty_blog_title['link'] : '';
								$the_mounty_blog_title_link_text = !empty($the_mounty_blog_title['link_text']) ? $the_mounty_blog_title['link_text'] : '';
							} else
								$the_mounty_blog_title_text = $the_mounty_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($the_mounty_blog_title_class); ?>"><?php
								$the_mounty_top_icon = the_mounty_get_category_icon();
								if (!empty($the_mounty_top_icon)) {
									$the_mounty_attr = the_mounty_getimagesize($the_mounty_top_icon);
									?><img src="<?php echo esc_url($the_mounty_top_icon); ?>" alt="<?php esc_attr_e( 'Site icon', 'the-mounty' ); ?>" <?php if (!empty($the_mounty_attr[3])) the_mounty_show_layout($the_mounty_attr[3]);?>><?php
								}
								echo wp_kses($the_mounty_blog_title_text, 'the_mounty_kses_content');
							?></h1>
							<?php
							if (!empty($the_mounty_blog_title_link) && !empty($the_mounty_blog_title_link_text)) {
								?><a href="<?php echo esc_url($the_mounty_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($the_mounty_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'the_mounty_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>