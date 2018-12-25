<?php

namespace Timoffmax\Useless\Model;

use Timoffmax\Useless\Api\OrderRepositoryInterface;
use Timoffmax\Useless\Api\Data\OrderInterface;
use Timoffmax\Useless\Model\ResourceModel\Order as OrderResourceModel;
use Timoffmax\Useless\Model\ResourceModel\Order\CollectionFactory;
use Timoffmax\Useless\Api\SearchResultInterface\OrderSearchResultsInterface;
use Timoffmax\Useless\Api\SearchResultInterface\OrderSearchResultsInterfaceFactory;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Reflection\DataObjectProcessor;

class OrderRepository implements OrderRepositoryInterface
{
    protected $orderFactory;
    protected $orderResourceModel;
    protected $collectionFactory;
    protected $searchResultsFactory;
    protected $dataObjectProcessor;

    public function __construct(
        OrderFactory $orderFactory,
        OrderResourceModel $orderResourceModel,
        CollectionFactory $collectionFactory,
        OrderSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderResourceModel = $orderResourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * @param \Timoffmax\Useless\Api\Data\OrderInterface $order
     * @return \Timoffmax\Useless\Api\Data\OrderInterface
     * @throws CouldNotSaveException
     */
    public function save(OrderInterface $order): OrderInterface
    {
        try {
            $this->orderResourceModel->save($order);
        } catch(\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $order;
    }

    /**
     * @param int $id
     * @return \Timoffmax\Useless\Api\Data\OrderInterface
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
     * @return \Timoffmax\Useless\Api\Data\OrderInterface
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
     * @param \Timoffmax\Useless\Api\Data\OrderInterface $order
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(OrderInterface $order): bool
    {
        try {
            $this->orderResourceModel->delete($order);
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
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Timoffmax\Useless\Api\SearchResultInterface\OrderSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): OrderSearchResultsInterface
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

    /**
     * @param int $orderId
     * @return bool
     */
    public function deleteByOrderId(int $orderId): bool
    {
        return $this->delete($this->getByOrderId($orderId));
    }
}
