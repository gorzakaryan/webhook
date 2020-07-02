<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab;

/**
 * Class Log
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook\Edit\Tab
 */
class Log extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \CrmPerks\Webhook\Model\ResourceModel\Logs\CollectionFactory
     */
    protected $logCollectionFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface|null
     */
    protected $_objectManager = null;

    /**
     * Log constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \CrmPerks\Webhook\Model\ResourceModel\Logs\CollectionFactory $logCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \CrmPerks\Webhook\Model\ResourceModel\Logs\CollectionFactory $logCollectionFactory,
        array $data = []
    ) {
        $this->logCollectionFactory = $logCollectionFactory;
        $this->_objectManager = $objectManager;

        parent::__construct($context, $backendHelper, $data);

        $this->setId("log_grid");
        $this->setDefaultSort("id");
        $this->setUseAjax(true);
    }

    /**
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        $id = $this->getRequest()->getParam("id");
        $logCollection = $this->logCollectionFactory->create()
            ->addFieldToFilter("webhook_id", $id);

        $this->setCollection($logCollection);
        return parent::_prepareCollection();
    }

    /**
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        $model = $this->_objectManager->get("\CrmPerks\Webhook\Model\Log");

        $this->addColumn(
            "log_id",
            [
                "header" => __("ID"),
                "index" => "log_id",
            ]
        );
        $this->addColumn(
            "log_status",
            [
                "header" => __("Status"),
                "index" => "log_status",
            ]
        );
        $this->addColumn(
            "message",
            [
                "header" => __("Message"),
                "index" => "message",
            ]
        );
        $this->addColumn(
            "created",
            [
                "header" => __("Created At"),
                "index" => "created",
            ]
        );

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl("*/logs/loggrid", ["_current" => true]);
    }
}
