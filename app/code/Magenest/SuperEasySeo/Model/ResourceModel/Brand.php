<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Model\ResourceModel;
/**
 * Class Brand
 * @package Magenest\SuperEasySeo\Model\ResourceModel
 */
class Brand extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function _construct()
    {
        $this->_init('brand', 'brand_id');
    }
}