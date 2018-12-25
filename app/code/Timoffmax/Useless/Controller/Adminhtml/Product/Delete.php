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
    protected $productRepository;

    /**
     * Delete constructor.
     * @param \Timoffmax\Useless\Model\ProductRepository $productRepository
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        ProductRepository $productRepository,
        Context $context
    ) {
        $this->productRepository = $productRepository;

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
                $this->productRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccessMessage(__('You have deleted the product.'));
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
        $this->messageManager->addErrorMessage(__('We can not find a product to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
