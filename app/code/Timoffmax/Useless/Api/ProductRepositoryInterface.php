<?php

namespace Timoffmax\Useless\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

use Magento\Framework\Api\SearchResultsInterface;
use Timoffmax\Useless\Api\Data\ProductInterface;

interface ProductRepositoryInterface
{
    /**
     * @param ProductInterface $page
     * @return bool
     */
    public function save(ProductInterface $page): bool;

    /**
     * @param $id
     * @return ProductInterface
     */
    public function getById($id): ProductInterface;

    /**
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface;

    /**
     * @param ProductInterface $page
     * @return bool
     */
    public function delete(ProductInterface $page): bool;

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool;
}
