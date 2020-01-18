<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Autolink\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

/**
 * Class General
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Autolink\Edit\Tab
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
        /* @var $model \Magenest\SuperEasySeo\Model\Autolink */
        $model = $this->_coreRegistry->registry('autolink');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);

        if ($model->getId()) {
            $fieldset->addField(
                'autolink_id',
                'hidden',
                [
                    'name' =>'autolink_id'
                ]
            );
        }
        $fieldset->addField(
            'enabled',
            'select',
            [
                'name' => 'enabled',
                'label' => __('Is Actived'),
                'title' => __('Is Actived'),
                'options' => ['0' => __('No'), '1' => __('Yes')],
            ]
        );
        $fieldset->addField(
            'keyword',
            'text',
            [
                'name' => 'keyword',
                'label' => __('Keyword'),
                'title' => __('Keyword'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Url Title'),
                'title' => __('Url Title'),
            ]
        );
        $fieldset->addField(
            'url',
            'text',
            [
                'name' => 'url',
                'label' => __('Url'),
                'title' => __('Url'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'url_target',
            'select',
            [
                'name' => 'url_target',
                'label' => __('Url Target'),
                'title' => __('Url Target'),
                'required'  => true,
                'options'   => ['1' => __('_self'), '2' => __('_blank')]
            ]
        );
        $fieldset->addField(
            'store',
            'multiselect',
            [
                'name'     => 'store[]',
                'label'    => __('Store Views'),
                'title'    => __('Store Views'),
                'required' => true,
                'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
            ]
        );

        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Priority'),
                'title' => __('Priority'),
                'class' => 'validate-number'
            ]
        );
        $form->setValues($model->getData());
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
        return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('General');
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
