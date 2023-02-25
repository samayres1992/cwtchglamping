<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.1
 */
 
$the_mounty_theme_obj = wp_get_theme();

?>
<div class="the_mounty_admin_notice the_mounty_rate_notice update-nag"><?php
	// Theme image
	if ( ($the_mounty_theme_img = the_mounty_get_file_url('screenshot.jpg')) != '') {
		?><div class="the_mounty_notice_image"><img src="<?php echo esc_url($the_mounty_theme_img); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'the-mounty' ); ?>"></div><?php
	}

	// Title
	?><h3 class="the_mounty_notice_title"><a href="<?php echo esc_url(the_mounty_storage_get('theme_download_url')); ?>" target="_blank"><?php
		// Translators: Add theme name and version to the 'Welcome' message
		echo esc_html(sprintf(__('Rate our theme "%s", please', 'the-mounty'),
				$the_mounty_theme_obj->name . (THE_MOUNTY_THEME_FREE ? ' ' . __('Free', 'the-mounty') : '')
				));
	?></a></h3><?php
	
	// Description
	?><div class="the_mounty_notice_text">
		<p><?php echo wp_kses_data(__('We are glad you chose our WP theme for your website. You’ve done well customizing your website and we hope that you’ve enjoyed working with our theme.', 'the-mounty')); ?></p>
		<p><?php echo wp_kses_data(__('It would be just awesome if you spend just a minute of your time to rate our theme or the customer service you’ve received from us.', 'the-mounty')); ?></p>
		<p class="the_mounty_notice_text_info"><?php echo wp_kses_data(__('* We love receiving your reviews! Every time you leave a review, our CEO Henry Rise gives $5 to homeless dog shelter! Save the planet with us!', 'the-mounty')); ?></p>
	</div><?php

	// Buttons
	?><div class="the_mounty_notice_buttons"><?php
		// Link to the theme download page
		?><a href="<?php echo esc_url(the_mounty_storage_get('theme_download_url')); ?>" class="button button-primary" target="_blank"><i class="dashicons dashicons-star-filled"></i> <?php
			// Translators: Add theme name
			echo esc_html(sprintf(__('Rate theme %s', 'the-mounty'), $the_mounty_theme_obj->name));
		?></a><?php
		// Link to the theme support
		?><a href="<?php echo esc_url(the_mounty_storage_get('theme_support_url')); ?>" class="button" target="_blank"><i class="dashicons dashicons-sos"></i> <?php
			esc_html_e('Support', 'the-mounty');
		?></a><?php
		// Link to the theme documentation
		?><a href="<?php echo esc_url(the_mounty_storage_get('theme_doc_url')); ?>" class="button" target="_blank"><i class="dashicons dashicons-book"></i> <?php
			esc_html_e('Documentation', 'the-mounty');
		?></a><?php
		// Dismiss
		?><a href="#" class="the_mounty_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="the_mounty_hide_notice_text"><?php esc_html_e('Dismiss', 'the-mounty'); ?></span></a>
	</div>
</div>