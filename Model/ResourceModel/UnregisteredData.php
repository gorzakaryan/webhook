<?php

namespace CrmPerks\Webhook\Model\ResourceModel;

/**
 * Class UnregisteredData
 * @package CrmPerks\Webhook\Model\ResourceModel
 */
class UnregisteredData extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init("crmperks_unregistered_data", "id");
    }
}
