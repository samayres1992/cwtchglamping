<?php

namespace REDQ_RnB;

use REDQ_RnB\Traits\Assets_Trait;

class Init
{
    use Assets_Trait;

    /**
     * Init class
     */
    public function __construct()
    {
        add_action('woocommerce_redq_rental_add_to_cart', [$this, 'rnb_template']);
        add_filter('woocommerce_integrations', [$this, 'rnb_integrations']);
        add_filter('woocommerce_get_settings_pages', [$this, 'rnb_get_settings_pages']);
        add_action('wp_head', [$this, 'rnb_prevent_ios_input_focus_zooming']);
    }

    /**
     * Book now form for rental product
     *
     * @return null
     * @since 1.0.0
     */
    public function rnb_template()
    {
        $template = 'single-product/add-to-cart/redq_rental.php';
        wc_get_template($template, $args = [], $template_path = '', RNB_PACKAGE_TEMPLATE_PATH);
    }

    /**
     * Google calendar settings page
     *
     * @param array $integrations
     * @return array
     */
    public function rnb_integrations($integrations)
    {
        $integrations[] = 'REDQ_RnB\INTEGRATION\Google_Calendar';
        return $integrations;
    }

    /**
     * Get global setting page
     *
     * @param array $settings
     * @return array
     */
    public function rnb_get_settings_pages($settings)
    {
        $settings[] = new \REDQ_RnB\ADMIN\Global_Settings();
        return $settings;
    }

    /**
     * Prevent ios input focus auto zooming
     *
     * @return null
     * @since 12.0.0
     */
    public function rnb_prevent_ios_input_focus_zooming()
    {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">';
    }
}
