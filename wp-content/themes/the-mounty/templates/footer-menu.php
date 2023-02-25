<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.10
 */

// Footer menu
$the_mounty_menu_footer = the_mounty_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($the_mounty_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php the_mounty_show_layout($the_mounty_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>