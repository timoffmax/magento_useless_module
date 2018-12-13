<?php

namespace Timoffmax\Useless\Model;

use \Timoffmax\Useless\Api\Data\OrderInterface;
use \Magento\Framework\DataObject\IdentityInterface;
use \Magento\Framework\Model\AbstractModel;

class Order extends AbstractModel implements OrderInterface, IdentityInterface
{
    const CACHE_TAG = 'timoffmax_useless_order';

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Timoffmax\Useless\Model\ResourceModel\Order');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
