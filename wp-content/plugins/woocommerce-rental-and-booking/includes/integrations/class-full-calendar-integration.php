<?php

namespace REDQ_RnB\INTEGRATION;

use REDQ_RnB\Traits\Legacy_Trait;
use REDQ_RnB\Traits\Assets_Trait;

use WC_Order;

/**
 * Class Full Calendar
 */
class Full_Calendar
{
    use Legacy_Trait, Assets_Trait;

    /**
     * Init class
     */
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'register_assets']);
    }

    /**
     * Register assets for calendar
     *
     * @param string $hook
     * @return void
     */
    public function register_assets($hook)
    {
        $screen = get_current_screen();
        $screen_id = $screen ? $screen->id : '';

        if ($screen_id !== 'toplevel_page_rnb_admin') {
            return;
        }

        $scripts = $this->get_full_calendar_scripts();
        $styles  = $this->get_full_calendar_styles();

        foreach ($scripts as $handle => $script) {
            $deps    = isset($script['deps']) ? $script['deps'] : false;
            $version = isset($script['version']) ? $script['version'] : RNB_VERSION;

            wp_register_script($handle, $script['src'], $deps, $version, true);
            wp_enqueue_script($handle);
        }

        foreach ($styles as $handle => $style) {
            $deps    = isset($style['deps']) ? $style['deps'] : false;
            $version = isset($style['version']) ? $style['version'] : RNB_VERSION;

            wp_register_style($handle, $style['src'], $deps, $version);
            wp_enqueue_style($handle);
        }

        $this->rnb_prepare_calendar_data($hook);
    }

    /**
     * Show all booking data on full calendar.
     *
     * @since 2.4.0
     *
     * @param mixed $hook
     */
    public function rnb_prepare_calendar_data($hook)
    {
        global $wpdb;
        $calendar_data = [];
        $calendarItems = $this->prepare_calendar_items();

        foreach ($calendarItems as $key => $item) {

            if (array_key_exists('start', $item) && array_key_exists('end', $item)) {
                $calendar_data[$key] = $item;
            }

            if (array_key_exists('start', $item) && !array_key_exists('end', $item)) {
                $start_info = isset($item['start_time']) && !empty($item['start_time']) ? $item['start'] . 'T' . $item['start_time'] : $item['start'];
                $return_info = isset($item['return_time']) && !empty($item['return_time']) ? $item['start'] . 'T' . $item['return_time'] : $item['start'];

                $item['start'] = rnb_format_date_time($start_info);
                $item['end'] = rnb_format_date_time($return_info);

                $calendar_data[$key] = $item;
            }

            if (array_key_exists('end', $item) && !array_key_exists('start', $item)) {
                $start_info = isset($item['start_time']) && !empty($item['start_time']) ? $item['end'] . 'T' . $item['start_time'] : $item['end'];
                $return_info = isset($item['return_time']) && !empty($item['return_time']) ? $item['end'] . 'T' . $item['return_time'] : $item['end'];

                $item['start'] = rnb_format_date_time($start_info);
                $item['end'] = rnb_format_date_time($return_info);

                $calendar_data[$key] = $item;
            }

            if (array_key_exists('start', $item) && array_key_exists('end', $item)) {
                $start_info = isset($item['start_time']) && !empty($item['start_time']) ? $item['start'] . 'T' . $item['start_time'] : $item['start'];
                $return_info = isset($item['return_time']) && !empty($item['return_time']) ? $item['end'] . 'T' . $item['return_time'] : $item['end'];

                $item['start'] = rnb_format_date_time($start_info);
                $item['end'] = rnb_format_date_time($return_info);

                $calendar_data[$key] = $item;
            }
        }

        wp_register_script('redq-admin-page', RNB_ROOT_URL . '/assets/js/admin-page.js', ['jquery'], $ver = false, true);
        wp_enqueue_script('redq-admin-page');

        $loc_data = [
            'calendar_data'     => $calendar_data,
            'lang_domain'       => get_option('rnb_lang_domain', 'en'),
            'day_of_week_start' => (int) get_option('rnb_day_of_week_start', 1) - 1,
        ];

        wp_localize_script('redq-admin-page', 'RNB_CALENDAR', $loc_data);
    }

    /**
     * Prepare calendar items
     *
     * @return array
     */
    public function prepare_calendar_items()
    {
        $results = [];

        $args = [
            'post_type'      => 'shop_order',
            'post_status'    => 'any',
            'posts_per_page' => -1,
        ];

        $posts = get_posts($args);

        if (empty($posts)) {
            return $results;
        }

        foreach ($posts as $post) {

            if ($post->post_status === 'wc-rnb-fake-order') {
                continue;
            }

            $order_id = $post->ID;
            $order    = new WC_Order($order_id);

            if (!count($order->get_items())) {
                continue;
            }

            foreach ($order->get_items() as $item_id => $item) {

                $product_id = $item->get_data()['product_id'];
                $product = wc_get_product($product_id);

                if (empty($product) || $product->get_type() !== 'redq_rental') {
                    continue;
                }

                $results[$item_id] = rnb_prepare_calendar_item_data($item, $order_id, $order);
            }
        }

        return $results;
    }
}
