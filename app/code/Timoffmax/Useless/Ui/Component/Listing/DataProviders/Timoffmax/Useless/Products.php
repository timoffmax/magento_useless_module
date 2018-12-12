<?php

namespace Timoffmax\Useless\Ui\Component\Listing\DataProviders\Timoffmax\Useless;

use \Timoffmax\Useless\Model\ResourceModel\Product\CollectionFactory;
class Products extends \Magento\Ui\DataProvider\AbstractDataProvider
{    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
