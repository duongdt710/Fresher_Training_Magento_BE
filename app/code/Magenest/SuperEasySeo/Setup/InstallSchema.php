<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Magenest\Groupons\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    const TABLE_PREFIX = 'magenest_seo_';

    /**
     * install tables
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $this->createTemplateTable($installer);
        $this->createAutolinkTable($installer);
        $this->createRedirectTable($installer);
        $this->createOptimizerConfigTable($installer);
        $this->createOptimizerImageTable($installer);
        $installer->endSetup();
    }

    /**
     * @param SchemaSetupInterface $installer
     */
    private function createTemplateTable($installer)
    {
        $tableName = self::TABLE_PREFIX.'template';

        $installer->getConnection()->dropTable($tableName);
        $table = $installer->getConnection()->newTable(
            $installer->getTable($tableName)
        )->addColumn(
            'template_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Template Id'
        )->addColumn(
            'type',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Type'
        )->addColumn(
            'store',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'store'
        )->addColumn(
            'enabled',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Enabled'
        )->addColumn(
            'url_key',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Url Key'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Description'
        )->addColumn(
            'short_description',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Short Description'
        )->addColumn(
            'meta_title',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Meta Title'
        )->addColumn(
            'meta_description',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Meta Description'
        )->addColumn(
            'assign_type',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Assign Type'
        )->addColumn(
            'name_template',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Name Template'
        )->addColumn(
            'template_rule',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Template Rule'
        )->addColumn(
            'apply_for',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true],
            'Apply For'
        )->addColumn(
            'attribute_set',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Attribute Set'
        )->addColumn(
            'apply_product',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Apply Product'
        )->addColumn(
            'apply_category',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Apply Category'
        )->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            255,
            ['nullable' => true],
            'Sort Order'
        )->setComment(
            'Template Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $installer
     */
    private function createAutolinkTable($installer)
    {
        $tableName = self::TABLE_PREFIX.'autolink';

        $installer->getConnection()->dropTable($tableName);
        $table = $installer->getConnection()->newTable(
            $installer->getTable($tableName)
        )->addColumn(
            'autolink_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Autolink Id'
        )->addColumn(
            'keyword',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Key Word'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Title'
        )->addColumn(
            'url_target',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Url Target'
        )->addColumn(
            'url',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Url'
        )->addColumn(
            'store',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Store'
        )->addColumn(
            'max_replace',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Max Replace'
        )->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Sort Order'
        )->addColumn(
            'enabled',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Enabled'
        )->addColumn(
            'use_product_description',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Use Product Description'
        )->addColumn(
            'use_product_short_description',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Use Product Short Description'
        )->addColumn(
            'use_category',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Use Category'
        )->addColumn(
            'use_cms',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'use_cms'
        )->addColumn(
            'render_html',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Render Html'
        )->setComment(
            'Autolink Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $installer
     */
    private function createRedirectTable($installer)
    {
        $tableName = self::TABLE_PREFIX.'redirect';

        $installer->getConnection()->dropTable($tableName);
        $table = $installer->getConnection()->newTable(
            $installer->getTable($tableName)
        )->addColumn(
            'redirect_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Redirect Id'
        )->addColumn(
            'request_url',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Request Url'
        )->addColumn(
            'target_url',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Target Url'
        )->addColumn(
            'not_found',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Not found'
        )->addColumn(
            'comment',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Comment'
        )->addColumn(
            'enabled',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Enabled'
        )->addColumn(
            'store',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Store'
        )->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Sort Order'
        )->setComment(
            'Redirect Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $installer
     */
    private function createOptimizerImageTable($installer)
    {
        $tableName = self::TABLE_PREFIX.'optimizer_image';

        $installer->getConnection()->dropTable($tableName);
        $table = $installer->getConnection()->newTable(
            $installer->getTable($tableName)
        )->addColumn(
            'image_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Image Id'
        )->addColumn(
            'optimizer_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false,],
            'Optimizer Id'
        )->addColumn(
            'path_image',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Path Image'
        )->addColumn(
            'status',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Status'
        )->addColumn(
            'error_message',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Error Message'
        )->addColumn(
            'size_before',
            Table::TYPE_DECIMAL,
            [10,5],
            ['nullable' => false,],
            'Size Before'
        )->addColumn(
            'size_after',
            Table::TYPE_DECIMAL,
            [10,5],
            ['nullable' => false,],
            'Size After'
        )->addColumn(
            'optimized_at',
            Table::TYPE_DATE,
            null,
            ['nullable' => true,],
            'Optimized At'
        )->setComment(
            'Image Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $installer
     */
    private function createOptimizerConfigTable($installer)
    {
        $tableName = self::TABLE_PREFIX.'optimizer_config';

        $installer->getConnection()->dropTable($tableName);
        $table = $installer->getConnection()->newTable(
            $installer->getTable($tableName)
        )->addColumn(
            'optimizer_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Optimizer Id'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true,],
            'Title'
        )->addColumn(
            'created_at',
            Table::TYPE_DATE,
            null,
            ['nullable' => true,],
            'Target Url'
        )->addColumn(
            'bath_size',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false,],
            'Bath Size'
        )->addColumn(
            'path',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Path'
        )->addColumn(
            'use_64bit',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true,],
            'Use 64bit'
        )->addColumn(
            'utilities_path',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Utilities Path'
        )->addColumn(
            'gif_utility',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Gif Utility'
        )->addColumn(
            'gif_utility_options',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Gif Utility Options'
        )->addColumn(
            'jpg_utility',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Jpg Utility'
        )->addColumn(
            'jpg_utility_options',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Jpg Utility Options'
        )->addColumn(
            'png_utility',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Png Utility'
        )->addColumn(
            'png_utility_options',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false,],
            'Png Utility Options'
        )->setComment(
            'Information Table'
        );

        $installer->getConnection()->createTable($table);
    }
}
