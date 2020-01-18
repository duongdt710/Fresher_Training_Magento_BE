<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Preview\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class LengthTitle
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Preview\Renderer
 */
class LengthTitle extends AbstractRenderer
{
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
     * Renders grid column
     *
     * @param Object $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $data = $this->_getValue($row);
        $length = strlen($data);
        if ($length > 55) {
            return '<span style="color:red">'.$length.'</span>';
        }

        return '<span >'.$length.'</span>';
    }
}
