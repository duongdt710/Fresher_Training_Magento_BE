<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\SuperEasySeo\Controller\Adminhtml\Brand;

use  Magenest\SuperEasySeo\Model\BrandFactory;
use Magento\Backend\App\Action;

/**
 * Class Delete
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Brand
 */
class Delete extends Action
{
    /**
     * @var BrandFactory
     */
    protected $member;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param BrandFactory $Member
     */
    public function __construct(Action\Context $context, BrandFactory $Member)
    {
        $this->member = $Member;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Exception
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams(); /*lấy request từ bên trang member*/
        $count = 0;
        foreach ($data as $item) {
            $model = $this->member->create()->load($item);
            if ($model->getId()) {
                $model->delete();
                $count++;

            }
        }
        $this->messageManager->addSuccess('A total of ' . $count . ' record(s) has been removed successfully, ');
        $this->_redirect('seo/brand');
        return;
    }
}