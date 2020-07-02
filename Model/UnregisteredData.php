<?php

namespace CrmPerks\Webhook\Model;

/**
 * Class UnregisteredData
 * @package CrmPerks\Webhook\Model
 */
class UnregisteredData extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init("CrmPerks\Webhook\Model\ResourceModel\UnregisteredData");
    }
}
