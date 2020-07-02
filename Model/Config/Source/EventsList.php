<?php

namespace CrmPerks\Webhook\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class EventsList
 * @package CrmPerks\Webhook\Model\Config\Source
 */
class EventsList implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ["value" => "0", "label" => "--Please choose an option--"],
            ["value" => "product/create", "label" => "New Product"],
            ["value" => "product/update", "label" => "Update Product"],
            ["value" => "product/delete", "label" => "Delete Product"],
            ["value" => "customer/login", "label" => "Login Customer"],
            ["value" => "customer/create", "label" => "New Customer"],
            ["value" => "customer/update", "label" => "Update Customer"],
            ["value" => "customer/delete", "label" => "Delete Customer"],
            ["value" => "order/create", "label" => "New Order"],
            ["value" => "order/cancelled", "label" => "Cancelled Order"],
            ["value" => "shipment/create", "label" => "New Shipment"],
            ["value" => "invoice/create", "label" => "New Invoice"],
            ["value" => "category/create", "label" => "New Category"],
            ["value" => "category/update", "label" => "Update Category"],
            ["value" => "category/delete", "label" => "Delete Category"],
            ["value" => "cart/update", "label" => "Update Cart"],
        ];
    }
}
