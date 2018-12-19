<?php

namespace Timoffmax\Useless\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

use Timoffmax\Useless\Model\OrderFactory;
use Timoffmax\Useless\Model\OrderRepository;

/**
 * Class OrderPlugin
 *
 * Used to save orders in custom table
 */
class OrderPlugin
{
    protected $orderFactory;
    protected $orderRepository;
    protected $scopeConfig;

    public function __construct(
        OrderFactory $orderFactory,
        OrderRepository $orderRepository,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
        $this->scopeConfig = $scopeConfig;
    }

    public function afterSave(
        OrderInterface $order,
        OrderInterface $result
    ): OrderInterface
    {
        if ($this->isModuleEnabled()) {
            // Prepare total value
            $convertRate = $this->scopeConfig->getValue(
                'timoffmax_useless_products/general/rate',
                ScopeInterface::SCOPE_STORE
            );
            $total = $order->getBaseGrandTotal() * $convertRate;

            try {
                // Update only price if instance already exists
                $customOrder = $this->orderRepository->getByOrderId($order->getId());
                $customOrder->setTotal($total);
            } catch (NoSuchEntityException $e) {
                // Create new custom order
                $customOrder = $this->orderFactory->create();
                $customOrder->setData([
                    'order_id' => $order->getId(),
                    'total' => $total,
                ]);
            } finally {
                // Save it anyway
                $customOrder->save();
            }
        }

        return $result;
    }

    protected function isModuleEnabled(): bool
    {
        return $this->scopeConfig->getValue(
            'timoffmax_useless_products/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }
}
