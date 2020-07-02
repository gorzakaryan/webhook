<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class AfterCancelOrder
 * @package CrmPerks\Webhook\Observer
 */
class AfterCancelOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "order/cancelled";

    /**
     * AfterCancelOrder constructor.
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
        $order = $event->getOrder();

        $this->helper->send($this->eventName, $order);
    }
}
