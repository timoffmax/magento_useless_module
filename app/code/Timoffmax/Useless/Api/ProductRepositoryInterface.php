<?php

namespace Timoffmax\Useless\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

use Magento\Framework\Api\SearchResultsInterface;
use Timoffmax\Useless\Api\Data\ProductInterface;

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
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface;

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
