<?php

namespace CrmPerks\Webhook\Controller\Adminhtml\Logs;

/**
 * Class Index
 * @package CrmPerks\Webhook\Controller\Adminhtml\Logs
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return  $this->resultFactory->create("page");
    }
}
