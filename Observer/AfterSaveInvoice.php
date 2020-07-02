<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class AfterSaveInvoice
 * @package CrmPerks\Webhook\Observer
 */
class AfterSaveInvoice implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "invoice/create";

    /**
     * AfterSaveInvoice constructor.
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
        $invoice = $event->getInvoice();

        $this->helper->send($this->eventName, $invoice);
    }
}
