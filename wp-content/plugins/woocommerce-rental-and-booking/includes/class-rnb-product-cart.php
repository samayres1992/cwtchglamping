<?php

namespace REDQ_RnB;

use Automattic\WooCommerce\Admin\Overrides\Order;
use REDQ_RnB\Booking_Manager;
use REDQ_RnB\Traits\Form_Trait;
use REDQ_RnB\Traits\Data_Trait;
use REDQ_RnB\Traits\Cost_Trait;
use REDQ_RnB\Traits\Error_Trait;
use WC_Order;

/**
 * Handle cart page
 *
 * @version 5.0.0
 * @since 1.0.0
 */
class Handle_Cart extends Booking_Manager
{
    use Form_Trait, Data_Trait, Cost_Trait, Error_Trait;

    public function __construct()
    {
        add_filter('woocommerce_add_to_cart_validation', [$this, 'rnb_add_to_cart_validation'], 10, 1);
        add_filter('woocommerce_add_cart_item_data', [$this, 'rnb_add_cart_item_data'], 20, 2);
        add_filter('woocommerce_add_cart_item', [$this, 'rnb_add_cart_item'], 20, 1);
        add_filter('woocommerce_get_cart_item_from_session', [$this, 'rnb_get_cart_item_from_session'], 20, 2);
        add_filter('woocommerce_get_item_data', [$this, 'rnb_get_item_data'], 20, 2);
        add_filter('woocommerce_cart_item_quantity', [$this, 'rnb_cart_item_quantity'], 20, 2);
        add_action('woocommerce_checkout_process', [$this, 'rnb_validate_checkout_process'], 20, 3);
        add_action('woocommerce_new_order_item', [$this, 'rnb_order_item_meta'], 20, 3);
        add_action('rnb_thankyou', [$this, 'rnb_thankyou'], 20, 1);
        add_action('woocommerce_order_status_failed', [$this, 'rnb_handle_failed_order'], 10, 2);
        add_action('wp_head', [$this, 'rnb_handle_after_order_event']);
    }

    /**
     * Server validation before add to cart
     *
     * @param boolean $valid
     * @return boolean
     */
    public function rnb_add_to_cart_validation($valid)
    {
        if (isset($_POST['order_type']) && $_POST['order_type'] === 'extend_order') {
            return true;
        }

        $product_id = isset($_POST['add-to-cart']) ? $_POST['add-to-cart'] : '';

        if (!is_rental_product($product_id)) {
            return $valid;
        }

        $inventory_id = isset($_POST['booking_inventory']) ? $_POST['booking_inventory'] : '';

        if (empty($product_id) || empty($inventory_id)) {
            wc_add_notice(sprintf(__('Sorry! product or inventory is not found', 'redq-rental')), 'error');
            return false;
        }

        $_POST = $this->rearrange_form_data($_POST);
        $has_errors = $this->handle_form($_POST);

        if ($has_errors && !empty($has_errors)) {
            wc_add_notice(sprintf(__('%s', 'redq-rental'), implode(',', $has_errors)), 'error');
            return false;
        }

        return $valid;
    }

    /**
     * Insert posted data into cart item meta
     *
     * @param $cart_item_meta
     * @param string $product_id , array $cart_item_meta
     * @return array
     */
    public function rnb_add_cart_item_data($cart_item_meta, $product_id)
    {
        $product_type = wc_get_product($product_id)->get_type();
        $order_type = isset($_POST['order_type']) ? $_POST['order_type'] : 'new_order';

        if ($product_type !== 'redq_rental' || $order_type !== 'new_order') {
            return $cart_item_meta;
        }

        if (isset($cart_item_meta['rental_data']['quote_id'])) {
            return $cart_item_meta;
        }

        $_POST = $this->rearrange_form_data($_POST);
        $posted_data = $this->prepare_form_data($_POST);
        
        $posted_data['posted_data'] = $_POST;

        $cart_item_meta['rental_data'] = $posted_data;

        return $cart_item_meta;
    }

    /**
     * Add cart item meta
     *
     * @param array $cart_item
     * @return array
     */
    public function rnb_add_cart_item($cart_item)
    {
        $product_id   = $cart_item['data']->get_id();
        $product_type = wc_get_product($product_id)->get_type();

        if (isset($cart_item['rental_data']['quote_id']) && !empty($cart_item['rental_data']['quote_id']) && $product_type === 'redq_rental') {
            $cart_item['data']->set_price($cart_item['rental_data']['rental_days_and_costs']['cost']);
        } else {
            if (isset($cart_item['rental_data']['rental_days_and_costs']['cost']) && $product_type === 'redq_rental') {
                $cart_item['data']->set_price($cart_item['rental_data']['rental_days_and_costs']['cost']);
            }

            // revert
            if (isset($cart_item['quantity']) && $product_type === 'redq_rental') {
                $cart_item['quantity'] = isset($cart_item['rental_data']['quantity']) ? $cart_item['rental_data']['quantity'] : 1;
            }
        }

        return $cart_item;
    }

    /**
     * Get item data from session
     *
     * @param array $cart_item
     * @param $values
     * @return array
     */
    public function rnb_get_cart_item_from_session($cart_item, $values)
    {
        if (!empty($values['rental_data'])) {
            $cart_item = $this->rnb_add_cart_item($cart_item);
        }
        return $cart_item;
    }

    /**
     * Show cart item data in cart and checkout page
     *
     * array $item_data
     * array $cart_item
     * @return array
     */
    public function rnb_get_item_data($item_data, $cart_item)
    {
        $product_id = $cart_item['data']->get_id();
        $product_type = wc_get_product($product_id)->get_type();

        if ($product_type !== 'redq_rental') {
            return $item_data;
        }

        $rental_data = $cart_item['rental_data'];
        if (empty($rental_data)) {
            return $item_data;
        }


        $quantity = intval($cart_item['quantity']);

        $options_data = [];
        $options_data['quote_id'] = '';

        $get_labels = redq_rental_get_settings($product_id, 'labels', ['pickup_location', 'return_location', 'pickup_date', 'return_date', 'resources', 'categories', 'person', 'deposites', 'inventory']);
        $labels = $get_labels['labels'];
        $get_displays = redq_rental_get_settings($product_id, 'display');
        $displays = $get_displays['display'];

        $get_conditions = redq_rental_get_settings($product_id, 'conditions');
        $conditional_data = $get_conditions['conditions'];

        $get_general = redq_rental_get_settings($product_id, 'general');
        $general_data = $get_general['general'];

        if (isset($rental_data['booking_inventory']) && !empty($rental_data['booking_inventory'])) {
            $item_data[] = [
                'key'    => $labels['inventory'],
                'value'   => get_the_title($rental_data['booking_inventory']),
            ];
        }

        if (isset($rental_data['pickup_date']) && $displays['pickup_date'] === 'open') {
            $pickup_date_time = convert_to_output_format($rental_data['pickup_date'], $conditional_data['date_format']);

            if (isset($rental_data['pickup_time']) && $displays['pickup_time'] !== 'closed') {
                $pickup_date_time .= ' ' . esc_html__('at', 'redq-rental') . ' ' . $rental_data['pickup_time'];
            }
            $item_data[] = [
                'key'    => $labels['pickup_datetime'],
                'value'   => $pickup_date_time,
            ];
        }

        if ((isset($rental_data['dropoff_date']) && $displays['return_date'] === 'open') || (isset($rental_data['dropoff_time']) && $displays['return_time'] === 'open')) {
            $return_date_time = convert_to_output_format($rental_data['dropoff_date'], $conditional_data['date_format']);

            if (isset($rental_data['dropoff_time']) && $displays['return_time'] !== 'closed') {
                $return_date_time .= ' ' . esc_html__('at', 'redq-rental') . ' ' . $rental_data['dropoff_time'];
            }

            $item_data[] = [
                'key'   => $labels['return_datetime'],
                'value' => $return_date_time,
            ];
        }

        if (isset($rental_data['quote_id']) && !empty($rental_data['quote_id'])) {
            $item_data[] = [
                'key'   => $options_data['quote_id'] ? $options_data['quote_id'] : __('Quote Request', 'redq-rental'),
                'value' => '#' . $rental_data['quote_id'],
            ];
        }

        if ($rental_data['rental_days_and_costs']['pricing_type'] === 'flat_hours') {
            $item_data[] = [
                'key'   => $general_data['total_hours'] ? $general_data['total_hours'] : esc_html__('Total Hours', 'redq-rental'),
                'value' => $rental_data['rental_days_and_costs']['flat_hours'],
            ];
        }

        if ($rental_data['rental_days_and_costs']['days'] <= 0 && $rental_data['rental_days_and_costs']['pricing_type'] !== 'flat_hours') {
            $item_data[] = [
                'key'   => $general_data['total_hours'] ? $general_data['total_hours'] : esc_html__('Total Hours', 'redq-rental'),
                'value' => $rental_data['rental_days_and_costs']['hours'],
            ];
        }

        if ($rental_data['rental_days_and_costs']['days'] > 0 && $rental_data['rental_days_and_costs']['pricing_type'] !== 'flat_hours') {
            $duration = '';
            $days = floor($rental_data['rental_days_and_costs']['flat_hours'] / 24);
            $hours = $rental_data['rental_days_and_costs']['flat_hours'] % 24;

            $duration .= $days ? $days . __(' Days ', 'redq-rental') : '';
            $duration .= $hours ? $hours . __(' Hours ', 'redq-rental') : '';

            $item_data[] = [
                'key'   => $general_data['total_days'] ? $general_data['total_days'] : esc_html__('Total Days', 'redq-rental'),
                'value' => $duration,
            ];
        }

        if ($rental_data['rental_days_and_costs']['price_breakdown']['duration_total']) {
            $duration_total = $rental_data['rental_days_and_costs']['price_breakdown']['duration_total'];
            $discount_total =  $rental_data['rental_days_and_costs']['price_breakdown']['discount_total'];
            $duration_total = $duration_total - $discount_total;

            $item_data[] = [
                'key'   => $general_data['duration_cost'] ? $general_data['duration_cost'] : esc_html__('Duration Total', 'redq-rental'),
                'value' => wc_price($duration_total),
            ];
        }


        if (isset($rental_data['pickup_location']) && !empty($rental_data['pickup_location'])) {

            $cost = isset($rental_data['pickup_location']) && !empty($rental_data['pickup_location']['cost']) ? $rental_data['pickup_location']['cost'] : 0;
            $details = $rental_data['pickup_location']['address'];

            if (!empty($cost)) {
                $details .= ' ( ' . __('Cost: ', 'redq-rental') . ' ' . wc_price($cost) . ' )';
            }

            $item_data[] = [
                'key'    => $labels['pickup_location'],
                'value'   => $details,
            ];
        }

        if (isset($rental_data['return_location']) && !empty($rental_data['return_location'])) {

            $cost = isset($rental_data['return_location']) && !empty($rental_data['return_location']['cost']) ? $rental_data['return_location']['cost'] : 0;
            $details = $rental_data['return_location']['address'];

            if (!empty($cost)) {
                $details .= ' ( ' . __('Cost: ', 'redq-rental') . ' ' . wc_price($cost) . ' )';
            }

            $item_data[] = [
                'key'    => $labels['return_location'],
                'value'   => $details,
            ];
        }

        if (isset($rental_data['location_cost']) && !empty($rental_data['location_cost'])) {
            $item_data[] = [
                'key'    => esc_html__('Location Cost', 'redq-rental'),
                'value'   => wc_price($rental_data['location_cost']),
            ];
        }

        if (isset($rental_data['payable_cat']) && !empty($rental_data['payable_cat'])) {
            $cat_name = '';
            foreach ($rental_data['payable_cat'] as $key => $category) {
                $unit = $category['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
                $cat_name .= $category['name'] . '×' . $category['quantity'] . ' ( ' . wc_price($category['cost']) . ' - ' . $unit . ' )' . ' , <br> ';
            }
            $item_data[] = [
                'key'    => $labels['categories'],
                'value'   => $cat_name,
            ];
        }

        if (isset($rental_data['payable_resource']) && !empty($rental_data['payable_resource'])) {
            $resource_name = '';
            foreach ($rental_data['payable_resource'] as $key => $resource) {
                $unit = $resource['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
                $resource_name .= $resource['name'] . ' ( ' . wc_price($resource['cost']) . ' - ' . $unit . ' )' . ' , <br> ';
            }
            $item_data[] = [
                'key'    => $labels['resource'],
                'value'   => $resource_name,
            ];
        }

        if (isset($rental_data['payable_security_deposites']) && !empty($rental_data['payable_security_deposites'])) {
            $deposit_name = '';
            foreach ($rental_data['payable_security_deposites'] as $key => $deposit) {
                $unit = $deposit['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
                $deposit_name .= $deposit['name'] . ' ( ' . wc_price($deposit['cost']) . ' - ' . $unit . ' )' . ' , <br> ';
            }
            $item_data[] = [
                'key'    => $labels['deposite'],
                'value'   => $deposit_name,
            ];
        }

        if (isset($rental_data['adults_info']) && !empty($rental_data['adults_info'])) {
            $adult = $rental_data['adults_info'];
            $unit = $adult['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
            $details = $adult['title'] . ' ( ' . wc_price($adult['cost']) . ' - ' . $unit . ' )';

            $item_data[] = [
                'key'    => $labels['adults'],
                'value'   => $details,
            ];
        }

        if (isset($rental_data['childs_info']) && !empty($rental_data['childs_info'])) {

            $child = $rental_data['childs_info'];
            $unit = $child['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
            $details = $child['title'] . ' ( ' . wc_price($child['cost']) . ' - ' . $unit . ' )';

            $item_data[] = [
                'key'    => $labels['childs'],
                'value'   => $details,
            ];
        }

        if (!empty($rental_data['rental_days_and_costs']['due_payment'])) {
            $item_data[] = [
                'key'    => $general_data['payment_due'] ? $general_data['payment_due'] : esc_html__('Due Payment', 'redq-rental'),
                'value'   => wc_price($rental_data['rental_days_and_costs']['due_payment'] * $quantity),
            ];
        }

        return $item_data;
    }

    /**
     * Set quantity always 1
     *
     * @param $product_quantity
     * @param array $cart_item_key , int $product_quantity
     * @return int
     */
    public function rnb_cart_item_quantity($quantity, $cart_item_key)
    {
        global $woocommerce;
        $cart_details = $woocommerce->cart->cart_contents;

        foreach ($cart_details as $key => $detail) {

            if ($key !== $cart_item_key) {
                continue;
            }

            $product_id = $detail['product_id'];
            $product_type = wc_get_product($product_id)->get_type();
            if ($product_type === 'redq_rental') {
                return $detail['quantity'] ? $detail['quantity'] : 1;
            }

            return $quantity;
        }
    }

    /**
     * Checking Processed Data
     *
     * @return void
     */
    public function rnb_validate_checkout_process()
    {
        $cart_items = WC()->cart->get_cart();

        if (empty($cart_items)) {
            $this->send_ajax_failure_response();
        }

        $has_errors = $this->handle_checkout_items($cart_items);

        if (count($has_errors)) {
            wc_add_notice(sprintf(__('%s', 'redq-rental'), implode(', ', $has_errors)), 'error');
            $this->send_ajax_failure_response();
        }
    }

    /**
     * order_item_meta function
     *
     * @param string $item_id , array $values
     * @param $values
     * @param $order_id
     * @return void
     * @throws Exception
     */
    public function rnb_order_item_meta($item_id, $item, $order_id)
    {
        $item_data = $item->get_data();

        if (!isset($item_data['product_id']) || empty($item_data['product_id'])) {
            return;
        }

        $product_id = $item_data['product_id'];
        $product_type = wc_get_product($product_id)->get_type();
        if ($product_type !== 'redq_rental' || !isset($item->legacy_values['rental_data'])) {
            return;
        }

        $rental_data = $item->legacy_values['rental_data'];

        //Check for backend order
        if (empty($rental_data)) {
            return;
        }

        $inventory_id = $rental_data['booking_inventory'];

        $options_data = array();
        $options_data['quote_id'] = '';
        $quantity = isset($rental_data['quantity']) ? $rental_data['quantity'] : 1;

        $labels = redq_rental_get_settings($product_id, 'labels', ['pickup_location', 'return_location', 'pickup_date', 'return_date', 'resources', 'categories', 'person', 'deposites', 'inventory'])['labels'];
        $displays = redq_rental_get_settings($product_id, 'display')['display'];
        $conditional_data = redq_rental_get_settings($product_id, 'conditions')['conditions'];
        $general_data = redq_rental_get_settings($product_id, 'general')['general'];

        $time_interval = !empty($conditional_data['time_interval']) ? (int) $conditional_data['time_interval'] : 30;

        if (isset($rental_data['quote_id'])) {
            wc_add_order_item_meta($item_id, $options_data['quote_id'] ? $options_data['quote_id'] : __('Quote Request', 'redq-rental'), $rental_data['quote_id']);

            update_post_meta($rental_data['quote_id'], '_rnb_rfq_order_id', $order_id);
            update_post_meta($rental_data['quote_id'], '_rnb_rfq_item_id', $item_id);
        }

        wc_add_order_item_meta($item_id, 'booking_inventory', $inventory_id);
        wc_add_order_item_meta($item_id, $labels['inventory'], get_the_title($inventory_id));

        if (isset($rental_data['pickup_date']) && $displays['pickup_date'] === 'open') {
            $pickup_date_time = convert_to_output_format($rental_data['pickup_date'], $conditional_data['date_format']);
            $ptime = '';
            if (isset($rental_data['pickup_time']) && $displays['pickup_time'] !== 'closed') {
                $pickup_date_time = $pickup_date_time . ' ' . esc_html__('at', 'redq-rental') . ' ' . $rental_data['pickup_time'];
                $ptime = $rental_data['pickup_time'];
            } else {
                $ptime = '00:00';
            }
            wc_add_order_item_meta($item_id, $labels['pickup_datetime'], $pickup_date_time);
            wc_add_order_item_meta($item_id, '_pickup_hidden_datetime', $rental_data['pickup_date'] . '|' . $ptime);
        }

        if ((isset($rental_data['dropoff_date']) && $displays['return_date'] === 'open') || (isset($rental_data['dropoff_time']) && $displays['return_time'] === 'open')) {
            $return_date_time = convert_to_output_format($rental_data['dropoff_date'], $conditional_data['date_format']);
            $rtime = '';
            if (isset($rental_data['dropoff_time']) && $displays['return_time'] !== 'closed') {
                $return_date_time = $return_date_time . ' ' . esc_html__('at', 'redq-rental') . ' ' . $rental_data['dropoff_time'];
                $rtime = $rental_data['dropoff_time'];
            } else {
                $rtime = '23:00';
            }
            wc_add_order_item_meta($item_id, $labels['return_datetime'], $return_date_time);
            wc_add_order_item_meta($item_id, '_return_hidden_datetime', $rental_data['dropoff_date'] . '|' . $rtime);
        }

        if ($rental_data['rental_days_and_costs']['pricing_type'] === 'flat_hours') {
            wc_add_order_item_meta($item_id, $general_data['total_hours'] ? $general_data['total_hours'] : esc_html__('Total Hours', 'redq-rental'), $rental_data['rental_days_and_costs']['flat_hours']);
            if ($rental_data['rental_days_and_costs']['days'] > 0) {
                wc_add_order_item_meta($item_id, '_return_hidden_days', $rental_data['rental_days_and_costs']['days']);
            }
        }

        if ($rental_data['rental_days_and_costs']['days'] > 0 && $rental_data['rental_days_and_costs']['pricing_type'] !== 'flat_hours') {

            $duration = '';
            $days = floor($rental_data['rental_days_and_costs']['flat_hours'] / 24);
            $hours = $rental_data['rental_days_and_costs']['flat_hours'] % 24;

            $duration .= $days ? $days . __(' Days ', 'redq-rental') : '';
            $duration .= $hours ? $hours . __(' Hours ', 'redq-rental') : '';

            wc_add_order_item_meta($item_id, $general_data['total_days'] ? $general_data['total_days'] : esc_html__('Total Days', 'redq-rental'), $duration);
            wc_add_order_item_meta($item_id, '_return_hidden_days', $rental_data['rental_days_and_costs']['days']);
        }

        if ($rental_data['rental_days_and_costs']['days'] <= 0 && $rental_data['rental_days_and_costs']['pricing_type'] !== 'flat_hours') {
            wc_add_order_item_meta($item_id, $general_data['total_hours'] ? $general_data['total_hours'] : esc_html__('Total Hours', 'redq-rental'), $rental_data['rental_days_and_costs']['hours']);
        }

        if ($rental_data['rental_days_and_costs']['price_breakdown']['duration_total']) {

            $duration_total = $rental_data['rental_days_and_costs']['price_breakdown']['duration_total'];
            $discount_total =  $rental_data['rental_days_and_costs']['price_breakdown']['discount_total'];
            $duration_total = $duration_total - $discount_total;

            wc_add_order_item_meta($item_id, $general_data['duration_cost'] ? $general_data['duration_cost'] : esc_html__('Duration Total', 'redq-rental'), wc_price($duration_total));
        }

        if (isset($rental_data['pickup_location']) && !empty($rental_data['pickup_location'])) {
            $cost = isset($rental_data['pickup_location']['cost']) && !empty($rental_data['pickup_location']['cost']) ? $rental_data['pickup_location']['cost'] : 0;
            $address = $rental_data['pickup_location']['address'];
            if (!empty($cost)) {
                $address .= ' ( ' . __('Cost: ', 'redq-rental') . ' ' . wc_price($cost) . ' )';
            }
            wc_add_order_item_meta($item_id, $labels['pickup_location'], $address);
        }

        if (isset($rental_data['return_location']) && !empty($rental_data['return_location'])) {
            $cost = isset($rental_data['return_location']['cost']) && !empty($rental_data['return_location']['cost']) ? $rental_data['return_location']['cost'] : 0;
            $address = $rental_data['return_location']['address'];
            if (!empty($cost)) {
                $address .= ' ( ' . __('Cost: ', 'redq-rental') . ' ' . wc_price($cost) . ' )';
            }
            wc_add_order_item_meta($item_id, $labels['return_location'], $address);
        }

        if (isset($rental_data['location_cost']) && !empty($rental_data['location_cost'])) {
            wc_add_order_item_meta($item_id, esc_html__('Location Cost', 'redq-rental'), wc_price($rental_data['location_cost']));
        }

        if (isset($rental_data['payable_cat']) && !empty($rental_data['payable_cat'])) {
            $category_details = '';
            foreach ($rental_data['payable_cat'] as $key => $category) {
                $unit = $category['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
                $category_details .= $category['name'] . '×' . $category['quantity'] . ' ( ' . wc_price($category['cost']) . ' - ' . $unit . ' )' . ' , <br> ';
            }
            wc_add_order_item_meta($item_id, $labels['categories'], $category_details);
        }

        if (isset($rental_data['payable_resource']) && !empty($rental_data['payable_resource'])) {
            $resource_details = '';
            foreach ($rental_data['payable_resource'] as $key => $resource) {
                $unit = $resource['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
                $resource_details .= $resource['name'] . ' ( ' . wc_price($resource['cost']) . ' - ' . $unit . ' )' . ' , <br> ';
            }
            wc_add_order_item_meta($item_id, $labels['resource'], $resource_details);
        }

        if (isset($rental_data['payable_security_deposites']) && !empty($rental_data['payable_security_deposites'])) {
            $deposit_details = '';
            foreach ($rental_data['payable_security_deposites'] as $key => $deposit) {
                $unit = $deposit['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
                $deposit_details .= $deposit['name'] . ' ( ' . wc_price($deposit['cost']) . ' - ' . $unit . ' )' . ' , <br> ';
            }
            wc_add_order_item_meta($item_id, $labels['deposite'], $deposit_details);
        }

        if (isset($rental_data['adults_info']) && !empty($rental_data['adults_info'])) {
            $adult = $rental_data['adults_info'];
            $unit = $adult['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
            $adult_details = $adult['title'] . ' ( ' . wc_price($adult['cost']) . ' - ' . $unit . ' )';
            wc_add_order_item_meta($item_id, $labels['adults'], $adult_details);
        }

        if (isset($rental_data['childs_info']) && !empty($rental_data['childs_info'])) {
            $child = $rental_data['childs_info'];
            $unit = $child['multiply'] === 'per_day' ?  __('Per Day', 'redq-rental')  :  __('One Time', 'redq-rental');
            $child_details = $child['title'] . ' ( ' . wc_price($child['cost']) . ' - ' . $unit . ' )';
            wc_add_order_item_meta($item_id, $labels['childs'], $child_details);
        }

        if (!empty($rental_data['rental_days_and_costs']['due_payment'])) {
            wc_add_order_item_meta($item_id, $general_data['payment_due'] ? $general_data['payment_due'] : esc_html__('Due Payment', 'redq-rental'), wc_price($rental_data['rental_days_and_costs']['due_payment'] * $quantity));
        }

        $price_breakdown = $rental_data['rental_days_and_costs']['price_breakdown'];
        wc_add_order_item_meta($item_id, 'rnb_price_breakdown', $price_breakdown);

        // Start inventory post meta update from here
        $booked_dates_ara = isset($rental_data['rental_days_and_costs']['booked_dates']['saved']) ? $rental_data['rental_days_and_costs']['booked_dates']['saved'] : array();

        $pickup_datetime = '';
        $return_datetime = '';

        if (isset($rental_data['pickup_date']) && !empty($rental_data['pickup_date'])) {
            $date = date_create($rental_data['pickup_date']);
            $pickup_datetime = date_format($date, "Y-m-d");
        }

        if (isset($rental_data['pickup_time']) && !empty($rental_data['pickup_time'])) {
            $pickup_datetime .= ' ' . $rental_data['pickup_time'];
        } else {
            $pickup_datetime .= ' ' . rnb_time_subtraction(0); // ' 00:00';
        }

        if (isset($rental_data['dropoff_date']) && !empty($rental_data['dropoff_date'])) {
            $date = date_create($rental_data['dropoff_date']);
            $return_datetime = date_format($date, "Y-m-d");
        }

        if (isset($rental_data['dropoff_time']) && !empty($rental_data['dropoff_time'])) {
            $return_datetime .= ' ' . $rental_data['dropoff_time'];
        } else {
            $return_datetime .= ' ' . rnb_time_subtraction($time_interval);
        }

        $booked_dates_ara = array(
            'pickup_datetime' => $pickup_datetime,
            'return_datetime' => $return_datetime,
            'inventory_id'    => $inventory_id,
            'product_id'      => $product_id,
            'quantity'        => get_post_meta($inventory_id, 'quantity', true),
        );

        $hidden_key = function_exists('rnb_oder_item_data_key') ? rnb_oder_item_data_key() :  'rnb_hidden_order_meta';
        wc_add_order_item_meta($item_id, $hidden_key, $rental_data);

        $order = wc_get_order($order_id);
        if (!in_array($order->get_status(), ['cancelled', 'failed'])) {
            rnb_process_rental_order_data($product_id, $order_id, $item_id, $inventory_id, $booked_dates_ara, $quantity);
        }
    }

    /**
     * Thank you
     */
    public function rnb_thankyou($order_id)
    {
        $order = new WC_Order($order_id);
        $items = $order->get_items();

        foreach ($items as $item) {
            foreach ($item['item_meta'] as $key => $value) {
                if ($key === 'Quote Request') {
                    wp_update_post(array(
                        'ID'          => $value[0],
                        'post_status' => 'quote-completed'
                    ));
                }
            }
        }
    }

    /**
     * Handle Failed order
     *
     * @param int $order_id
     * @param object $order
     * @return void
     */
    public function rnb_handle_failed_order($order_id, $order)
    {
        if (!empty($order) && !in_array($order->get_status(), ['cancelled', 'failed'])) {
            return;
        }

        $items = $order->get_items();

        foreach ($items as $key => $item) {
            $item_data = $item->get_data();

            $args = array(
                'order_id'   => $order_id,
                'item_id'    => $item_data['id'],
                'product_id' => $item_data['product_id'],
            );

            rnb_booking_dates_update($args);
        }
    }

    /**
     * Handle after order event
     *
     * @return void
     */
    public function rnb_handle_after_order_event()
    {
        global $wp;

        if (!is_wc_endpoint_url('order-received')) {
            return;
        }

        $order_id = absint($wp->query_vars['order-received']);
        $order    = wc_get_order($order_id);

        if(empty($order)){
            return;
        }

        if (!in_array($order->get_status(), ['cancelled', 'failed'])) {
            return;
        }

        $items = $order->get_items();

        foreach ($items as $key => $item) {
            $item_data = $item->get_data();

            $args = array(
                'order_id'   => $order_id,
                'item_id'    => $item_data['id'],
                'product_id' => $item_data['product_id'],
            );

            rnb_booking_dates_update($args);
        }
    }
}
