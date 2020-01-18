<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Gallery
 * @package Magenest\SuperEasySeo\Model\ResourceModel
 */
class Gallery extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('catalog_product_entity_media_gallery_value', 'record_id');
    }
}
