<?php

namespace Timoffmax\Useless\Controller\Adminhtml\Order;

use Timoffmax\Useless\Model\ResourceModel\Order\CollectionFactory;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $productDeleted = 0;

        /** @var \Timoffmax\Useless\Model\Order $product */
        foreach ($collection->getItems() as $product) {
            $product->delete();
            $productDeleted++;
        }

        if ($productDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $productDeleted)
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}
