<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook;

use Magento\Backend\Block\Template;

/**
 * Class Mapping
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook
 */
class Mapping extends Template
{
    /**
     * @var \Magento\Framework\App\DeploymentConfig\Reader
     */
    protected $_configReader;

    /**
     * @var \CrmPerks\Webhook\Model\MappingFactory
     */
    protected $mapping;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Mapping constructor.
     * @param Template\Context $context
     * @param \Magento\Framework\App\DeploymentConfig\Reader $configReader
     * @param \CrmPerks\Webhook\Model\MappingFactory $mapping
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\DeploymentConfig\Reader $configReader,
        \CrmPerks\Webhook\Model\MappingFactory $mapping,
        \Magento\Framework\Registry $registry
    ) {
        $this->_configReader = $configReader;
        $this->mapping = $mapping;
        $this->_coreRegistry = $registry;

        parent::__construct($context);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\RuntimeException
     */
    public function getAdminBaseUrl()
    {
        $config = $this->_configReader->load();
        $adminSuffix = $config["backend"]["frontName"];
        return $this->getBaseUrl() . $adminSuffix . "/";
    }

    /**
     * @return array|bool|mixed
     */
    public function getFields()
    {
        if ($webhookModel = $this->_coreRegistry->registry("webhook_model")) {
            $mappingFields = json_decode($webhookModel->getMappingFields(), true);
            if ($mappingFields) {
                $fieldNames = $mappingFields["names"];

                $fields = [];
                foreach ($mappingFields["valuesDynamic"] as $key => $value) {
                    $fields[$value] = $fieldNames[$key];
                }
                return $fields;
            }
            return false;
        }
        return $this->_coreRegistry->registry("mapping_fields");
    }

    /**
     * @return array|bool
     */
    public function getStaticValues()
    {
        if ($webhookModel = $this->_coreRegistry->registry("webhook_model")) {

            $mappingFields = json_decode($webhookModel->getMappingFields(), true);
            if ($mappingFields) {
                $staticFields = $mappingFields["valuesStatic"];
                $fields = [];
                foreach ($mappingFields["valuesDynamic"] as $key => $value) {
                    $fields[$value] = $staticFields[$key];
                }
                return $fields;
            }
            return false;
        }
        return false;
    }

    /**
     * @return array|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAttributes()
    {
        if ($webhookModel = $this->_coreRegistry->registry("webhook_model")) {
            $eventName = strtok($webhookModel->getEvent(), "/");
            $attributes = $this->mapping->create()->getOrRegisterAttributes($eventName);

            return $attributes;
        }

        return $this->_coreRegistry->registry("attributes");
    }
}
