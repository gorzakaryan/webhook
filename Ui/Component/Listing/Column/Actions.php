<?php

namespace CrmPerks\Webhook\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class Actions
 * @package CrmPerks\Webhook\Ui\Component\Listing\Column
 */
class Actions extends Column
{
    const EDIT_URL = "crmperks_hook/index/edit";
    const DELETE_URL = "crmperks_hook/index/delete";

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Actions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                if ($item["id"]) {
                    $item[$name]["edit"] = [
                        "href" => $this->urlBuilder->getUrl(self::EDIT_URL, array("id" => $item["id"])),
                        "label" => "Edit"
                    ];
                    $item[$name]["delete"] = [
                        "href" => $this->urlBuilder->getUrl(self::DELETE_URL, array("id" => $item["id"])),
                        "label" => "Delete"
                    ];
                }
            }
        }

        return $dataSource;
    }
}
