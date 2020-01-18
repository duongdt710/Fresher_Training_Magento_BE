<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

/**
 * Class General
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab
 */
class General extends Generic implements TabInterface
{
    protected $_prepareForm;

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Customer\Api\GroupRepositoryInterface
     */
    protected $_groupRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Convert\DataObject
     */
    protected $_objectConverter;

    /**
     * @var
     */
    protected $_fieldFactory;

    /**
     * Main constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Convert\DataObject $objectConverter
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Convert\DataObject $objectConverter,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_groupRepository = $groupRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_objectConverter = $objectConverter;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * prepare form
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        /* @var $model \Magenest\Optimizer\Model\OptimizerConfig */
        $model = $this->_coreRegistry->registry('information');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);

        if ($model->getId()) {
            $fieldset->addField(
                'optimizer_id',
                'hidden',
                [
                    'name' =>'optimizer_id'
                ]
            );
        }
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'bath_size',
            'text',
            [
                'name' => 'bath_size',
                'label' => __('Bath Size'),
                'title' => __('Bath Size'),
                'note' => __('Number of images to be optimized per request.')
            ]
        );
        $fieldset->addField(
            'path',
            'text',
            [
                'name' => 'path',
                'label' => __('Path'),
                'title' => __('Path'),
                'note' => __('Paths to be scanned for images.'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'use_64bit',
            'select',
            [
                'name' => 'use_64bit',
                'label' => __('Use system with 64-bit'),
                'title' => __('Use system with 64-bit'),
                'options' => ['0' => __('No'), '1' => __('Yes')],
            ]
        );
        $fieldset->addField(
            'gif_utility',
            'text',
            [
                'name' => 'gif_utility',
                'label' => __('GIF Format'),
                'title' => __('GIF Format'),
                'note' => __('Optimization utility for .gif files.'),
            ]
        );
        $fieldset->addField(
            'gif_utility_options',
            'text',
            [
                'name' => 'gif_utility_options',
                'label' => __('GIF Options'),
                'title' => __('GIF Options'),
                'note' => __('Options for optimization of .gif files.'),
            ]
        );
        $fieldset->addField(
            'jpg_utility',
            'text',
            [
                'name' => 'jpg_utility',
                'label' => __('JPG Format'),
                'title' => __('JPG Format'),
                'note' => __('Optimization utility for .jpg files.'),
            ]
        );
        $fieldset->addField(
            'jpg_utility_options',
            'text',
            [
                'name' => 'jpg_utility_options',
                'label' => __('JPG Options'),
                'title' => __('JPG Options'),
                'note' => __('Options for optimization of .jpg files.'),
            ]
        );
        $fieldset->addField(
            'png_utility',
            'text',
            [
                'name' => 'png_utility',
                'label' => __('PNG Format'),
                'title' => __('PNG Format'),
                'note' => __('Optimization utility for .png files.'),
            ]
        );
        $fieldset->addField(
            'png_utility_options',
            'text',
            [
                'name' => 'png_utility_options',
                'label' => __('PNG Options'),
                'title' => __('PNG Options'),
                'note' => __('Options for optimization of .png files.'),
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
        return __('General Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('General Information');
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
