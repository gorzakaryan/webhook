<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class AfterSaveShipment
 * @package CrmPerks\Webhook\Observer
 */
class AfterSaveShipment implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "shipment/create";

    /**
     * AfterSaveShipment constructor.
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
        $shipment = $event->getShipment();

        $this->helper->send($this->eventName, $shipment);
    }
}
