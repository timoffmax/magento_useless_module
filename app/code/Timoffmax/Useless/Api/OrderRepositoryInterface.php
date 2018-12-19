<?php

namespace Timoffmax\Useless\Api;

use Timoffmax\Useless\Api\Data\OrderInterface;

use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderRepositoryInterface
{
    /**
     * @param OrderInterface $page
     * @return OrderInterface
     */
    public function save(OrderInterface $order): OrderInterface;

    /**
     * @param int $id
     * @return OrderInterface
     */
    public function getById(int $id): ?OrderInterface;

    /**
     * @param int $orderId
     * @return OrderInterface
     */
    public function getByOrderId(int $orderId): ?OrderInterface;

    /**
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface;

    /**
     * @param OrderInterface $page
     * @return bool
     */
    public function delete(OrderInterface $order): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
