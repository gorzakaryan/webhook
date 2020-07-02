<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class BeforeDeleteCategory
 * @package CrmPerks\Webhook\Observer
 */
class AfterDeleteCategory implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "category/delete";

    /**
     * BeforeDeleteCategory constructor.
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
        $category = $event->getCategory();

        $this->helper->send($this->eventName, $category);
    }
}
