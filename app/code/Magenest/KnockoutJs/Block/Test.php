<?php

namespace Magenest\KnockoutJs\Block;
use Magento\Framework\View\Element\Template;

class Test extends Template
{
    /**
     * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface
     */
    protected $layoutProcessors;
    public function __construct(
        Template\Context $context,
        array $layoutProcessors = [],
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->layoutProcessors = $layoutProcessors;
    }
    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
//        return parent::getJsLayout();
        return \Zend_Json::encode($this->jsLayout);
    }
}