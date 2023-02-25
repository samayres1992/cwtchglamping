<?php
/**
 * Information about this theme
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.30
 */


// Redirect to the 'About Theme' page after switch theme
if (!function_exists('the_mounty_about_after_switch_theme')) {
	add_action('after_switch_theme', 'the_mounty_about_after_switch_theme', 1000);
	function the_mounty_about_after_switch_theme() {
		update_option('the_mounty_about_page', 1);
	}
}
if ( !function_exists('the_mounty_about_after_setup_theme') ) {
	add_action( 'init', 'the_mounty_about_after_setup_theme', 1000 );
	function the_mounty_about_after_setup_theme() {
		if (get_option('the_mounty_about_page') == 1) {
			update_option('the_mounty_about_page', 0);
			wp_safe_redirect(admin_url().'themes.php?page=the_mounty_about');
			exit();
		}
	}
}


// Add 'About Theme' item in the Appearance menu
if (!function_exists('the_mounty_about_add_menu_items')) {
	add_action( 'admin_menu', 'the_mounty_about_add_menu_items' );
	function the_mounty_about_add_menu_items() {
		$theme = wp_get_theme();
		$theme_name = $theme->name . (THE_MOUNTY_THEME_FREE ? ' ' . esc_html__('Free', 'the-mounty') : '');
		add_theme_page(
			// Translators: Add theme name to the page title
			sprintf(esc_html__('About %s', 'the-mounty'), $theme_name),	//page_title
			// Translators: Add theme name to the menu title
			sprintf(esc_html__('About %s', 'the-mounty'), $theme_name),	//menu_title
			'manage_options',											//capability
			'the_mounty_about',											//menu_slug
			'the_mounty_about_page_builder'								//callback
		);
	}
}


// Load page-specific scripts and styles
if (!function_exists('the_mounty_about_enqueue_scripts')) {
	add_action( 'admin_enqueue_scripts', 'the_mounty_about_enqueue_scripts' );
	function the_mounty_about_enqueue_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id == 'appearance_page_the_mounty_about') {
			// Scripts
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			
			if (function_exists('the_mounty_plugins_installer_enqueue_scripts'))
				the_mounty_plugins_installer_enqueue_scripts();
			
			// Styles
			wp_enqueue_style( 'fontello-icons',  the_mounty_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			if ( ($fdir = the_mounty_get_file_url('theme-specific/theme-about/theme-about.css')) != '' )
				wp_enqueue_style( 'the-mounty-about',  $fdir, array(), null );
		}
	}
}


// Build 'About Theme' page
if (!function_exists('the_mounty_about_page_builder')) {
	function the_mounty_about_page_builder() {
		$theme = wp_get_theme();
		?>
		<div class="the_mounty_about">

			<?php do_action('the_mounty_action_theme_about_before_header', $theme); ?>

			<div class="the_mounty_about_header">

				<?php do_action('the_mounty_action_theme_about_before_logo'); ?>

				<div class="the_mounty_about_logo"><?php
					$logo = the_mounty_get_file_url('theme-specific/theme-about/logo.png');
					if (empty($logo)) $logo = the_mounty_get_file_url('screenshot.jpg');
					if (!empty($logo)) {
						?><img src="<?php echo esc_url($logo); ?>"><?php
					}
				?></div>

				<?php do_action('the_mounty_action_theme_about_before_title', $theme); ?>
				
				<h1 class="the_mounty_about_title"><?php
					// Translators: Add theme name and version to the 'Welcome' message
					echo esc_html(sprintf(__('Welcome to %1$s %2$s v.%3$s', 'the-mounty'),
											$theme->name,
											THE_MOUNTY_THEME_FREE ? __('Free', 'the-mounty') : '',
											$theme->version
										)
								);
				?></h1>

				<?php do_action('the_mounty_action_theme_about_before_description', $theme); ?>

				<div class="the_mounty_about_description">
					<?php
					if (THE_MOUNTY_THEME_FREE) {
						?><p><?php
							// Translators: Add the download url and the theme name to the message
							echo wp_kses_data(sprintf(__('Now you are using Free version of <a href="%1$s">%2$s Pro Theme</a>.', 'the-mounty'),
														esc_url(the_mounty_storage_get('theme_download_url')),
														$theme->name
														)
												);
							// Translators: Add the theme name and supported plugins list to the message
							echo '<br>' . wp_kses_data(sprintf(__('This version is SEO- and Retina-ready. It also has a built-in support for parallax and slider with swipe gestures. %1$s Free is compatible with many popular plugins, such as %2$s', 'the-mounty'),
														$theme->name,
														the_mounty_about_get_supported_plugins()
														)
												);
						?></p>
						<p><?php
							// Translators: Add the download url to the message
							echo wp_kses_data(sprintf(__('We hope you have a great acquaintance with our themes. If you are looking for a fully functional website, you can get the <a href="%s">Pro Version here</a>', 'the-mounty'),
														esc_url(the_mounty_storage_get('theme_download_url'))
														)
												);
						?></p><?php
					} else {
						?><p><?php
							// Translators: Add the theme name to the message
							echo wp_kses_data(sprintf(__('%s is a Premium WordPress theme. It has a built-in support for parallax, slider with swipe gestures, and is SEO- and Retina-ready', 'the-mounty'),
														$theme->name
														)
												);
						?></p>
						<p><?php
							// Translators: Add supported plugins list to the message
							echo wp_kses_data(sprintf(__('The Premium Theme is compatible with many popular plugins, such as %s', 'the-mounty'),
														the_mounty_about_get_supported_plugins()
														)
												);
						?></p><?php
					}
					?>
				</div>

				<?php do_action('the_mounty_action_theme_about_after_description', $theme); ?>

			</div>

			<?php do_action('the_mounty_action_theme_about_before_tabs', $theme); ?>

			<div id="the_mounty_about_tabs" class="the_mounty_tabs the_mounty_about_tabs">
				<ul>
					<?php do_action('the_mounty_action_theme_about_before_tabs_list', $theme); ?>
					<li><a href="#the_mounty_about_section_start"><?php esc_html_e('Getting started', 'the-mounty'); ?></a></li>
					<li><a href="#the_mounty_about_section_actions"><?php esc_html_e('Recommended actions', 'the-mounty'); ?></a></li>
					<?php do_action('the_mounty_action_theme_about_after_tabs_list', $theme); ?>
				</ul>

				<?php do_action('the_mounty_action_theme_about_before_tabs_sections', $theme); ?>

				<div id="the_mounty_about_section_start" class="the_mounty_tabs_section the_mounty_about_section"><?php
				
					// Install required plugins
					if (!THE_MOUNTY_THEME_FREE_WP && !the_mounty_exists_trx_addons()) {
						?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
							<h2 class="the_mounty_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'the-mounty'); ?>
							</h2>
							<div class="the_mounty_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'the-mounty');
							?></div>
							<?php the_mounty_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
						<h2 class="the_mounty_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'the-mounty'); ?>
						</h2>
						<div class="the_mounty_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'the-mounty'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="the_mounty_about_block_link button button-primary"><?php
							esc_html_e('Install plugins', 'the-mounty');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
						<h2 class="the_mounty_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'the-mounty'); ?>
						</h2>
						<div class="the_mounty_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'the-mounty');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   class="the_mounty_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'the-mounty');
						?></a>
						<?php if (!THE_MOUNTY_THEME_FREE) { ?>
							<?php esc_html_e('or', 'the-mounty'); ?>
							<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
							   class="the_mounty_about_block_link button"><?php
								esc_html_e('Theme Options', 'the-mounty');
							?></a>
						<?php } ?>
					</div></div><?php
					
					// Documentation
					?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
						<h2 class="the_mounty_about_block_title">
							<i class="dashicons dashicons-book"></i>
							<?php esc_html_e('Read full documentation', 'the-mounty');	?>
						</h2>
						<div class="the_mounty_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Need more details? Please check our full online documentation for detailed information on how to use %s.', 'the-mounty'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(the_mounty_storage_get('theme_doc_url')); ?>"
						   target="_blank"
						   class="the_mounty_about_block_link button button-primary"><?php
							esc_html_e('Documentation', 'the-mounty');
						?></a>
					</div></div><?php
					
					// Video tutorials
					?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
						<h2 class="the_mounty_about_block_title">
							<i class="dashicons dashicons-video-alt2"></i>
							<?php esc_html_e('Video tutorials', 'the-mounty');	?>
						</h2>
						<div class="the_mounty_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('No time for reading documentation? Check out our video tutorials and learn how to customize %s in detail.', 'the-mounty'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(the_mounty_storage_get('theme_video_url')); ?>"
						   target="_blank"
						   class="the_mounty_about_block_link button button-primary"><?php
							esc_html_e('Watch videos', 'the-mounty');
						?></a>
					</div></div><?php
					
					// Support
					if (!THE_MOUNTY_THEME_FREE) {
						?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
							<h2 class="the_mounty_about_block_title">
								<i class="dashicons dashicons-sos"></i>
								<?php esc_html_e('Support', 'the-mounty'); ?>
							</h2>
							<div class="the_mounty_about_block_description"><?php
								// Translators: Add the theme name to the message
								echo esc_html(sprintf(__('We want to make sure you have the best experience using %s and that is why we gathered here all the necessary informations for you.', 'the-mounty'), $theme->name));
							?></div>
							<a href="<?php echo esc_url(the_mounty_storage_get('theme_support_url')); ?>"
							   target="_blank"
							   class="the_mounty_about_block_link button button-primary"><?php
								esc_html_e('Support', 'the-mounty');
							?></a>
						</div></div><?php
					}
					
					// Online Demo
					?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
						<h2 class="the_mounty_about_block_title">
							<i class="dashicons dashicons-images-alt2"></i>
							<?php esc_html_e('On-line demo', 'the-mounty'); ?>
						</h2>
						<div class="the_mounty_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Visit the Demo Version of %s to check out all the features it has', 'the-mounty'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(the_mounty_storage_get('theme_demo_url')); ?>"
						   target="_blank"
						   class="the_mounty_about_block_link button button-primary"><?php
							esc_html_e('View demo', 'the-mounty');
						?></a>
					</div></div>
					
				</div>



				<div id="the_mounty_about_section_actions" class="the_mounty_tabs_section the_mounty_about_section"><?php
				
					// Install required plugins
					if (!THE_MOUNTY_THEME_FREE_WP && !the_mounty_exists_trx_addons()) {
						?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
							<h2 class="the_mounty_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'the-mounty'); ?>
							</h2>
							<div class="the_mounty_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'the-mounty');
							?></div>
							<?php the_mounty_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
						<h2 class="the_mounty_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'the-mounty'); ?>
						</h2>
						<div class="the_mounty_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'the-mounty'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="the_mounty_about_block_link button button button-primary"><?php
							esc_html_e('Install plugins', 'the-mounty');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="the_mounty_about_block"><div class="the_mounty_about_block_inner">
						<h2 class="the_mounty_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'the-mounty'); ?>
						</h2>
						<div class="the_mounty_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'the-mounty');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   target="_blank"
						   class="the_mounty_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'the-mounty');
						?></a>
						<?php esc_html_e('or', 'the-mounty'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="the_mounty_about_block_link button"><?php
							esc_html_e('Theme Options', 'the-mounty');
						?></a>
					</div></div>
					
				</div>

				<?php do_action('the_mounty_action_theme_about_after_tabs_sections', $theme); ?>
				
			</div>

			<?php do_action('the_mounty_action_theme_about_after_tabs', $theme); ?>

		</div>
		<?php
	}
}


// Utils
//------------------------------------

// Return supported plugin's names
if (!function_exists('the_mounty_about_get_supported_plugins')) {
	function the_mounty_about_get_supported_plugins() {
		return '"' . join('", "', array_values(the_mounty_storage_get('required_plugins'))) . '"';
	}
}

require_once THE_MOUNTY_THEME_DIR . 'includes/plugins-installer/plugins-installer.php';
?>