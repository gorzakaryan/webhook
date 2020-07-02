<?php

namespace CrmPerks\Webhook\Helper;

use Magento\Framework\App\Helper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magento\Framework\HTTP\Client\Curl;
use CrmPerks\Webhook\Model\HookFactory;
use CrmPerks\Webhook\Model\LogFactory;
use CrmPerks\Webhook\Model\UnregisteredDataFactory;

/**
 * Class Data
 * @package CrmPerks\Webhook\Helper
 */
class Data extends Helper\AbstractHelper
{
    /**
     * @var CurlFactory
     */
    protected $curlFactory;

    /**
     * @var HookFactory
     */
    protected $hookFactory;

    /**
     * @var LogFactory
     */
    protected $logFactory;

    /**
     * @var UnregisteredDataFactory
     */
    protected $unregisteredDataFactory;

    /**
     * @var Curl
     */
    protected $curl;

    /**
     * Data constructor.
     * @param Context $context
     * @param CurlFactory $curlFactory
     * @param Curl $curl
     * @param HookFactory $hookFactory
     * @param LogFactory $logFactory
     * @param UnregisteredDataFactory $unregisteredDataFactory
     */
    public function __construct(
        Context $context,
        CurlFactory $curlFactory,
        Curl $curl,
        HookFactory $hookFactory,
        LogFactory $logFactory,
        UnregisteredDataFactory $unregisteredDataFactory
    ) {
        $this->curlFactory = $curlFactory;
        $this->hookFactory = $hookFactory;
        $this->logFactory = $logFactory;
        $this->unregisteredDataFactory = $unregisteredDataFactory;
        $this->curl = $curl;

        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function isModuleEnable()
    {
        return $this->scopeConfig->getValue("crmperks_hook/general/enable",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param $event
     * @param $item
     */
    public function send($event, $item)
    {
        if (!$this->isModuleEnable()) {
            return;
        }

        $hookCollection = $this->hookFactory->create()->getCollection()
            ->addFieldToFilter("event", $event)
            ->addFieldToFilter("status", 1)
            ->setOrder("priority", "ASC");

        foreach ($hookCollection as $hook) {
            try {
                $this->sendRequest($hook, $item);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }
    }

    /**
     * @param $hook
     * @param $item
     * @return mixed
     * @throws \Exception
     */
    public function sendRequest($hook, $item)
    {
        $mapping = json_decode($hook->getMappingFields(), true);
        $requestData = [];
        if ($mapping) {
            $requestData = $this->mappingData($item, $mapping["valuesDynamic"]);
            $requestData = $this->issetStaticValue($requestData, $mapping["valuesStatic"]);
        } else {
            $requestData = $item;
        }

        $serviceUrl = $hook->getServiceAddress();
        $format = $hook->getFormat();
        $headers = $hook->getHeaders();

        if ($headers && !is_array($headers)) {
            $headers = json_decode($headers, true);
        }

        $headersConfig = [];
        foreach ($headers as $key => $value) {
            $headersConfig[] = trim($key) . ": " . trim($value);
        }
        if ($format) {
            $headersConfig[] = "Content-Type: " . $format;
        }

//        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
//        $this->curl->setOption(CURLOPT_POST, true);

        $result["success"] = false;
        $result["message"] = "Done";

        try {
            $collection = $this->unregisteredDataFactory->create()->getCollection()->getData();
            foreach ($collection as $key => $value) {
                try {
                    if (isset($value["service_url"]) && $value["service_url"] == $serviceUrl) {
                        $result["message"] = "unregistered";
                        $this->curl->post($serviceUrl, $value["hook_data"]);
                    }
                } catch (\Exception $e) {
                    $result["message"] = $e->getMessage();
                }

                if ($result["message"] == "unregistered") {
                    $hookData = $this->unregisteredDataFactory->create()->load($value["id"]);
                    $hookData->delete();
                    $result["message"] = "Done";
                }
            }

            if ($format == "application/xml") {
                $requestData = $this->arrayToXml($requestData, false);
            }

            $this->curl->setHeaders($headersConfig);
            $this->curl->post($serviceUrl, $requestData);

            if (in_array($this->curl->getStatus(), [200, 201])) {
                $result["success"] = true;
            } else {
                $result["message"] = __("Cannot connect to server. Please try again later.");
            }
        } catch (\Exception $e) {
            $result["message"] = $e->getMessage();
        }

        $status = "success";
        if (!$result["success"]) {
            $this->saveUnregisteredData($hook, $requestData, $headersConfig);
            $status = "error";
        }
        $this->addLog($hook, $status, $result["message"]);

        return $result;
    }

    /**
     * @param $hook
     * @param $status
     * @param $message
     * @throws \Exception
     */
    public function addLog($hook, $status, $message)
    {
        $hookModel = $this->logFactory->create();
        $hookModel->setHookName($hook->getName());
        $hookModel->setEvent($hook->getEvent());
        $hookModel->setLogStatus($status);
        $hookModel->setServiceAddress($hook->getServiceAddress());
        $hookModel->setMessage($message);
        $hookModel->setWebhookId($hook->getId());
        $hookModel->save();
    }

    /**
     * @param $hook
     * @param $requestData
     * @param $headersConfig
     * @throws \Exception
     */
    public function saveUnregisteredData($hook, $requestData, $headersConfig)
    {
        $hookData["requestData"] = $requestData;
        $hookData["headersConfig"] = $headersConfig;
        $unregisteredData = $this->unregisteredDataFactory->create();
        $unregisteredData->setWebhookId($hook->getId());
        $unregisteredData->setServiceUrl($hook->getServiceAddress());
        $unregisteredData->setHookData(json_encode($hookData));
        $unregisteredData->save();
    }

    /**
     * @param $item
     * @param $valuesDynamic
     * @return mixed
     */
    public function mappingData($item, $valuesDynamic)
    {
        foreach ($valuesDynamic as $mapItems) {
            if (strpos($mapItems, "bill_") !== false) {
                $requestData[$mapItems] = $item->getBillingAddress()->getData(str_replace("bill_", "", $mapItems));
                continue;
            }

            if (strpos($mapItems, "ship_") !== false) {
                $requestData[$mapItems] = $item->getBillingAddress()->getData(str_replace("ship_", "", $mapItems));
                continue;
            }
            if ($item->getData($mapItems)) {
                $requestData[$mapItems] = $item->getData($mapItems);
            } else {
                $requestData[$mapItems] = '';
            }
        }

        return $requestData;
    }

    /**
     * @param $requestData
     * @param $staticValue
     * @return array|bool
     */
    public function issetStaticValue($requestData, $staticValue)
    {
        if (count($requestData) !== count($staticValue))
            return false;

        $arrResult = [];
        $i = 0;
        foreach ($requestData as $key => $value) {
            if ($staticValue[$i] != "") {
                $arrResult[$staticValue[$i]] = $value;
            } else {
                $arrResult[$key] = $value;
            }
            $i++;
        }

        return $arrResult;
    }

    /**
     * @param $requestData
     * @param bool $xml
     * @return mixed
     */
    function arrayToXml($requestData, $xml = false)
    {
        if ($xml === false) {
            $xml = new \SimpleXMLElement("<result/>");
        }

        foreach ($requestData as $key => $value) {
            if (is_array($value)) {
                $this->arrayToXml($value, $xml->addChild($key));
            } else {
                $xml->addChild($key, $value);
            }
        }

        return $xml->asXML();
    }
}
