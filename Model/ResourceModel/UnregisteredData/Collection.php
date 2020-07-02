<?php

namespace CrmPerks\Webhook\Model\ResourceModel\UnregisteredData;

/**
 * Class Collection
 * @package CrmPerks\Webhook\Model\ResourceModel\UnregisteredData
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public  function _construct()
    {
        $this->_init("\CrmPerks\Webhook\Model\UnregisteredData", "\CrmPerks\Webhook\Model\ResourceModel\UnregisteredData");
    }
}
