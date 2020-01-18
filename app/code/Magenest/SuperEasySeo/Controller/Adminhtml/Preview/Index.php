<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Preview;

use Magenest\SuperEasySeo\Controller\Adminhtml\Preview as AbstractPreview;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Preview
 */
class Index extends AbstractPreview
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

        $resultPage->setActiveMenu('Magenest_SuperEasySeo::preview_seo');
        $resultPage->addBreadcrumb(__('Preview Product'), __('Preview Product'));
        $resultPage->addBreadcrumb(__('Preview Product'), __('Preview Product'));
        $resultPage->getConfig()->getTitle()->prepend(__('Preview Product'));

        return  $resultPage;
    }
}
