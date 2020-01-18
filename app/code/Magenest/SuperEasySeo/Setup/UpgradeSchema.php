<?php
namespace Magenest\SuperEasySeo\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface {
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.1.5') < 0) {
            $installer = $setup;
            $installer->startSetup();
            $connection = $installer->getConnection();
            // Install new database
            $table = $installer->getConnection()->newTable(
                $installer->getTable('magenest_seo_template')
            )->addColumn(
                'template_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,  null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Template Id'
            )->addColumn(
                'type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => false,],
                'Type'
            )->addColumn(
                'store',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => false,],
                'store'
            )->addColumn(
                'enabled',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Enabled'
            )->addColumn(
                'url_key',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Url Key'
            )->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Description'
            )->addColumn(
                'short_description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Short Description'
            )->addColumn(
                'meta_title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Meta Title'
            )->addColumn(
                'meta_description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Meta Description'
            )->addColumn(
                'assign_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Assign Type'
            )->addColumn(
                'name_template',
                \Magento\Framework\DB\Ddl\ Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Name Template'
            )->addColumn(
                'template_rule',
                \Magento\Framework\DB\Ddl\ Table::TYPE_TEXT, null,
                ['nullable' => true],
                'Template Rule'
            )->addColumn(
                'apply_for',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true],
                'Apply For'
            )->addColumn(
                'attribute_set',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true],
                'Attribute Set'
            )->addColumn(
                'apply_product',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true],
                'Apply Product'
            )->addColumn(
                'apply_category',
                \Magento\Framework\DB\Ddl\ Table::TYPE_TEXT, null,
                ['nullable' => true],
                'Apply Category'
            )->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 255,
                ['nullable' => true],
                'Sort Order'
            )->setComment(
                'Template Table'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();

            $table =  $installer->getConnection()->newTable(
                $installer->getTable('magenest_seo_autolink')
            )->addColumn(
                'autolink_id',
                \Magento\Framework\DB\Ddl\ Table::TYPE_INTEGER, null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Autolink Id'
            )->addColumn(
                'keyword',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Key Word'
            )->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Title'
            )->addColumn(
                'url_target',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Url Target'
            )->addColumn(
                'url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Url'
            )->addColumn(
                'store',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Store'
            )->addColumn(
                'max_replace',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Max Replace'
            )->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Sort Order'
            )->addColumn(
                'enabled',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Enabled'
            )->addColumn(
                'use_product_description',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Use Product Description'
            )->addColumn(
                'use_product_short_description',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Use Product Short Description'
            )->addColumn(
                'use_category',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Use Category'
            )->addColumn(
                'use_cms',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'use_cms'
            )->addColumn(
                'render_html',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true,],
                'Render Html'
            )->setComment(
                'Autolink Table'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable('magenest_seo_redirect')
            )->addColumn(
                'redirect_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Redirect Id'
            )->addColumn(
                'request_url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Request Url'
            )->addColumn(
                'target_url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Target Url'
            )->addColumn(
                'not_found',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Not found'
            )->addColumn(
                'comment',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Comment'
            )->addColumn(
                'enabled',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Enabled'
            )->addColumn(
                'store',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Store'
            )->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Sort Order'
            )->setComment(
                'Redirect Table'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable('magenest_seo_optimizer_image')
            )->addColumn(
                'image_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
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
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => false,],
                'Optimizer Id'
            )->addColumn(
                'path_image',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => true,],
                'Path Image'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                ['nullable' => true,],
                'Status'
            )->addColumn(
                'error_message',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                ['nullable' => false,],
                'Error Message'
            )->addColumn(
                'size_before',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, [10,5],
                ['nullable' => false,],
                'Size Before'
            )->addColumn(
                'size_after',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, [10,5],
                ['nullable' => false,],
                'Size After'
            )->addColumn(
                'optimized_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE, null,
                ['nullable' => true,],
                'Optimized At'
            )->setComment(
                'Image Table'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable('magenest_seo_optimizer_config')
            )->addColumn(
                  'optimizer_id',
                  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                  [
                      'identity' => true,
                      'unsigned' => true,
                      'nullable' => false,
                      'primary' => true
                  ],
                  'Optimizer Id'
            )->addColumn(
                  'title',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                  ['nullable' => true,],
                  'Title'
            )->addColumn(
                  'created_at',
                  \Magento\Framework\DB\Ddl\Table::TYPE_DATE, null,
                  ['nullable' => true,],
                  'Target Url'
            )->addColumn(
                  'bath_size',
                  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                  ['nullable' => false,],
                  'Bath Size'
            )->addColumn(
                  'path',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                  ['nullable' => false,],
                  'Path'
            )->addColumn(
                  'use_64bit',
                  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                  ['nullable' => true,],
                  'Use 64bit'
            )->addColumn(
                  'utilities_path',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                  ['nullable' => false,],
                  'Utilities Path'
            )->addColumn(
                  'gif_utility',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                  ['nullable' => false,],
                  'Gif Utility'
            )->addColumn(
                  'gif_utility_options',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                  ['nullable' => false,],
                  'Gif Utility Options'
            )->addColumn(
                  'jpg_utility',
                  \Magento\Framework\DB\Ddl\ Table::TYPE_TEXT, null,
                  ['nullable' => false,],
                  'Jpg Utility'
            )->addColumn(
                  'jpg_utility_options',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                  ['nullable' => false,],
                  'Jpg Utility Options'
            )->addColumn(
                  'png_utility',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                  ['nullable' => false,],
                  'Png Utility'
            )->addColumn(
                  'png_utility_options',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                  ['nullable' => false,],
                  'Png Utility Options'
            )->setComment(
                  'Information Table'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable('brand')
            )->addColumn(
                'brand_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Brand Id'
            )->addColumn(
                'brand_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null,
                [
                    'length' => 10,
                    'nullable' => false,
                ],
                'Brand Name'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();
        }
    }
}
