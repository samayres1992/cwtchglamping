<?php

namespace REDQ_RnB;

use REDQ_RnB\Booking_Manager;
use REDQ_RnB\Traits\Form_Trait;
use REDQ_RnB\Traits\Data_Trait;
use REDQ_RnB\Traits\Cost_Trait;
use REDQ_RnB\Traits\Error_Trait;
use REDQ_RnB\Traits\Period_Trait;

/**
 * Ajax class
 */
class Ajax extends Booking_Manager
{
    use Form_Trait, Data_Trait, Cost_Trait, Error_Trait, Period_Trait;

    /**
     * init class
     */
    public function __construct()
    {
        $events = [
            'rnb_get_inventory_data'       => true,
            'rnb_calculate_inventory_data' => true,
            'rnb_quote_booking_data'       => true,
            'rnb_clear_order_item_dates'   => false,
            'rnb_refund_deposit'   => false
        ];

        foreach ($events as $event => $nopriv) {
            add_action('wp_ajax_' . $event, [$this, $event]);
            if ($nopriv) {
                add_action('wp_ajax_nopriv_' . $event, [$this, $event]);
            }
        }
    }

    /**
     * Get inventory details
     *
     * @return response
     */
    public function rnb_get_inventory_data()
    {

        $inventory_id = $_POST['inventory_id'];
        $product_id   = $_POST['post_id'];

        $periods = $this->get_periods($product_id, $inventory_id);

        $availability = rnb_inventory_availability_check($product_id, $inventory_id);
        $allowed_datetime = rnb_inventory_availability_check($product_id, $inventory_id, 'ALLOWED_DATETIMES_ONLY');

        $cart_dates = rental_product_in_cart($product_id);
        $starting_block_days = redq_rental_staring_block_days($product_id);

        $holidays = redq_rental_handle_holidays($product_id);

        $buffer_dates = array_merge($starting_block_days, $cart_dates, $holidays);

        $rnb_data = rnb_get_combined_settings_data($product_id);

        $pricing_data = redq_rental_get_pricing_data($inventory_id, $product_id);
        $rnb_data['pricings'] = $pricing_data;

        $price_unit = rnb_get_product_price($product_id, $inventory_id);
        $price_unit_markup = $price_unit['prefix'] . '&nbsp;' . wc_price($price_unit['price']) . '&nbsp;' . $price_unit['suffix'];

        $woocommerce_info = rnb_get_woocommerce_currency_info();
        $translated_strings = rnb_get_translated_strings();
        $localize_info = rnb_get_localize_info($product_id);

        $booking_data = [
            'rnb_data'           => $rnb_data,
            'block_dates'        => $availability,
            'woocommerce_info'   => $woocommerce_info,
            'translated_strings' => $translated_strings,
            'availability'       => $availability,
            'buffer_days'        => $buffer_dates,
            'quantity'           => get_post_meta($inventory_id, 'quantity', true),
            'unit_price'         => $price_unit_markup,
            'product_id'         => $product_id
        ];

        // $calendar_data = [
        //     'availability'       => $availability,
        //     'calendar_props'     => $rnb_data,
        //     'block_dates'        => $availability,
        //     'allowed_datetime'   => $allowed_datetime,
        //     'localize_info'      => $localize_info,
        //     'translated_strings' => $translated_strings,
        //     'buffer_days'        => $buffer_dates,
        // ];

        $calendar_data = [
            'availability'       => $periods['availability'],
            'calendar_props'     => $rnb_data,
            'block_dates'        =>  $periods['availability'],
            'allowed_datetime'   =>  $periods['allowed_datetime'],
            'localize_info'      => $localize_info,
            'translated_strings' => $translated_strings,
            'buffer_days'        => $periods['buffer_dates'],
        ];

        $conditions = redq_rental_get_settings($product_id, 'conditions');
        $conditional_data = $conditions['conditions'];

        $pick_up_locations = rnb_arrange_pickup_location_data($product_id, $inventory_id, $conditional_data);
        $return_locations  = rnb_arrange_return_location_data($product_id, $inventory_id, $conditional_data);
        $deposits          = rnb_arrange_security_deposit_data($product_id, $inventory_id, $conditional_data);
        $adult_data        = rnb_arrange_adult_data($product_id, $inventory_id, $conditional_data);
        $child_data        = rnb_arrange_child_data($product_id, $inventory_id, $conditional_data);
        $resources         = rnb_arrange_resource_data($product_id, $inventory_id, $conditional_data);
        $categories        = rnb_arrange_category_data($product_id, $inventory_id, $conditional_data);

        echo json_encode([
            'booking_data'      => $booking_data,
            'calendar_data'     => $calendar_data,
            'pick_up_locations' => $pick_up_locations,
            'return_locations'  => $return_locations,
            'deposits'          => $deposits,
            'adults'            => $adult_data,
            'childs'            => $child_data,
            'resources'         => $resources,
            'categories'        => $categories,
        ]);

        wp_die();
    }

    /**
     * calculate_inventory_data
     * 
     * @return response
     */
    public function rnb_calculate_inventory_data()
    {
        $posted_data = [];

        $post_form = $_POST['form'];
        $product_id = isset($post_form['add-to-cart']) ? $post_form['add-to-cart'] : '';
        $inventory_id = isset($post_form['booking_inventory']) ? $post_form['booking_inventory'] : '';

        if (empty($product_id) || empty($inventory_id)) {
            return;
        }

        $_POST['form'] = $this->rearrange_form_data($_POST['form']);

        $has_errors = $this->handle_form($_POST['form']);

        if ($has_errors && !empty($has_errors)) {
            $posted_data['error'] = $has_errors;
            wp_send_json($posted_data);
        }

        $posted_data = $this->prepare_form_data($_POST['form']);

        $cart_quantity = $this->check_product_quantity_in_cart($product_id, $_POST['form']);
        $quantity = (isset($posted_data['quantity']) && !empty($posted_data['quantity'])) ? intval($posted_data['quantity']) : 1;
        $final_cost = wc_price($posted_data['rental_days_and_costs']['cost'] * $quantity);

        $price_breakdown = $posted_data['rental_days_and_costs'];
        $distance_unit = isset($posted_data['distance_unit_type']) ? $posted_data['distance_unit_type'] : null;

        $response = [
            'quantity'           => $quantity,
            'available_quantity' => $posted_data['available_quantity'] - $cart_quantity,
            'total_cost'         => $final_cost,
            'date_multiply'      => $posted_data['date_multiply'],
            'price_breakdown'    => rnb_format_prices($price_breakdown, $quantity, $product_id, $distance_unit),
        ];

        wp_send_json($response);
    }

    /**
     * rnb_quote_booking_data
     *
     * @return response
     */
    public function rnb_quote_booking_data()
    {
        $quote_id    = $_POST['quote_id'];
        $product_id  = $_POST['product_id'];
        $cart_data   = [];
        $posted_data = [];

        $display_options = redq_rental_get_settings($product_id, 'display')['display'];
        $quote_meta      = json_decode(get_post_meta($quote_id, 'order_quote_meta', true), true);
        $cost            = get_post_meta($quote_id, '_quote_price', true);
        $cost            = floatval($cost);

        if (is_array($quote_meta) && !empty($quote_meta)) {
            foreach ($quote_meta as $key => $value) {
                if (isset($quote_meta[$key]['name'])) :
                    $posted_data[$quote_meta[$key]['name']] = $quote_meta[$key]['value'];
                endif;
            }
        };

        $pre_payment_percentage = get_option('rnb_instance_payment');
        if (empty($pre_payment_percentage) || $display_options['instance_payment'] === 'closed') {
            $pre_payment_percentage = 100;
        }

        $instance_payment = ($cost * $pre_payment_percentage) / 100;
        $due_payment = $cost - $instance_payment;

        $posted_data['quote_id'] = $quote_id;
        $posted_data = $this->rearrange_form_data($posted_data);
        $ajax_data = $this->prepare_form_data($posted_data);

        $quantity =  intval($ajax_data['quantity']);

        $ajax_data['rental_days_and_costs']['cost'] = $instance_payment;
        $ajax_data['rental_days_and_costs']['instant_pay'] = $pre_payment_percentage;
        $ajax_data['rental_days_and_costs']['due_payment'] = floatval($due_payment) * $quantity;

        $ajax_data['posted_data'] = $posted_data;
        $cart_data['rental_data'] = $ajax_data;

        if (WC()->cart->add_to_cart($product_id, $quantity = 1, $variation_id = '', $variation = '', $cart_data)) {
            echo json_encode([
                'success' => true,
            ]);
        }

        wp_die();
    }

    /**
     * Clear order item date
     *
     * @return void
     */
    public function rnb_clear_order_item_dates()
    {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : '';

        if (!($product_id && $item_id && $order_id)) {
            $response = [
                'success' => false,
                'message' => esc_html__('Sorry! Something goes wrong. Please check again', 'redq-rental')
            ];
            wp_send_json($response);
        }

        $args = [
            'product_id' => $product_id,
            'order_id'   => $order_id,
            'item_id'    => $item_id
        ];

        rnb_booking_dates_update($args);

        $response = [
            'success' => true,
            'message' => esc_html__('Blocked dates has been clear successfully!', 'redq-rental')
        ];
        wp_send_json($response);
    }

    /**
     * Refund deposit
     *
     * @return json
     */
    public function rnb_refund_deposit()
    {
        if (!current_user_can('edit_shop_orders')) {
            wp_die(-1);
        }

        $order_id      = isset($_POST['order_id']) ? absint($_POST['order_id']) : 0;
        $refund_amount = isset($_POST['refund_amount']) ? wc_format_decimal(sanitize_text_field(wp_unslash($_POST['refund_amount'])), wc_get_price_decimals()) : 0;
        $refund_reason = __('Deposit Refund', 'redq-rental');
        $response      = [];

        try {
            $order      = wc_get_order($order_id);
            $line_items = [];
            $max_refund = wc_format_decimal($order->get_total() - $order->get_total_refunded(), wc_get_price_decimals());

            if ((!$refund_amount && (wc_format_decimal(0, wc_get_price_decimals()) !== $refund_amount)) || $max_refund < $refund_amount || 0 > $refund_amount) {
                throw new \Exception(__('Invalid refund amount', 'redq-rental'));
            }

            // Create the refund object.
            $refund = wc_create_refund(
                [
                    'amount'         => $refund_amount,
                    'reason'         => $refund_reason,
                    'order_id'       => $order_id,
                    'line_items'     => $line_items,
                    'refund_payment' => false,
                    'restock_items'  => 0,
                ]
            );

            add_post_meta($refund->get_id(), '_refunded_type', 'rnb_refund_deposit');

            if (is_wp_error($refund)) {
                throw new \Exception($refund->get_error_message());
            }
        } catch (\Exception $e) {
            wp_send_json_error(['error' => $e->getMessage()]);
        }

        $response = [
            'success' => true,
            'message' => esc_html__('Amount refunded successfully', 'redq-rental')
        ];
        wp_send_json($response);
    }
}
