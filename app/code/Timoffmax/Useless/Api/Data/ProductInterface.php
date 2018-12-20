<?php

namespace Timoffmax\Useless\Api\Data;

/**
 * Interface ProductInterface
 */
interface ProductInterface
{
    public const PRODUCT_ID = 'product_id';
    public const PRICE = 'price';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * @return float|null
     */
    public function getPrice(): ?float;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param int $productId
     * @return ProductInterface
     */
    public function setProductId(int $productId): ProductInterface;

    /**
     * @param float $price
     * @return ProductInterface
     */
    public function setPrice(float $price): ProductInterface;

    /**
     * @api
     * @param string $createdAt
     * @return ProductInterface
     */
    public function setCreatedAt(string $createdAt): ProductInterface;

    /**
     * @param string $updatedAt
     * @return ProductInterface
     */
    public function setUpdatedAt(string $updatedAt): ProductInterface;
}
