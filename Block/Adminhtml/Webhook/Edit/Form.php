<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Form
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit
 */
class Form extends Generic
{
    /**
     * @return Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                "data" => [
                    "id" => "edit_form",
                    "action" => $this->getUrl("crmperks_hook/index/save"),
                    "enctype" => "multipart/form-data",
                    "method" => "post",
                ],
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
