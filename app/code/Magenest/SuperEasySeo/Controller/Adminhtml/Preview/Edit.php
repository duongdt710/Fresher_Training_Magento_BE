<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Preview;

use Magenest\SuperEasySeo\Controller\Adminhtml\Preview as AbstractPreview;

/**
 * Class Edit
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Product
 */
class Edit extends AbstractPreview
{
    
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_SuperEasySeo::preview_seo')
            ->addBreadcrumb(__('Preview'), __('Preview'));
        
        return $resultPage;
    }

    /**
     * @return $this|\Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
//        // 1. Get ID and create model
//        $id = $this->getRequest()->getParam('id');
//        $model = $this->_objectManager->create('Magenest\SuperEasySeo\Model\Template');
//
//        // 2. Initial checking
//        if ($id) {
//            $model->load($id);
//            if (!$model->getId()) {
//                $this->messageManager->addError(__('This template no longer exists.'));
//                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
//                $resultRedirect = $this->resultRedirectFactory->create();
//
//                return $resultRedirect->setPath('*/*/');
//            }
//        }
//
//        // 3. Set entered data if was error when we do save
//        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
//        if (!empty($data)) {
//            $model->setData($data);
//        }
//
//        // 4. Register model to use later in blocks
//        $this->_coreRegistry->register('template', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Preview Template'));
        
        return $resultPage;
    }
}
