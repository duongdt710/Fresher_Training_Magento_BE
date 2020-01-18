<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Product\Content;

use Magento\Backend\Block\Widget;
use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;

/**
 * Class Analysis
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Product\Content
 */
class Analysis extends Widget
{
    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Set Template
     *
     * @var string
     */
    protected $_template = 'product/content/analysis.phtml';


    /**
     * Analysis constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Get Event Model
     *
     * @return mixed
     */
    public function getProductId()
    {
        $product = $this->_coreRegistry->registry('current_product');
        $id = $product->getId();

        return $id;
    }

    /**
     * @param $productId
     * @return string
     */
    public function getContentAnalysis()
    {
        $store = $this->_request->getParam('store');
        if ($store) {
            return $this->getUrl('seo/product/analysis', ['id'=> $this->getProductId(), 'store'=>$store]);
        }
        return $this->getUrl('seo/product/analysis', ['id'=> $this->getProductId()]);
    }
}
