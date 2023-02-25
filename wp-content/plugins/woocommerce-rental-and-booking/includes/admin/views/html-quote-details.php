<div id="request-a-quote-data">
    <h2><?php esc_html_e('Quote', 'redq-rental') ?><?php echo '#' . $post->ID ?><?php esc_html_e('Details', 'redq-rental') ?></h2>
    <p class="quote_number">
        <?php
        $product_id = get_post_meta($post->ID, 'add-to-cart', true);
        $product_title = get_the_title($product_id);
        $product_url = get_the_permalink($product_id);

        $get_labels = redq_rental_get_settings($product_id, 'labels', array('pickup_location', 'return_location', 'pickup_date', 'return_date', 'resources', 'categories', 'person', 'deposites'));
        $labels = $get_labels['labels'];
        $order_quote_meta = json_decode(stripslashes(get_post_meta($post->ID, 'order_quote_meta', true)), true);

        // $inventory_index = array_search('booking_inventory', array_column($order_quote_meta, 'name'));
        // $inventory_id = $order_quote_meta[$inventory_index]['value'];

        ?>
        <?php esc_html_e('Request for:', 'redq-rental') ?> <a href="<?php echo esc_url($product_url) ?>" target="_blank"><?php echo $product_title ?></a>
    </p>


    <?php
    $contacts = array();
    foreach ($order_quote_meta as $meta) {
        if (isset($meta['name'])) {
            switch ($meta['name']) {
                case 'add-to-cart':
                case 'cat_quantity':
                case 'currency-symbol':
                    break;

                case 'booking_inventory':
                    if (!empty($meta['value'])) :
                        echo '<dt style="float: left;margin-right: 10px;">' . esc_html__('Inventory', 'redq-rental') . ':</dt>';
                        echo '<dd><p><strong>' . get_the_title($meta['value']) . '</strong></p></dd>';
                    endif;
                    break;

                case 'pickup_location':
                    if (!empty($meta['value'])) :
                        $pickup_location       = get_pickup_location_data($meta['value'], 'pickup_location');
                        $pickup_location_title = $labels['pickup_location'];
                        $pickup_location_data  = explode('|', $pickup_location);
                        $pickup_value = $pickup_location_data[1] . ' ( ' . wc_price($pickup_location_data[2]) . ' )';

                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_location_title) . ':</dt>';
                        echo '<dd><p><strong>' . $pickup_value . '</strong></p></dd>';
                    endif;
                    break;

                case 'dropoff_location':
                    if (!empty($meta['value'])) :
                        $dropoff_location      = get_dropoff_location_data($meta['value'], 'dropoff_location');
                        $return_location_title = $labels['return_location'];
                        $return_location_data  = explode('|', $dropoff_location);
                        $return_value          = $return_location_data[1] . ' ( ' . wc_price($return_location_data[2]) . ' )';

                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($return_location_title) . ':</dt>';
                        echo '<dd><p><strong>' . $return_value . '</strong></p></dd>';
                    endif;
                    break;

                case 'pickup_date':
                    if (!empty($meta['value'])) :
                        $pickup_date_title = $labels['pickup_date'];
                        $pickup_date_value = $meta['value'];
                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_date_title) . ':</dt>';
                        echo '<dd><p><strong>' . $pickup_date_value . '</strong></p></dd>';
                    endif;
                    break;

                case 'pickup_time':
                    if (!empty($meta['value'])) :
                        $pickup_time_title = $labels['pickup_time'];
                        $pickup_time_value = $meta['value'] ? $meta['value'] : '';
                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($pickup_time_title) . ':</dt>';
                        echo '<dd><p><strong>' . $pickup_time_value . '</strong></p></dd>';
                    endif;
                    break;

                case 'dropoff_date':
                    if (!empty($meta['value'])) :
                        $return_date_title = $labels['return_date'];
                        $return_date_value = $meta['value'] ? $meta['value'] : '';
                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($return_date_title) . ':</dt>';
                        echo '<dd><p><strong>' . $return_date_value . '</strong></p></dd>';
                    endif;
                    break;

                case 'dropoff_time':
                    if (!empty($meta['value'])) :
                        $return_time_title = $labels['return_time'];
                        $return_time_value = $meta['value'] ? $meta['value'] : '';
                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($return_time_title) . ':</dt>';
                        echo '<dd><p><strong>' . $return_time_value . '</strong></p></dd>';
                    endif;
                    break;

                case 'additional_adults_info':
                    if (!empty($meta['value'])) :
                        $adult = get_person_data($meta['value'], 'person');
                        $person_title = $labels['adults'];
                        $dval = explode('|', $adult);
                        $person_value = $dval[0] . ' ( ' . wc_price($dval[1]) . ' - ' . $dval[2] . ' )';
                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($person_title) . ':</dt>';
                        echo '<dd><p><strong>' . $person_value . '</strong></p></dd>';
                    endif;
                    break;

                case 'additional_childs_info':
                    if (!empty($meta['value'])) :
                        $child = get_person_data($meta['value'], 'person');
                        $person_title = $labels['childs'];
                        $dval = explode('|', $child);
                        $person_value = $dval[0] . ' ( ' . wc_price($dval[1]) . ' - ' . $dval[2] . ' )';
                        echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($person_title) . ':</dt>';
                        echo '<dd><p><strong>' . $person_value . '</strong></p></dd>';
                    endif;
                    break;

                case 'extras':
                    $resources = get_resource_data($meta['value'], 'resource');
                    $resources_title = $labels['resource'];
                    $resource_name = '';
                    $payable_resource = array();
                    foreach ($resources as $key => $value) {
                        $extras = explode('|', $value);
                        $payable_resource[$key]['resource_name'] = $extras[0];
                        $payable_resource[$key]['resource_cost'] = $extras[1];
                        $payable_resource[$key]['cost_multiply'] = $extras[2];
                        $payable_resource[$key]['resource_hourly_cost'] = $extras[3];
                    }
                    foreach ($payable_resource as $key => $value) {
                        if ($value['cost_multiply'] === 'per_day') {
                            $resource_name .= $value['resource_name'] . ' ( ' . wc_price($value['resource_cost']) . ' - ' . __('Per Day', 'redq-rental') . ' )' . ' , <br> ';
                        } else {
                            $resource_name .= $value['resource_name'] . ' ( ' . wc_price($value['resource_cost']) . ' - ' . __('One Time', 'redq-rental') . ' )' . ' , <br> ';
                        }
                    }
                    echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($resources_title) . ':</dt>';
                    echo '<dd><p><strong>' . $resource_name . '</strong></p></dd>';
                    break;

                case 'categories':
                    $categories = get_category_data($meta['value'], 'rnb_categories');
                    $categories_title = $labels['categories'];
                    $category_name = '';
                    $payable_category = array();
                    foreach ($categories as $key => $value) {
                        $category = explode('|', $value);
                        $payable_category[$key]['category_name'] = $category[0];
                        $payable_category[$key]['category_cost'] = $category[1];
                        $payable_category[$key]['cost_multiply'] = $category[2];
                        $payable_category[$key]['category_hourly_cost'] = $category[3];
                        $payable_category[$key]['category_qty'] = $category[4];
                    }
                    foreach ($payable_category as $key => $value) {
                        if ($value['cost_multiply'] === 'per_day') {
                            $category_name .= $value['category_name'] . ' ( ' . wc_price($value['category_cost']) . ' - ' . __('Per Day', 'redq-rental') . ' )' . ' * ' . $value['category_qty'] . ' , <br> ';
                        } else {
                            $category_name .= $value['category_name'] . ' ( ' . wc_price($value['category_cost']) . ' - ' . __('One Time', 'redq-rental') . ' )' . ' * ' . $value['category_qty'] . ' , <br> ';
                        }
                    }
                    echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($categories_title) . ':</dt>';
                    echo '<dd><p><strong>' . $category_name . '</strong></p></dd>';
                    break;

                case 'cat_quantity[]':
                    break;

                case 'security_deposites':
                    $deposits = get_deposit_data($meta['value'], 'deposite');
                    $deposits_title = $labels['deposite'];
                    $deposite_name = '';
                    $payable_deposits = array();
                    foreach ($deposits as $key => $value) {
                        $extras = explode('|', $value);
                        $payable_deposits[$key]['deposite_name'] = $extras[0];
                        $payable_deposits[$key]['deposite_cost'] = $extras[1];
                        $payable_deposits[$key]['cost_multiply'] = $extras[2];
                        $payable_deposits[$key]['deposite_hourly_cost'] = $extras[3];
                    }
                    foreach ($payable_deposits as $key => $value) {
                        if ($value['cost_multiply'] === 'per_day') {
                            $deposite_name .= $value['deposite_name'] . ' ( ' . wc_price($value['deposite_cost']) . ' - ' . __('Per Day', 'redq-rental') . ' )' . ' , <br> ';
                        } else {
                            $deposite_name .= $value['deposite_name'] . ' ( ' . wc_price($value['deposite_cost']) . ' - ' . __('One Time', 'redq-rental') . ' )' . ' , <br> ';
                        }
                    }
                    echo '<dt style="float: left;margin-right: 10px;">' . esc_attr($deposits_title) . ':</dt>';
                    echo '<dd><p><strong>' . $deposite_name . '</strong></p></dd>';
                    break;

                case 'inventory_quantity':
                    echo '<dt style="float: left;margin-right: 10px;">' . esc_html__('Quantity', 'redq-rental') . ':</dt>';
                    echo '<dd><p><strong>' . $meta['value'] . '</strong></p></dd>';
                    break;

                case 'quote_price':
                    echo '<dt style="float: left;margin-right: 10px;">' . esc_html__('Quote Price', 'redq-rental') . ':</dt>';
                    echo '<dd><p><strong>' . wc_price($meta['value']) . '</strong></p></dd>';
                    break;

                default:
                    echo '<dt style="float: left;margin-right: 10px;">' . $meta['name'] . ':</dt>';
                    echo '<dd><p><strong>' . $meta['value'] . '</strong></p></dd>';
                    break;
            }
        }

        if (isset($meta['forms'])) {
            $contacts = $meta['forms'];
        }
    }
    ?>

    <h2><?php esc_html_e('Customer information', 'redq-rental'); ?></h2>
    <?php
    if ($contacts) {
        foreach ($contacts as $key => $value) {
            if ($key !== 'quote_message') :
                // Remove quote from the string
                $key_substr = substr($key, 6);
                // Convert string to the Camel Case
                $key_to_str = ucwords(str_replace('_', ' ', $key_substr));

                echo '<p><strong>' . __($key_to_str, 'redq-rental') . ' : </strong>' . $value . '</p>';
            endif;
        }
    }
    ?>
</div>