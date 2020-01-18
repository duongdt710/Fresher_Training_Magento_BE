<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Redirect;

use Magenest\SuperEasySeo\Controller\Adminhtml\Redirect as AbstractRedirect;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Redirect
 */
class Index extends AbstractRedirect
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

        $resultPage->setActiveMenu('Magenest_SuperEasySeo::redirect');
        $resultPage->addBreadcrumb(__('Redirect Template'), __('Redirect Template'));
        $resultPage->addBreadcrumb(__('Redirect Template'), __('Redirect Template'));
        $resultPage->getConfig()->getTitle()->prepend(__('Redirect Template'));

        return  $resultPage;
    }
}
