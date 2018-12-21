<?php

namespace Timoffmax\Useless\Block\Adminhtml\Order\Edit;

class GenericButton
{
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->context = $context;    
    }
    
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }    
    
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getOrderId()]);
    }   
    
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }    
    
    public function getOrderId()
    {
        return $this->context->getRequest()->getParam('id');
    }     
}
