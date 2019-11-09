<?php
namespace Packt\HelloWorld\Setup;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
class UpgradeSchema implements UpgradeSchemaInterface {
    public function upgrade(SchemaSetupInterface $setup,
    ModuleContextInterface $context) {
        if (version_compare($context->getVersion(), '2.1.3') < 0) {
            $installer = $setup;
            $installer->startSetup();
            $connection = $installer->getConnection();
            //Install new database table
            $table = $installer->getConnection()->newTable(
            $installer->getTable('packt_helloworld_subscription')
            )->addColumn(
                'subscription_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,[
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
                ],
                'Subscription Id'
            )->addColumn('created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,[
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
                ],
                'Created at'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Updated at'
            )->addColumn(
                'firstname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                ['nullable' => false],
                'First name'
            )->addColumn(
                'lastname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                ['nullable' => false],
                'Last name'
            )->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Email address'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,[
                'nullable' => false,
                'default' => 'pending',
                ],
                'Status'
            )->addColumn(
                'message',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',[
                'unsigned' => true,
                'nullable' => false
                ],
                'Subscription notes'
            )->addIndex(
                $installer->getIdxName('packt_helloworld_subscription',
                ['email']),
                ['email']
                )->setComment(
                'Cron Schedule'
            );
            $installer->getConnection()->createTable($table);$installer->endSetup();

            //Install new database table
            $table = $installer->getConnection()->newTable(
                $installer->getTable('packt_helloworld_movie')
                )->addColumn(
                    'movie_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,[
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,    
                    'primary' => true,
                    'auto increment' => true
                    ],
                    'Movie Id'
                )->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,[
                    'nullable' => false,
                    ],
                    'Name'
                )->addColumn(
                    'description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Description'
                )->addColumn(
                    'rating',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    64,
                    ['nullable' => false],
                    'Rating'
                )->addColumn(
                    'director_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Director Id'
                // )->addForeignKey(
                //         $installer->getFkName(
                //             'packt_helloworld_movie',
                //             'director_id',
                //             'packt_helloworld_director',
                //             'director_id'
                //         ),
                //         'director_id',
                //         $installer->getTable('packt_helloworld_director'),
                //         'director_id',
                //         \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                $installer->getConnection()->createTable($table);$installer->endSetup();

                $table = $installer->getConnection()->newTable(
                    $installer->getTable('packt_helloworld_director')
                )->addColumn(
                    'director_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,    
                        'primary' => true,
                        'auto increment' => true
                    ],
                    'Director Id'
                )->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, 
                    [
                        'nullable' => false
                    ],
                    'Name'
                );
                $installer->getConnection()->createTable($table);$installer->endSetup();

        }
    }
}