<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

						// Widgets area inside page content
						the_mounty_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					the_mounty_create_widgets_area('widgets_below_page');

					$the_mounty_body_style = the_mounty_get_theme_option('body_style');
					if ($the_mounty_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$the_mounty_footer_type = the_mounty_get_theme_option("footer_type");
			if ($the_mounty_footer_type == 'custom' && !the_mounty_is_layouts_available())
				$the_mounty_footer_type = 'default';
			get_template_part( "templates/footer-{$the_mounty_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (false && the_mounty_is_on(the_mounty_get_theme_option('debug_mode')) && the_mounty_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(the_mounty_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>