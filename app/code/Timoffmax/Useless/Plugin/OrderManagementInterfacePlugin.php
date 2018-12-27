<?php

namespace Timoffmax\Useless\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Store\Model\ScopeInterface;

use Timoffmax\Useless\Model\Order as CustomOrder;
use Timoffmax\Useless\Model\OrderFactory as CustomOrderFactory;
use Timoffmax\Useless\Model\OrderRepository as CustomOrderRepository;
use Timoffmax\Useless\Api\Data\OrderInterface as CustomOrderInterface;

/**
 * Class OrderPlugin
 *
 * Used to save orders in custom table
 */
class OrderManagementInterfacePlugin
{
    protected $customOrderFactory;
    protected $customOrderRepository;
    protected $scopeConfig;

    public function __construct(
        CustomOrderFactory $cutomOrderFactory,
        CustomOrderRepository $customOrderRepository,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->customOrderFactory = $cutomOrderFactory;
        $this->customOrderRepository = $customOrderRepository;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Create custom order after original order has been placed whether on frontend or admin
     *
     * @param OrderManagementInterface $orderManagementInterface
     * @param OrderInterface $order
     * @return OrderInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function afterPlace(
        OrderManagementInterface $orderManagementInterface,
        OrderInterface $order
    ): OrderInterface
    {
        if ($this->isModuleEnabled()) {
            $convertRate = $this->scopeConfig->getValue(
                'timoffmax_useless_products/general/rate',
                ScopeInterface::SCOPE_STORE
            );
            $total = $order->getBaseGrandTotal() * $convertRate;

            /** @var CustomOrder $customOrder */
            $customOrder = $this->customOrderFactory->create();
            $customOrder->setData([
                CustomOrderInterface::ORDER_ID => $order->getId(),
                CustomOrderInterface::TOTAL => $total,
            ]);

            $this->customOrderRepository->save($customOrder);
        }

        return $order;
    }

    /**
     * Returns the module status
     *
     * @return bool
     */
    protected function isModuleEnabled(): bool
    {
        return $this->scopeConfig->getValue(
            'timoffmax_useless_products/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }
}
