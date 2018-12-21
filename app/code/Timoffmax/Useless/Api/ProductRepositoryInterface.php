<?php

namespace Timoffmax\Useless\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

use Timoffmax\Useless\Api\Data\ProductInterface;
use Timoffmax\Useless\Api\SearchResultInterface\ProductSearchResultsInterface;

/**
 * Interface ProductRepositoryInterface
 */
interface ProductRepositoryInterface
{
    /**
     * @param \Timoffmax\Useless\Api\Data\ProductInterface $product
     * @return \Timoffmax\Useless\Api\Data\ProductInterface
     */
    public function save(ProductInterface $product): ProductInterface;

    /**
     * @param int $id
     * @return \Timoffmax\Useless\Api\Data\ProductInterface
     */
    public function getById(int $id): ?ProductInterface;

    /**
     * @param int $productId
     * @return \Timoffmax\Useless\Api\Data\ProductInterface
     */
    public function getByProductId(int $productId): ?ProductInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Timoffmax\Useless\Api\SearchResultInterface\ProductSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ProductSearchResultsInterface;

    /**
     * @param \Timoffmax\Useless\Api\Data\ProductInterface $product
     * @return bool
     */
    public function delete(ProductInterface $product): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $productId
     * @return bool
     */
    public function deleteByProductId(int $productId): bool;
}
