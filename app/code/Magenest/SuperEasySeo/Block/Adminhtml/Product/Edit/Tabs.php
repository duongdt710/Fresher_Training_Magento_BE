<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Product\Edit;

/**
 * Admin page left menu
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
                    'Magenest\SuperEasySeo\Block\Adminhtml\Product\Edit\Tab\General',
                    'seo.product.tab.general'
                )->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'attribute',
            [
                'label'   => __('Attribute Set'),
                'content' => $this->getLayout()->createBlock(
                    'Magenest\SuperEasySeo\Block\Adminhtml\Product\Edit\Tab\Attribute',
                    'seo.product.tab.attribute'
                )->toHtml(),
                'active' => false
            ]
        );
        $this->addTab(
            'product',
            [
                'label'   => __('Products Apply'),
                'content' => $this->getLayout()->createBlock(
                    'Magenest\SuperEasySeo\Block\Adminhtml\Product\Edit\Tab\Product',
                    'seo.product.tab.product'
                )->toHtml(),
                'active' => false
            ]
        );
    }
}
