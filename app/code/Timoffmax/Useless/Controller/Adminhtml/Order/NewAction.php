<?php

namespace Timoffmax\Useless\Controller\Adminhtml\Order;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class NewAction extends Action
{
    const ADMIN_RESOURCE = 'Timoffmax_Useless::products';

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;        
        parent::__construct($context);
    }
    
    public function execute()
    {
        return $this->resultPageFactory->create();  
    }    
}
