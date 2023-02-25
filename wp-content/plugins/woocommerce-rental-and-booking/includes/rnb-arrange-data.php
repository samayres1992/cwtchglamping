<?php

use Carbon\Carbon;

function rnb_arrange_inventory_data($product_id, $conditions)
{
    $has_inventory = rnb_get_product_inventory_id($product_id);

    if (empty($has_inventory)) {
        return;
    }

    $args = [
        'post_type'      => 'inventory',
        'post__in'       => $has_inventory,
        'posts_per_page' => -1,
        'orderby'        => 'post__in',
    ];

    $inventories = get_posts($args);

    foreach ($inventories as $index => $inventory) {
        $inventories[$index]->quantity = get_post_meta($inventory->ID, 'quantity', true);
    }

    $payloads = [
        'data'        => $inventories,
        'title'       => 'Inventories',
        'placeholder' => 'Choose inventory',
        'layout'      => $conditions['booking_layout']
    ];

    return apply_filters('rnb_product_inventories', $payloads, $product_id, $conditions);
}

/**
 * rnb_arrange_pickup_location_data function
 *
 * @param int $product_id
 * @param array $conditions
 * @return array
 */
function rnb_arrange_pickup_location_data($product_id, $inventory_id, $conditions)
{
    $pickup_labels = redq_rental_get_settings($product_id, 'labels', ['pickup_location']);

    $payloads = [
        'data' => $conditions['booking_layout'] !== 'layout_two' ? WC_Product_Redq_Rental::redq_get_rental_payable_attributes('pickup_location', $inventory_id) : [],
        'title' => $pickup_labels['labels']['pickup_location'],
        'placeholder' => $pickup_labels['labels']['pickup_loc_placeholder'],
        'layout' => $conditions['booking_layout']
    ];

    return apply_filters('rnb_product_pickup_locations', $payloads, $product_id, $inventory_id, $conditions);
}

/**
 * rnb_arrange_return_location_data function
 *
 * @param int $product_id
 * @param array $conditions
 * @return array
 */
function rnb_arrange_return_location_data($product_id, $inventory_id, $conditions)
{
    $labels = redq_rental_get_settings($product_id, 'labels', ['return_location']);

    $payloads = [
        'data' => $conditions['booking_layout'] !== 'layout_two' ? WC_Product_Redq_Rental::redq_get_rental_payable_attributes('dropoff_location', $inventory_id) : [],
        'title' => $labels['labels']['return_location'],
        'placeholder' => $labels['labels']['return_loc_placeholder'],
        'layout' => $conditions['booking_layout']
    ];

    return apply_filters('rnb_product_return_locations', $payloads, $product_id, $inventory_id, $conditions);
}

/**
 * rnb_arrange_resource_data function
 *
 * @param int $product_id
 * @param array $conditions
 * @return array
 */
function rnb_arrange_resource_data($product_id, $inventory_id, $conditions)
{
    $labels = redq_rental_get_settings($product_id, 'labels', ['resources']);
    $resources = WC_Product_Redq_Rental::redq_get_rental_payable_attributes('resource', $inventory_id);

    foreach ($resources as $key => $resource) {
        if ($resource['resource_applicable'] === 'per_day') {
            $resources[$key]['extra_meta'] = '<span class="pull-right show_if_day">' . wc_price($resource['resource_cost']) . '<span>' . __(' - Per Day', 'redq-rental') . '</span></span>
				<span class="pull-right show_if_time" style="display: none;">' . wc_price($resource['resource_hourly_cost']) . ' ' . __(' - Per Hour', 'redq-rental') . '</span>';
        } else {
            $resources[$key]['extra_meta'] = '<span class="pull-right">' . wc_price($resource['resource_cost']) . ' ' . __(' - One Time', 'redq-rental') . '</span>';
        }
    }

    $payloads = [
        'data' => $resources,
        'title' => $labels['labels']['resource'],
    ];

    return apply_filters('rnb_product_resources', $payloads, $product_id, $inventory_id, $conditions);
}

/**
 * rnb_arrange_category_data function
 *
 * @param int $product_id
 * @param array $conditions
 * @return array
 */
function rnb_arrange_category_data($product_id, $inventory_id, $conditions)
{
    $labels = redq_rental_get_settings($product_id, 'labels', ['categories']);
    $categories = WC_Product_Redq_Rental::redq_get_rental_payable_attributes('rnb_categories', $inventory_id);
    foreach ($categories as $key => $category) {
        if ($category['applicable'] === 'per_day') {
            $categories[$key]['extra_meta'] = '<span class="pull-right show_if_day">' . wc_price($category['cost']) . '<span> ' . __(' - Per Day', 'redq-rental') . '</span></span>
				<span class="pull-right show_if_time" style="display: none;">' . wc_price($category['hourlycost']) . ' ' . __(' - Per Hour', 'redq-rental') . '</span>';
        } else {
            $categories[$key]['extra_meta'] = '<span class="pull-right">' . wc_price($category['cost']) . ' ' . __(' - One Time', 'redq-rental') . '</span>';
        }

        $args = [
            'input_name' => 'cat_quantity',
            'min_value' => 1,
            'max_value' => $category['qty'] ? $category['qty'] : 1,
        ];

        $product = wc_get_product($product_id);

        $defaults = [
            'input_id' => uniqid('quantity_'),
            'input_name' => 'quantity',
            'input_value' => '1',
            'classes' => apply_filters('woocommerce_quantity_input_classes', ['input-text', 'qty', 'text'], $product),
            'max_value' => apply_filters('woocommerce_quantity_input_max', -1, $product),
            'min_value' => apply_filters('woocommerce_quantity_input_min', 0, $product),
            'step' => apply_filters('woocommerce_quantity_input_step', 1, $product),
            'pattern' => apply_filters('woocommerce_quantity_input_pattern', has_filter('woocommerce_stock_amount', 'intval') ? '[0-9]*' : ''),
            'inputmode' => apply_filters('woocommerce_quantity_input_inputmode', has_filter('woocommerce_stock_amount', 'intval') ? 'numeric' : ''),
            // 'product_name' => $product ? $product->get_title() : '',
            'placeholder' => __('Quantity', 'woocommerce'),
            'title' => esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce'),
            'labelledby' => !empty($args['product_name']) ? sprintf(__('%s quantity', 'woocommerce'), strip_tags($args['product_name'])) : '',
        ];

        $args = apply_filters('woocommerce_quantity_input_args', wp_parse_args($args, $defaults), $product);

        // Apply sanity to min/max args - min cannot be lower than 0.
        $args['min_value'] = max($args['min_value'], 0);
        $args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

        // Max cannot be lower than min if defined.
        if ('' !== $args['max_value'] && $args['max_value'] < $args['min_value']) {
            $args['max_value'] = $args['min_value'];
        }

        $categories[$key]['quantity_input'] = $args;
    }

    $payloads = [
        'data' => $categories,
        'title' => $labels['labels']['categories'],
    ];

    return apply_filters('rnb_product_categories', $payloads, $product_id, $inventory_id, $conditions);
}

/**
 * rnb_arrange_adult_data
 *
 * @param int $product_id
 * @param array $conditions
 * @return array
 */
function rnb_arrange_adult_data($product_id, $inventory_id, $conditions)
{
    $labels = redq_rental_get_settings($product_id, 'labels', ['person']);
    $person = WC_Product_Redq_Rental::redq_get_rental_payable_attributes('person', $inventory_id);
    $adults = isset($person['adults']) ? $person['adults'] : [];

    if (isset($adults) && !empty($adults)) {
        foreach ($adults as $key => $adult) {
            if ($adult['person_cost_applicable'] === 'per_day') {

                $extra_meta = __(' ', 'redq-rental');
                $extra_hourly_meta = __(' ', 'redq-rental');

                if (isset($adult['person_cost']) && !empty($adult['person_cost'])) {
                    $extra_meta .= wc_price($adult['person_cost']);
                    $extra_meta .= __(' - Per day', 'redq-rental');
                }

                if (isset($adult['person_hourly_cost']) && !empty($adult['person_hourly_cost'])) {
                    $extra_hourly_meta .= wc_price($adult['person_hourly_cost']);
                    $extra_hourly_meta .= __(' - Per hour', 'redq-rental');
                }

                $adults[$key]['extra_meta'] = $extra_meta;
                $adults[$key]['extra_hourly_meta'] = $extra_hourly_meta;

                //For modal layout
                $adults[$key]['extra_meta_modal'] = '<span class="pull-right show_if_day">' . wc_price($adult['person_cost']) . '<span>' . __(' - Per Day', 'redq-rental') . '</span></span>
				<span class="pull-right show_if_time" style="display: none;">' . wc_price($adult['person_hourly_cost']) . ' ' . __(' - Per Hour', 'redq-rental') . '</span>';
            } else {
                $extra_meta = __(' ', 'redq-rental');
                if (isset($adult['person_cost']) && !empty($adult['person_cost'])) {
                    $extra_meta .= wc_price($adult['person_cost']);
                    $extra_meta .= __(' - One time', 'redq-rental');
                }

                $adults[$key]['extra_meta'] = $extra_meta;

                //For modal layout
                $adults[$key]['extra_meta_modal'] = $extra_meta;
            }
        }
    }

    $payloads = [
        'data' => $adults,
        'title' => $labels['labels']['adults'],
        'placeholder' => $labels['labels']['adults_placeholder'],
    ];

    return apply_filters('rnb_product_adults', $payloads, $product_id, $inventory_id, $conditions);
}

/**
 * rnb_arrange_child_data
 *
 * @param int $product_id
 * @param array $conditions
 * @return array
 */
function rnb_arrange_child_data($product_id, $inventory_id, $conditions)
{
    $labels = redq_rental_get_settings($product_id, 'labels', ['person']);

    $person = WC_Product_Redq_Rental::redq_get_rental_payable_attributes('person', $inventory_id);
    $children = isset($person['childs']) ? $person['childs'] : [];

    if (isset($children) && !empty($children)) {
        foreach ($children as $key => $child) {
            if ($child['person_cost_applicable'] === 'per_day') {

                $extra_meta = __(' ', 'redq-rental');
                $extra_hourly_meta = __(' ', 'redq-rental');

                if (isset($child['person_cost']) && !empty($child['person_cost'])) {
                    $extra_meta .= wc_price($child['person_cost']);
                    $extra_meta .= __(' - Per day', 'redq-rental');
                }

                if (isset($child['person_hourly_cost']) && !empty($child['person_hourly_cost'])) {
                    $extra_hourly_meta .= wc_price($child['person_hourly_cost']);
                    $extra_hourly_meta .= __(' - Per hour', 'redq-rental');
                }

                $children[$key]['extra_meta'] = $extra_meta;
                $children[$key]['extra_hourly_meta'] = $extra_hourly_meta;

                //For modal layout
                $children[$key]['extra_meta_modal'] = '<span class="pull-right show_if_day">' . wc_price($child['person_cost']) . '<span>' . __(' - Per Day', 'redq-rental') . '</span></span>
				<span class="pull-right show_if_time" style="display: none;">' . wc_price($child['person_hourly_cost']) . ' ' . __(' - Per Hour', 'redq-rental') . '</span>';
            } else {
                $extra_meta = __(' ', 'redq-rental');

                if (isset($child['person_cost']) && !empty($child['person_cost'])) {
                    $extra_meta .= wc_price($child['person_cost']);
                    $extra_meta .= __(' - One time', 'redq-rental');
                }

                $children[$key]['extra_meta'] = $extra_meta;

                //For modal layout
                $children[$key]['extra_meta_modal'] = $extra_meta;
            }
        }
    }

    $payloads = [
        'data' => $children,
        'title' => $labels['labels']['childs'],
        'placeholder' => $labels['labels']['childs_placeholder'],
    ];

    return apply_filters('rnb_product_children', $payloads, $product_id, $inventory_id, $conditions);
}

/**
 * rnb_arrange_security_deposit_data function
 *
 * @param int $product_id
 * @param array $conditional_data
 * @return array
 */
function rnb_arrange_security_deposit_data($product_id, $inventory_id, $conditions)
{
    $deposits = WC_Product_Redq_Rental::redq_get_rental_payable_attributes('deposite', $inventory_id);
    $labels = redq_rental_get_settings($product_id, 'labels', ['deposites']);

    foreach ($deposits as $key => $deposit) {
        if ($deposit['security_deposite_applicable'] === 'per_day') {
            $deposits[$key]['extra_meta'] = '<span class="pull-right show_if_day">' . wc_price($deposit['security_deposite_cost']) . '<span> ' . __(' - Per Day', 'redq-rental') . ' </span></span>
				<span class="pull-right show_if_time" style="display: none;">' . wc_price($deposit['security_deposite_hourly_cost']) . ' ' . __(' - Per Hour', 'redq-rental') . '</span>';
        } else {
            $deposits[$key]['extra_meta'] = '<span class="pull-right">' . wc_price($deposit['security_deposite_cost']) . ' ' . __(' - One Time', 'redq-rental') . '</span>';
        }
    }

    $payloads = [
        'data' => $deposits,
        'title' => $labels['labels']['deposite'],
    ];

    return apply_filters('rnb_product_deposits', $payloads, $product_id, $inventory_id, $conditions);
}

function rnb_time_subtraction($time)
{
    $hour = $time >= 60 ? 01 : 00;
    $mins = $time >= 60 ? 00 : $time;

    $upper_limit = new DateTime('24:00');
    $lower_limit = new DateTime("$hour:$mins");

    $interval = $upper_limit->diff($lower_limit);
    $result = $interval->format('%H:%i');

    return $result;
}

/**
 * Check dates in URL
 *
 * @return boolean
 */
function rnb_check_url_dates()
{
    return isset($_GET['daterange']) && !empty($_GET['daterange']) ? true : false;
}

/**
 * Normalize url params
 *
 * @return array
 */
function rnb_normalize_params()
{
    global $post;

    $product_id = isset($post->ID) ? $post->ID : null;
    $results = [];

    if (empty($product_id)) {
        return $results;
    }

    $params = $_GET;
    if (empty($params)) {
        return $results;
    }

    $dates = isset($params['daterange']) ? $params['daterange'] : '';
    if (!empty($dates)) {
        $conditions = redq_rental_get_settings($product_id, 'conditions')['conditions'];

        $split_dates = explode('-', $dates);
        $start_date = isset($split_dates[0]) ? trim($split_dates[0]) : '';
        $return_date = isset($split_dates[1]) ? trim($split_dates[1]) : '';

        $results['start_date'] = (new Carbon($start_date))->format($conditions['date_format']);
        $results['return_date'] = (new Carbon($return_date))->format($conditions['date_format']);
    }

    if (isset($params['tex_resource'])) {
        $results['resources'] = $params['tex_resource'];
    }

    if (isset($params['tex_pickup_location'])) {
        $results['pickup_location'] = $params['tex_pickup_location'];
    }

    if (isset($params['tex_return_location'])) {
        $results['return_location'] = $params['tex_return_location'];
    }

    if (isset($params['tex_person'])) {
        $results['person'] = $params['tex_person'];
    }

    return $results;
}


/**
 * Prepare data for Full & Google calendar
 *
 * @param object $item
 * @param int $order_id
 * @param object $order
 * @return array
 */
function rnb_prepare_calendar_item_data($item, $order_id, $order)
{
    $results = [];

    $item_data = $item->get_data();

    $item_id    = $item_data['id'];
    $product_id = $item_data['product_id'];
    $quantity   = $item_data['quantity'];

    $results['post_status'] = 'wc-' . $order->get_status();
    $results['title'] = html_entity_decode(get_the_title($product_id)) . ' ×' . $quantity;
    $results['link'] = get_the_permalink($product_id);
    $results['id'] = $order_id;
    $results['color'] = rnb_get_status_to_color_map($order->get_status());
    $results['description'] = '<table cellspacing="0" class="redq-rental-display-meta"><tbody><tr><th>' . __('Order ID:', 'redq-rental') . '</th><td># <a href="' . admin_url('post.php?post=' . absint($order->get_id()) . '&action=edit') . '"> ' . $order_id . ' </a> </td></tr>';
    $results['description'] .= '<table cellspacing="0" class="redq-rental-display-meta"><tbody><tr><th>' . __('Quantity:', 'redq-rental') . '</th><td>' . $quantity . '</td></tr>';

    $item_details = $item->get_formatted_meta_data('');

    foreach ($item_details as $item_detail) {
        if ('_pickup_hidden_datetime' !== $item_detail->key && '_return_hidden_datetime' !== $item_detail->key && '_return_hidden_days' !== $item_detail->key && 'booking_inventory' !== $item_detail->key && 'redq_google_cal_sync_id' !== $item_detail->key) {
            $results['description'] .= '<tr><th>' . $item_detail->key . '</th><td>' . $item_detail->value . '</td></tr>';
        }

        if (in_array($item_detail->key, ['_pickup_hidden_datetime', 'pickup_hidden_datetime'])) {
            $pickup_datetime = explode('|', $item_detail->value);
            $results['start'] = $pickup_datetime[0];
            $results['start_time'] = isset($pickup_datetime[1]) ? $pickup_datetime[1] : '';
        }

        if (in_array($item_detail->key, ['_return_hidden_datetime', 'return_hidden_datetime'])) {
            $return_datetime = explode('|', $item_detail->value);
            $results['end'] = $return_datetime[0];
            $results['return_date'] = $return_datetime[0];
            $results['return_time'] = isset($return_datetime[1]) ? $return_datetime[1] : '';
        }

        $results['url'] = admin_url('post.php?post=' . absint($order->get_id()) . '&action=edit');
    }

    //Only for backend orders
    $backend_item_details = wc_get_order_item_meta($item_id, 'rnb_hidden_order_meta');
    $price_breakdown = isset($backend_item_details['rental_days_and_costs']['price_breakdown']) ? $backend_item_details['rental_days_and_costs']['price_breakdown'] : [];

    if ($backend_item_details) {
        $results['start'] = $backend_item_details['pickup_date'];
        $results['start_time'] = $backend_item_details['pickup_time'];

        $results['end'] = isset($backend_item_details['return_date']) ? $backend_item_details['return_date'] : $backend_item_details['dropoff_date'];
        $results['return_time'] = isset($backend_item_details['return_time']) ? $backend_item_details['return_time'] : $backend_item_details['dropoff_time'];
    }
    //End

    $item_total = $item->get_total();
    $item_tax = $item->get_total_tax();
    $item_tax = $item_tax ? $item_tax : 0;
    $deposit_total = isset($price_breakdown['deposit_total']) ? $price_breakdown['deposit_total'] : 0;
    // $order_total = $order->get_formatted_order_total();

    $results['description'] .= '<tr><th>' . esc_html__('Total Amount', 'redq-rental') . '</th><td>' . wc_price($item_total + $deposit_total + $item_tax) . '</td>';
    // $results['description'] .= '<tr><th>' . esc_html__('Order Total', 'redq-rental') . '</th><td>' . $order_total . '</td>';
    $results['description'] .= '</tbody></table>';


    return $results;
}

/**
 * Status to color scheme
 *
 * @return array|string
 */
function rnb_get_status_to_color_map($status = null)
{
    $map =  [
        'pending'    => '#7266BA',
        'processing' => '#23B7E5',
        'on-hold'    => '#f7cb13',
        'completed'  => '#27C24C',
        'cancelled'  => '#A00',
        'refunded'   => '#a7aaad',
        'failed'     => '#EE3939',
    ];

    if (empty($status)) {
        return $map;
    }

    return isset($map[$status]) ? $map[$status] : '#7266BA';
};
