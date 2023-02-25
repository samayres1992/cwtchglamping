<?php

namespace REDQ_RnB;

/**
 * Modify existing hook
 */
class Modify_Hook
{
    public function __construct()
    {
        add_filter('woocommerce_is_purchasable', [$this, 'is_rentable'], 10, 2);
        add_filter('woocommerce_get_price_html', [$this, 'product_price_html'], 10, 2);
    }

    /**
     * Make rental product rentable even price is 0
     *
     * @param boolean $purchasable
     * @param object $product
     * @return boolean
     */
    public function is_rentable($purchasable, $product)
    {
        $product_id = $product->get_id();
        $product_inventory = rnb_get_product_inventory_id($product_id);

        if (!is_rental_product($product_id)) {
            return $purchasable;
        }

        if (empty($product_inventory)) {
            return false;
        }

        return true;
    }

    /**
     * product_price_html
     *
     * @param mixed $price_html
     * @param mixed $product
     *
     * @return string
     */
    public function product_price_html($price_html, $product)
    {
        $product_id = $product->get_id();
        $product_type = wc_get_product($product_id)->get_type();

        if ($product_type !== 'redq_rental') {
            return $price_html;
        }

        $inventory = rnb_get_product_inventory_id($product_id);
        $result = rnb_get_product_price($product_id);

        $price_limit = $result['price_limit'];
        $price = $result['price'];
        $prefix = $result['prefix'];
        $suffix = $result['suffix'];

        $range = $price_limit['min'] !== $price_limit['max'] ? wc_price($price_limit['min']) . ' - ' . wc_price($price_limit['max']) : wc_price($price_limit['min']);

        if (count($inventory)) {
            $price_html = '<span class="amount rnb_price_unit_' . $product_id . '"> ' . $prefix . '&nbsp;' . $range . '&nbsp;' . $suffix . '</span>';
            update_post_meta($product_id, '_price', $price);
        } else {
            $price_html = sprintf(__('Unrentable! Inventory Not Found.', 'redq-rental'));
        }

        return $price_html . $product->get_price_suffix();
    }
}
