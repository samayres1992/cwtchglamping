<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0.22
 */

if (!defined("THE_MOUNTY_THEME_FREE"))		define("THE_MOUNTY_THEME_FREE", false);
if (!defined("THE_MOUNTY_THEME_FREE_WP"))	define("THE_MOUNTY_THEME_FREE_WP", false);

// Theme storage
$THE_MOUNTY_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'the-mounty'),
			
			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'contact-form-7'				=> esc_html__('Contact Form 7', 'the-mounty'),
			'elegro-payment'				=> esc_html__('elegro Crypto Payment', 'the-mounty'),
			'date-time-picker-field'		=> esc_html__('Date Time Picker Field', 'the-mounty'),
			'woocommerce'					=> esc_html__('WooCommerce', 'the-mounty')

		),

		// List of plugins for the FREE version only
		//-----------------------------------------------------
		THE_MOUNTY_THEME_FREE 
			? array(
					// Recommended (supported) plugins for the FREE (lite) version
					) 

		// List of plugins for the PREMIUM version only
		//-----------------------------------------------------
			: array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'booked'					=> esc_html__('Booked Appointments', 'the-mounty'),
					'essential-grid'			=> esc_html__('Essential Grid', 'the-mounty'),
					'revslider'					=> esc_html__('Revolution Slider', 'the-mounty'),
					'the-events-calendar'		=> esc_html__('The Events Calendar', 'the-mounty'),
					'js_composer'				=> esc_html__('WPBakery PageBuilder', 'the-mounty'),
					'wp-gdpr-compliance'        => esc_html__( 'Cookie Information', 'the-mounty' ),
					'trx_updater'        		=> esc_html__( 'ThemeREX Updater', 'the-mounty' ),
					)
	),

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'		=> THE_MOUNTY_THEME_FREE 
								? 'env-ancora'
								: '',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> '//themounty.ancorathemes.com',
	'theme_doc_url'		=> '//themounty.ancorathemes.com/doc',
	'theme_download_url'=> '//themeforest.net/item/the-mounty-campground-camping-wordpress-theme/22357361',
	'theme_support_url'	=> '//themerex.net/support/',
	'theme_video_url'	=> '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',

	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'  => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'		=> array(
						// By device
						'desktop'	=> array('min' => 1680),
						'notebook'	=> array('min' => 1280, 'max' => 1679),
						'tablet'	=> array('min' =>  768, 'max' => 1279),
						'mobile'	=> array('max' =>  767),
						// By size
						'xxl'		=> array('max' => 1679),
						'xl'		=> array('max' => 1439),
						'lg'		=> array('max' => 1279),
						'md'		=> array('max' => 1023),
						'sm'		=> array('max' =>  767),
						'sm_wp'		=> array('max' =>  600),
						'xs'		=> array('max' =>  479)
						)
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('the_mounty_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'the_mounty_customizer_theme_setup1', 1 );
	function the_mounty_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		the_mounty_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for the main and the child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes

			'customize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame

			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'

			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> false,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false,		// Allow upload not pre-packaged plugins via TGMPA
			
			'allow_no_image'		=> false,		// Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.

			'separate_schemes'		=> true, 		// Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

			'allow_fullscreen'		=> false 		// Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
													// In the Page Options this styles are present always (can be removed if filter 'the_mounty_filter_allow_fullscreen' return false)
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		the_mounty_storage_set('load_fonts', array(
			// Google font
            array(
                'name'	 => 'Bree Serif',
                'family' => 'serif'
            ),
			array(
				'name'	 => 'Permanent Marker',
				'family' => 'cursive'
				),
			array(
				'name'	 => 'Candal',
				'family' => 'sans-serif'
				),
			// Font-face packed with theme
			array(
				'name'   => 'Montserrat',
				'family' => 'sans-serif'
				)
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		the_mounty_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags

		the_mounty_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'the-mounty'),
				'description'		=> esc_html__('Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'the-mounty'),
				'font-family'		=> '"Bree Serif",serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.6em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.6em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '4.333rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.333em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '1.0417em',
				'margin-bottom'		=> '0.5833em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '3.2rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.333em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '1.0952em',
				'margin-bottom'		=> '0.7619em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '2.4rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.333em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '1.4545em',
				'margin-bottom'		=> '0.7879em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '1.867em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.333em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '1.6923em',
				'margin-bottom'		=> '1em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '1.6rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.333em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '1.7em',
				'margin-bottom'		=> '1.3em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '1.2rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.333em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '1.4706em',
				'margin-bottom'		=> '0.9412em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'the-mounty'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'the-mounty'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'the-mounty'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '1em',
				'font-weight'		=> 'inherit',
				'font-style'		=> 'normal',
				'line-height'		=> '1.6em',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'the-mounty'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'the-mounty'),
				'font-family'		=> '"Permanent Marker",cursive',
				'font-size' 		=> '16px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.6em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'the-mounty'),
				'description'		=> esc_html__('Font settings of the main menu items', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'the-mounty'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'the-mounty'),
				'font-family'		=> '"Candal",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		the_mounty_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'the-mounty'),
							'description'	=> esc_html__('Colors of the main content area', 'the-mounty')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'the-mounty'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'the-mounty')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'the-mounty'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'the-mounty')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'the-mounty'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'the-mounty')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'the-mounty'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'the-mounty')
							),
			)
		);
		the_mounty_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'the-mounty'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'the-mounty')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'the-mounty'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'the-mounty')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'the-mounty'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'the-mounty')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'the-mounty'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'the-mounty')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'the-mounty'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'the-mounty')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'the-mounty'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'the-mounty')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'the-mounty'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'the-mounty')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'the-mounty'),
							'description'	=> esc_html__('Color of the links inside this block', 'the-mounty')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'the-mounty'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'the-mounty')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'the-mounty'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'the-mounty')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'the-mounty'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'the-mounty')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'the-mounty'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'the-mounty')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'the-mounty'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'the-mounty')
							)
			)
		);
		the_mounty_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'the-mounty'),
				'internal' => true,
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',
					'bd_color'			=> '#e5e5e5',
		
					// Text and links colors
					'text'				=> '#8c8c8c',
					'text_light'		=> '#b7b7b7',
					'text_dark'			=> '#2d2929',
					'text_link'			=> '#5b9a42',
					'text_hover'		=> '#f2682a',
					'text_link2'		=> '#efc429',
					'text_hover2'		=> '#e8c11e',
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#efeeea',
					'alter_bg_hover'	=> '#2d2929',
					'alter_bd_color'	=> '#e5e5e5',
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#333333',
					'alter_light'		=> '#b7b7b7',
					'alter_dark'		=> '#1d1d1d',
					'alter_link'		=> '#f2682a',
					'alter_hover'		=> '#72cfd5',
					'alter_link2'		=> '#899b8e',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1e1d22',
					'extra_bg_hover'	=> '#2d2929',
					'extra_bd_color'	=> '#313131',
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#bfbfbf',
					'extra_light'		=> '#afafaf',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#ffffff',
					'extra_hover'		=> '#f2682a',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#efeeea',
					'input_bg_hover'	=> '#efeeea',
					'input_bd_color'	=> '#efeeea',
					'input_bd_hover'	=> '#f2682a',
					'input_text'		=> '#848484',
					'input_light'		=> '#848484',
					'input_dark'		=> '#2d2929',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#ffffff',
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#e8c11e'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'the-mounty'),
				'internal' => true,
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#241e1e',
					'bd_color'			=> '#2e2c33',
		
					// Text and links colors
					'text'				=> '#b7b7b7',
					'text_light'		=> '#2d2929',
					'text_dark'			=> '#ffffff',
					'text_link'			=> '#5b9a42',
                    'text_hover'		=> '#f2682a',
                    'text_link2'		=> '#efc429',
					'text_hover2'		=> '#e8c11e',
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#2c2525',
					'alter_bg_hover'	=> '#333333',
					'alter_bd_color'	=> '#464646',
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#a6a6a6',
					'alter_light'		=> '#5f5f5f',
					'alter_dark'		=> '#ffffff',
					'alter_link'		=> '#ffaa5f',
					'alter_hover'		=> '#fe7259',
					'alter_link2'		=> '#899b8e',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1e1d22',
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#464646',
					'extra_bd_hover'	=> '#4a4a4a',
					'extra_text'		=> '#a6a6a6',
					'extra_light'		=> '#5f5f5f',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#ffaa5f',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#373030',
					'input_bg_hover'	=> '#373030',
					'input_bd_color'	=> '#373030',
					'input_bd_hover'	=> '#f26825',
					'input_text'		=> '#b7b7b7',
					'input_light'		=> '#5f5f5f',
					'input_dark'		=> '#ffffff',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#ffffff',
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			)
		
		));
		
		// Simple schemes substitution
		the_mounty_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		the_mounty_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' => 0.9),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'alter_link_02'		=> array('color' => 'alter_link',		'alpha' => 0.2),
			'alter_link_07'		=> array('color' => 'alter_link',		'alpha' => 0.7),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'extra_link_02'		=> array('color' => 'extra_link',		'alpha' => 0.2),
			'extra_link_07'		=> array('color' => 'extra_link',		'alpha' => 0.7),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_link_09'		=> array('color' => 'text_link',		'alpha' => 0.9),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		// Parameters to set order of schemes in the css
		the_mounty_storage_set('schemes_sorted', array(
													'color_scheme', 'header_scheme', 'menu_scheme', 'sidebar_scheme', 'footer_scheme'
													));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		the_mounty_storage_set('theme_thumbs', apply_filters('the_mounty_filter_add_thumb_sizes', array(
			// Width of the image is equal to the content area width (without sidebar)
			// Height is fixed
			'the_mounty-thumb-huge'		=> array(
												'size'	=> array(1280, 658, true),
												'title' => esc_html__( 'Huge image', 'the-mounty' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			// Width of the image is equal to the content area width (with sidebar)
			// Height is fixed
			'the_mounty-thumb-big' 		=> array(
												'size'	=> array( 765, 428, true),
												'title' => esc_html__( 'Large image', 'the-mounty' ),
												'subst'	=> 'trx_addons-thumb-big'
												),

			// Width of the image is equal to the 1/3 of the content area width (without sidebar)
			// Height is fixed
			'the_mounty-thumb-med' 		=> array(
												'size'	=> array( 407, 275, true),
												'title' => esc_html__( 'Medium image', 'the-mounty' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			// Small square image (for avatars in comments, etc.)
			'the_mounty-thumb-tiny' 		=> array(
												'size'	=> array(  120,  120, true),
												'title' => esc_html__( 'Small square avatar', 'the-mounty' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

			// Width of the image is equal to the content area width (with sidebar)
			// Height is proportional (only downscale, not crop)
			'the_mounty-thumb-masonry-big' => array(
												'size'	=> array( 765,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'the-mounty' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
			// Height is proportional (only downscale, not crop)
			'the_mounty-thumb-masonry'		=> array(
												'size'	=> array( 407,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'the-mounty' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'the_mounty_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'the_mounty_importer_set_options', 9 );
	function the_mounty_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(the_mounty_get_protocol() . '://demofiles.ancorathemes.com/the-mounty/');
			// Required plugins
			$options['required_plugins'] = array_keys(the_mounty_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 0;
			// Default demo
			$options['files']['default']['title'] = esc_html__('The Mounty Demo', 'the-mounty');
			$options['files']['default']['domain_dev'] = esc_url(the_mounty_get_protocol() . '://themounty.ancorathemes.com');		// Developers domain
			$options['files']['default']['domain_demo']= esc_url(the_mounty_get_protocol() . '://themounty.ancorathemes.com');		// Demo-site domain

			// Banners
			$options['banners'] = array(
				array(
					'image' => the_mounty_get_file_url('theme-specific/theme-about/images/frontpage.png'),
					'title' => esc_html__('Front Page Builder', 'the-mounty'),
					'content' => wp_kses(__("Create your front page right in the WordPress Customizer. There's no need any page builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'the-mounty'), 'the_mounty_kses_content' ),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('Watch Video Introduction', 'the-mounty'),
					'duration' => 20
					),
				array(
					'image' => the_mounty_get_file_url('theme-specific/theme-about/images/layouts.png'),
					'title' => esc_html__('Layouts Builder', 'the-mounty'),
					'content' => wp_kses(__('Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'the-mounty'), 'the_mounty_kses_content' ),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('Learn More', 'the-mounty'),
					'duration' => 20
					),
				array(
					'image' => the_mounty_get_file_url('theme-specific/theme-about/images/documentation.png'),
					'title' => esc_html__('Read Full Documentation', 'the-mounty'),
					'content' => wp_kses(__('Need more details? Please check our full online documentation for detailed information on how to use The Mounty', 'the-mounty'), 'the_mounty_kses_content' ),
					'link_url' => esc_url(the_mounty_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online Documentation', 'the-mounty'),
					'duration' => 15
					),
				array(
					'image' => the_mounty_get_file_url('theme-specific/theme-about/images/video-tutorials.png'),
					'title' => esc_html__('Video Tutorials', 'the-mounty'),
					'content' => wp_kses(__('No time for reading documentation? Check out our video tutorials and learn how to customize The Mounty in detail.', 'the-mounty'), 'the_mounty_kses_content' ),
					'link_url' => esc_url(the_mounty_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video Tutorials', 'the-mounty'),
					'duration' => 15
					),
				array(
					'image' => the_mounty_get_file_url('theme-specific/theme-about/images/studio.png'),
					'title' => esc_html__('Website Customization', 'the-mounty'),
					'content' => wp_kses(__("Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'the-mounty'), 'the_mounty_kses_content' ),
					'link_url' => esc_url('//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash'),
					'link_caption' => esc_html__('Contact Us', 'the-mounty'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}



// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('the_mounty_create_theme_options')) {

	function the_mounty_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = esc_html__('Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'the-mounty');
		
		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count(the_mounty_storage_get('schemes')) < 2;
		
		the_mounty_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'the-mounty'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'the-mounty'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'the-mounty'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'the-mounty') ),
				"class" => "the_mounty_column-1_2 the_mounty_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'the-mounty'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'the-mounty') ),
				"class" => "the_mounty_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_zoom' => array(
				"title" => esc_html__('Logo zoom', 'the-mounty'),
				"desc" => wp_kses_data( __("Zoom the logo. 1 - original size. Maximum size of logo depends on the actual size of the picture", 'the-mounty') ),
				"std" => 1,
				"min" => 0.2,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'the-mounty') ),
				"class" => "the_mounty_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'the-mounty') ),
				"class" => "the_mounty_column-1_2 the_mounty_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'the-mounty') ),
				"class" => "the_mounty_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'the-mounty') ),
				"class" => "the_mounty_column-1_2 the_mounty_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'the-mounty') ),
				"class" => "the_mounty_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'the-mounty') ),
				"class" => "the_mounty_column-1_2 the_mounty_new_row",
				"std" => '',
				"type" => "hidden"//"image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'the-mounty') ),
				"class" => "the_mounty_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => "hidden"//THE_MOUNTY_THEME_FREE ? "hidden" : "image"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'the-mounty'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'the-mounty'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'the-mounty'),
				"desc" => wp_kses_data( __('Select width of the body content', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'the-mounty')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => the_mounty_get_list_body_styles(false),
				"type" => "select"
				),
			'page_width' => array(
				"title" => esc_html__('Page width', 'the-mounty'),
				"desc" => wp_kses_data( __("Total width of the site content and sidebar (in pixels). If empty - use default width", 'the-mounty') ),
				"dependency" => array(
					'body_style' => array('boxed', 'wide')
				),
				"std" => 1280,
				"min" => 1000,
				"max" => 1400,
				"step" => 10,
				"refresh" => false,
				"customizer" => 'page',		// SASS name to preview changes 'on fly'
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "slider"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'the-mounty') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'the-mounty')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'the-mounty'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'the-mounty')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'the-mounty'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'the-mounty'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'the-mounty')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'the-mounty'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'the-mounty')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'sidebar_width' => array(
				"title" => esc_html__('Sidebar width', 'the-mounty'),
				"desc" => wp_kses_data( __("Width of the sidebar (in pixels). If empty - use default width", 'the-mounty') ),
				"std" => 405,
				"min" => 150,
				"max" => 500,
				"step" => 10,
				"refresh" => false,
				"customizer" => 'sidebar',		// SASS name to preview changes 'on fly'
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "slider"
				),
			'sidebar_gap' => array(
				"title" => esc_html__('Sidebar gap', 'the-mounty'),
				"desc" => wp_kses_data( __("Gap between content and sidebar (in pixels). If empty - use default gap", 'the-mounty') ),
				"std" => 110,
				"min" => 0,
				"max" => 110,
				"step" => 1,
				"refresh" => false,
				"customizer" => 'gap',		// SASS name to preview changes 'on fly'
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "slider"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'the-mounty'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'the-mounty') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'the-mounty'),
				"desc" => '',
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'the-mounty'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'the-mounty')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'the-mounty'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'the-mounty')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'the-mounty'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'the-mounty')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'the-mounty'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'the-mounty')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'the-mounty'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'the-mounty'),
				"desc" => wp_kses_data( __("Specify the border radius of the form fields and buttons in pixels", 'the-mounty') ),
				"std" => 0,
				"min" => 0,
				"max" => 20,
				"step" => 1,
				"refresh" => false,
				"customizer" => 'rad',		// SASS name to preview changes 'on fly'
				"type" => "hidden"//THE_MOUNTY_THEME_FREE ? "hidden" : "slider"
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'the-mounty'),
				"desc" => '',
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'the-mounty'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'the-mounty') ),
				"std" => 0,
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'the-mounty'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'the-mounty') ),
                "std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'the-mounty'), 'the_mounty_kses_content' ),
                "type"  => "text"
            ),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'the-mounty'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'the-mounty'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'the-mounty'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"std" => 'default',
				"options" => the_mounty_get_list_header_footer_types(),
				"type" => THE_MOUNTY_THEME_FREE || !the_mounty_exists_trx_addons() ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'the-mounty'),
				"desc" => wp_kses( __("Select custom header from Layouts Builder", 'the-mounty'), 'the_mounty_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'the-mounty'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"std" => 'default',
				"options" => array(),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'the-mounty'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"std" => 0,
				"type" => "hidden"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'the-mounty'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'the-mounty') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => "hidden"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwidth', 'the-mounty'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'the-mounty'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'the-mounty') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'the-mounty'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'the-mounty') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'the-mounty'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => the_mounty_get_list_range(0,6),
				"type" => "select"
				),

			'menu_style' => array(
				"title" => esc_html__('Menu position', 'the-mounty'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'the-mounty'),
					'left'	=> esc_html__('Left',	'the-mounty'),
					'right'	=> esc_html__('Right',	'the-mounty')
				),
				"type" => "hidden"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'the-mounty'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => "hidden"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'the-mounty'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => "hidden"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'the-mounty'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'the-mounty') ),
				"std" => 1,
				"type" => "hidden"
				),
            
            'header_image_info'             => array(
                'title' => esc_html__( 'Header image', 'the-mounty' ),
                'desc'  => '',
                'type'  => 'info',
            ),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'the-mounty'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'the-mounty') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"std" => 0,
				"type" => "hidden"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'the-mounty'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'the-mounty') ),
				"priority" => 500,
				"dependency" => array(
					'header_type' => array('default')
				),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'the-mounty'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'the-mounty') ),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 0,
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'the-mounty'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'the-mounty') ),
				"std" => '',
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'the-mounty'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'the-mounty'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'the-mounty'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'the-mounty'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'the-mounty'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'the-mounty'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'the-mounty'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'the-mounty')
				),
				"std" => 'default',
				"options" => the_mounty_get_list_header_footer_types(),
				"type" => THE_MOUNTY_THEME_FREE || !the_mounty_exists_trx_addons() ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'the-mounty'),
				"desc" => wp_kses( __("Select custom footer from Layouts Builder", 'the-mounty'), 'the_mounty_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'the-mounty')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'the-mounty'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'the-mounty')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'the-mounty'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'the-mounty')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => the_mounty_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwidth', 'the-mounty'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'the-mounty') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'the-mounty')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'the-mounty'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'the-mounty') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'the-mounty') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'the-mounty') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'the-mounty'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'the-mounty') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => !the_mounty_exists_trx_addons() ? "hidden" : "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'the-mounty'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'the-mounty') ),
				"translate" => true,
				"std" => esc_html__('AncoraThemes &copy; {Y}. All rights reserved.', 'the-mounty'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'the-mounty'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'the-mounty') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'the-mounty'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'the-mounty') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'the-mounty'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'the-mounty'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'the-mounty'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'the-mounty'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'the-mounty') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'the-mounty'),
						'fullpost'	=> esc_html__('Full post',	'the-mounty')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'the-mounty'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'the-mounty') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 60,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'the-mounty'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'the-mounty') ),
					"std" => 2,
					"options" => the_mounty_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'the-mounty'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'the-mounty'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'the-mounty'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'the-mounty'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'the-mounty'),
						'links'	=> esc_html__("Older/Newest", 'the-mounty'),
						'more'	=> esc_html__("Load more", 'the-mounty'),
						'infinite' => esc_html__("Infinite scroll", 'the-mounty')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'the-mounty'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'the-mounty'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'the-mounty'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'the-mounty') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'the-mounty'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'the-mounty') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'the-mounty'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'the-mounty') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'the-mounty'),
					"desc" => '',
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'the-mounty'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'the-mounty') ),
					"std" => 'hide',
					"options" => array(),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'the-mounty'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'the-mounty') ),
					"std" => 'hide',
					"options" => array(),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'the-mounty'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'the-mounty') ),
					"std" => 'hide',
					"options" => array(),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'the-mounty'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'the-mounty') ),
					"std" => 'hide',
					"options" => array(),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'the-mounty'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'the-mounty'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'the-mounty') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'the-mounty'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'the-mounty') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'the-mounty'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'the-mounty') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'the-mounty'),
						'columns' => esc_html__('Mini-cards',	'the-mounty')
					),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'the-mounty'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'the-mounty'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'the-mounty') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=0|date=1|counters=0|author=1|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'the-mounty'),
						'date'		 => esc_html__('Post date', 'the-mounty'),
						'author'	 => esc_html__('Post author', 'the-mounty'),
						'counters'	 => esc_html__('Post counters', 'the-mounty'),
						'share'		 => esc_html__('Share links', 'the-mounty'),
						'edit'		 => esc_html__('Edit link', 'the-mounty')
					),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Post counters', 'the-mounty'),
					"desc" => wp_kses_data( __("Show only selected counters. Attention! Likes and Views are available only if ThemeREX Addons is active", 'the-mounty') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0likes=0|comments=0',
					"options" => array(
						'views' => esc_html__('Views', 'the-mounty'),
						'likes' => esc_html__('Likes', 'the-mounty'),
						'comments' => esc_html__('Comments', 'the-mounty')
					),
					"type" => THE_MOUNTY_THEME_FREE || !the_mounty_exists_trx_addons() ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'the-mounty'),
					"desc" => wp_kses_data( __('Settings of the single post', 'the-mounty') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'the-mounty'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'the-mounty') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'the-mounty'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'the-mounty') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'the-mounty'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'the-mounty') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'the-mounty'),
					"desc" => wp_kses_data( __("Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'the-mounty') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'the-mounty') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=0|date=1|counters=1|author=1|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'the-mounty'),
						'date'		 => esc_html__('Post date', 'the-mounty'),
						'author'	 => esc_html__('Post author', 'the-mounty'),
						'counters'	 => esc_html__('Post counters', 'the-mounty'),
						'share'		 => esc_html__('Share links', 'the-mounty'),
						'edit'		 => esc_html__('Edit link', 'the-mounty')
					),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Post counters', 'the-mounty'),
					"desc" => wp_kses_data( __("Show only selected counters. Attention! Likes and Views are available only if plugin ThemeREX Addons is active", 'the-mounty') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=0|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'the-mounty'),
						'likes' => esc_html__('Likes', 'the-mounty'),
						'comments' => esc_html__('Comments', 'the-mounty')
					),
					"type" => THE_MOUNTY_THEME_FREE || !the_mounty_exists_trx_addons() ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'the-mounty'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'the-mounty') ),
					"std" => 1,
					"type" => !the_mounty_exists_trx_addons() ? "hidden" : "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'the-mounty'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'the-mounty') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'the-mounty'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'the-mounty'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'the-mounty') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'the-mounty')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'the-mounty'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'the-mounty') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => the_mounty_get_list_range(1,9),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'the-mounty'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'the-mounty') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => the_mounty_get_list_range(1,4),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'the-mounty'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'the-mounty') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => the_mounty_get_list_styles(1,2),
					"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'the-mounty'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'the-mounty'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'the-mounty') ),
				"hidden" => $hide_schemes,
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'the-mounty'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'the-mounty')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'the-mounty'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'the-mounty')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'the-mounty'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'the-mounty')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "hidden"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'the-mounty'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'the-mounty')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'the-mounty'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'the-mounty')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'the-mounty'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'the-mounty') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'the-mounty'),
				"desc" => '',
				"std" => '$the_mounty_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'the-mounty'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'the-mounty') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'the-mounty')
				),
				"hidden" => true,
				"std" => '',
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'the-mounty'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'the-mounty') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'the-mounty')
				),
				"hidden" => true,
				"std" => '',
				"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'the-mounty'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'the-mounty'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'the-mounty') )
						. '<br>'
						. wp_kses_data( __('Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'the-mounty') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'the-mounty'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'the-mounty') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'the-mounty') ),
				"class" => "the_mounty_column-1_3 the_mounty_new_row",
				"refresh" => false,
				"std" => '$the_mounty_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=the_mounty_get_theme_setting('max_load_fonts'); $i++) {
			if (the_mounty_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'the-mounty'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'the-mounty'),
				"desc" => '',
				"class" => "the_mounty_column-1_3 the_mounty_new_row",
				"refresh" => false,
				"std" => '$the_mounty_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'the-mounty'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'the-mounty') )
							: '',
				"class" => "the_mounty_column-1_3",
				"refresh" => false,
				"std" => '$the_mounty_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'the-mounty'),
					'serif' => esc_html__('serif', 'the-mounty'),
					'sans-serif' => esc_html__('sans-serif', 'the-mounty'),
					'monospace' => esc_html__('monospace', 'the-mounty'),
					'cursive' => esc_html__('cursive', 'the-mounty'),
					'fantasy' => esc_html__('fantasy', 'the-mounty')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'the-mounty'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'the-mounty') )
								. '<br>'
								. wp_kses_data( __('Attention! Each weight and style increase download size! Specify only used weights and styles.', 'the-mounty') )
							: '',
				"class" => "the_mounty_column-1_3",
				"refresh" => false,
				"std" => '$the_mounty_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = the_mounty_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'the-mounty'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses( sprintf(__('Font settings of the "%s" tag.', 'the-mounty'), $tag), 'the_mounty_kses_content' ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$load_order = 1;
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
					$load_order = 2;		// Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'the-mounty'),
						'100' => esc_html__('100 (Light)', 'the-mounty'), 
						'200' => esc_html__('200 (Light)', 'the-mounty'), 
						'300' => esc_html__('300 (Thin)',  'the-mounty'),
						'400' => esc_html__('400 (Normal)', 'the-mounty'),
						'500' => esc_html__('500 (Semibold)', 'the-mounty'),
						'600' => esc_html__('600 (Semibold)', 'the-mounty'),
						'700' => esc_html__('700 (Bold)', 'the-mounty'),
						'800' => esc_html__('800 (Black)', 'the-mounty'),
						'900' => esc_html__('900 (Black)', 'the-mounty')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'the-mounty'),
						'normal' => esc_html__('Normal', 'the-mounty'), 
						'italic' => esc_html__('Italic', 'the-mounty')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'the-mounty'),
						'none' => esc_html__('None', 'the-mounty'), 
						'underline' => esc_html__('Underline', 'the-mounty'),
						'overline' => esc_html__('Overline', 'the-mounty'),
						'line-through' => esc_html__('Line-through', 'the-mounty')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'the-mounty'),
						'none' => esc_html__('None', 'the-mounty'), 
						'uppercase' => esc_html__('Uppercase', 'the-mounty'),
						'lowercase' => esc_html__('Lowercase', 'the-mounty'),
						'capitalize' => esc_html__('Capitalize', 'the-mounty')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "the_mounty_column-1_5",
					"refresh" => false,
					"load_order" => $load_order,
					"std" => '$the_mounty_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		the_mounty_storage_set_array_before('options', 'panel_colors', $fonts);


		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if (!function_exists('get_header_video_url')) {
			the_mounty_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'the-mounty'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'the-mounty') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'the-mounty')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}


		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		// ------------------------------------------------------
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			the_mounty_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'the-mounty'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'the-mounty') ),
				"class" => "the_mounty_column-1_2 the_mounty_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('the_mounty_options_get_list_cpt_options')) {
	function the_mounty_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'the-mounty'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'the-mounty') ),
						"std" => 'inherit',
						"options" => the_mounty_get_list_header_footer_types(true),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'the-mounty'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'the-mounty'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'the-mounty'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'the-mounty'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'the-mounty'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'the-mounty') ),
						"std" => 'inherit',
						"options" => array(
							'inherit' => esc_html__('Inherit', 'the-mounty'),
							1 => esc_html__('Yes', 'the-mounty'),
							0 => esc_html__('No', 'the-mounty'),
						),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "switch"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'the-mounty'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'the-mounty'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'the-mounty'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'the-mounty'), $title) ),
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'the-mounty'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'the-mounty'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => $cpt === 'shop' ? 'woocommerce_widgets' : 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'the-mounty'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'the-mounty') ),
						"std" => 'inherit',
						"options" => array(
							'inherit' => esc_html__('Inherit', 'the-mounty'),
							1 => esc_html__('Hide', 'the-mounty'),
							0 => esc_html__('Show', 'the-mounty'),
						),
						"type" => "switch"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'the-mounty'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'the-mounty') ),
						"std" => 'inherit',
						"options" => the_mounty_get_list_header_footer_types(true),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'the-mounty'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'the-mounty') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'the-mounty'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'the-mounty') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'the-mounty'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'the-mounty') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => the_mounty_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwidth', 'the-mounty'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'the-mounty') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'the-mounty'),
						"desc" => '',
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'the-mounty'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'the-mounty') ),
						"std" => 'hide',
						"options" => array(),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'the-mounty'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'the-mounty') ),
						"std" => 'hide',
						"options" => array(),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'the-mounty'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'the-mounty') ),
						"std" => 'hide',
						"options" => array(),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'the-mounty'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'the-mounty') ),
						"std" => 'hide',
						"options" => array(),
						"type" => THE_MOUNTY_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('the_mounty_options_get_list_choises')) {
	add_filter('the_mounty_filter_options_get_list_choises', 'the_mounty_options_get_list_choises', 10, 2);
	function the_mounty_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = the_mounty_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = the_mounty_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = the_mounty_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (strpos($id, '_scheme') > 0)
				$list = the_mounty_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = the_mounty_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = the_mounty_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = the_mounty_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = the_mounty_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = the_mounty_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = the_mounty_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = the_mounty_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = the_mounty_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = the_mounty_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = the_mounty_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = the_mounty_array_merge(array(0 => esc_html__('- Select category -', 'the-mounty')), the_mounty_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = the_mounty_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = the_mounty_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = the_mounty_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>