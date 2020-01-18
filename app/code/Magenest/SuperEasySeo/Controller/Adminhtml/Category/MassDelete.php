<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Category;

use Magenest\SuperEasySeo\Controller\Adminhtml\Category as AbstractCategory;

/**
 * Class MassDelete
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Category
 */
class MassDelete extends AbstractCategory
{
    /**
     * @return mixed
     */
    public function execute()
    {
        $collections = $this->_filter->getCollection($this->_collectionFactory->create());
        $totals = 0;
        try {
            foreach ($collections as $item) {
            /** @var \Magenest\SuperEasySeo\Model\Template $item */
                $item->delete();
                $totals++;
            }

            $this->messageManager->addSuccess(__('A total of %1 record(s) have been deteled.', $totals));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, __('Something went wrong while delete the post(s).'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        
        return $resultRedirect->setPath('*/*/');
    }
}
