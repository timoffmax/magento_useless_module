<?php

namespace Timoffmax\Useless\Model;

use Timoffmax\Useless\Api\ProductRepositoryInterface;
use Timoffmax\Useless\Api\Data\ProductInterface;
use Timoffmax\Useless\Model\ResourceModel\Product as ProductResourceModel;
use Timoffmax\Useless\Model\ResourceModel\Product\CollectionFactory;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterface;

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
        SearchResultsInterfaceFactory $searchResultsFactory       
    ) {
        $this->productFactory = $productFactory;
        $this->productResourceModel = $productResourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param ProductInterface $product
     * @return ProductInterface
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
     * @return Product
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
     * @return ProductInterface
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
     * @param ProductInterface $product
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
     * @param SearchCriteriaInterface $criteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);  
        $collection = $this->collectionFactory->create();

        foreach ($criteria->getFilterGroups() as $filterGroup) {
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
        $sortOrders = $criteria->getSortOrders();

        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];

        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }

        $searchResults->setItems($objects);

        return $searchResults;        
    }
}
