<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Gallery
 * @package Magenest\SuperEasySeo\Model
 */
class Gallery extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\ResourceModel\Gallery');
    }
}
