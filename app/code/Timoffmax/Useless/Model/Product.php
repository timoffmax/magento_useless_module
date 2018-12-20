<?php

namespace Timoffmax\Useless\Model;

use \Timoffmax\Useless\Api\Data\ProductInterface;
use \Magento\Framework\DataObject\IdentityInterface;
use \Magento\Framework\Model\AbstractModel;

/**
 * Class Product
 */
class Product extends AbstractModel implements ProductInterface, IdentityInterface
{
    const CACHE_TAG = 'timoffmax_useless_product';

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Timoffmax\Useless\Model\ResourceModel\Product');
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->getData(self::PRICE);
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
     * @param int $productId
     * @return ProductInterface
     */
    public function setProductId(int $productId): ProductInterface
    {
        return $this->getData(self::PRODUCT_ID, $productId);
    }

    /**
     * @param float $price
     * @return ProductInterface
     */
    public function setPrice(float $price): ProductInterface
    {
        return $this->getData(self::PRICE, $price);
    }

    /**
     * @param string $createdAt
     * @return ProductInterface
     */
    public function setCreatedAt(string $createdAt): ProductInterface
    {
        return $this->getData(self::CREATED_AT, $createdAt);
    }

    /**
     * @param string $updatedAt
     * @return ProductInterface
     */
    public function setUpdatedAt(string $updatedAt): ProductInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
