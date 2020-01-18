<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Autolink;

use Magenest\SuperEasySeo\Controller\Adminhtml\Autolink as AbstractAutolink;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Autolink
 */
class Index extends AbstractAutolink
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

        $resultPage->setActiveMenu('Magenest_SuperEasySeo::autolink');
        $resultPage->addBreadcrumb(__('Crosslink Template'), __('Crosslink Template'));
        $resultPage->addBreadcrumb(__('Crosslink Template'), __('Crosslink Template'));
        $resultPage->getConfig()->getTitle()->prepend(__('Crosslink Template'));

        return  $resultPage;
    }
}
