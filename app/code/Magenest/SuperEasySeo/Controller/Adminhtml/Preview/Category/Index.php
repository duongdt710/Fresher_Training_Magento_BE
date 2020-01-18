<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Preview\Category;

use Magenest\SuperEasySeo\Controller\Adminhtml\PreviewCategory as AbstractPreviewCategory;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Preview\Category
 */
class Index extends AbstractPreviewCategory
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

        $resultPage->setActiveMenu('Magenest_SuperEasySeo::preview_category');
        $resultPage->addBreadcrumb(__('Preview Category'), __('Preview Category'));
        $resultPage->addBreadcrumb(__('Preview Category'), __('Preview Category'));
        $resultPage->getConfig()->getTitle()->prepend(__('Preview Category'));

        return  $resultPage;
    }
}
