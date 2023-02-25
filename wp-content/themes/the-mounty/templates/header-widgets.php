<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

// Header sidebar
$the_mounty_header_name = the_mounty_get_theme_option('header_widgets');
$the_mounty_header_present = !the_mounty_is_off($the_mounty_header_name) && is_active_sidebar($the_mounty_header_name);
if ($the_mounty_header_present) { 
	the_mounty_storage_set('current_sidebar', 'header');
	$the_mounty_header_wide = the_mounty_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($the_mounty_header_name) ) {
		dynamic_sidebar($the_mounty_header_name);
	}
	$the_mounty_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($the_mounty_widgets_output)) {
		$the_mounty_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $the_mounty_widgets_output);
		$the_mounty_need_columns = strpos($the_mounty_widgets_output, 'columns_wrap')===false;
		if ($the_mounty_need_columns) {
			$the_mounty_columns = max(0, (int) the_mounty_get_theme_option('header_columns'));
			if ($the_mounty_columns == 0) $the_mounty_columns = min(6, max(1, substr_count($the_mounty_widgets_output, '<aside ')));
			if ($the_mounty_columns > 1)
				$the_mounty_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($the_mounty_columns).' widget', $the_mounty_widgets_output);
			else
				$the_mounty_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($the_mounty_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$the_mounty_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($the_mounty_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'the_mounty_action_before_sidebar' );
				the_mounty_show_layout($the_mounty_widgets_output);
				do_action( 'the_mounty_action_after_sidebar' );
				if ($the_mounty_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$the_mounty_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>