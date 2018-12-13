<?php

namespace Timoffmax\Useless\Api;

use Timoffmax\Useless\Api\Data\OrderInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderRepositoryInterface
{
    public function save(OrderInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(OrderInterface $page);

    public function deleteById($id);
}
