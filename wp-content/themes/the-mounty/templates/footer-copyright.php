<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.10
 */

// Copyright area
?>
<div class="footer_copyright_wrap<?php
				if (!the_mounty_is_inherit(the_mounty_get_theme_option('copyright_scheme')))
					echo ' scheme_' . esc_attr(the_mounty_get_theme_option('copyright_scheme'));
 				?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				$the_mounty_copyright = the_mounty_get_theme_option('copyright');
				if (!empty($the_mounty_copyright)) {
					// Replace {{Y}} or {Y} with the current year
					$the_mounty_copyright = str_replace(array('{{Y}}', '{Y}'), date_i18n('Y'), $the_mounty_copyright);
					// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
					$the_mounty_copyright = the_mounty_prepare_macros($the_mounty_copyright);
					// Display copyright
					echo wp_kses(nl2br($the_mounty_copyright), 'the_mounty_kses_content');
				}
			?></div>
		</div>
	</div>
</div>
