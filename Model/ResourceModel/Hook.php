<?php

namespace CrmPerks\Webhook\Model\ResourceModel;

/**
 * Class Hook
 * @package CrmPerks\Webhook\Model\ResourceModel
 */
class Hook extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init("crmperks_hooks", "id");
    }
}
