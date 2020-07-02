<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook;

/**
 * Class Edit
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected function _construct()
    {
        $id = $this->getRequest()->getParam("id");
        $this->pageConfig->getTitle()->set(__("Webhook Details"));
        $this->_blockGroup = "CrmPerks_Webhook";
        $this->_controller = "adminhtml_webhook";

        parent::_construct();

        $this->buttonList->add(
            "save_and_continue",
            [
                "label" => __("Save and Continue Edit"),
                "class" => "save",
                "data_attribute" => [
                    "mage-init" => [
                        "button" => ["event" => "saveAndContinueEdit", "target" => "#edit_form"],
                    ],
                ]
            ],
            10
        );
        $this->buttonList->remove("reset");
    }
}
