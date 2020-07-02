<?php
namespace CrmPerks\Webhook\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $productCollectionFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        return parent::__construct($context);
    }

    public function getProductCollectionByCategories($ids)
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $ids]);

        return $collection;
    }

    public function execute()
    {
        $ids = [3,6];
        $categoryProducts = $this->getProductCollectionByCategories($ids);
        foreach ($categoryProducts as $product) {
            $categories = $product->getCategoryIds();
            if (!in_array('4', $categories)) {
                $categories[] = '4';
                $product->setCategoryIds($categories);
                try {
                    $product->save();
                } catch (\Magento\Framework\Exception\AlreadyExistsException $alreadyExistsException) {
                    if($alreadyExistsException->getMessage() == 'URL key for specified store already exists.'){
                        continue;
                    }
                }

            }
        }
    }
}
