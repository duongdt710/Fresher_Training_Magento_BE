<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Autolink\Edit;

/**
 * Class Tabs
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Autolink\Edit
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
        $this->setTitle(__('Crosslink Tab'));
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
                    'Magenest\SuperEasySeo\Block\Adminhtml\Autolink\Edit\Tab\General',
                    'seo.autolink.tab.general'
                )->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'apply',
            [
                'label'   => __('Apply For'),
                'content' => $this->getLayout()->createBlock(
                    'Magenest\SuperEasySeo\Block\Adminhtml\Autolink\Edit\Tab\Apply',
                    'seo.autolink.tab.apply'
                )->toHtml(),
                'active' => false
            ]
        );
    }
}
