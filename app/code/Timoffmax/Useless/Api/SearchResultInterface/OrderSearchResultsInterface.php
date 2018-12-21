<?php

namespace Timoffmax\Useless\Api\SearchResultInterface;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface OrderSearchResultsInterface
 * @api
 */
interface OrderSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Timoffmax\Useless\Api\Data\OrderInterface[]
     */
    public function getItems();

    /**
     * @param \Timoffmax\Useless\Api\Data\OrderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
