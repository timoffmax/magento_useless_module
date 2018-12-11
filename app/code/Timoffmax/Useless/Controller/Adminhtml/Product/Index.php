<?php
namespace Timoffmax\Useless\Controller\Adminhtml\Product;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Timoffmax_Useless::products';  
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/index/index');
        return $resultRedirect;
    }     
}
