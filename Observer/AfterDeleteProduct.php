<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class AfterDeleteProduct
 * @package CrmPerks\Webhook\Observer
 */
class AfterDeleteProduct implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "product/delete";

    /**
     * @param \CrmPerks\Webhook\Helper\Data $helper
     */
    public function __construct(
        \CrmPerks\Webhook\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();
        $product = $event->getProduct();

        $this->helper->send($this->eventName, $product);
    }
}
