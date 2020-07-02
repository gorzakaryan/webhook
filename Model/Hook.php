<?php

namespace CrmPerks\Webhook\Model;

/**
 * Class Hook
 * @package CrmPerks\Webhook\Model
 */
class Hook extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init("CrmPerks\Webhook\Model\ResourceModel\Hook");
    }

    /**
     * @return array
     */
    public function getPublicLables()
    {
        return [
            0 => __("Disabled"),
            1 => __("Enabled"),
        ];
    }
}
