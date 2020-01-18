<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Product;

use Magenest\SuperEasySeo\Controller\Adminhtml\Product as AbstractProduct;

/**
 * Class NewAction
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Product
 */
class NewAction extends AbstractProduct
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
