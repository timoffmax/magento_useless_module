<?php

namespace Timoffmax\Useless\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;

use Timoffmax\Useless\Model\ProductRepository;
use Timoffmax\Useless\Model\ProductFactory;

/**
 * Class ProductPlugin
 *
 * Used to save products in custom table
 */
class ProductPlugin
{
    protected $productFactory;
    protected $productRepository;
    protected $scopeConfig;

    public function __construct(
        ProductFactory $productFactory,
        ProductRepository $productRepository,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
    }

    public function afterSave(
        ProductInterface $product,
        ProductInterface $result
    ): ProductInterface
    {
        if ($this->isModuleEnabled()) {
            // Prepare price value
            $convertRate = $this->scopeConfig->getValue(
                'timoffmax_useless_products/general/rate',
                ScopeInterface::SCOPE_STORE
            );
            $price = $product->getPrice() * $convertRate;

            try {
                // Update only price if instance already exists
                $customProduct = $this->productRepository->getByProductId($product->getId());
                $customProduct->setPrice($price);
            } catch (NoSuchEntityException $e) {
                // Create new custom product
                $customProduct = $this->productFactory->create();
                $customProduct->setData([
                    'product_id' => $product->getId(),
                    'price' => $price,
                ]);
            } finally {
                // Save it anyway
                $customProduct->save();
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
