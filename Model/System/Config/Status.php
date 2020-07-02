<?php

namespace CrmPerks\Webhook\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Status
 * @package CrmPerks\Webhook\Model\System\Config
 */
class Status implements ArrayInterface
{
    const ENABLED  = 1;
    const DISABLED = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            self::ENABLED => __("Enabled"),
            self::DISABLED => __("Disabled")
        ];

        return $options;
    }
}
