<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab;

/**
 * Class Mapping
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab
 */
class Mapping extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var string
     */
    protected $name = "";

    /**
     * @var string
     */
    protected $status = "";

    /**
     * @var string
     */
    protected $event = "";

    /**
     * @var string
     */
    protected $service_address = "";

    /**
     * @var string
     */
    protected $format = "";

    /**
     * Mapping constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return $this|\Magento\Backend\Block\Widget\Form\Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            "mapping_fieldset",
            ["legend" => __("Mapping Management"), "class" => "fieldset-wide"]
        );
        $fieldset->addType(
            "mapping",
            "\CrmPerks\Webhook\Block\Adminhtml\Webhook\Renderer\RowMapping"
        );
        $fieldset->addField(
            "mapping",
            "mapping",
            [
                "name"  => "mapping",
            ]
        );

        $this->setForm($form);
        parent::_prepareForm();

        return $this;
    }
}
