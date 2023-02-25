<?php
/* ThemeREX Addons support functions
------------------------------------------------------------------------------- */

// Add theme-specific functions
require_once THE_MOUNTY_THEME_DIR . 'theme-specific/trx_addons-setup.php';

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('the_mounty_trx_addons_theme_setup1')) {
	add_action( 'after_setup_theme', 'the_mounty_trx_addons_theme_setup1', 1 );
	function the_mounty_trx_addons_theme_setup1() {
		if (the_mounty_exists_trx_addons()) {
			add_filter( 'the_mounty_filter_list_posts_types',			'the_mounty_trx_addons_list_post_types');
			add_filter( 'the_mounty_filter_list_header_footer_types',	'the_mounty_trx_addons_list_header_footer_types');
			add_filter( 'the_mounty_filter_list_header_styles',		'the_mounty_trx_addons_list_header_styles');
			add_filter( 'the_mounty_filter_list_footer_styles',		'the_mounty_trx_addons_list_footer_styles');
			add_action( 'the_mounty_action_load_options',				'the_mounty_trx_addons_add_link_edit_layout');
			add_filter( 'trx_addons_filter_default_layouts',		'the_mounty_trx_addons_default_layouts');
			add_filter( 'trx_addons_filter_load_options',			'the_mounty_trx_addons_default_components');
			add_filter( 'trx_addons_cpt_list_options',				'the_mounty_trx_addons_cpt_list_options', 10, 2);
			add_filter( 'trx_addons_filter_sass_import',			'the_mounty_trx_addons_sass_import', 10, 2);
			add_filter( 'trx_addons_filter_override_options', 'the_mounty_trx_addons_override_options' );
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('the_mounty_trx_addons_theme_setup9')) {
	add_action( 'after_setup_theme', 'the_mounty_trx_addons_theme_setup9', 9 );
	function the_mounty_trx_addons_theme_setup9() {
		if (the_mounty_exists_trx_addons()) {
			add_filter( 'trx_addons_filter_add_thumb_sizes',			'the_mounty_trx_addons_add_thumb_sizes');
			add_filter( 'trx_addons_filter_get_thumb_size',				'the_mounty_trx_addons_get_thumb_size');
			add_filter( 'trx_addons_filter_featured_image',				'the_mounty_trx_addons_featured_image', 10, 2);
			add_filter( 'trx_addons_filter_no_image',					'the_mounty_trx_addons_no_image' );
			add_filter( 'trx_addons_filter_get_list_icons',				'the_mounty_trx_addons_get_list_icons', 10, 2 );
			add_action( 'wp_enqueue_scripts', 							'the_mounty_trx_addons_frontend_scripts', 1100 );
			add_filter( 'the_mounty_filter_query_sort_order',	 			'the_mounty_trx_addons_query_sort_order', 10, 3);
			add_filter( 'the_mounty_filter_merge_scripts',					'the_mounty_trx_addons_merge_scripts');
			add_filter( 'the_mounty_filter_prepare_css',					'the_mounty_trx_addons_prepare_css', 10, 2);
			add_filter( 'the_mounty_filter_prepare_js',					'the_mounty_trx_addons_prepare_js', 10, 2);
			add_filter( 'the_mounty_filter_localize_script',				'the_mounty_trx_addons_localize_script');
			add_filter( 'the_mounty_filter_get_post_categories',		 	'the_mounty_trx_addons_get_post_categories');
			add_filter( 'the_mounty_filter_get_post_date',		 			'the_mounty_trx_addons_get_post_date');
			add_filter( 'trx_addons_filter_get_post_date',		 		'the_mounty_trx_addons_get_post_date_wrap');
			add_filter( 'the_mounty_filter_post_type_taxonomy',			'the_mounty_trx_addons_post_type_taxonomy', 10, 2 );
			add_filter( 'trx_addons_filter_theme_logo',					'the_mounty_trx_addons_theme_logo');
			add_filter( 'trx_addons_filter_show_site_name_as_logo',		'the_mounty_trx_addons_show_site_name_as_logo');
			add_filter( 'trx_addons_filter_post_meta',					'the_mounty_trx_addons_post_meta', 10, 2);
			add_filter( 'trx_addons_filters_get_theme_info',			'the_mounty_trx_addons_get_theme_info', 9);
			add_filter( 'the_mounty_filter_sidebar_present',				'the_mounty_trx_addons_sidebar_present' );
			if (is_admin()) {
				add_filter( 'the_mounty_filter_allow_override_options', 'the_mounty_trx_addons_allow_override_options', 10, 2 );
				add_filter( 'the_mounty_filter_allow_theme_icons', 		'the_mounty_trx_addons_allow_theme_icons', 10, 2);
				add_filter( 'trx_addons_filter_export_options',			'the_mounty_trx_addons_export_options');
			} else {
				add_filter( 'trx_addons_filter_inc_views',		 		'the_mounty_trx_addons_inc_views');
				add_filter( 'the_mounty_filter_post_meta_args',			'the_mounty_trx_addons_post_meta_args', 10, 3);
				add_filter( 'trx_addons_filter_args_related',			'the_mounty_trx_addons_args_related');
				add_filter( 'trx_addons_filter_seo_snippets',			'the_mounty_trx_addons_seo_snippets');
				add_action( 'trx_addons_action_before_article',			'the_mounty_trx_addons_before_article', 10, 1);
				add_filter( 'the_mounty_filter_get_mobile_menu',			'the_mounty_trx_addons_get_mobile_menu');
				add_filter( 'the_mounty_filter_detect_blog_mode',			'the_mounty_trx_addons_detect_blog_mode' );
				add_filter( 'the_mounty_filter_get_blog_title', 			'the_mounty_trx_addons_get_blog_title');
				add_action( 'the_mounty_action_login',						'the_mounty_trx_addons_action_login');
				add_action( 'the_mounty_action_cart',						'the_mounty_trx_addons_action_cart');
				add_action( 'the_mounty_action_breadcrumbs',				'the_mounty_trx_addons_action_breadcrumbs');
				add_action( 'the_mounty_action_show_layout',				'the_mounty_trx_addons_action_show_layout', 10, 1);
				add_filter( 'the_mounty_filter_get_translated_layout',		'the_mounty_trx_addons_filter_get_translated_layout', 10, 1);
				add_filter( 'trx_addons_filter_sc_layout_content',		'the_mounty_trx_addons_replace_current_year', 20, 2 );
				add_action( 'the_mounty_action_user_meta',					'the_mounty_trx_addons_action_user_meta');
				add_action( 'the_mounty_action_before_post_meta',			'the_mounty_trx_addons_action_before_post_meta');
				add_filter( 'trx_addons_filter_featured_image_override','the_mounty_trx_addons_featured_image_override');
				add_filter( 'trx_addons_filter_get_current_mode_image',	'the_mounty_trx_addons_get_current_mode_image');
				add_filter( 'the_mounty_filter_related_thumb_size',		'the_mounty_trx_addons_related_thumb_size');
				add_filter( 'the_mounty_filter_get_post_iframe', 			'the_mounty_trx_addons_get_post_iframe', 10, 1);
			}
		}

		// Add this filter any time: if plugin exists - load plugin's styles, if not exists - load layouts.scss instead plugin's styles
		add_action( 'wp_enqueue_scripts', 								'the_mounty_trx_addons_layouts_styles' );
		add_filter( 'the_mounty_filter_merge_styles',						'the_mounty_trx_addons_merge_styles');
		add_filter( 'the_mounty_filter_merge_styles_responsive',			'the_mounty_trx_addons_merge_styles_responsive');

		if (is_admin()) {
			add_filter( 'the_mounty_filter_tgmpa_required_plugins',		'the_mounty_trx_addons_tgmpa_required_plugins' );
		} else {
			add_action( 'the_mounty_action_search',						'the_mounty_trx_addons_action_search', 10, 3);
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'the_mounty_trx_addons_tgmpa_required_plugins' ) ) {
	
	function the_mounty_trx_addons_tgmpa_required_plugins($list=array()) {
		if (the_mounty_storage_isset('required_plugins', 'trx_addons')) {
			$path = the_mounty_get_file_dir('plugins/trx_addons/trx_addons.zip');
			if (!empty($path) || the_mounty_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> the_mounty_storage_get_array('required_plugins', 'trx_addons'),
					'slug' 		=> 'trx_addons',
					'version'	=> '1.71.46.4',
					'source'	=> !empty($path) ? $path : 'upload://trx_addons.zip',
					'required' 	=> true
				);
			}
		}
		return $list;
	}
}


/* Add options in the Theme Options Customizer
------------------------------------------------------------------------------- */

if (!function_exists('the_mounty_trx_addons_cpt_list_options')) {
	
	function the_mounty_trx_addons_cpt_list_options($options, $cpt) {
		if ($cpt == 'layouts' && THE_MOUNTY_THEME_FREE) {
			$options = array();
		} else if (is_array($options)) {
			foreach ($options as $k=>$v) {
				// Store this option in the external (not theme's) storage
				$options[$k]['options_storage'] = 'trx_addons_options';
				// Hide this option from plugin's options (only for overriden options)
				$options[$k]['hidden'] = in_array($cpt, array('cars', 'cars_agents', 'certificates', 'courses', 'dishes', 'portfolio', 'properties', 'agents', 'resume', 'services', 'sport', 'team', 'testimonials'));
			}
		}
		return $options;
	}
}

// Return plugin's specific options for CPT
if (!function_exists('the_mounty_trx_addons_get_list_cpt_options')) {
	function the_mounty_trx_addons_get_list_cpt_options($cpt) {
		$options = array();
		if ($cpt == 'cars')
			$options = array_merge(
						trx_addons_cpt_cars_get_list_options(),
						trx_addons_cpt_cars_agents_get_list_options()
						);
		else if ($cpt == 'certificates')
			$options = trx_addons_cpt_certificates_get_list_options();
		else if ($cpt == 'courses')
			$options = trx_addons_cpt_courses_get_list_options();
		else if ($cpt == 'dishes')
			$options = trx_addons_cpt_dishes_get_list_options();
		else if ($cpt == 'portfolio')
			$options = trx_addons_cpt_portfolio_get_list_options();
		else if ($cpt == 'resume')
			$options = trx_addons_cpt_resume_get_list_options();
		else if ($cpt == 'services')
			$options = trx_addons_cpt_services_get_list_options();
		else if ($cpt == 'properties')
			$options = array_merge(
						trx_addons_cpt_properties_get_list_options(),
						trx_addons_cpt_agents_get_list_options()
						);
		else if ($cpt == 'sport')
			$options = trx_addons_cpt_sport_get_list_options();
		else if ($cpt == 'team')
			$options = trx_addons_cpt_team_get_list_options();
		else if ($cpt == 'testimonials')
			$options = trx_addons_cpt_testimonials_get_list_options();

		foreach ($options as $k=>$v) {
			// Disable refresh the preview area on change any plugin's option
			$options[$k]['refresh'] = false;
			// Remove parameter 'hidden'
			if (!empty($v['hidden']))
				unset($options[$k]['hidden']);
			// Add description
			if ($v['type'] == 'info')
				$options[$k]['desc'] = wp_kses_data(__('In order to see changes made by settings of this section, click "Save" and refresh the page', 'the-mounty'));
		}
		return $options;
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('the_mounty_trx_addons_setup3')) {
	add_action( 'after_setup_theme', 'the_mounty_trx_addons_setup3', 3 );
	function the_mounty_trx_addons_setup3() {

		// Section 'Cars' - settings to show 'Cars' blog archive and single posts
		if (the_mounty_exists_cars()) {
			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'cars' => array(
						"title" => esc_html__('Cars', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the cars pages.', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('cars'),
				the_mounty_options_get_list_cpt_options('cars'),
				array(
					"single_info_cars" => array(
						"title" => esc_html__('Single car', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					'show_related_posts_cars' => array(
						"title" => esc_html__('Show related posts', 'the-mounty'),
						"desc" => wp_kses_data( __("Show section 'Related cars' on the single car page", 'the-mounty') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'related_posts_cars' => array(
						"title" => esc_html__('Related cars', 'the-mounty'),
						"desc" => wp_kses_data( __('How many related cars should be displayed on the single car page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_cars' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,9),
						"type" => "select"
						),
					'related_columns_cars' => array(
						"title" => esc_html__('Related columns', 'the-mounty'),
						"desc" => wp_kses_data( __('How many columns should be used to output related cars on the single car page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_cars' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,4),
						"type" => "select"
						)
				)
			));
		}

		// Section 'Certificates'
		if (the_mounty_exists_certificates()) {
			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'certificates' => array(
						"title" => esc_html__('Certificates', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display "Certificates"', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('certificates')
			));
		}

		// Section 'Courses' - settings to show 'Courses' blog archive and single posts
		if (the_mounty_exists_courses()) {

			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'courses' => array(
						"title" => esc_html__('Courses', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the courses pages', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('courses'),
				the_mounty_options_get_list_cpt_options('courses'),
				array(
					"single_info_courses" => array(
						"title" => esc_html__('Single course', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					'show_related_posts_courses' => array(
						"title" => esc_html__('Show related posts', 'the-mounty'),
						"desc" => wp_kses_data( __("Show section 'Related courses' on the single course page", 'the-mounty') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'related_posts_courses' => array(
						"title" => esc_html__('Related courses', 'the-mounty'),
						"desc" => wp_kses_data( __('How many related courses should be displayed on the single course page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_courses' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,9),
						"type" => "select"
						),
					'related_columns_courses' => array(
						"title" => esc_html__('Related columns', 'the-mounty'),
						"desc" => wp_kses_data( __('How many columns should be used to output related courses on the single course page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_courses' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,4),
						"type" => "select"
						)
				)
			));
		}

		// Section 'Dishes' - settings to show 'Dishes' blog archive and single posts
		if (the_mounty_exists_dishes()) {

			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'dishes' => array(
						"title" => esc_html__('Dishes', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the dishes pages', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('dishes'),
				the_mounty_options_get_list_cpt_options('dishes'),
				array(
					"single_info_dishes" => array(
						"title" => esc_html__('Single dish', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					'show_related_posts_dishes' => array(
						"title" => esc_html__('Show related posts', 'the-mounty'),
						"desc" => wp_kses_data( __("Show section 'Related dishes' on the single dish page", 'the-mounty') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'related_posts_dishes' => array(
						"title" => esc_html__('Related dishes', 'the-mounty'),
						"desc" => wp_kses_data( __('How many related dishes should be displayed on the single dish page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_dishes' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,9),
						"type" => "select"
						),
					'related_columns_dishes' => array(
						"title" => esc_html__('Related columns', 'the-mounty'),
						"desc" => wp_kses_data( __('How many columns should be used to output related dishes on the single dish page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_dishes' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,4),
						"type" => "select"
						)
					)
				)
			);
		}

		// Section 'Portfolio' - settings to show 'Portfolio' blog archive and single posts
		if (the_mounty_exists_portfolio()) {
			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'portfolio' => array(
						"title" => esc_html__('Portfolio', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the portfolio pages', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('portfolio'),
				the_mounty_options_get_list_cpt_options('portfolio'),
				array(
					"single_info_portfolio" => array(
						"title" => esc_html__('Single portfolio item', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					'show_related_posts_portfolio' => array(
						"title" => esc_html__('Show related posts', 'the-mounty'),
						"desc" => wp_kses_data( __("Show section 'Related portfolio items' on the single portfolio page", 'the-mounty') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'related_posts_portfolio' => array(
						"title" => esc_html__('Related portfolio items', 'the-mounty'),
						"desc" => wp_kses_data( __('How many related portfolio items should be displayed on the single portfolio page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_portfolio' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,9),
						"type" => "select"
						),
					'related_columns_portfolio' => array(
						"title" => esc_html__('Related columns', 'the-mounty'),
						"desc" => wp_kses_data( __('How many columns should be used to output related portfolio on the single portfolio page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_portfolio' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,4),
						"type" => "select"
						)
				)
			));
		}

		// Section 'Properties' - settings to show 'Properties' blog archive and single posts
		if (the_mounty_exists_properties()) {

			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'properties' => array(
						"title" => esc_html__('Properties', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the properties pages', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('properties'),
				the_mounty_options_get_list_cpt_options('properties'),
				array(
					"single_info_properties" => array(
						"title" => esc_html__('Single property', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					'show_related_posts_properties' => array(
						"title" => esc_html__('Show related posts', 'the-mounty'),
						"desc" => wp_kses_data( __("Show section 'Related properties' on the single property page", 'the-mounty') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'related_posts_properties' => array(
						"title" => esc_html__('Related properties', 'the-mounty'),
						"desc" => wp_kses_data( __('How many related properties should be displayed on the single property page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_properties' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,9),
						"type" => "select"
						),
					'related_columns_properties' => array(
						"title" => esc_html__('Related columns', 'the-mounty'),
						"desc" => wp_kses_data( __('How many columns should be used to output related properties on the single property page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_properties' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,4),
						"type" => "select"
						)
					)
				)
			);
		}

		// Section 'Resume'
		if (the_mounty_exists_resume()) {
			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'resume' => array(
						"title" => esc_html__('Resume', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display "Resume"', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('resume')
			));
		}

		// Section 'Services' - settings to show 'Services' blog archive and single posts
		if (the_mounty_exists_services()) {

			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'services' => array(
						"title" => esc_html__('Services', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the services pages', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('services'),
				the_mounty_options_get_list_cpt_options('services'),
				array(
					"single_info_services" => array(
						"title" => esc_html__('Single service item', 'the-mounty'),
						"desc" => '',
						"type" => "info",
						),
					'show_related_posts_services' => array(
						"title" => esc_html__('Show related posts', 'the-mounty'),
						"desc" => wp_kses_data( __("Show section 'Related services' on the single service page", 'the-mounty') ),
						"std" => 0,
						"type" => "checkbox"
						),
					'related_posts_services' => array(
						"title" => esc_html__('Related services', 'the-mounty'),
						"desc" => wp_kses_data( __('How many related services should be displayed on the single service page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_services' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,9),
						"type" => "select"
						),
					'related_columns_services' => array(
						"title" => esc_html__('Related columns', 'the-mounty'),
						"desc" => wp_kses_data( __('How many columns should be used to output related services on the single service page?', 'the-mounty') ),
						"dependency" => array(
							'show_related_posts_services' => array(1)
						),
						"std" => 3,
						"options" => the_mounty_get_list_range(1,4),
						"type" => "select"
						)
				)
			));
		}

		// Section 'Sport' - settings to show 'Sport' blog archive and single posts
		if (the_mounty_exists_sport()) {
			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'sport' => array(
						"title" => esc_html__('Sport', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the sport pages', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('sport'),
				the_mounty_options_get_list_cpt_options('sport')
			));
		}

		// Section 'Team' - settings to show 'Team' blog archive and single posts
		if (the_mounty_exists_team()) {
			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'team' => array(
						"title" => esc_html__('Team', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display the team members pages.', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('team'),
				the_mounty_options_get_list_cpt_options('team')
			));
		}

		// Section 'Testimonials'
		if (the_mounty_exists_resume()) {
			the_mounty_storage_merge_array('options', '', array_merge(
				array(
					'testimonials' => array(
						"title" => esc_html__('Testimonials', 'the-mounty'),
						"desc" => wp_kses_data( __('Select parameters to display "Testimonials"', 'the-mounty') ),
						"type" => "section"
						)
				),
				the_mounty_trx_addons_get_list_cpt_options('testimonials')
			));
		}
	}
}

// Add 'layout edit' link to the 'description' in the 'header_style' and 'footer_style' parameters
if ( !function_exists('the_mounty_trx_addons_add_link_edit_layout') ) {
	
	function the_mounty_trx_addons_add_link_edit_layout() {
		static $added = false;
		if ($added) return;
		$added = true;
		$options = the_mounty_storage_get('options');
		foreach($options as $k=>$v) {
			if (!isset($v['std'])) continue;
			$k1 = substr($k, 0, 12);
			if ($k1=='header_style' || $k1=='footer_style') {
				$layout = the_mounty_get_theme_option($k);
				if (the_mounty_is_inherit($layout))
					$layout = the_mounty_get_theme_option($k1);
				if (!empty($layout)) {
					$layout = explode('-', $layout);
					$layout = $layout[count($layout)-1];
					if ((int) $layout > 0) {
						the_mounty_storage_set_array2('options', $k, 'desc', $v['desc']
												. '<br>'
												. sprintf('<a href="%1$s" class="the_mounty_post_editor'.(intval($layout)==0 ? ' the_mounty_hidden' : '').'" target="_blank">%2$s</a>',
															admin_url( sprintf( "post.php?post=%d&amp;action=edit", $layout ) ),
															__("Open selected layout in a new tab to edit", 'the-mounty')
														)
												);
					}
				}
			}
		}
	}
}


// Setup internal plugin's parameters
if (!function_exists('the_mounty_trx_addons_init_settings')) {
	add_filter( 'trx_addons_init_settings', 'the_mounty_trx_addons_init_settings');
	function the_mounty_trx_addons_init_settings($settings) {
		$settings['socials_type']	= the_mounty_get_theme_setting('socials_type');
		$settings['icons_type']		= the_mounty_get_theme_setting('icons_type');
		$settings['icons_selector']	= the_mounty_get_theme_setting('icons_selector');
		return $settings;
	}
}


// Return theme-specific data to the dashboard widget
if (!function_exists('the_mounty_trx_addons_get_theme_info')) {
	
	function the_mounty_trx_addons_get_theme_info($theme_info) {
		$theme_info['theme_activated'] = (int) get_option( "the_mounty_theme_activated" );
		$theme_info['theme_page_url'] = admin_url() . 'themes.php?page=the_mounty_about';
		$theme_info['theme_plugins'] = join(',', array_keys(the_mounty_storage_get('required_plugins')));
		$theme_info['theme_categories'] = the_mounty_storage_get('theme_categories');
		$theme_info['theme_actions'] = array(
						'demo' => array(
										'link' => the_mounty_storage_get('theme_demo_url'),
										'title' => esc_html__('Demo', 'the-mounty')
										),
						'doc' => array(
										'link' => the_mounty_storage_get('theme_doc_url'),
										'title' => esc_html__('Docs', 'the-mounty')
										),
						'support' => array(
										'link' => the_mounty_storage_get('theme_support_url'),
										'title' => esc_html__('Support', 'the-mounty')
										)
						);
		if (THE_MOUNTY_THEME_FREE) {
			$theme_info['theme_name'] .= ' ' . esc_html__('Free', 'the-mounty');
			$theme_info['theme_actions']['pro'] = array(
										'link' => the_mounty_storage_get('theme_download_url'),
										'title' => esc_html__('Go Pro', 'the-mounty')
										);
		}
		return $theme_info;
	}
}


// Hide sidebar on the news feed pages
if ( !function_exists( 'the_mounty_trx_addons_sidebar_present' ) ) {
	
	function the_mounty_trx_addons_sidebar_present($present) {
		return get_post_type() != 'trx_feed' && $present;
	}
}




/* Plugin's support utilities
------------------------------------------------------------------------------- */

// Check if plugin installed and activated
if ( !function_exists( 'the_mounty_exists_trx_addons' ) ) {
	function the_mounty_exists_trx_addons() {
		return defined('TRX_ADDONS_VERSION');
	}
}

// Return true if cars is supported
if ( !function_exists( 'the_mounty_exists_cars' ) ) {
	function the_mounty_exists_cars() {
		return defined('TRX_ADDONS_CPT_CARS_PT');
	}
}

// Return true if certificates is supported
if ( !function_exists( 'the_mounty_exists_certificates' ) ) {
	function the_mounty_exists_certificates() {
		return defined('TRX_ADDONS_CPT_CERTIFICATES_PT');
	}
}

// Return true if courses is supported
if ( !function_exists( 'the_mounty_exists_courses' ) ) {
	function the_mounty_exists_courses() {
		return defined('TRX_ADDONS_CPT_COURSES_PT');
	}
}

// Return true if dishes is supported
if ( !function_exists( 'the_mounty_exists_dishes' ) ) {
	function the_mounty_exists_dishes() {
		return defined('TRX_ADDONS_CPT_DISHES_PT');
	}
}

// Return true if layouts is supported
if ( !function_exists( 'the_mounty_exists_layouts' ) ) {
	function the_mounty_exists_layouts() {
		return defined('TRX_ADDONS_CPT_LAYOUTS_PT');
	}
}

// Return true if portfolio is supported
if ( !function_exists( 'the_mounty_exists_portfolio' ) ) {
	function the_mounty_exists_portfolio() {
		return defined('TRX_ADDONS_CPT_PORTFOLIO_PT');
	}
}

// Return true if properties is supported
if ( !function_exists( 'the_mounty_exists_properties' ) ) {
	function the_mounty_exists_properties() {
		return defined('TRX_ADDONS_CPT_PROPERTIES_PT');
	}
}

// Return true if resume is supported
if ( !function_exists( 'the_mounty_exists_resume' ) ) {
	function the_mounty_exists_resume() {
		return defined('TRX_ADDONS_CPT_RESUME_PT');
	}
}

// Return true if services is supported
if ( !function_exists( 'the_mounty_exists_services' ) ) {
	function the_mounty_exists_services() {
		return defined('TRX_ADDONS_CPT_SERVICES_PT');
	}
}

// Return true if sport is supported
if ( !function_exists( 'the_mounty_exists_sport' ) ) {
	function the_mounty_exists_sport() {
		return defined('TRX_ADDONS_CPT_COMPETITIONS_PT');
	}
}

// Return true if team is supported
if ( !function_exists( 'the_mounty_exists_team' ) ) {
	function the_mounty_exists_team() {
		return defined('TRX_ADDONS_CPT_TEAM_PT');
	}
}

// Return true if testimonials is supported
if ( !function_exists( 'the_mounty_exists_testimonials' ) ) {
	function the_mounty_exists_testimonials() {
		return defined('TRX_ADDONS_CPT_TESTIMONIALS_PT');
	}
}


// Return true if it's cars page
if ( !function_exists( 'the_mounty_is_cars_page' ) ) {
	function the_mounty_is_cars_page() {
		return function_exists('trx_addons_is_cars_page') && trx_addons_is_cars_page();
	}
}

// Return true if it's courses page
if ( !function_exists( 'the_mounty_is_courses_page' ) ) {
	function the_mounty_is_courses_page() {
		return function_exists('trx_addons_is_courses_page') && trx_addons_is_courses_page();
	}
}

// Return true if it's dishes page
if ( !function_exists( 'the_mounty_is_dishes_page' ) ) {
	function the_mounty_is_dishes_page() {
		return function_exists('trx_addons_is_dishes_page') && trx_addons_is_dishes_page();
	}
}

// Return true if it's properties page
if ( !function_exists( 'the_mounty_is_properties_page' ) ) {
	function the_mounty_is_properties_page() {
		return function_exists('trx_addons_is_properties_page') && trx_addons_is_properties_page();
	}
}

// Return true if it's portfolio page
if ( !function_exists( 'the_mounty_is_portfolio_page' ) ) {
	function the_mounty_is_portfolio_page() {
		return function_exists('trx_addons_is_portfolio_page') && trx_addons_is_portfolio_page();
	}
}

// Return true if it's services page
if ( !function_exists( 'the_mounty_is_services_page' ) ) {
	function the_mounty_is_services_page() {
		return function_exists('trx_addons_is_services_page') && trx_addons_is_services_page();
	}
}

// Return true if it's team page
if ( !function_exists( 'the_mounty_is_team_page' ) ) {
	function the_mounty_is_team_page() {
		return function_exists('trx_addons_is_team_page') && trx_addons_is_team_page();
	}
}

// Return true if it's sport page
if ( !function_exists( 'the_mounty_is_sport_page' ) ) {
	function the_mounty_is_sport_page() {
		return function_exists('trx_addons_is_sport_page') && trx_addons_is_sport_page();
	}
}

// Return true if custom layouts are available
if ( !function_exists( 'the_mounty_is_layouts_available' ) ) {
	function the_mounty_is_layouts_available() {
		return the_mounty_exists_trx_addons()
										&& (
											function_exists('the_mounty_exists_sop') && the_mounty_exists_sop()
											||
											function_exists('the_mounty_exists_elementor') && the_mounty_exists_elementor()
											||
											function_exists('the_mounty_exists_vc') && the_mounty_exists_vc()
											);
	}
}

// Detect current blog mode
if ( !function_exists( 'the_mounty_trx_addons_detect_blog_mode' ) ) {
	
	function the_mounty_trx_addons_detect_blog_mode($mode='') {
		if ( the_mounty_is_cars_page() )
			$mode = 'cars';
		else if ( the_mounty_is_courses_page() )
			$mode = 'courses';
		else if ( the_mounty_is_dishes_page() )
			$mode = 'dishes';
		else if ( the_mounty_is_properties_page() )
			$mode = 'properties';
		else if ( the_mounty_is_portfolio_page() )
			$mode = 'portfolio';
		else if ( the_mounty_is_services_page() )
			$mode = 'services';
		else if ( the_mounty_is_sport_page() )
			$mode = 'sport';
		else if ( the_mounty_is_team_page() )
			$mode = 'team';
		return $mode;
	}
}

// Disallow increment views counter on the blog archive
if ( !function_exists( 'the_mounty_trx_addons_inc_views' ) ) {
	
	function the_mounty_trx_addons_inc_views($allow=false) {
		return $allow && is_page() && the_mounty_storage_isset('blog_archive') ? false : $allow;
	}
}

// Add team, courses, etc. to the supported posts list
if ( !function_exists( 'the_mounty_trx_addons_list_post_types' ) ) {
	
	function the_mounty_trx_addons_list_post_types($list=array()) {
		if (function_exists('trx_addons_get_cpt_list')) {
			$cpt_list = trx_addons_get_cpt_list();
			foreach ($cpt_list as $cpt => $title) {
				if (
					   (defined('TRX_ADDONS_CPT_CARS_PT') && $cpt == TRX_ADDONS_CPT_CARS_PT)
					|| (defined('TRX_ADDONS_CPT_COURSES_PT') && $cpt == TRX_ADDONS_CPT_COURSES_PT)
					|| (defined('TRX_ADDONS_CPT_DISHES_PT') && $cpt == TRX_ADDONS_CPT_DISHES_PT)
					|| (defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $cpt == TRX_ADDONS_CPT_PORTFOLIO_PT)
					|| (defined('TRX_ADDONS_CPT_PROPERTIES_PT') && $cpt == TRX_ADDONS_CPT_PROPERTIES_PT)
					|| (defined('TRX_ADDONS_CPT_SERVICES_PT') && $cpt == TRX_ADDONS_CPT_SERVICES_PT)
					|| (defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && $cpt == TRX_ADDONS_CPT_COMPETITIONS_PT)
					|| (defined('TRX_ADDONS_CPT_TEAM_PT') && $cpt == TRX_ADDONS_CPT_TEAM_PT)
					)
					$list[$cpt] = $title;
			}
		}
		return $list;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'the_mounty_trx_addons_post_type_taxonomy' ) ) {
	
	function the_mounty_trx_addons_post_type_taxonomy($tax='', $post_type='') {
		if ( defined('TRX_ADDONS_CPT_CARS_PT') && $post_type == TRX_ADDONS_CPT_CARS_PT )
			$tax = TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER;
		else if ( defined('TRX_ADDONS_CPT_COURSES_PT') && $post_type == TRX_ADDONS_CPT_COURSES_PT )
			$tax = TRX_ADDONS_CPT_COURSES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_DISHES_PT') && $post_type == TRX_ADDONS_CPT_DISHES_PT )
			$tax = TRX_ADDONS_CPT_DISHES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $post_type == TRX_ADDONS_CPT_PORTFOLIO_PT )
			$tax = TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_PROPERTIES_PT') && $post_type == TRX_ADDONS_CPT_PROPERTIES_PT )
			$tax = TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE;
		else if ( defined('TRX_ADDONS_CPT_SERVICES_PT') && $post_type == TRX_ADDONS_CPT_SERVICES_PT )
			$tax = TRX_ADDONS_CPT_SERVICES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && $post_type == TRX_ADDONS_CPT_COMPETITIONS_PT )
			$tax = TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_TEAM_PT') && $post_type == TRX_ADDONS_CPT_TEAM_PT )
			$tax = TRX_ADDONS_CPT_TEAM_TAXONOMY;
		return $tax;
	}
}

// Show categories of the team, courses, etc.
if ( !function_exists( 'the_mounty_trx_addons_get_post_categories' ) ) {
	
	function the_mounty_trx_addons_get_post_categories($cats='') {

		if ( defined('TRX_ADDONS_CPT_CARS_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_CARS_PT) {
				$cats = the_mounty_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE);
			}
		}
		if ( defined('TRX_ADDONS_CPT_COURSES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_COURSES_PT) {
				$cats = the_mounty_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_COURSES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_DISHES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_DISHES_PT) {
				$cats = the_mounty_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_DISHES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_PORTFOLIO_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_PORTFOLIO_PT) {
				$cats = the_mounty_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_PROPERTIES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_PROPERTIES_PT) {
				$cats = the_mounty_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE);
			}
		}
		if ( defined('TRX_ADDONS_CPT_SERVICES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_SERVICES_PT) {
				$cats = the_mounty_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_COMPETITIONS_PT) {
				$cats = the_mounty_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_TEAM_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_TEAM_PT) {
				$cats = the_mounty_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_TEAM_TAXONOMY);
			}
		}
		return $cats;
	}
}

// Show post's date with the theme-specific format
if ( !function_exists( 'the_mounty_trx_addons_get_post_date_wrap' ) ) {
	
	function the_mounty_trx_addons_get_post_date_wrap($dt='') {
		return apply_filters('the_mounty_filter_get_post_date', $dt);
	}
}

// Show date of the courses
if ( !function_exists( 'the_mounty_trx_addons_get_post_date' ) ) {
	
	function the_mounty_trx_addons_get_post_date($dt='') {

		if ( defined('TRX_ADDONS_CPT_COURSES_PT') && get_post_type()==TRX_ADDONS_CPT_COURSES_PT) {
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$dt = $meta['date'];
			// Translators: Add formatted date to the output
			$dt = sprintf($dt < date('Y-m-d') ? esc_html__('Started on %s', 'the-mounty') : esc_html__('Starting %s', 'the-mounty'),
					date_i18n(get_option('date_format'), strtotime($dt)));

		} else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && in_array(get_post_type(), array(TRX_ADDONS_CPT_COMPETITIONS_PT, TRX_ADDONS_CPT_ROUNDS_PT, TRX_ADDONS_CPT_MATCHES_PT))) {
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$dt = $meta['date_start'];
			// Translators: Add formatted date to the output
			$dt = sprintf($dt < date('Y-m-d').(!empty($meta['time_start']) ? ' H:i' : '') ? esc_html__('Started on %s', 'the-mounty') : esc_html__('Starting %s', 'the-mounty'),
					date_i18n(get_option('date_format') . (!empty($meta['time_start']) ? ' '.get_option('time_format') : ''), strtotime($dt.(!empty($meta['time_start']) ? ' '.trim($meta['time_start']) : ''))));

		} else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && get_post_type() == TRX_ADDONS_CPT_PLAYERS_PT) {
			// Uncomment (remove) next line if you want to show player's birthday in the page title block
			if (false) {
				$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
				// Translators: Add formatted date to the output
				$dt = !empty($meta['birthday']) ? sprintf(esc_html__('Birthday: %s', 'the-mounty'), date_i18n(get_option('date_format'), strtotime($meta['birthday']))) : '';
			} else
				$dt = '';
		}
		return $dt;
	}
}

// Check if override options is allowed
if (!function_exists('the_mounty_trx_addons_allow_override_options')) {
	
	function the_mounty_trx_addons_allow_override_options( $allow, $post_type ) {
		return $allow
					|| (defined('TRX_ADDONS_CPT_CARS_PT') && in_array($post_type, array(
																				TRX_ADDONS_CPT_CARS_PT,
																				TRX_ADDONS_CPT_CARS_AGENTS_PT
																				)))
					|| (defined('TRX_ADDONS_CPT_COURSES_PT') && $post_type==TRX_ADDONS_CPT_COURSES_PT)
					|| (defined('TRX_ADDONS_CPT_DISHES_PT') && $post_type==TRX_ADDONS_CPT_DISHES_PT)
					|| (defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $post_type==TRX_ADDONS_CPT_PORTFOLIO_PT) 
					|| (defined('TRX_ADDONS_CPT_PROPERTIES_PT') && in_array($post_type, array(
																				TRX_ADDONS_CPT_PROPERTIES_PT,
																				TRX_ADDONS_CPT_AGENTS_PT
																				)))
					|| (defined('TRX_ADDONS_CPT_RESUME_PT') && $post_type==TRX_ADDONS_CPT_RESUME_PT) 
					|| (defined('TRX_ADDONS_CPT_SERVICES_PT') && $post_type==TRX_ADDONS_CPT_SERVICES_PT) 
					|| (defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && in_array($post_type, array(
																				TRX_ADDONS_CPT_COMPETITIONS_PT,
																				TRX_ADDONS_CPT_ROUNDS_PT,
																				TRX_ADDONS_CPT_MATCHES_PT
																				)))
					|| (defined('TRX_ADDONS_CPT_TEAM_PT') && $post_type==TRX_ADDONS_CPT_TEAM_PT);
	}
}

// Check if theme icons is allowed
if (!function_exists('the_mounty_trx_addons_allow_theme_icons')) {
	
	function the_mounty_trx_addons_allow_theme_icons($allow, $post_type) {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		return $allow
					|| (defined('TRX_ADDONS_CPT_LAYOUTS_PT') && $post_type==TRX_ADDONS_CPT_LAYOUTS_PT)
					|| (!empty($screen->id) && in_array($screen->id, array(
																		'appearance_page_trx_addons_options',
																		'profile'
																	)
														)
						);
	}
}

// Disable theme-specific fields in the exported options
if (!function_exists('the_mounty_trx_addons_export_options')) {
	
	function the_mounty_trx_addons_export_options($options) {
		// ThemeREX Addons
		if (!empty($options['trx_addons_options'])) {
			$options['trx_addons_options']['debug_mode'] = 0;
			$options['trx_addons_options']['api_google'] = '';
			$options['trx_addons_options']['api_google_analitics'] = '';
			$options['trx_addons_options']['api_google_remarketing'] = '';
			$options['trx_addons_options']['demo_enable'] = 0;
			$options['trx_addons_options']['demo_referer'] = '';
			$options['trx_addons_options']['demo_default_url'] = '';
			$options['trx_addons_options']['demo_logo'] = '';
			$options['trx_addons_options']['demo_post_type'] = '';
			$options['trx_addons_options']['demo_taxonomy'] = '';
			$options['trx_addons_options']['demo_logo'] = '';
			$options['trx_addons_options']['demo_logo'] = '';
			unset($options['trx_addons_options']['themes_market_referals']);
		}
		// ThemeREX Donations
		if (!empty($options['trx_donations_options'])) {
			$options['trx_donations_options']['pp_account'] = '';
		}
		// WooCommerce
		if (!empty($options['woocommerce_paypal_settings'])) {
			$options['woocommerce_paypal_settings']['email'] = '';
			$options['woocommerce_paypal_settings']['receiver_email'] = '';
			$options['woocommerce_paypal_settings']['identity_token'] = '';
		}
		return $options;		
	}
}

// Set related posts and columns for the plugin's output
if (!function_exists('the_mounty_trx_addons_args_related')) {
	
	function the_mounty_trx_addons_args_related($args) {
		if (!empty($args['template_args_name']) 
			&& in_array($args['template_args_name'], 
				array('trx_addons_args_sc_cars', 
					  'trx_addons_args_sc_courses',
					  'trx_addons_args_sc_dishes',
					  'trx_addons_args_sc_portfolio',
					  'trx_addons_args_sc_properties',
  					  'trx_addons_args_sc_services'))) {
			$args['posts_per_page'] = (int) the_mounty_get_theme_option('show_related_posts')
												? the_mounty_get_theme_option('related_posts')
												: 0;
			$args['columns'] = the_mounty_get_theme_option('related_columns');
		}
		return $args;
	}
}
// Add 'custom' to the headers types list
if ( !function_exists( 'the_mounty_trx_addons_list_header_footer_types' ) ) {
	
	function the_mounty_trx_addons_list_header_footer_types($list=array()) {
		if (the_mounty_exists_layouts()) {
			$list['custom'] = esc_html__('Custom', 'the-mounty');
		}
		return $list;
	}
}

// Add layouts to the headers list
if ( !function_exists( 'the_mounty_trx_addons_list_header_styles' ) ) {
	
	function the_mounty_trx_addons_list_header_styles($list=array()) {
		if (the_mounty_exists_layouts()) {
			$layouts = the_mounty_get_list_posts(false, array(
							'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
							'meta_key' => 'trx_addons_layout_type',
							'meta_value' => 'header',
							'orderby' => 'ID',
							'order' => 'asc',
							'not_selected' => false
							)
						);
			$new_list = array();
			foreach ($layouts as $id=>$title) {
				if ($id != 'none') $new_list['header-custom-'.intval($id)] = $title;
			}
			$list = the_mounty_array_merge($new_list, $list);
		}
		return $list;
	}
}

// Add layouts to the footers list
if ( !function_exists( 'the_mounty_trx_addons_list_footer_styles' ) ) {
	
	function the_mounty_trx_addons_list_footer_styles($list=array()) {
		if (the_mounty_exists_layouts()) {
			$layouts = the_mounty_get_list_posts(false, array(
							'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
							'meta_key' => 'trx_addons_layout_type',
							'meta_value' => 'footer',
							'orderby' => 'ID',
							'order' => 'asc',
							'not_selected' => false
							)
						);
			$new_list = array();
			foreach ($layouts as $id=>$title) {
				if ($id != 'none') $new_list['footer-custom-'.intval($id)] = $title;
			}
			$list = the_mounty_array_merge($new_list, $list);
		}
		return $list;
	}
}


// Replace {{Y}} or {Y} with the current year in the layouts
if ( !function_exists( 'the_mounty_trx_addons_replace_current_year' ) ) {
	
	function the_mounty_trx_addons_replace_current_year($content, $post_id=0) {
		return str_replace(array('{{Y}}', '{Y}'), date_i18n('Y'), $content);
	}
}


// Add theme-specific layouts to the list
if (!function_exists('the_mounty_trx_addons_default_layouts')) {
	
	function the_mounty_trx_addons_default_layouts($default_layouts=array()) {
		if (the_mounty_storage_isset('trx_addons_default_layouts')) {
			$layouts = the_mounty_storage_get('trx_addons_default_layouts');
		} else {
			require_once THE_MOUNTY_THEME_DIR . 'theme-specific/trx_addons-layouts.php';
			if (!isset($layouts) || !is_array($layouts))
				$layouts = array();
			else {
				// Replace demo-site urls with current site url
				$old_url = the_mounty_storage_get('theme_demo_url');
				if (substr($old_url, -1)=='/') $old_url = substr($old_url, 0, strlen($old_url)-1);
				$site_url = get_site_url();
				if (substr($site_url, -1)=='/') $site_url = substr($site_url, 0, strlen($site_url)-1);
				$layouts = the_mounty_str_replace(array(
													$old_url,
													the_mounty_remove_protocol_from_url($old_url, false),
													the_mounty_remove_protocol_from_url($old_url, true)
													),
											  array(
											  		$site_url,
											  		the_mounty_remove_protocol_from_url($site_url, false),
											  		the_mounty_remove_protocol_from_url($site_url, true)
											  		),
											  $layouts);
			}
			the_mounty_storage_set('trx_addons_default_layouts', $layouts);
		}
		if (count($layouts) > 0)
			$default_layouts = array_merge($default_layouts, $layouts);
		return $default_layouts;
	}
}


// Add theme-specific components to the plugin's options
if (!function_exists('the_mounty_trx_addons_default_components')) {
	
	function the_mounty_trx_addons_default_components($options=array()) {
		if (empty($options['components_present'])) {
			if (the_mounty_storage_isset('trx_addons_default_components')) {
				$components = the_mounty_storage_get('trx_addons_default_components');
			} else {
				require_once THE_MOUNTY_THEME_DIR . 'theme-specific/trx_addons-components.php';
				if (!isset($components) || !is_array($components))
					$components = array();
				the_mounty_storage_set('trx_addons_default_components', $components);
			}
			$options = is_array($options) && count($components) > 0
									? array_merge($options, $components)
									: $components;
		}
		// Turn on API of the theme required plugins
		$plugins = the_mounty_storage_get('required_plugins');
		foreach ($plugins as $p=>$v) {			
			//Disable check, because some components can be added after the plugin's options are saved
			if (true || isset($options["components_api_{$p}"]))
				$options["components_api_{$p}"] = 1;
		}
		return $options;
	}
}

// Add theme-specific options to the post's options
if (!function_exists('the_mounty_trx_addons_override_options')) {
    add_filter( 'trx_addons_filter_override_options', 'the_mounty_trx_addons_override_options');
    function the_mounty_trx_addons_override_options($options=array()) {
        return apply_filters('the_mounty_filter_override_options', $options);
    }
}

// Enqueue custom styles
if ( !function_exists( 'the_mounty_trx_addons_layouts_styles' ) ) {
	
	function the_mounty_trx_addons_layouts_styles() {
		if (!the_mounty_exists_trx_addons()) {
			if (the_mounty_get_file_dir('plugins/trx_addons/layouts/layouts.css')!='') {
				wp_enqueue_style( 'the-mounty-trx-addons-layouts',  the_mounty_get_file_url('plugins/trx_addons/layouts/layouts.css'), array(), null );
			}
			if (the_mounty_get_file_dir('plugins/trx_addons/layouts/layouts.responsive.css')!='') {
				wp_enqueue_style( 'the-mounty-trx-addons-layouts-responsive',  the_mounty_get_file_url('plugins/trx_addons/layouts/layouts.responsive.css'), array(), null );
			}
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'the_mounty_trx_addons_merge_styles' ) ) {
	
	function the_mounty_trx_addons_merge_styles($list) {
		$list[] = 'plugins/trx_addons/_trx_addons.scss';
		return $list;
	}
}

// Merge responsive styles
if ( !function_exists( 'the_mounty_trx_addons_merge_styles_responsive' ) ) {
	
	function the_mounty_trx_addons_merge_styles_responsive($list) {
		$list[] = 'plugins/trx_addons/_trx_addons-responsive.scss';
		return $list;
	}
}

// Add theme-specific vars to the list of responsive files of ThemeREX Addons
if ( !function_exists( 'the_mounty_trx_addons_sass_import' ) ) {
	
	function the_mounty_trx_addons_sass_import($output='', $file='') {
		if (strpos($file, 'vars.scss') !== false)
			$output .= "\n" . the_mounty_fgc(the_mounty_get_file_dir('css/_theme-vars.scss')) . "\n";
		return $output;
	}
}

// Enqueue custom scripts
if ( !function_exists( 'the_mounty_trx_addons_frontend_scripts' ) ) {
	
	function the_mounty_trx_addons_frontend_scripts() {
		if (the_mounty_exists_trx_addons()) {
			if (the_mounty_is_on(the_mounty_get_theme_option('debug_mode')) && the_mounty_get_file_dir('plugins/trx_addons/trx_addons.js')!='')
				wp_enqueue_script( 'the-mounty-trx-addons', the_mounty_get_file_url('plugins/trx_addons/trx_addons.js'), array('jquery'), null, true );
		}
	}
}
	
// Merge custom scripts
if ( !function_exists( 'the_mounty_trx_addons_merge_scripts' ) ) {
	
	function the_mounty_trx_addons_merge_scripts($list) {
		$list[] = 'plugins/trx_addons/trx_addons.js';
		return $list;
	}
}



// Plugin API - theme-specific wrappers for plugin functions
//------------------------------------------------------------------------

// Debug functions wrappers
if (!function_exists('ddo')) { function ddo($obj, $level=-1) { return var_dump($obj); } }
if (!function_exists('dcl')) { function dcl($msg, $level=-1) { echo '<br><pre>' . esc_html($msg) . '</pre><br>'; } }
if (!function_exists('dco')) { function dco($obj, $level=-1) { dcl(ddo($obj, $level), $level); } }
if (!function_exists('dcs')) { function dcs($level=-1) { $s = debug_backtrace(); array_shift($s); dco($s, $level); } }

// Check if URL contain specified string
if (!function_exists('the_mounty_check_url')) {
	function the_mounty_check_url($val='', $defa=false) {
		return function_exists('trx_addons_check_url') 
					? trx_addons_check_url($val) 
					: $defa;
	}
}

// Check if layouts components are showed or set new state
if (!function_exists('the_mounty_sc_layouts_showed')) {
	function the_mounty_sc_layouts_showed($name, $val=null) {
		if (function_exists('trx_addons_sc_layouts_showed')) {
			if ($val!==null)
				trx_addons_sc_layouts_showed($name, $val);
			else
				return trx_addons_sc_layouts_showed($name);
		} else {
			if ($val!==null)
				return the_mounty_storage_set_array('sc_layouts_components', $name, $val);
			else
				return the_mounty_storage_get_array('sc_layouts_components', $name);
		}
	}
}

// Return image size multiplier
if (!function_exists('the_mounty_get_retina_multiplier')) {
	function the_mounty_get_retina_multiplier($force_retina=0) {
		$mult = function_exists('trx_addons_get_retina_multiplier') ? trx_addons_get_retina_multiplier($force_retina) : 1;
		return max(1, $mult);
	}
}

// Return slider layout
if (!function_exists('the_mounty_get_slider_layout')) {
	function the_mounty_get_slider_layout($args) {
		return function_exists('trx_addons_get_slider_layout') 
					? trx_addons_get_slider_layout($args) 
					: '';
	}
}

// Return video player layout
if (!function_exists('the_mounty_get_video_layout')) {
	function the_mounty_get_video_layout($args) {
		return function_exists('trx_addons_get_video_layout') 
					? trx_addons_get_video_layout($args) 
					: '';
	}
}

// Return theme specific layout of the featured image block
if ( !function_exists( 'the_mounty_trx_addons_featured_image' ) ) {
	
	function the_mounty_trx_addons_featured_image($processed=false, $args=array()) {
		$args['show_no_image'] = true;
		$args['singular'] = false;
		$args['hover'] = isset($args['hover']) && $args['hover']=='' ? '' : the_mounty_get_theme_option('image_hover');
		the_mounty_show_post_featured($args);
		return true;
	}
}

// Remove some thumb-sizes from the ThemeREX Addons list
if ( !function_exists( 'the_mounty_trx_addons_add_thumb_sizes' ) ) {
	
	function the_mounty_trx_addons_add_thumb_sizes($list=array()) {
		if (is_array($list)) {
			$thumb_sizes = the_mounty_storage_get('theme_thumbs');
			foreach ($thumb_sizes as $v) {
				if (!empty($v['subst']) && isset($list[$v['subst']]))
					unset($list[$v['subst']]);
			}
		}
		return $list;
	}
}

// and replace removed styles with theme-specific thumb size
if ( !function_exists( 'the_mounty_trx_addons_get_thumb_size' ) ) {
	
	function the_mounty_trx_addons_get_thumb_size($thumb_size='') {
		$thumb_sizes = the_mounty_storage_get('theme_thumbs');
		foreach ($thumb_sizes as $k => $v) {
			if (strpos($thumb_size, $v['subst']) !== false) {
				$thumb_size = str_replace($thumb_size, $v['subst'], $k);
				break;
			}
		}
		return $thumb_size;
	}
}

// Return theme specific 'no-image' picture
if ( !function_exists( 'the_mounty_trx_addons_no_image' ) ) {
	
	function the_mounty_trx_addons_no_image($no_image='') {
		return the_mounty_get_no_image($no_image);
	}
}

// Return theme-specific icons
if ( !function_exists( 'the_mounty_trx_addons_get_list_icons' ) ) {
	
	function the_mounty_trx_addons_get_list_icons($list, $prepend_inherit) {
		return the_mounty_get_list_icons($prepend_inherit);
	}
}

// Return links to the social profiles
if (!function_exists('the_mounty_get_socials_links')) {
	function the_mounty_get_socials_links($style='icons') {
		return function_exists('trx_addons_get_socials_links') 
					? trx_addons_get_socials_links($style)
					: '';
	}
}

// Return links to share post
if (!function_exists('the_mounty_get_share_links')) {
	function the_mounty_get_share_links($args=array()) {
		return function_exists('trx_addons_get_share_links') 
					? trx_addons_get_share_links($args)
					: '';
	}
}

// Display links to share post
if (!function_exists('the_mounty_show_share_links')) {
	function the_mounty_show_share_links($args=array()) {
		if (function_exists('trx_addons_get_share_links')) {
			$args['echo'] = true;
			trx_addons_get_share_links($args);
		}
	}
}

// Return post icon
if (!function_exists('the_mounty_get_post_icon')) {
	function the_mounty_get_post_icon($post_id=0) {
		return function_exists('trx_addons_get_post_icon') 
					? trx_addons_get_post_icon($post_id)
					: '';
	}
}

// Show reactions in the single posts
if (!function_exists('the_mounty_trx_addons_action_before_post_meta')) {
	
	function the_mounty_trx_addons_action_before_post_meta() {
		if (trx_addons_is_on(trx_addons_get_option('emotions_allowed')) && is_single() && !is_attachment())
			trx_addons_get_post_reactions(true);
	}
}


// Return image from the category
if (!function_exists('the_mounty_get_category_image')) {
	function the_mounty_get_category_image($term_id=0) {
		return function_exists('trx_addons_get_category_image') 
					? trx_addons_get_category_image($term_id)
					: '';
	}
}

// Return small image (icon) from the category
if (!function_exists('the_mounty_get_category_icon')) {
	function the_mounty_get_category_icon($term_id=0) {
		return function_exists('trx_addons_get_category_icon') 
					? trx_addons_get_category_icon($term_id)
					: '';
	}
}

// Return string with counters items
if (!function_exists('the_mounty_get_post_counters')) {
	function the_mounty_get_post_counters($counters='views') {
		return function_exists('trx_addons_get_post_counters')
					? str_replace('post_counters_item', 'post_meta_item post_counters_item', trx_addons_get_post_counters($counters))
					: '';
	}
}

// Return list with animation effects
if (!function_exists('the_mounty_get_list_animations_in')) {
	function the_mounty_get_list_animations_in() {
		return function_exists('trx_addons_get_list_animations_in') 
					? trx_addons_get_list_animations_in()
					: array();
	}
}

// Return classes list for the specified animation
if (!function_exists('the_mounty_get_animation_classes')) {
	function the_mounty_get_animation_classes($animation, $speed='normal', $loop='none') {
		return function_exists('trx_addons_get_animation_classes') 
					? trx_addons_get_animation_classes($animation, $speed, $loop)
					: '';
	}
}

// Return string with the likes counter for the specified comment
if (!function_exists('the_mounty_get_comment_counters')) {
	function the_mounty_get_comment_counters($counters = 'likes') {
		return function_exists('trx_addons_get_comment_counters') 
					? trx_addons_get_comment_counters($counters)
					: '';
	}
}

// Display likes counter for the specified comment
if (!function_exists('the_mounty_show_comment_counters')) {
	function the_mounty_show_comment_counters($counters = 'likes') {
		if (function_exists('trx_addons_get_comment_counters'))
			trx_addons_get_comment_counters($counters, true);
	}
}

// Add query params to sort posts by views or likes
if (!function_exists('the_mounty_trx_addons_query_sort_order')) {
	
	function the_mounty_trx_addons_query_sort_order($q=array(), $orderby='date', $order='desc') {
		if ($orderby == 'views') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'trx_addons_post_views_count';
		} else if ($orderby == 'likes') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'trx_addons_post_likes_count';
		}
		return $q;
	}
}

// Return theme-specific logo to the plugin
if ( !function_exists( 'the_mounty_trx_addons_theme_logo' ) ) {
	
	function the_mounty_trx_addons_theme_logo($logo) {
		return the_mounty_get_logo_image();
	}
}

// Return true, if theme allow use site name as logo
if ( !function_exists( 'the_mounty_trx_addons_show_site_name_as_logo' ) ) {
	
	function the_mounty_trx_addons_show_site_name_as_logo($allow=true) {
		return $allow && the_mounty_is_on(the_mounty_get_theme_option('logo_text'));
	}
}

// Return theme-specific post meta to the plugin
if ( !function_exists( 'the_mounty_trx_addons_post_meta' ) ) {
	
	function the_mounty_trx_addons_post_meta($meta, $args=array()) {
		return the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', $args, 'trx_addons', 1));
	}
}

// Return theme-specific post meta args
if ( !function_exists( 'the_mounty_trx_addons_post_meta_args' ) ) {
	
	function the_mounty_trx_addons_post_meta_args($args=array(), $from='', $columns=1) {
		if (is_single() && $from=='trx_addons') {
			$args['components'] = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('meta_parts'));
			$args['counters'] = the_mounty_array_get_keys_by_value(the_mounty_get_theme_option('counters'));
			$args['seo'] = the_mounty_is_on(the_mounty_get_theme_option('seo_snippets'));
		}
		return $args;
	}
}

// Check if featured image override is allowed
if ( !function_exists( 'the_mounty_trx_addons_featured_image_override' ) ) {
	
	function the_mounty_trx_addons_featured_image_override($flag=false) {
		if ($flag) {
			$flag = the_mounty_is_on(the_mounty_get_theme_option('header_image_override')) 
					&& apply_filters('the_mounty_filter_allow_override_header_image', true);
		}
		return $flag;
	}
}

// Return featured image for current mode (post/page/category/blog template ...)
if ( !function_exists( 'the_mounty_trx_addons_get_current_mode_image' ) ) {
	
	function the_mounty_trx_addons_get_current_mode_image($img='') {
		return the_mounty_get_current_mode_image($img);
	}
}

// Return featured image size for related posts
if ( !function_exists( 'the_mounty_trx_addons_related_thumb_size' ) ) {
	
	function the_mounty_trx_addons_related_thumb_size($size='') {
		if (defined('TRX_ADDONS_CPT_CERTIFICATES_PT') && get_post_type() == TRX_ADDONS_CPT_CERTIFICATES_PT)
			$size = the_mounty_get_thumb_size( 'masonry-big' );
		return $size;
	}
}
	
// Redirect action 'get_mobile_menu' to the plugin
// Return stored items as mobile menu
if ( !function_exists( 'the_mounty_trx_addons_get_mobile_menu' ) ) {
	
	function the_mounty_trx_addons_get_mobile_menu($menu) {
		return apply_filters('trx_addons_filter_get_mobile_menu', $menu);
	}
}

// Redirect action 'login' to the plugin
if (!function_exists('the_mounty_trx_addons_action_login')) {
	
	function the_mounty_trx_addons_action_login($args=array()) {
		do_action( 'trx_addons_action_login', $args );
	}
}

// Redirect action 'cart' to the plugin
if (!function_exists('the_mounty_trx_addons_action_cart')) {
	
	function the_mounty_trx_addons_action_cart($args=array()) {
		do_action( 'trx_addons_action_cart', $args );
	}
}

// Redirect action 'search' to the plugin
if (!function_exists('the_mounty_trx_addons_action_search')) {
	
	function the_mounty_trx_addons_action_search($style, $class, $ajax) {
		if (the_mounty_exists_trx_addons())
			do_action( 'trx_addons_action_search', $style, $class, $ajax );
		else {
			set_query_var('the_mounty_search_args', compact('style', 'class', 'ajax'));
			get_template_part('templates/search-form');
			set_query_var('the_mounty_search_args', array());
		}
	}
}

// Redirect action 'breadcrumbs' to the plugin
if (!function_exists('the_mounty_trx_addons_action_breadcrumbs')) {
	
	function the_mounty_trx_addons_action_breadcrumbs() {
		do_action( 'trx_addons_action_breadcrumbs' );
	}
}

// Redirect action 'show_layout' to the plugin
if (!function_exists('the_mounty_trx_addons_action_show_layout')) {
	
	function the_mounty_trx_addons_action_show_layout($layout_id='') {
		do_action( 'trx_addons_action_show_layout', $layout_id );
	}
}

// Redirect filter 'get_translated_layout' to the plugin
if (!function_exists('the_mounty_trx_addons_filter_get_translated_layout')) {
	
	function the_mounty_trx_addons_filter_get_translated_layout($layout_id='') {
		return apply_filters( 'trx_addons_filter_get_translated_layout', $layout_id );
	}
}

// Show user meta (socials)
if (!function_exists('the_mounty_trx_addons_action_user_meta')) {
	
	function the_mounty_trx_addons_action_user_meta() {
		do_action( 'trx_addons_action_user_meta' );
	}
}

// Redirect filter 'get_blog_title' to the plugin
if ( !function_exists( 'the_mounty_trx_addons_get_blog_title' ) ) {
	
	function the_mounty_trx_addons_get_blog_title($title='') {
		return apply_filters('trx_addons_filter_get_blog_title', $title);
	}
}

// Redirect filter 'get_post_iframe' to the plugin
if ( !function_exists( 'the_mounty_trx_addons_get_post_iframe' ) ) {
	
	function the_mounty_trx_addons_get_post_iframe($html='') {
		return apply_filters('trx_addons_filter_get_post_iframe', $html);
	}
}

// Return true, if theme need a SEO snippets
if (!function_exists('the_mounty_trx_addons_seo_snippets')) {
	
	function the_mounty_trx_addons_seo_snippets($enable=false) {
		return the_mounty_is_on(the_mounty_get_theme_option('seo_snippets'));
	}
}

// Show user meta (socials)
if (!function_exists('the_mounty_trx_addons_before_article')) {
	
	function the_mounty_trx_addons_before_article($page='') {
		if (the_mounty_is_on(the_mounty_get_theme_option('seo_snippets')))
			get_template_part('templates/seo');
	}
}

// Redirect filter 'prepare_css' to the plugin
if (!function_exists('the_mounty_trx_addons_prepare_css')) {
	
	function the_mounty_trx_addons_prepare_css($css='', $remove_spaces=true) {
		return apply_filters( 'trx_addons_filter_prepare_css', $css, $remove_spaces );
	}
}

// Redirect filter 'prepare_js' to the plugin
if (!function_exists('the_mounty_trx_addons_prepare_js')) {
	
	function the_mounty_trx_addons_prepare_js($js='', $remove_spaces=true) {
		return apply_filters( 'trx_addons_filter_prepare_js', $js, $remove_spaces );
	}
}

// Add plugin's specific variables to the scripts
if (!function_exists('the_mounty_trx_addons_localize_script')) {
	
	function the_mounty_trx_addons_localize_script($arr) {
		$arr['trx_addons_exists'] = the_mounty_exists_trx_addons();
		return $arr;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if (the_mounty_exists_trx_addons()) { require_once THE_MOUNTY_THEME_DIR . 'plugins/trx_addons/trx_addons-styles.php'; }

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'the_mounty_trx_addons_privacy_text' ) ) {
    add_filter( 'trx_addons_filter_privacy_text', 'the_mounty_trx_addons_privacy_text' );
    function the_mounty_trx_addons_privacy_text( $text='' ) {
        return the_mounty_get_privacy_text();
    }
}

// Add theme-specific options to the post's options
if ( ! function_exists( 'the_mounty_trx_addons_override_options' ) ) {
	
	function the_mounty_trx_addons_override_options( $options = array() ) {
		return apply_filters( 'the_mounty_filter_override_options', $options );
	}
}


?>