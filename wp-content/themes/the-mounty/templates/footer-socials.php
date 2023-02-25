<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.10
 */


// Socials
if ( the_mounty_is_on(the_mounty_get_theme_option('socials_in_footer')) && ($the_mounty_output = the_mounty_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php the_mounty_show_layout($the_mounty_output); ?>
		</div>
	</div>
	<?php
}
?>