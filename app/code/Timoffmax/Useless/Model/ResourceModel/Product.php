<?php
namespace Timoffmax\Useless\Model\ResourceModel;
class Product extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('timoffmax_useless_product','product_id');
    }
}
