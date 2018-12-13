<?php

namespace Timoffmax\Useless\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

use Timoffmax\Useless\Model\OrderRepository;

class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Timoffmax_Useless::products';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    
    /**
     * @var \Timoffmax\Useless\Model\OrderRepository
     */
    protected $objectRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Timoffmax\Useless\Model\OrderRepository $objectRepository
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        OrderRepository $objectRepository
    ) {
        $this->dataPersistor    = $dataPersistor;
        $this->objectRepository  = $objectRepository;
        
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            /** @var \Timoffmax\Useless\Model\Order $model */
            $model = $this->_objectManager->create('Timoffmax\Useless\Model\Order');

            $id = $this->getRequest()->getParam('id');

            if ($id) {
                $model = $this->objectRepository->getById($id);
            }

            $model->setData($data);

            try {
                $this->objectRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the thing.'));
                $this->dataPersistor->clear('timoffmax_useless_product');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the data.'));
            }

            $this->dataPersistor->set('timoffmax_useless_product', $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }    
}
