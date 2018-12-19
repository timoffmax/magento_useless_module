<?php

namespace Timoffmax\Useless\Api\Data;

interface OrderInterface
{
    public const ORDER_ID = 'order_id';
    public const TOTAL = 'total';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getOrderId(): ?int;

    /**
     * @return float|null
     */
    public function getTotal(): ?float;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

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