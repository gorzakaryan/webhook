<?php

namespace CrmPerks\Webhook\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

/**
 * Class Edit
 * @package CrmPerks\Webhook\Controller\Adminhtml\Index
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \CrmPerks\Webhook\Model\HookFactory
     */
    protected $hook;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \CrmPerks\Webhook\Model\HookFactory $hook
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \CrmPerks\Webhook\Model\HookFactory $hook
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->hook = $hook;
        
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam("id");
        $model = $this->hook->create();
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__("Webhook no longer exists."));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath("*/*/");
            }
            $this->_coreRegistry->register("webhook_model", $model);
        }
        $resultPage = $this->resultPageFactory->create();

        return $resultPage;
    }
}
