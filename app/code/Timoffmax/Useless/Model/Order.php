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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->getData($this->_idFieldName);
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * @return float|null
     */
    public function getTotal(): ?float
    {
        return $this->getData(self::TOTAL);
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param int $id
     * @return OrderInterface
     */
    public function setId($id)
    {
        return $this->setData($this->_idFieldName, $id);
    }

    /**
     * @param int $orderId
     * @return OrderInterface
     */
    public function setOrderId(int $orderId): OrderInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * @param float $total
     * @return OrderInterface
     */
    public function setTotal(float $total): OrderInterface
    {
        return $this->setData(self::TOTAL, $total);
    }

    /**
     * @param string $createdAt
     * @return OrderInterface
     */
    public function setCreatedAt(string $createdAt): OrderInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @param string $updatedAt
     * @return OrderInterface
     */
    public function setUpdatedAt(string $updatedAt): OrderInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
