<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Product;

use Magenest\SuperEasySeo\Controller\Adminhtml\Product as AbstractProduct;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Product
 */
class Index extends AbstractProduct
{
    /**
     * Execute
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('Magenest_SuperEasySeo::product_template');
        $resultPage->addBreadcrumb(__('Product Template'), __('Product Template'));
        $resultPage->addBreadcrumb(__('Product Template'), __('Product Template'));
        $resultPage->getConfig()->getTitle()->prepend(__('Product Template'));

        return  $resultPage;
    }
}
