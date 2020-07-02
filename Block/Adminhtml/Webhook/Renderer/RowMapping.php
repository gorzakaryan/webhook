<?php

namespace CrmPerks\Webhook\Block\Adminhtml\Webhook\Renderer;

use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Escaper;
use CrmPerks\Webhook\Block\Adminhtml\Webhook\Mapping;

/**
 * Class RowMapping
 * @package CrmPerks\Webhook\Block\Adminhtml\Webhook\Renderer
 */
class RowMapping extends \Magento\Framework\Data\Form\Element\AbstractElement
{
    /**
     * @var Mapping
     */
    protected $_mappingBlock;

    /**
     * RowMapping constructor.
     * @param Mapping $mappingBlock
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param array $data
     */
    public function __construct(
        Mapping $mappingBlock,
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        $data = []
    ) {
        $this->_mappingBlock = $mappingBlock;

        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
    }

    /**
     * @return string
     */
    public function getElementHtml()
    {
        return $this->_mappingBlock->setTemplate("mapping.phtml")
            ->unsetData()
            ->toHtml();
    }
}
