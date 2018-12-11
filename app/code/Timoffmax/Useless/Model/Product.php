<?php

namespace Timoffmax\Useless\Model;

class Product extends \Magento\Framework\Model\AbstractModel implements \Timoffmax\Useless\Api\Data\ProductInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'timoffmax_useless_product';

    protected function _construct()
    {
        $this->_init('Timoffmax\Useless\Model\ResourceModel\Product');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
