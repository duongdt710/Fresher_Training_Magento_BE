<?php
namespace Packt\HelloWorld\Block\Adminhtml;
class Movie extends \Magento\Backend\Block\Widget\Grid\Container
{
protected function _construct()
{
$this->_blockGroup = 'Packt_HelloWorld';
$this->_controller = 'adminhtml_movie';
parent::_construct();
}
}
