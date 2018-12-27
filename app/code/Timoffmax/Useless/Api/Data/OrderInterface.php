<?php

namespace Timoffmax\Useless\Api\Data;

interface OrderInterface
{
    public const ORDER_ID = 'order_id';
    public const ORIGINAL_TOTAL = 'original_total';
    public const TOTAL = 'total';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return int|null
     */
    public function getOrderId(): ?int;

    /**
     * @return float|null
     */
    public function getTotal(): ?float;

    /**
     * @return float|null
     */
    public function getOriginalTotal(): ?float;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param int $id
     * @return OrderInterface
     */
    public function setId($id);

    /**
     * @param int $orderId
     * @return OrderInterface
     */
    public function setOrderId(int $orderId): OrderInterface;

    /**
     * @param float $total
     * @return OrderInterface
     */
    public function setTotal(float $total): OrderInterface;

    /**
     * @param float $originalTotal
     * @return OrderInterface
     */
    public function setOriginalTotal(float $originalTotal): OrderInterface;

    /**
     * @param string $createdAt
     * @return OrderInterface
     */
    public function setCreatedAt(string $createdAt): OrderInterface;

    /**
     * @param string $updatedAt
     * @return OrderInterface
     */
    public function setUpdatedAt(string $updatedAt): OrderInterface;
}