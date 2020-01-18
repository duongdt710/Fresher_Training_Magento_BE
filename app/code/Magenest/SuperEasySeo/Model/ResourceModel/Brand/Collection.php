<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Model\ResourceModel\Brand;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'brand_id';

    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\Brand', 'Magenest\SuperEasySeo\Model\ResourceModel\Brand');
    }
}
