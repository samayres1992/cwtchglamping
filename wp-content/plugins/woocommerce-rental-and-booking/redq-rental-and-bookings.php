<?php

/**
 * Plugin Name: WooCommerce Rental & Booking System
 * Plugin URI: https://codecanyon.net/item/rnb-woocommerce-rental-booking-system/14835145?ref=redqteam
 * Description: RnB – WooCommerce Rental & Booking is a user friendly woocommerce booking plugin built as woocommerce extension. This powerful woocommerce plugin allows you to sell your time or date based bookings. It creates a new product type to your WooCommerce site. Perfect for those wanting to offer rental , booking , or real estate agencies or services.
 * Version: 14.0.2
 * Author: RedQ Team
 * Author URI: https://redq.io/
 * License: http : //www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: redq-rental
 * Domain Path: /languages
 * WC requires at least: 3.0.0
 * WC tested up to: latest
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
$required_plugins = ['woocommerce/woocommerce.php'];

if (count(array_intersect($required_plugins, $active_plugins)) !== count($required_plugins)) {
    add_action('admin_notices', 'rnb_notice');
    function rnb_notice()
    {
        $woocommerce_link = '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>';
        echo '<div class="error"><p><strong>' . sprintf(esc_html__('RnB requires WooCommerce to be installed and active. You can download %s from here.', 'redq-rental'), $woocommerce_link) . '</strong></p></div>';
    }
    return;
}

final class RedQ_Rental_And_Bookings
{
    /**
     * Plugin data from get_plugins()
     *
     * @since 1.0
     * @var object
     */
    public $plugin_data;

    /**
     * Plugin version
     */
    public $plugin_version = '14.0.2';

    /**
     * Includes to load
     *
     * @since 1.0
     * @var array
     */
    public $includes;

    /**
     * Init class
     *
     * @return null
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [&$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'rnb_flush_rewrite_rule']);
        register_activation_hook(__FILE__, [$this, 'rnb_flush_rewrite_rule']);

        $quote_menu = get_option('rnb_enable_rft_endpoint', 'yes');
        if ($quote_menu == 'yes') {
            add_action('init', [$this, 'rfq_endpoints']);
        }

        add_action('plugins_loaded', [$this, 'init_plugin'], 1);
        add_action('plugins_loaded', [$this, 'text_domain']);
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'rnb_action_links'], 1);
    }

    /**
     * RFQ Endpoint
     *
     * @return null
     * @since 3.0.0
     */
    public static function rfq_endpoints()
    {
        add_rewrite_endpoint('request-quote', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('view-quote', EP_ALL);
    }

    /**
     * Initialize singleton instance
     *
     * @return \RedQ_Rental_And_Bookings
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Plugin constant define
     *
     * @return null
     * @since 1.0.0
     */
    public function define_constants()
    {
        define('RNB_VERSION', $this->plugin_version);
        define('RNB_FILE', __FILE__);
        define('RNB_PATH', __DIR__);
        define('RNB_TEMPLATE_PATH', untrailingslashit(plugin_dir_path(RNB_FILE)));
        define('RNB_URL', plugins_url('', RNB_FILE));
        define('RNB_ASSETS', RNB_URL . '/assets');
        define('RNB_INC_DIR', 'includes');
        define('RNB_LANG_DIR', 'languages');
        define('RNB_ROOT_URL', untrailingslashit(plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__))));
        define('RNB_DIR', dirname(plugin_basename(RNB_FILE))); // plugin's directory
        define('RNB_ASSETS_DIR', 'assets'); // assets directory
        define('RNB_PACKAGE_TEMPLATE_PATH', untrailingslashit(plugin_dir_path(__FILE__)) . '/templates/');
    }

    /**
     * Plugin information
     *
     * @return void
     */
    public function activate()
    {
        $installer = new REDQ_RnB\Installer();
        $installer->run();
    }

    /**
     * flush rewrite rules
     *
     * @return void
     */
    public function rnb_flush_rewrite_rule()
    {
        RedQ_Rental_And_Bookings::rfq_endpoints();
    }

    /**
     * Load plugin files
     *
     * @return void
     */
    public function init_plugin()
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        new REDQ_RnB\Init();
        new REDQ_RnB\Modify_Hook();
        new REDQ_RnB\Assets();
        new REDQ_RnB\Ajax();
        new REDQ_RnB\Handle_Cart();
        new REDQ_RnB\Handle_Order();
        // new REDQ_RnB\Handle_Email();
        new REDQ_RnB\Handle_RFQ();
        new REDQ_RnB\Control_Color();
        new REDQ_RnB\ADMIN\Generator();

        if (is_admin()) {
            new REDQ_RnB\ADMIN\Admin_Page();
            new REDQ_RnB\ADMIN\Meta_Boxes();
            new REDQ_RnB\ADMIN\Save_Meta();
            new REDQ_RnB\INTEGRATION\Full_Calendar();
        } else {
            new REDQ_RnB\Tabs();
        }

        require_once trailingslashit(RNB_PATH) . RNB_INC_DIR . '/class-redq-product-redq_rental.php';
    }

    /**
     * Plugin text-domain
     *
     * @return null
     * @since 1.0.0
     */
    public function text_domain()
    {
        load_plugin_textdomain('redq-rental', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * rnb_action_links
     *
     * @param array $links
     *
     * @return array
     */
    public function rnb_action_links($links)
    {
        $links[] = '<a href="https://rnb-doc.vercel.app/" target="_blank">' . __('Docs', 'redq-rental') . '</a>';
        $links[] = '<a href="https://redqsupport.ticksy.com/" target="_blank">' . __('Support', 'redq-rental') . '</a>';
        $links[] = '<a href="https://codecanyon.net/user/redqteam/portfolio?ref=redqteam" target="_blank">' . __('Portfolio', 'redq-rental') . '</a>';

        return $links;
    }
}

/**
 * Initialize main plugin
 *
 * @return \RedQ_Rental_And_Bookings
 */
function redq_rnb()
{
    return RedQ_Rental_And_Bookings::init();
}
redq_rnb();
