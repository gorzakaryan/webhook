<?php

namespace CrmPerks\Webhook\Model\ResourceModel\Hook;

/**
 * Class Collection
 * @package CrmPerks\Webhook\Model\ResourceModel\Hook
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = "id";

    public  function _construct()
    {
        $this->_init("CrmPerks\Webhook\Model\Hook", "CrmPerks\Webhook\Model\ResourceModel\Hook");
    }
}
