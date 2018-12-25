<?php

namespace Timoffmax\Useless\Api;

use Timoffmax\Useless\Api\Data\OrderInterface;
use Timoffmax\Useless\Api\SearchResultInterface\OrderSearchResultsInterface;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface OrderRepositoryInterface
 */
interface OrderRepositoryInterface
{
    /**
     * @param \Timoffmax\Useless\Api\Data\OrderInterface $order
     * @return \Timoffmax\Useless\Api\Data\OrderInterface
     */
    public function save(OrderInterface $order): OrderInterface;

    /**
     * @param int $id
     * @return \Timoffmax\Useless\Api\Data\OrderInterface
     */
    public function getById(int $id): ?OrderInterface;

    /**
     * @param int $orderId
     * @return \Timoffmax\Useless\Api\Data\OrderInterface
     */
    public function getByOrderId(int $orderId): ?OrderInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Timoffmax\Useless\Api\SearchResultInterface\OrderSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): OrderSearchResultsInterface;

    /**
     * @param \Timoffmax\Useless\Api\Data\OrderInterface $order
     * @return bool
     */
    public function delete(OrderInterface $order): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $orderId
     * @return bool
     */
    public function deleteByOrderId(int $orderId): bool;
}
