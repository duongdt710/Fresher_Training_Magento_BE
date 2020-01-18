<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\SuperEasySeo\Controller\Adminhtml\Brand;

use Magento\Framework\App\Action\Context;

/**
 * Class Save
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Brand
 */
class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magenest\SuperEasySeo\Model\BrandFactory
     */
    protected $member;

    /**
     * Save constructor.
     * @param Context $context
     * @param \Magenest\SuperEasySeo\Model\BrandFactory $member
     */
    public function __construct(Context $context, \Magenest\SuperEasySeo\Model\BrandFactory $member)
    {
        $this->member = $member;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Exception
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $mem = $this->member->create();
        $mem->setData($data)->save();
        $this->messageManager->addSuccessMessage('Add Brand Susscessfully!');
        $this->_redirect('seo/brand');
    }
}

