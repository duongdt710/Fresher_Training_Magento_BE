<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml;

/**
 * Class Autolink
 * @package Magenest\SuperEasySeo\Block\Adminhtml
 */
class Autolink extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Magenest_SuperEasySeo';
        $this->_controller = 'adminhtml_autolink';

        parent::_construct();
    }
}
