<?php

namespace Timoffmax\Useless\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

use Timoffmax\Useless\Api\Data\ProductInterface;

/**
 * Interface ProductRepositoryInterface
 *
 * @api
 */
interface ProductRepositoryInterface
{
    /**
     * @param ProductInterface $page
     * @return ProductInterface
     */
    public function save(ProductInterface $product): ProductInterface;

    /**
     * @param int $id
     * @return ProductInterface
     */
    public function getById(int $id): ?ProductInterface;

    /**
     * @param int $productId
     * @return ProductInterface
     */
    public function getByProductId(int $productId): ?ProductInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * @param ProductInterface $page
     * @return bool
     */
    public function delete(ProductInterface $product): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
