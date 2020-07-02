<?php

namespace CrmPerks\Webhook\Model\ResourceModel\Logs;

/**
 * Class Collection
 * @package CrmPerks\Webhook\Model\ResourceModel\Logs
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = "id";

    public function _construct()
    {
        $this->_init("CrmPerks\Webhook\Model\Log", "CrmPerks\Webhook\Model\ResourceModel\Log");
    }
}
