<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Redirect\Edit;

/**
 * Class Form
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Redirect\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_prepareForm;
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
    
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_systemStore = $systemStore;
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /* @var $model \Magenest\SuperEasySeo\Model\Redirect */
        $model = $this->_coreRegistry->registry('redirect');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
        );
        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('')]);

        if ($model->getId()) {
            $fieldset->addField(
                'redirect_id',
                'hidden',
                [
                    'name' =>'redirect_id'
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
                'note' => '<b>Redirect only if request URL can\'t be found(404)</b>',
            ]
        );
        $fieldset->addField(
            'request_url',
            'text',
            [
                'name' => 'request_url',
                'label' => __('Request Url'),
                'title' => __('Request Url'),
                'required' => true,
                'note' => __('Redirect if user opens this URL. E.g. \'/request url\'.'),
            ]
        );
        $fieldset->addField(
            'target_url',
            'text',
            [
                'name' => 'target_url',
                'label' => __('Target Url'),
                'title' => __('Target Url'),
                'required' => true,
                'note' => __('Redirect to this URL. E.g. \'/target url\'.')
            ]
        );
//        $fieldset->addField(
//            'comment',
//            'textarea',
//            [
//                'name' => 'comment',
//                'label' => __('Comments'),
//                'title' => __('Comments'),
//            ]
//        );
        $fieldset->addField(
            'store',
            'multiselect',
            [
                'name'     => 'store[]',
                'label'    => __('Visible in Store View'),
                'title'    => __('Visible in Store View'),
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
                'required' => true,
            ]
        );
        $form->setValues($model->getData());
        $this->setForm($form);
        $form->setUseContainer(true);

        return parent::_prepareForm();
    }
}
