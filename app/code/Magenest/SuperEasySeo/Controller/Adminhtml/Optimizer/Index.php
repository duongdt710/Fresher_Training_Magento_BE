<?php
/**
 * Copyright © 2015 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer;

use Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer as AbstractOptimizer;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer
 */
class Index extends AbstractOptimizer
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

        $resultPage->setActiveMenu('Magenest_SuperEasySeo::optimize_form');
        $resultPage->addBreadcrumb(__('Images Optimizer'), __('Images Optimizer'));
        $resultPage->addBreadcrumb(__('Images Optimizer'), __('Images Optimizer'));
        $resultPage->getConfig()->getTitle()->prepend(__('Images Optimizer'));

        return  $resultPage;
    }
}
