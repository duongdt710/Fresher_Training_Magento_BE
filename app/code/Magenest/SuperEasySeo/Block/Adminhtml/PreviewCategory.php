<?php
/**
 * Created by PhpStorm.
 * User: gialam
 * Date: 16/03/2017
 * Time: 10:11
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml;

/**
 * Class PreviewCategory
 * @package Magenest\SuperEasySeo\Block\Adminhtml
 */
class PreviewCategory extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup  =   'Magenest_SuperEasySeo';
        $this->_controller  =   'adminhtml_preview_category';
        parent::_construct();
        $this->removeButton('add');
    }
}
