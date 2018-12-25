<?php

namespace Timoffmax\Useless\Controller\Adminhtml\Order;

use Timoffmax\Useless\Model\OrderRepository;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;

class Delete extends Action
{  
    const ADMIN_RESOURCE = 'Timoffmax_Useless::products';
    
    /**
     * @var \Timoffmax\Useless\Model\OrderRepository
     */
    protected $orderRepository;

    /**
     * Delete constructor.
     * @param \Timoffmax\Useless\Model\OrderRepository $orderRepository
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        OrderRepository $orderRepository,
        Context $context
    ) {
        $this->orderRepository = $orderRepository;

        parent::__construct($context);
    }
          
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                // delete model
                $this->orderRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccessMessage(__('You have deleted the order.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can not find an order to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
