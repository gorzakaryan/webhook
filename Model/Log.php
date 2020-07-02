<?php

namespace CrmPerks\Webhook\Model;

/**
 * Class Log
 * @package CrmPerks\Webhook\Model
 */
class Log extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init("CrmPerks\Webhook\Model\ResourceModel\Log");
    }

    /**
     * @return array
     */
    public function getPublicLables()
    {
        return [
            0 => __("Error"),
            1 => __("Success"),
        ];
    }
}
