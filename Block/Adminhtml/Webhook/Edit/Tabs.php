<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit;

/**
 * Class Tabs
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        $this->setId("webhook_edit_tabs");
        $this->setDestElementId("edit_form");
        $this->setTitle(__("webhook details"));

        parent::_construct();
    }

    /**
     * @return \Magento\Backend\Block\Widget\Tabs
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeToHtml()
    {
        $this->addTab("general", [
            "label" => __("General"),
            "title" => __("General"),
            "content" => $this->getLayout()->createBlock("CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab\General")->toHtml(),
            "active" => true
        ]);

        $this->addTab("mapping", [
            "label" => __("Field Mapping"),
            "title" => __("Field Mapping"),
            "content" => $this->getLayout()->createBlock("CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab\Mapping")->toHtml(),
            "active" => false
        ]);

        if($this->getRequest()->getParam("id")) {
            $this->addTab("log", [
                "label" => __("Log Manager"),
                "title" => __("Log Manager"),
                "content" => $this->getLayout()->createBlock("CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab\Log")->toHtml(),
                "active" => false
            ]);
        }

        return parent::_beforeToHtml();
    }
}
