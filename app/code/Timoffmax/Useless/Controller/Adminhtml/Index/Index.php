<?php

namespace Timoffmax\Useless\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE='Timoffmax_Useless::products';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/product/index');

        return $resultRedirect;
    }
}
