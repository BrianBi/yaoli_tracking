<?php 
namespace Yaoli\Tracking\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
	/**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
    	/**
         * Create Table yaoli_order_tracking
         */
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()
            ->newTable($installer->getTable('yaoli_order_tracking'))
            ->addColumn(
            	'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_BIGINT,
                20,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Tracking ID'
            )->addColumn(
                'tracking_platform',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                [],
                'tracking platform'
            )->addColumn(
                'tracking_order_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                100,
                [],
                'tracking order id'
            )->addColumn(
                'tracking_posted',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                1,
                [],
                'tracking posted'
            )->addColumn(
                'tracking_post_try_count',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                [],
                'tracking platform'
            )->addColumn(
                'tracking_action_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                32,
                [],
                'tracking Action Id'
            )->addColumn(
                'tracking_created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'tracking platform'
            )->addColumn(
                'tracking_sku',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'tracking sku'
            )->addColumn(
                'tracking_total_qty',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                [],
                'tracking total qty'
            )->addColumn(
                'tracking_total_money',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12, 4',
                [],
                'tracking total money'
            )->addColumn(
                'tracking_currency',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                32,
                [],
                'tracking currency'
            )->addColumn(
                'tracking_discount',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12, 4',
                [],
                'tracking discount'
            )->addColumn(
                'tracking_source',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                500,
                [],
                'tracking source'
            )->addColumn(
                'tracking_coupon',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'tracking total money'
            )->addIndex(
                $installer->getIdxName('yaoli_order_tracking', ['id']),
                ['id']
            )->addIndex(
                $installer->getIdxName('yaoli_order_tracking', ['tracking_platform']),
                ['tracking_platform']
            )->addIndex(
                $installer->getIdxName('yaoli_order_tracking', ['tracking_currency']),
                ['tracking_currency']
            )->addIndex(
                $installer->getIdxName('yaoli_order_tracking', ['tracking_order_id']),
                ['tracking_order_id']
            )->addIndex(
                $installer->getIdxName('yaoli_order_tracking', ['tracking_action_id']),
                ['tracking_action_id']
            )->addIndex(
                $installer->getIdxName('yaoli_order_tracking', ['tracking_sku']),
                ['tracking_sku']
            );
            
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}