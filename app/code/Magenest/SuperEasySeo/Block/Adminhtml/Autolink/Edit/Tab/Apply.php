<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Autolink\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

/**
 * Class Apply
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Autolink\Edit\Tab
 */
class Apply extends Generic implements TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magenest\SuperEasySeo\Model\Option\Category\Category
     */
    protected $optionCategory;

    /**
     * Category constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magenest\SuperEasySeo\Model\Option\Category\Category $category
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magenest\SuperEasySeo\Model\Option\Category\Category $category,
        array $data = []
    ) {
        $this->optionCategory = $category;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * prepare form
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        /* @var $model \Magenest\SuperEasySeo\Model\Autolink */
        $model = $this->_coreRegistry->registry('autolink');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Apply For')]);

        $fieldset->addField(
            'use_product_description',
            'select',
            [
                'name' => 'use_product_description',
                'label' => __('Use with Product Description'),
                'title' => __('Use with Product Description'),
                'options' => ['0' => __('No'), '1' => __('Yes')],
                'required' => true,
            ]
        );
        $fieldset->addField(
            'use_product_short_description',
            'select',
            [
                'name' => 'use_product_short_description',
                'label' => __('Use with Product Short Description'),
                'title' => __('Use with Product Short Description'),
                'options' => ['0' => __('No'), '1' => __('Yes')],
                'required' => true,
            ]
        );
        $fieldset->addField(
            'use_category',
            'select',
            [
                'name' => 'use_category',
                'label' => __('Use with Category'),
                'title' => __('Use with Category'),
                'options' => ['0' => __('No'), '1' => __('Yes')],
                'required' => true,
            ]
        );
        $fieldset->addField(
            'use_cms',
            'select',
            [
                'name' => 'use_cms',
                'label' => __('Use with CMS'),
                'title' => __('Use with CMS'),
                'options' => ['0' => __('No'), '1' => __('Yes')],
                'required' => true,
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Apply For');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Apply For');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

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
}
