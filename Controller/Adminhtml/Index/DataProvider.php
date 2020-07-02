<?php

namespace CrmPerks\Webhook\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;

/**
 * Class DataProvider
 * @package CrmPerks\Webhook\Controller\Adminhtml\Index
 */
class DataProvider extends Action
{
    /**
     * @var string
     */
    protected $eventName;

    /**
     * @var \CrmPerks\Webhook\Model\MappingFactory
     */
    protected $mapping;

    /**
     * @var JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * @var Attribute
     */
    protected $_attributeFactory;

    /**
     * DataProvider constructor.
     * @param Action\Context $context
     * @param \CrmPerks\Webhook\Model\MappingFactory $mapping
     * @param JsonFactory $resultJsonFactory
     * @param Attribute $attributeFactory
     */
    public function __construct(
        Action\Context $context,
        \CrmPerks\Webhook\Model\MappingFactory $mapping,
        JsonFactory $resultJsonFactory,
        Attribute $attributeFactory
    ) {
        $this->mapping = $mapping;
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_attributeFactory = $attributeFactory;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->_resultJsonFactory->create();

        if ($this->getRequest()->isAjax()) {
            try {
                $this->eventName = strtok($this->getRequest()->getParam("event"), "/");

                $mappingModel = $this->mapping->create();
                $mappingModel->registerFields($this->eventName);
                $mappingModel->getOrRegisterAttributes($this->eventName, true);

                $output = $this->_view->getLayout()
                    ->createBlock("CrmPerks\Webhook\Block\Adminhtml\Webhook\Mapping")
                    ->setTemplate("CrmPerks_Webhook::mapping.phtml")
                    ->toHtml();

                $result->setData([
                        "success" => true,
                        "html" => [
                            "mapping_fields" => $output,
                            "attributes" => $mappingModel->getOrRegisterAttributes($this->eventName)
                        ]
                    ]
                );
            } catch (\Exception $e) {

            }

            return $result;
        }
    }
}
