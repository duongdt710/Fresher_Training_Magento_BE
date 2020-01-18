<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Preview\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Store\Model\StoreManagerInterface;

class Image extends AbstractRenderer
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
        $imagePath = $this->_getValue($row);
        if ($imagePath=="") {
            $test = $this->getViewFileUrl('Magenest_SuperEasySeo::images/thumbnail.jpg');
            return "<img src=$test width='75' height='75'/>";
        } else {
            $mediaDirectory = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            );

            return "<img src='".$mediaDirectory.'catalog/product'.$imagePath."' width='75' height='75'/>";
        }
    }
}
