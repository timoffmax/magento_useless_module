<?php

namespace Timoffmax\Useless\Model;

use Timoffmax\Useless\Api\ProductRepositoryInterface;
use Timoffmax\Useless\Api\Data\ProductInterface;
use Timoffmax\Useless\Api\SearchResultInterface\ProductSearchResultsInterface;
use Timoffmax\Useless\Api\SearchResultInterface\ProductSearchResultsInterfaceFactory;
use Timoffmax\Useless\Model\ResourceModel\Product as ProductResourceModel;
use Timoffmax\Useless\Model\ResourceModel\Product\CollectionFactory;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;

class ProductRepository implements ProductRepositoryInterface
{
    protected $productFactory;
    protected $productResourceModel;
    protected $collectionFactory;
    protected $searchResultsFactory;
    
    public function __construct(
        ProductFactory $productFactory,
        ProductResourceModel $productResourceModel,
        CollectionFactory $collectionFactory,
        ProductSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->productFactory = $productFactory;
        $this->productResourceModel = $productResourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param \Timoffmax\Useless\Api\Data\ProductInterface $product
     * @return \Timoffmax\Useless\Api\Data\ProductInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductInterface $product): ProductInterface
    {
        try {
            $this->productResourceModel->save($product);
        } catch(\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $product;
    }

    /**
     * @param int $id
     * @return \Timoffmax\Useless\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ?ProductInterface
    {
        $product = $this->productFactory->create();
        $this->productResourceModel->load($product, $id);

        if (!$product->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }

        return $product;
    }

    /**
     * @param int $productId
     * @return \Timoffmax\Useless\Api\Data\ProductInterface
     */
    public function getByProductId(int $productId): ?ProductInterface
    {
        $product = $this->productFactory->create();
        $this->productResourceModel->load($product, $productId, Product::PRODUCT_ID);

         if (!$product->getProductId()) {
            throw new NoSuchEntityException(__('Object with product id "%1" does not exist.', $productId));
        }

        return $product;
    }

    /**
     * @param \Timoffmax\Useless\Api\Data\ProductInterface $product
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ProductInterface $product): bool
    {
        try {
            $this->productResourceModel->delete($product);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Timoffmax\Useless\Api\SearchResultInterface\ProductSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ProductSearchResultsInterface
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $collection = $this->collectionFactory->create();

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];

            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }

            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();

        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $products = [];

        foreach ($collection as $product) {
            $products[] = $product;
        }

        $searchResults->setItems($products);

        return $searchResults;        
    }
}
