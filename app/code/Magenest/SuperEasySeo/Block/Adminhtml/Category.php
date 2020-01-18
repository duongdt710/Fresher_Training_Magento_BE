<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace   Magenest\SuperEasySeo\Block\Adminhtml;

/**
 * Class Category
 * @package Magenest\SuperEasySeo\Block\Adminhtml
 */
class Category extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Magenest_SuperEasySeo';
        $this->_controller = 'adminhtml_category';

        parent::_construct();
    }
}
