<?php

namespace Timoffmax\Useless\Model;

use Timoffmax\Useless\Api\OrderRepositoryInterface;
use Timoffmax\Useless\Api\Data\OrderInterface;
use Timoffmax\Useless\Model\ResourceModel\Order as OrderResourceModel;
use Timoffmax\Useless\Model\ResourceModel\Order\CollectionFactory;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

class OrderRepository implements OrderRepositoryInterface
{
    protected $orderFactory;
    protected $orderResourceModel;
    protected $collectionFactory;
    protected $searchResultsFactory;
    
    public function __construct(
        OrderFactory $orderFactory,
        OrderResourceModel $orderResourceModel,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory       
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderResourceModel = $orderResourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param OrderInterface $object
     * @return OrderInterface
     * @throws CouldNotSaveException
     */
    public function save(OrderInterface $object): OrderInterface
    {
        try {
            $this->orderResourceModel->save($object);
        } catch(\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $object;
    }

    /**
     * @param int $id
     * @return OrderInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): OrderInterface
    {
        $object = $this->orderFactory->create();
        $this->orderResourceModel->load($object, $id);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Order with id "%1" does not exist.', $id));
        }

        return $object;        
    }

    /**
     * @param int $orderId
     * @return OrderInterface
     */
    public function getByOrderId(int $orderId): ?OrderInterface
    {
        $order = $this->orderFactory->create();
        $this->orderResourceModel->load($order, $orderId, Order::ORDER_ID);

        if (!$order->getOrderId()) {
            throw new NoSuchEntityException(__('Object with order id "%1" does not exist.', $orderId));
        }

        return $order;
    }

    /**
     * @param OrderInterface $object
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(OrderInterface $object): bool
    {
        try {
            $this->orderResourceModel->delete($object);
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
     * @return SearchResultsInterface
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
