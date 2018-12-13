<?php

namespace Timoffmax\Useless\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Product extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('timoffmax_useless_product','id');
    }
}
