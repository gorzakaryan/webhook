<?php

namespace CrmPerks\Webhook\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * @package CrmPerks\Webhook\Controller\Adminhtml\Index
 */
class Save extends Action
{
    /**
     * @var \CrmPerks\Webhook\Model\HookFactory
     */
    protected $hook;

    /**
     * Save constructor.
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
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (isset($data["headers"])) {
            $arrayValuesName = [];
            $arrayValuesValue = [];
            foreach ($data["headers"] as $key => $value) {
                if ($key == "valuesName") {
                    foreach ($data["headers"][$key] as $k => $v) {
                        $arrayValuesName[] = $v;
                    }
                } else {
                    foreach ($data["headers"][$key] as $k => $v) {
                        $arrayValuesValue[] = $v;
                    }
                }
            }
            $arrHeaders = array_combine($arrayValuesName, $arrayValuesValue);
        } else {
            $arrHeaders = [];
        }

        if ($data) {
            $model = $this->hook->create();
            if (isset($data["id"])) {
                $model = $model->load($data["id"]);
            }
            $model->setData($data);
            if (isset($data["mapping"])) {
                $model->setMappingFields(json_encode($data["mapping"]));
            }
            $arrHeaders = json_encode($arrHeaders);
            $model->setHeaders($arrHeaders);

            try {
                $model->save();
                $this->messageManager->addSuccess(__("You saved the Webhook."));
                if ($this->getRequest()->getParam("back")) {
                    return $resultRedirect->setPath("*/*/edit", ["id" => $model->getId()]);
                }
                return $resultRedirect->setPath("*/*/");
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __("Something went wrong while saving the webhook."));
            }

            return $resultRedirect->setPath("*/*/edit", ["id" => $this->getRequest()->getParam("id")]);
        }

        return $resultRedirect->setPath("*/*/");
    }
}
