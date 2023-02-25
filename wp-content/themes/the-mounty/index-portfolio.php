<?php
/**
 * The template for homepage posts with "Portfolio" style
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
	
	// Show filters
	$the_mounty_cat = the_mounty_get_theme_option('parent_cat');
	$the_mounty_post_type = the_mounty_get_theme_option('post_type');
	$the_mounty_taxonomy = the_mounty_get_post_type_taxonomy($the_mounty_post_type);
	$the_mounty_show_filters = the_mounty_get_theme_option('show_filters');
	$the_mounty_tabs = array();
	if (!the_mounty_is_off($the_mounty_show_filters)) {
		$the_mounty_args = array(
			'type'			=> $the_mounty_post_type,
			'child_of'		=> $the_mounty_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'taxonomy'		=> $the_mounty_taxonomy,
			'pad_counts'	=> false
		);
		$the_mounty_portfolio_list = get_terms($the_mounty_args);
		if (is_array($the_mounty_portfolio_list) && count($the_mounty_portfolio_list) > 0) {
			$the_mounty_tabs[$the_mounty_cat] = esc_html__('All', 'the-mounty');
			foreach ($the_mounty_portfolio_list as $the_mounty_term) {
				if (isset($the_mounty_term->term_id)) $the_mounty_tabs[$the_mounty_term->term_id] = $the_mounty_term->name;
			}
		}
	}
	if (count($the_mounty_tabs) > 0) {
		$the_mounty_portfolio_filters_ajax = true;
		$the_mounty_portfolio_filters_active = $the_mounty_cat;
		$the_mounty_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters the_mounty_tabs the_mounty_tabs_ajax">
			<ul class="portfolio_titles the_mounty_tabs_titles">
				<?php
				foreach ($the_mounty_tabs as $the_mounty_id=>$the_mounty_title) {
					?><li><a href="<?php echo esc_url(the_mounty_get_hash_link(sprintf('#%s_%s_content', $the_mounty_portfolio_filters_id, $the_mounty_id))); ?>" data-tab="<?php echo esc_attr($the_mounty_id); ?>"><?php echo esc_html($the_mounty_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$the_mounty_ppp = the_mounty_get_theme_option('posts_per_page');
			if (the_mounty_is_inherit($the_mounty_ppp)) $the_mounty_ppp = '';
			foreach ($the_mounty_tabs as $the_mounty_id=>$the_mounty_title) {
				$the_mounty_portfolio_need_content = $the_mounty_id==$the_mounty_portfolio_filters_active || !$the_mounty_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $the_mounty_portfolio_filters_id, $the_mounty_id)); ?>"
					class="portfolio_content the_mounty_tabs_content"
					data-blog-template="<?php echo esc_attr(the_mounty_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(the_mounty_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($the_mounty_ppp); ?>"
					data-post-type="<?php echo esc_attr($the_mounty_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($the_mounty_taxonomy); ?>"
					data-cat="<?php echo esc_attr($the_mounty_id); ?>"
					data-parent-cat="<?php echo esc_attr($the_mounty_cat); ?>"
					data-need-content="<?php echo (false===$the_mounty_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($the_mounty_portfolio_need_content) 
						the_mounty_show_portfolio_posts(array(
							'cat' => $the_mounty_id,
							'parent_cat' => $the_mounty_cat,
							'taxonomy' => $the_mounty_taxonomy,
							'post_type' => $the_mounty_post_type,
							'page' => 1,
							'sticky' => $the_mounty_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		the_mounty_show_portfolio_posts(array(
			'cat' => $the_mounty_cat,
			'parent_cat' => $the_mounty_cat,
			'taxonomy' => $the_mounty_taxonomy,
			'post_type' => $the_mounty_post_type,
			'page' => 1,
			'sticky' => $the_mounty_sticky_out
			)
		);
	}

	the_mounty_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>