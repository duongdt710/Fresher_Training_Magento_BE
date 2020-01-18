<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer;

/**
 * Class Refresh
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer
 */
class Refresh extends \Magento\Backend\App\Action
{
    /**
     * return page
     */
    public function execute()
    {
        $this->messageManager->addSuccessMessage('Refesh success !');
        $this->getResponse()->setRedirect($this->_redirect->getRedirectUrl($this->getUrl('*')));
        $this->_redirect('seo/*/');
        return;
    }
}
