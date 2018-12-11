<?php
namespace Timoffmax\Useless\Ui\Component\Listing\DataProviders\Timoffmax\Useless;

class Products extends \Magento\Ui\DataProvider\AbstractDataProvider
{    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Timoffmax\Useless\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
