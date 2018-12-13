<?php

namespace Timoffmax\Useless\Model\ResourceModel\Product;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            'Timoffmax\Useless\Model\Product',
            'Timoffmax\Useless\Model\ResourceModel\Product'
        );
    }
}
