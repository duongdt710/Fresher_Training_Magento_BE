<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Index
 */
class Index extends \Magenest\SuperEasySeo\Controller\Index
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $resultPage;
    }
}
