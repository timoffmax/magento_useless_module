<?php

namespace Timoffmax\Useless\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Prepare a table for products
        $productTable = $installer->getConnection()->newTable(
            $installer->getTable('timoffmax_useless_product')
        )
        ->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'ID'
        )
        ->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true],
            'Product ID'
        )
        ->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT, ],
            'Creation Time'
        )
        ->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE, ],
            'Modification Time'
        )
        ->addIndex(
            $setup->getIdxName('timoffmax_useless_product', ['product_id']),
            ['product_id'],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        )
        ->addForeignKey(
            $setup->getFkName('timoffmax_useless_product', 'product_id', 'catalog_product_entity', 'entity_id'),
            'product_id',
            $setup->getTable('catalog_product_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        );

        // Prapare a table for orders
        $orderTable = $installer->getConnection()->newTable(
            $installer->getTable('timoffmax_useless_order')
        )
        ->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'ID'
        )
        ->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true],
            'Order ID'
        )
        ->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT, ],
            'Creation Time'
        )
        ->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE, ],
            'Modification Time'
        )
        ->addIndex(
            $setup->getIdxName('timoffmax_useless_order', ['order_id']),
            ['order_id'],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        )
        ->addForeignKey(
            $setup->getFkName('timoffmax_useless_order', 'order_id', 'catalog_product_entity', 'entity_id'),
            'order_id',
            $setup->getTable('sales_order'),
            'entity_id',
            Table::ACTION_CASCADE
        );

        // Create tables
        $installer->getConnection()->createTable($productTable);
        $installer->getConnection()->createTable($productTable);

        $installer->endSetup();
    }
}
