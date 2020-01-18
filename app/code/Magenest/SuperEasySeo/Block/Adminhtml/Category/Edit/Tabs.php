<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Category\Edit;

/**
 * Class Tabs
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Category\Edit
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
        $this->setTitle(__('Template'));
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
                'label'   => __('General'),
                'content' => $this->getLayout()->createBlock(
                    'Magenest\SuperEasySeo\Block\Adminhtml\Category\Edit\Tab\General',
                    'seo.category.tab.general'
                )->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'category',
            [
                'label'   => __('Categories'),
                'content' => $this->getLayout()->createBlock(
                    'Magenest\SuperEasySeo\Block\Adminhtml\Category\Edit\Tab\Category',
                    'seo.category.tab.category'
                )->toHtml(),
                'active' => false
            ]
        );
    }
}
