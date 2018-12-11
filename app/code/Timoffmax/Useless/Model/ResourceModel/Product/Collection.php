<?php
namespace Timoffmax\Useless\Model\ResourceModel\Product;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Timoffmax\Useless\Model\Product','Timoffmax\Useless\Model\ResourceModel\Product');
    }
}
