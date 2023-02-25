<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.10
 */

// Logo
if (the_mounty_is_on(the_mounty_get_theme_option('logo_in_footer'))) {
	$the_mounty_logo_image = the_mounty_get_logo_image('footer');
	$the_mounty_logo_text  = get_bloginfo( 'name' );
	if (!empty($the_mounty_logo_image) || !empty($the_mounty_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($the_mounty_logo_image)) {
                    $the_mounty_attr = the_mounty_getimagesize($the_mounty_logo_image);
                    echo '<a href="'.esc_url(home_url('/')).'">'
                        . '<img src="'.esc_url($the_mounty_logo_image).'"'
                        . ' class="logo_footer_image"'
                        . ' alt="'.esc_attr__('Site logo', 'the-mounty').'"'
                        . (!empty($the_mounty_attr[3]) ? ' ' . wp_kses_data($the_mounty_attr[3]) : '')
                        .'>'
                        . '</a>' ;
				} else if (!empty($the_mounty_logo_text)) {
                    echo '<h1 class="logo_footer_text">'
                        . '<a href="'.esc_url(home_url('/')).'">'
                        . esc_html($the_mounty_logo_text)
                        . '</a>'
                        . '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>