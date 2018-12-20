<?php

namespace Timoffmax\Useless\Api\SearchResultInterface;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ProductSearchResultsInterface
 * @api
 */
interface ProductSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get test Complete list.
     *
     * @return \Timoffmax\Useless\Api\Data\ProductInterface[]
     */
    public function getItems();

    /**
     * Set test Complete list.
     *
     * @param \Timoffmax\Useless\Api\Data\ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
