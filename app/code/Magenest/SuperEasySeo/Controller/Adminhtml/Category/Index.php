<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Category;

use Magenest\SuperEasySeo\Controller\Adminhtml\Category as AbstractCategory;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Category
 */
class Index extends AbstractCategory
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

        $resultPage->setActiveMenu('Magenest_SuperEasySeo::category_template');
        $resultPage->addBreadcrumb(__('Category Template'), __('Category Template'));
        $resultPage->addBreadcrumb(__('Category Template'), __('Category Template'));
        $resultPage->getConfig()->getTitle()->prepend(__('Category Template'));

        return  $resultPage;
    }
}
