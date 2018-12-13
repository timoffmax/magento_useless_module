<?php

namespace Timoffmax\Useless\Controller\Adminhtml\Product;

use Timoffmax\Useless\Model\ProductRepository;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;

class Delete extends Action
{  
    const ADMIN_RESOURCE = 'Timoffmax_Useless::products';
    
    /**
     * @var \Timoffmax\Useless\Model\ProductRepository
     */
    protected $objectRepository;

    /**
     * Delete constructor.
     * @param \Timoffmax\Useless\Model\ProductRepository $objectRepository
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        ProductRepository $objectRepository,
        Context $context
    ) {
        $this->objectRepository = $objectRepository;

        parent::__construct($context);
    }
          
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('object_id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                // delete model
                $this->objectRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccess(__('You have deleted the product.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can not find an object to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
