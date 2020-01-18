<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Category\Edit;

use Magento\Backend\Block\Template\Context;

/**
 * Class Js
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Category\Edit
 */
class Js extends \Magento\Backend\Block\Template
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Template
     */
    protected $template;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * Js constructor.
     * @param Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magenest\SuperEasySeo\Model\Template $template
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        \Magenest\SuperEasySeo\Model\TemplateFactory $template,
        array $data
    ) {
        $this->template = $template;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function getAssignType()
    {
        $data = $this->_request->getParams();
        $id = 0 ;
        if (isset($data['id'])) {
            $model = $this->template->create()->load($data['id']);
            $id = $model->getAssignType();
        }

        return $id;
    }

    /**
     * @return bool
     */
    public function checkEdit()
    {
        $data = $this->_request->getParams();
        if (isset($data['id'])) {
            return 1;
        }

        return 2;
    }
}
