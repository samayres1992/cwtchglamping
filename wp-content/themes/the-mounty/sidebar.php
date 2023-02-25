<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

if (the_mounty_sidebar_present()) {
	ob_start();
	$the_mounty_sidebar_name = the_mounty_get_theme_option('sidebar_widgets');
	the_mounty_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($the_mounty_sidebar_name) ) {
		dynamic_sidebar($the_mounty_sidebar_name);
	}
	$the_mounty_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($the_mounty_out)) {
		$the_mounty_sidebar_position = the_mounty_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($the_mounty_sidebar_position); ?> widget_area<?php if (!the_mounty_is_inherit(the_mounty_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(the_mounty_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'the_mounty_action_before_sidebar' );
				the_mounty_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $the_mounty_out));
				do_action( 'the_mounty_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>