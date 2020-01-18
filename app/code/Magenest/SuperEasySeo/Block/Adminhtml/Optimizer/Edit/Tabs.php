<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit;

/**
 * Class Tabs
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('page_base_fieldset');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Optimizer Tab'));
    }

    /**
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        $this->addTab(
            'general',
            [
                'label'   => __('General Information'),
                'content' => $this->getLayout()->createBlock(
                    'Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab\General',
                    'optimizer.tab.general'
                )->toHtml(),
                'active' => true
            ]
        );
        $id = $this->_request->getParam('id');
        if ($id) {
            $this->addTab(
                'optimize',
                [
                    'label'   => __('Optimize Images'),
                    'content' => $this->getLayout()->createBlock(
                        'Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab\Optimize',
                        'optimizer.tab.optimize'
                    )->toHtml(),
                    'active' => false
                ]
            );
            $this->addTab(
                'list_image',
                [
                    'label'   => __('List Images'),
                    'content' => $this->getLayout()->createBlock(
                        'Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab\ListImages',
                        'optimizer.tab.listimages'
                    )->toHtml(),
                    'active' => false
                ]
            );
        }
    }
}
