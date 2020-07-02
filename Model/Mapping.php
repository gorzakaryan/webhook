<?php

namespace CrmPerks\Webhook\Model;

use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;

/**
 * Class Mapping
 * @package CrmPerks\Webhook\Model
 */
class Mapping extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order
     */
    protected $orderResource;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Invoice
     */
    protected $invoiceResource;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Shipment
     */
    protected $shipmentResource;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer
     */
    protected $customerResource;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     */
    protected $catalogEavAttribute;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Address\CollectionFactory
     */
    protected $addressCollection;

    /**
     * Mapping constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Sales\Model\ResourceModel\Order $orderResource
     * @param \Magento\Sales\Model\ResourceModel\Order\Invoice $invoiceResource
     * @param \Magento\Sales\Model\ResourceModel\Order\Shipment $shipmentResource
     * @param \Magento\Customer\Model\ResourceModel\Customer $customerResource
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $catalogEavAttribute
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Sales\Model\ResourceModel\Order\Address\CollectionFactory $addressCollection
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Model\ResourceModel\Order $orderResource,
        \Magento\Sales\Model\ResourceModel\Order\Invoice $invoiceResource,
        \Magento\Sales\Model\ResourceModel\Order\Shipment $shipmentResource,
        \Magento\Customer\Model\ResourceModel\Customer $customerResource,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $catalogEavAttribute,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Sales\Model\ResourceModel\Order\Address\CollectionFactory $addressCollection,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->orderResource = $orderResource;
        $this->invoiceResource = $invoiceResource;
        $this->shipmentResource = $shipmentResource;
        $this->customerResource = $customerResource;
        $this->catalogEavAttribute = $catalogEavAttribute;
        $this->categoryFactory = $categoryFactory;
        $this->orderRepository = $orderRepository;
        $this->addressCollection = $addressCollection;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @param $event
     */
    public function registerFields($event)
    {
        $fields = [];
        switch($event) {
            case "product" :
                $fields = [
                    "entity_id" => "ID",
                    "name" => "Name",
                    "description" => "Description",
                    "short_description" => "Short Description",
                    "sku" => "SKU",
                    "weight" => "Weight",
                    "news_from_date" => "Set Product as New from Date",
                    "news_to_date" => "Set Product as New to Date",
                    "status" => "Status",
                    "country_of_manufacture" => "Country of Manufacture",
                    "url_key" => "URL Key",
                    "price" => "Price",
                    "special_price" => "Special Price",
                    "special_from_date" => "Special From Date",
                    "special_to_date" => "Special To Date",
                    "qty" => "Quantity",
                    "meta_title" => "Meta Title",
                    "meta_keyword" => "Meta Keywords",
                    "meta_description" => "Meta Description",
                    "tax_class_id" => "Tax Class",
                    "image" => "Base Image",
                    "small_image" => "Small Image",
                    "thumbnail" => "Thumbnail",
                ];
                break;
            case "category" :
                $fields = [
                    "entity_id" => "ID",
                    "name" => "Name",
                    "is_active" => "Is Active",
                    "description" => "Description",
                    "image" => "Image",
                    "meta_title" => "Page Title",
                    "meta_keywords" => "Meta Keywords",
                    "meta_description" => "Meta Description",
                    "path" => "Path",
                ];
                break;
            case "customer" :
                $fields = [
                    "entity_id" => "ID",
                    "email" => "Email",
                    "created_at" => "Created At",
                    "updated_at" => "Updated At",
                    "firstname" => "First name",
                    "middlename" => "Middle Name/Initial",
                    "lastname" => "Last name",
                    "taxvat" => "Tax/VAT Number",
                    "gender" => "Gender",
                    "dob" => "Date of Birth",
                    "default_billing" => "Default Billing Address",
                    "default_shipping" => "Default Shipping Address",
                ];
                break;
            case "order" :
                $fields = [
                    "entity_id" => "ID",
                    "state" => "State",
                    "status" => "Status",
                    "coupon_code" => "Coupon Code",
                    "coupon_rule_name" => "Coupon Rule Name",
                    "increment_id" => "Increment ID",
                    "created_at" => "Created At",
                    "customer_firstname" => "Customer First Name",
                    "customer_lastname" => "Customer Last Name",
                    "order_currency_code" => "Currency Code",
                    "total_item_count" => "Total Item Count",
                    "store_currency_code" => "Store Currency Code",
                    "shipping_discount_amount" => "Shipping Discount Amount",
                    "discount_description" => "Discount Description",
                    "shipping_method" => "Shipping Method",
                    "store_name" => "Store Name",
                    "discount_amount" => "Discount Amount",
                    "tax_amount" => "Tax Amount",
                    "subtotal" => "Sub Total",
                    "grand_total" => "Grand Total",
                ];

                $fields = array_merge($fields, $this->getBillindAndShippingFields());
                break;
            case "invoice" :
                $fields = [
                    "entity_id" => "ID",
                    "increment_id" => "Increment ID",
                    "order_id" => "Order ID",
                    "shipping_amount" => "Shipping Amount",
                    "order_currency_code" => "Currency Code",
                    "total_qty" => "Total Qty",
                    "store_currency_code" => "Store Currency Code",
                    "discount_description" => "Discount Description",
                    "shipping_incl_tax" => "Shipping Tax",
                    "discount_amount" => "Discount Amount",
                    "tax_amount" => "Tax Amount",
                    "subtotal" => "Sub Total",
                    "grand_total" => "Grand Total",
                ];

                $fields = array_merge($fields, $this->getBillindAndShippingFields());
                break;
            case "shipment" :
                $fields = [
                    "entity_id" => "Entity Id",
                    "store_id" => "Store Id",
                    "total_weight" => "Total Weight",
                    "total_qty" => "Total Qty",
                    "email_sent" => "Email Sent",
                    "send_email" => "Send Email	",
                    "order_id" => "Order Id",
                    "customer_id" => "Customer Id",
                    "shipment_status" => "Shipment Status",
                    "increment_id" => "Increment Id",
                    "created_at" => "Created At",
                    "updated_at" => "Updated At",
                    "packages" => "Packed Products in Packages",
                    "shipping_label" => "Shipping Label Content",
                ];

                $fields = array_merge($fields, $this->getBillindAndShippingFields());
                break;
            default:
                break;
        }

        $this->_registry->register("mapping_fields", $fields);
    }

    /**
     * @param $event
     * @param bool $is_new
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOrRegisterAttributes($event, $is_new = false)
    {
        $attributes = [];
        switch ($event) {
            case "order":
                $columsCollection = $this->orderResource->getConnection()
                    ->describeTable($this->orderResource->getMainTable());

                $attributes = $this->setBillingAndShippingInfo(
                    $this->getAttributesFromDB($columsCollection)
                );
                break;
            case "invoice":
                $collectionData = $this->invoiceResource->getConnection()
                    ->describeTable($this->invoiceResource->getMainTable());

                $attributes = $this->setBillingAndShippingInfo(
                    $this->getAttributesFromDB($collectionData)
                );
                break;
            case "shipment":
                $collectionData = $this->shipmentResource->getConnection()
                    ->describeTable($this->shipmentResource->getMainTable());

                $attributes = $this->setBillingAndShippingInfo(
                    $this->getAttributesFromDB($collectionData)
                );
                break;
            case "customer":
                $collection = $this->customerResource->loadAllAttributes()->getSortedAttributes();
                $attributes = $this->getEavAttributes($collection);
                $attributes[] = [
                    "name"  => "entity_id",
                    "title" => "ID"
                ];
                break;
            case "product":
                $collection = $this->catalogEavAttribute->getCollection()
                    ->addFieldToFilter(AttributeSet::KEY_ENTITY_TYPE_ID, 4);
                $attributes = $this->getEavAttributes($collection);
                $attributes[] = [
                    "name"  => "entity_id",
                    "title" => "ID"
                ];
                break;
            case "category":
                $collection = $this->categoryFactory->create()->getAttributes();
                $attributes = $this->getEavAttributes($collection);
                $attributes[] = [
                    "name"  => "entity_id",
                    "title" => "ID"
                ];
                break;
        }

        if ($is_new) {
            $this->_registry->register("attributes", $attributes);
        } else {
            return $attributes;
        }
    }

    /**
     * @param $columsCollection
     * @return array
     */
    protected function getAttributesFromDB($columsCollection)
    {
        $attrCollection = [];
        foreach ($columsCollection as $item) {
            $attrCollection[] = [
                "name"  => $item["COLUMN_NAME"],
                "title" => ucwords(str_replace("_", " ", $item["COLUMN_NAME"]))
            ];
        }

        return $attrCollection;
    }

    /**
     * @param $collection
     * @return array
     */
    protected function getEavAttributes($collection)
    {
        $attrCollection = [];
        foreach ($collection as $item) {
            $attrCollection[] = [
                "name"  => $item->getAttributeCode(),
                "title" => $item->getDefaultFrontendLabel()
            ];
        }

        return $attrCollection;
    }

    /**
     * @return array
     */
    public function getBillindAndShippingFields()
    {
        return [
            "bill_firstname" => "Billing First Name",
            "bill_middlename" => "Billing Middle Name",
            "bill_lastname" => "Billing Last Name",
            "bill_company" => "Billing Company",
            "bill_street" => "Billing Street",
            "bill_city" => "Billing City",
            "bill_region" => "Billing State/Province",
            "bill_postcode" => "Billing Zip/Postal Code",
            "bill_telephone" => "Billing Telephone",
            "bill_country_id" => "Billing Country",
            "ship_firstname" => "Shipping First Name",
            "ship_middlename" => "Shipping Middle Name",
            "ship_lastname" => "Shipping Last Name",
            "ship_company" => "Shipping Company",
            "ship_street" => "Shipping Street",
            "ship_city" => "Shipping City",
            "ship_region" => "Shipping State/Province",
            "ship_postcode" => "Shipping Zip/Postal Code",
            "ship_country_id" => "Shipping Country",
        ];
    }

    /**
     * @param $attributes
     * @return array
     */
    public function setBillingAndShippingInfo($attributes)
    {
        foreach ($this->getBillindAndShippingFields() as $key => $value) {
            $attributes[] = [
                "name"  => $key,
                "title" => $value
            ];
        }

        return $attributes;
    }
}
