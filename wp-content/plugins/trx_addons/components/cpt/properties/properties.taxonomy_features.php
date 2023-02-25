<?php
/**
 * ThemeREX Addons Custom post type: Properties (Taxonomy 'Features' support)
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.22
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Define Custom post type and taxonomy constants for 'Properties'
if ( ! defined('TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES') )
		define('TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES', trx_addons_cpt_param('properties', 'taxonomy_features'));

// Register post type and taxonomy
if (!function_exists('trx_addons_cpt_properties_taxonomy_features_init')) {
	add_action( 'init', 'trx_addons_cpt_properties_taxonomy_features_init' );
	function trx_addons_cpt_properties_taxonomy_features_init() {
		
		register_taxonomy( TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES, TRX_ADDONS_CPT_PROPERTIES_PT, array(
			'post_type' 		=> TRX_ADDONS_CPT_PROPERTIES_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Features', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Feature', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Features', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Features', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Feature', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Feature:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Feature', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Feature', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add New Feature', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Feature Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'Features', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => trx_addons_cpt_param('properties', 'taxonomy_features_slug') )
			)
		);
	}
}


// Replace standard theme templates
//-------------------------------------------------------------

// Change standard category template for properties categories (groups)
if ( !function_exists( 'trx_addons_cpt_properties_taxonomy_features_taxonomy_template' ) ) {
	add_filter('taxonomy_template',	'trx_addons_cpt_properties_taxonomy_features_taxonomy_template');
	function trx_addons_cpt_properties_taxonomy_features_taxonomy_template( $template ) {
		if ( is_tax(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES) ) {
			if (($template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.archive_features.php')) == '') 
				$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.archive.php');
		}
		return $template;
	}	
}



// Admin utils
// -----------------------------------------------------------------

// Show <select> with properties categories in the admin filters area
if (!function_exists('trx_addons_cpt_properties_taxonomy_features_admin_filters')) {
	add_action( 'restrict_manage_posts', 'trx_addons_cpt_properties_taxonomy_features_admin_filters' );
	function trx_addons_cpt_properties_taxonomy_features_admin_filters() {
		trx_addons_admin_filters(TRX_ADDONS_CPT_PROPERTIES_PT, TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES);
	}
}
  
// Clear terms cache on the taxonomy 'features' save
if (!function_exists('trx_addons_cpt_properties_admin_clear_cache_features')) {
	add_action( 'edited_'.TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES, 'trx_addons_cpt_properties_admin_clear_cache_features', 10, 1 );
	add_action( 'delete_'.TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES, 'trx_addons_cpt_properties_admin_clear_cache_features', 10, 1 );
	add_action( 'created_'.TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES, 'trx_addons_cpt_properties_admin_clear_cache_features', 10, 1 );
	function trx_addons_cpt_properties_admin_clear_cache_features( $term_id=0 ) {  
		trx_addons_admin_clear_cache_terms(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES);
	}
}


// Additional parameters to the taxonomy
//--------------------------------------------------------------------------

// Save additional parameters
if (!function_exists('trx_addons_cpt_properties_taxonomy_features_save_custom_fields')) {
    add_action('edited_'.TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES,	'trx_addons_cpt_properties_taxonomy_features_save_custom_fields', 10, 1 );
    add_action('created_'.TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES,	'trx_addons_cpt_properties_taxonomy_features_save_custom_fields', 10, 1 );
    function trx_addons_cpt_properties_taxonomy_features_save_custom_fields($term_id) {
        if (isset($_POST['trx_addons_icon'])) {
            trx_addons_set_term_meta(array(
                'term_id' => $term_id,
                'key' => 'icon'
            ),
                $_POST['trx_addons_icon']
            );
        }
    }
}

// Display additional fields
if (!function_exists('trx_addons_cpt_properties_taxonomy_features_show_custom_fields')) {
    add_action(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES.'_edit_form_fields', 'trx_addons_cpt_properties_taxonomy_features_show_custom_fields', 10, 1 );
    add_action(TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES.'_add_form_fields', 'trx_addons_cpt_properties_taxonomy_features_show_custom_fields', 10, 1 );
    function trx_addons_cpt_properties_taxonomy_features_show_custom_fields($term) {
        $term_id = !empty($term->term_id) ? $term->term_id : 0;

        // Icon
        echo ((int) $term_id > 0 ? '<tr' : '<div') . ' class="form-field">'
            . ((int) $term_id > 0 ? '<th valign="top" scope="row">' : '<div>');
        ?><label id="trx_addons_icon_label" for="trx_addons_icon"><?php esc_html_e('Icon:', 'trx_addons'); ?></label><?php
        echo ((int) $term_id > 0 ? '</th>' : '</div>')
            . ((int) $term_id > 0 ? '<td valign="top">' : '<div>');
        $icon_id = $term_id > 0
            ? trx_addons_get_term_meta(array(
                'taxonomy'	=> TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES,
                'term_id'	=> $term_id,
                'key'		=> 'icon'
            ))
            : '';
        ?><input type="text" id="trx_addons_icon" class="trx_addons_icon_selector_field" name="trx_addons_icon" value="<?php echo $icon_id ?>"><?php
        echo (int) $term_id > 0 ? '</td></tr>' : '</div></div>';
    }
}
?>