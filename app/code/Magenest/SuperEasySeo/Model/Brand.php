<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Model;
/**
 * Class Brand
 * @package Magenest\SuperEasySeo\Model
 */
class Brand extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'brand';

    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\ResourceModel\Brand');
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}