<?php

namespace Timoffmax\Useless\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

use Timoffmax\Useless\Model\OrderFactory;

/**
 * Class OrderPlugin
 *
 * Used to save orders in custom table
 */
class OrderPlugin
{
    protected $orderFactory;
    protected $scopeConfig;

    public function __construct(
        OrderFactory $orderFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->orderFactory = $orderFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function afterSave(
        OrderInterface $order,
        OrderInterface $result
    ): OrderInterface
    {
        if ($this->isModuleEnabled()) {
            $convertRate = $this->scopeConfig->getValue(
                'timoffmax_useless_products/general/rate',
                ScopeInterface::SCOPE_STORE
            );
            $total = $order->getBaseGrandTotal() * $convertRate;

            $this->orderFactory->create()
                ->setData([
                    'order_id' => $order->getEntityId(),
                    'total' => $total,
                ])
                ->save()
            ;
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
