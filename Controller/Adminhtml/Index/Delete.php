<?php

namespace CrmPerks\Webhook\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

/**
 * Class Delete
 * @package CrmPerks\Webhook\Controller\Adminhtml\Index
 */
class Delete extends Action
{
    /**
     * @var \CrmPerks\Webhook\Model\HookFactory
     */
    protected $hook;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param \CrmPerks\Webhook\Model\HookFactory $hook
     */
    public function __construct(
        Action\Context $context,
        \CrmPerks\Webhook\Model\HookFactory $hook
    ) {
        $this->hook = $hook;
        
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam("id");
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->hook->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__("Webhook has been deleted."));

                return $resultRedirect->setPath("*/*/");
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath("*/*/edit", ["page_id" => $id]);
            }
        }
        $this->messageManager->addError(__("We can\'t find a webhook to delete."));

        return $resultRedirect->setPath("*/*/");
    }
}
