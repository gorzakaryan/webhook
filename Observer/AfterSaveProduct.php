<?php

namespace CrmPerks\Webhook\Observer;

use CrmPerks\Webhook\Helper\Data;
use CrmPerks\Webhook\Model\HookFactory;
use CrmPerks\Webhook\Model\WebhookFactory;
use Magento\Framework\HTTP\Client\Curl;

/**
 * Class AfterSaveProduct
 * @package CrmPerks\Webhook\Observer
 */
class AfterSaveProduct implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "product/create";

    /**
     * AfterSaveProduct constructor.
     * @param Data $helper
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

        if (!$product->isObjectNew()) {
            $this->eventName = "product/update";
        }

        $this->helper->send($this->eventName, $product);
    }
}
