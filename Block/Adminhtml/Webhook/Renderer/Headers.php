<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook\Renderer;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Headers
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook\Renderer
 */
class Headers extends AbstractFieldArray
{
    /**
     * @var string
     */
    protected $_template = "CrmPerks_Webhook::headers.phtml";

    /**
     * @var \CrmPerks\Webhook\Model\HookFactory
     */
    protected $hookFactory;

    /**
     * Headers constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \CrmPerks\Webhook\Model\HookFactory $hookFactory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \CrmPerks\Webhook\Model\HookFactory $hookFactory
    ) {
        $this->hookFactory = $hookFactory;

        parent::__construct($context);
    }

    public function _construct()
    {
        $this->addColumn("name", ["label" => __("Name")]);
        $this->addColumn("value", ["label" => __("Value")]);
        $this->_addAfter = false;

        parent::_construct();
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getAddButtonLabel()
    {
        return __("Add");
    }

    /**
     * @return array|mixed
     */
    public function getHeadersFields()
    {
        $id = $this->getRequest()->getParam("id");
        if ($id) {
            $hookCollection = $this->hookFactory->create()->load($id);

            return json_decode($hookCollection->getData("headers"), true);
        }

        return [];
    }
}
