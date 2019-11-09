<?php
namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface {
    public function upgrade(SchemaSetupInterface $setup,
    ModuleContextInterface $context) {
        if (version_compare($context->getVersion(), '2.1.2') < 0) {
            $installer = $setup;
            $installer->startSetup();
            $connection = $installer->getConnection();
            //Install new database table
            $table = $installer->getConnection()->newTable(
            $installer->getTable('magenest_movie')
            )->addColumn(
                'movie_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,
                [
                    'length' => 10,
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Movie Id'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,null,
                [
                    'length' => 10,
                    'nullable' => false,
                ],
                'Name'
            )->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,null,
                [
                    'nullable' => false,
                ],
            'Description'
            )->addColumn(
                'rating',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false,],
                'Rating'
            )->addColumn(
                'director_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,
                [   
                    'length' => 10,
                    'nullable' => false,
                    'unsigned' => true,
                ],
                'Director Id'
            )->addForeignKey(
                $installer->getFkName(
                    'magenest_movie', 
                    'director_id', 
                    'magenest_director', 
                    'director_id'
                ),
                'director_id',
                $installer->getTable('magenest_director'),
                'director_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
            $installer->getConnection()->createTable($table);$installer->endSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable('magenest_director')
                )->addColumn(
                    'director_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,
                    [
                        'length' => 10,
                        'nullable' => false,
                        'unsigned' => true,
                        'primary' => true,
                        'identity' => true,
                    ],
                    'Director Id'
                )->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,null,
                    [
                        'length' => 10,
                        'nullable' => false,
                    ],
                    'Name'
                );
                $installer->getConnection()->createTable($table);$installer->endSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable('magenest_actor')
            )
            ->addColumn(
                'actor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                [
                    'length' => 10,
                    'identity' => true,
                    'nullable' => false,
                    'unsigned' => true,
                    'primary' => true,
                ], 'Actor Id'
            )->addColumn(
                'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,null,
                    [
                        'length' => 10,
                        'nullable' => false,
                    ],
                    'Name'
                );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable('magenest_movie_actor')
            )->addColumn(
                'movie_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,
                [
                    'length' => 10,
                    'unsigned' => true,
                    'nullable' => false,
                ], 'Movie Id'
            )->addColumn(
                'actor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,null,
                [
                    'length' => 10,
                    'nullable' => false,
                    'unsigned' => true,
                ], 'Actor Id'
            )->addForeignKey(
                $installer->getFkName(
                    'magenest_movie_actor',
                    'movie_id',
                    'magenest_movie',
                    'movie_id'
                ), 'movie_id',
                $installer->getTable('magenest_movie'),
                'movie_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName(
                    'magenest_movie_actor',
                    'actor_id',
                    'magenest_actor',
                    'actor_id'
                ), 'actor_id',
                $installer->getTable('magenest_actor'),
                'actor_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();
        }
    }
}