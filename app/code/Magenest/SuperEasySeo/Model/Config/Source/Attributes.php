<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection as AttributeCollection;

/**
 * Class Attributes
 * @package Magenest\SuperEasySeo\Model\Config\Source
 */
class Attributes implements \Magento\Framework\Option\ArrayInterface
{
    /**
     *
     * @var array
     */
    protected $options;

    /**
     * @var AttributeCollection
     */
    protected $attributeCollection;

    /**
     * Attributes constructor.
     * @param AttributeCollection $attributeCollection
     */
    public function __construct(AttributeCollection $attributeCollection)
    {
        $this->attributeCollection = $attributeCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $options = [];
            foreach ($this->attributeCollection as $item) {
                $frontendLabel = $item->getData('frontend_label') ? ' (' .  $item->getData('frontend_label')  . ')' : '';
                $options[$item->getData('attribute_code')] = $item->getData('attribute_code') . $frontendLabel;
            }
            array_unshift($options, __('-- Please Select --'));
            $this->options = $options;
        }

        return $this->options;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $_tmpOptions = $this->toOptionArray();
        $_options = [];
        foreach ($_tmpOptions as $option) {
            $_options[$option['value']] = $option['label'];
        }

        return $_options;
    }
}
