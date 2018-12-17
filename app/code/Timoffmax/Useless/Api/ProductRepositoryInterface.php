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
    public function save(ProductInterface $page): ProductInterface;

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
     * @return ProductInterface
     */
    public function delete(ProductInterface $page): ProductInterface;

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool;
}
