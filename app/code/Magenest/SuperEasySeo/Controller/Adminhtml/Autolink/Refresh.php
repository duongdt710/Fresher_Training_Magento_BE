<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Autolink;

/**
 * Class Refresh
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Autolink
 */
class Refresh extends \Magento\Backend\App\Action
{
    /**
     * execute
     */
    public function execute()
    {
        $this->messageManager->addSuccess('Refesh success !');
        $this->getResponse()->setRedirect($this->_redirect->getRedirectUrl($this->getUrl('*')));
        $this->_redirect('seo/*/');

        return;
    }
}
