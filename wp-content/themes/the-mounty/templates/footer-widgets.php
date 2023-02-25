<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.10
 */

// Footer sidebar
$the_mounty_footer_name = the_mounty_get_theme_option('footer_widgets');
$the_mounty_footer_present = !the_mounty_is_off($the_mounty_footer_name) && is_active_sidebar($the_mounty_footer_name);
if ($the_mounty_footer_present) { 
	the_mounty_storage_set('current_sidebar', 'footer');
	$the_mounty_footer_wide = the_mounty_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($the_mounty_footer_name) ) {
		dynamic_sidebar($the_mounty_footer_name);
	}
	$the_mounty_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($the_mounty_out)) {
		$the_mounty_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $the_mounty_out);
		$the_mounty_need_columns = true;	//or check: strpos($the_mounty_out, 'columns_wrap')===false;
		if ($the_mounty_need_columns) {
			$the_mounty_columns = max(0, (int) the_mounty_get_theme_option('footer_columns'));
			if ($the_mounty_columns == 0) $the_mounty_columns = min(4, max(1, substr_count($the_mounty_out, '<aside ')));
			if ($the_mounty_columns > 1)
				$the_mounty_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($the_mounty_columns).' widget', $the_mounty_out);
			else
				$the_mounty_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($the_mounty_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$the_mounty_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($the_mounty_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'the_mounty_action_before_sidebar' );
				the_mounty_show_layout($the_mounty_out);
				do_action( 'the_mounty_action_after_sidebar' );
				if ($the_mounty_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$the_mounty_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>