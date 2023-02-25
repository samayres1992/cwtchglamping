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
<div class="the_mounty_admin_notice the_mounty_welcome_notice update-nag"><?php
	// Theme image
	if ( ($the_mounty_theme_img = the_mounty_get_file_url('screenshot.jpg')) != '') {
		?><div class="the_mounty_notice_image"><img src="<?php echo esc_url($the_mounty_theme_img); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'the-mounty' ); ?>"></div><?php
	}

	// Title
	?><h3 class="the_mounty_notice_title"><?php
		// Translators: Add theme name and version to the 'Welcome' message
		echo esc_html(sprintf(__('Welcome to %1$s v.%2$s', 'the-mounty'),
				$the_mounty_theme_obj->name . (THE_MOUNTY_THEME_FREE ? ' ' . __('Free', 'the-mounty') : ''),
				$the_mounty_theme_obj->version
				));
	?></h3><?php

	// Description
	?><div class="the_mounty_notice_text"><?php
		echo str_replace('. ', '.<br>', wp_kses_data($the_mounty_theme_obj->description));
		if (!the_mounty_exists_trx_addons()) {
			echo (!empty($the_mounty_theme_obj->description) ? '<br><br>' : '')
					. wp_kses_data(__('Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'the-mounty'));
		}
	?></div><?php

	// Buttons
	?><div class="the_mounty_notice_buttons"><?php
		// Link to the page 'About Theme'
		?><a href="<?php echo esc_url(admin_url().'themes.php?page=the_mounty_about'); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> <?php
			// Translators: Add theme name
			echo esc_html(sprintf(__('About %s', 'the-mounty'), $the_mounty_theme_obj->name));
		?></a><?php
		// Link to the page 'Install plugins'
		if (the_mounty_get_value_gp('page')!='tgmpa-install-plugins') {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-plugins"></i> <?php esc_html_e('Install plugins', 'the-mounty'); ?></a>
			<?php
		}
		// Link to the 'One-click demo import'
		if (function_exists('the_mounty_exists_trx_addons') && the_mounty_exists_trx_addons() && class_exists('trx_addons_demo_data_importer')) {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=trx_importer'); ?>" class="button button-primary"><i class="dashicons dashicons-download"></i> <?php esc_html_e('One Click Demo Data', 'the-mounty'); ?></a>
			<?php
		}
		// Link to the Customizer
		?><a href="<?php echo esc_url(admin_url().'customize.php'); ?>" class="button"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Customizer', 'the-mounty'); ?></a><?php
		// Link to the Theme Options
		if (!THE_MOUNTY_THEME_FREE) {
			?><span> <?php esc_html_e('or', 'the-mounty'); ?> </span>
        	<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>" class="button"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Options', 'the-mounty'); ?></a><?php
        }
        // Dismiss this notice
        ?><a href="#" class="the_mounty_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="the_mounty_hide_notice_text"><?php esc_html_e('Dismiss', 'the-mounty'); ?></span></a>
	</div>
</div>