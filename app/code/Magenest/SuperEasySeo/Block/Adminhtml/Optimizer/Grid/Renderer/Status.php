<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Grid\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Status
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Grid\Renderer
 */
class Status extends AbstractRenderer
{
    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        StoreManagerInterface $storemanager,
        array $data = []
    ) {
        $this->_storeManager = $storemanager;
        parent::__construct($context, $data);
        $this->_authorization = $context->getAuthorization();
    }

    /**
     * @param \Magento\Framework\DataObject $row
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $status = $this->_getValue($row);
        if ($status == "2") {
            return "<p style=\"background-color:#00fF11; text-align: center; color: black\">Optimized</p> ";
        } elseif ($status == "1") {
            return "<p style=\"background-color:#ffff00; text-align: center; color: black\">No Optimized</p> ";
        }
    }
}
