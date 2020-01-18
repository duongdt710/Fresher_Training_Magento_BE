<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer;

use Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer as AbstractOptimizer;

/**
 * Class MassDeleteImage
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer
 */
class MassDeleteImage extends AbstractOptimizer
{
    /**
     * Delete Action
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getParam('list_image');
        $modelImage  = $this->_objectManager->create('Magenest\SuperEasySeo\Model\OptimizerImage');
        if (!is_array($data) || empty($data)) {
            $this->messageManager->addErrorMessage(__('Please select order(s).'));
        } else {
            try {
                foreach ($data as $imageId) {
                    $modelImage->load($imageId)->delete();
                }

                $this->messageManager->addSuccessMessage(
                    __('A total of %1 record(s) have been deleted.', count($data))
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $this->resultRedirectFactory->create()->setPath('seo/optimizer/edit', ['id'=>$this->getRequest()->getParam('id')]);
    }
}
