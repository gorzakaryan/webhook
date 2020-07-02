<?php

namespace CrmPerks\Webhook\Model\ResourceModel;

/**
 * Class Log
 * @package CrmPerks\Webhook\Model\ResourceModel
 */
class Log extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init("crmperks_logs", "id");
    }
}
