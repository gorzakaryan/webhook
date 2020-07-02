<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class AfterSaveCart
 * @package CrmPerks\Webhook\Observer
 */
class AfterSaveCart implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "cart/update";

    /**
     * AfterSaveCart constructor.
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
        $cart = $observer->getEvent()->getCart();
        $quoteData = $cart->getQuote()->getItemsCollection()->getData();

        $this->helper->send($this->eventName, $quoteData);
    }
}
