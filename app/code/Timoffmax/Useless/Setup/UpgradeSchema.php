<?php

namespace Timoffmax\Useless\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable('timoffmax_useless_product'),
                    'price',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Product price',
                        'after' => 'product_id',
                    ]
                )
            ;

            $setup->getConnection()
                ->addColumn(
                    $setup->getTable('timoffmax_useless_order'),
                    'total',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Order total',
                        'after' => 'order_id',
                    ]
                )
            ;
        }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable('timoffmax_useless_product'),
                    'original_price',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Original product price',
                        'after' => 'product_id',
                    ]
                )
            ;

            $setup->getConnection()
                ->addColumn(
                    $setup->getTable('timoffmax_useless_order'),
                    'original_total',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Original order total',
                        'after' => 'order_id',
                    ]
                )
            ;
        }

        $setup->endSetup();
    }
}
