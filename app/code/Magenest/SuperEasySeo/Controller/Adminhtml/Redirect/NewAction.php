<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Redirect;

use Magenest\SuperEasySeo\Controller\Adminhtml\Redirect as AbstractRedirect;

/**
 * Class NewAction
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Redirect
 */
class NewAction extends AbstractRedirect
{
    /**
     * forward to edit
     *
     * @return $this
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        
        return $resultForward->forward('edit');
    }
}
