<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Preview;

use Magento\Backend\Block\Template\Context;

/**
 * Class Js
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Preview
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

    /**
     * @return string
     */
    public function getPreviewUrl()
    {
        return $this->getUrl('seo/preview/showPreview', ['_secure' => true]);
    }

    /**
     * @return mixed
     */
    public function getToolbarContent()
    {
        $layout = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template')->setTemplate('Magenest_SuperEasySeo::preview/toolbar.phtml')->toHtml();
        return $layout;
    }

}
