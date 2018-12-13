<?php

namespace Timoffmax\Useless\Model;

use \Timoffmax\Useless\Api\Data\ProductInterface;
use \Magento\Framework\DataObject\IdentityInterface;
use \Magento\Framework\Model\AbstractModel;

class Product extends AbstractModel implements ProductInterface, IdentityInterface
{
    const CACHE_TAG = 'timoffmax_useless_product';

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Timoffmax\Useless\Model\ResourceModel\Product');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
