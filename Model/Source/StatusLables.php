<?php

namespace CrmPerks\Webhook\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class StatusLables
 * @package CrmPerks\Webhook\Model\Source
 */
class StatusLables  implements OptionSourceInterface
{
    /**
     * @var \CrmPerks\Webhook\Model\Hook
     */
    protected $hook;

    /**
     * StatusLables constructor.
     * @param \CrmPerks\Webhook\Model\Hook $hook
     */
    public function __construct(\CrmPerks\Webhook\Model\Hook $hook)
    {
        $this->hook = $hook;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->hook->getPublicLables();
        $options = [];

        foreach ($availableOptions as $key => $value) {
            $options[] = [
                "label" => $value,
                "value" => $key,
            ];
        }

        return $options;
    }
}
