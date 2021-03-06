<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class RegisterCustomer
 * @package CrmPerks\Webhook\Observer
 */
class RegisterCustomer implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "customer/create";

    /**
     * RegisterCustomer constructor.
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
        $customer = $event->getCustomer();

        $this->helper->send($this->eventName, $customer);
    }
}
