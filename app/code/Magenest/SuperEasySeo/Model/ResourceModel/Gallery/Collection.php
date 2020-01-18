<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\ResourceModel\Gallery;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Magenest\SuperEasySeo\Model\ResourceModel\Gallery
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\Gallery', 'Magenest\SuperEasySeo\Model\ResourceModel\Gallery');
    }
}
