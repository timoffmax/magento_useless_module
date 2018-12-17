<?php

namespace Timoffmax\Useless\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

use Magento\Store\Model\ScopeInterface;
use Timoffmax\Useless\Model\ProductFactory;

/**
 * Class ProductPlugin
 *
 * Used to save products in custom table
 */
class ProductPlugin
{
    protected $productFactory;
    protected $scopeConfig;

    public function __construct(
        ProductFactory $productFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->productFactory = $productFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function afterSave(
        ProductInterface $product,
        ProductInterface $result
    ): ProductInterface
    {
        if ($this->isModuleEnabled()) {
            $convertRate = $this->scopeConfig->getValue(
                'timoffmax_useless_products/general/rate',
                ScopeInterface::SCOPE_STORE
            );
            $price = $product->getPrice() * $convertRate;

            $this->productFactory->create()
                ->setData([
                    'product_id' => $product->getId(),
                    'price' => $price,
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
