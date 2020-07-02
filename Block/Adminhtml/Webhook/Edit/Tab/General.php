<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab;

/**
 * Class General
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab
 */
class General extends \Magento\Backend\Block\Widget\Form\Generic
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
     * @var \CrmPerks\Webhooks\Model\Config\Source\EventsList
     */
    protected $eventsList;

    /**
     * @var bool
     */
    protected $disable_event_choosing = false;

    /**
     * @var string
     */
    protected $priority = "";

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $systemStore;

    /**
     * General constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \CrmPerks\Webhook\Model\Config\Source\EventsList $eventsList
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \CrmPerks\Webhook\Model\Config\Source\EventsList $eventsList,
        array $data = []
    ) {
        $this->systemStore   = $systemStore;
        $this->eventsList = $eventsList;
        
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
            "base_fieldset",
            ["legend" => __("General"), "class" => "fieldset-wide"]
        );

        if ($webhookModel = $this->_coreRegistry->registry("webhook_model")) {
            $this->name = $webhookModel->getName();
            $this->status = $webhookModel->getStatus();
            $this->event = $webhookModel->getEvent();
            $this->service_address = $webhookModel->getServiceAddress();
            $this->format = $webhookModel->getFormat();
            $this->disable_event_choosing = true;
            $this->priority = $webhookModel->getPriority();

            $fieldset->addField(
                "id",
                "hidden",
                [
                    "name" => "id",
                    "required" => true,
                    "value" => $webhookModel->getId()
                ]
            );
        }

        $fieldset->addField(
            "status",
            "select",
            [
                "name" => "status",
                "label" => __("Status"),
                "title" => __("Status"),
                "value" => $this->status,
                "values" => ["0" => __("Disabled"), "1" =>__("Enabled")],
                "required" => true
            ]
        );
        $fieldset->addField(
            "name",
            "text",
            [
                "name" => "name",
                "label" => __("Name"),
                "title" => __("Name"),
                "value" => $this->name,
                "required" => true
            ]
        );
        $fieldset->addField(
            "event",
            "select",
            [
                "name" => "event",
                "label" => __("Choose Event"),
                "title" => __("Choose Event"),
                "value" => $this->event,
                "values" => $this->eventsList->toOptionArray(),
                "required" => true,
                "disabled" => $this->disable_event_choosing
            ]
        );
        $fieldset->addField(
            "format",
            "select",
            [
                "name" => "format",
                "label" => __("Format"),
                "title" => __("Format"),
                "value" => $this->format,
                "values" => ["application/json" => __("Application/JSON"), "application/xml" =>__("Application/XML")],
                "required" => true
            ]
        );
        $fieldset->addField(
            "service_address",
            "text",
            [
                "name" => "service_address",
                "label" => __("Service Address"),
                "title" => __("Service Address"),
                "value" => $this->service_address,
                "required" => true
            ]
        );
        $fieldset->addField("priority", "text", [
            "name"  => "priority",
            "label" => __("Priority"),
            "title" => __("Priority"),
            "value" => $this->priority,
            "note"  => __("0 is highest")
        ]);
        $rendererBlock = $this->getLayout()
            ->createBlock("CrmPerks\Webhook\Block\Adminhtml\Webhook\Renderer\Headers");
        $fieldset->addField("headers", "text", [
            "name"  => "headers",
            "label" => __("Header"),
            "title" => __("Header"),
        ])->setRenderer($rendererBlock);

        $this->setForm($form);
        parent::_prepareForm();
        
        return $this;
    }
}
