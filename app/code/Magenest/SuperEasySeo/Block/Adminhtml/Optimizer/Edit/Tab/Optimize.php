<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab;

/**
 * Class Optimize
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab
 */
class Optimize extends \Magento\Backend\Block\Template
{
    protected $_template = 'optimizer/button.phtml';
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * @return string
     */
    public function getImages()
    {
        return $this->getUrl('seo/optimizer/scan', ['id'=>$this->_request->getParam('id')]);
    }

    /**
     * @return string
     */
    public function getOptimizeImage()
    {
        return $this->getUrl('seo/optimizer/optimize', ['id'=>$this->_request->getParam('id')]);
    }
}
