<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class AfterSaveOrder
 * @package CrmPerks\Webhook\Observer
 */
class AfterSaveOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "order/create";

    /**
     * AfterSaveOrder constructor.
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
