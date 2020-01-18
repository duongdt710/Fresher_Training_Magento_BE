<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\ResourceModel\OptimizerConfig;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Magenest\Optimizer\Model\ResourceModel\OptimizerConfig
 */
class Collection extends AbstractCollection
{
    /**
     * ID Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'optimizer_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\OptimizerConfig', 'Magenest\SuperEasySeo\Model\ResourceModel\OptimizerConfig');
    }
}
