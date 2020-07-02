<?php

namespace CrmPerks\Webhook\Observer;

/**
 * Class AfterSaveCategory
 * @package CrmPerks\Webhook\Observer
 */
class AfterSaveCategory implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \CrmPerks\Webhook\Helper\Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $eventName = "category/create";

    /**
     * AfterSaveCategory constructor.
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

        if (!$category->isObjectNew()) {
            $this->eventName = "category/update";
        }

        $this->helper->send($this->eventName, $category);
    }
}
