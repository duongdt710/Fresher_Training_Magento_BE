<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\Source;

/**
 * Class Conditions
 * @package Magenest\SuperEasySeo\Model\Config\Source
 */
class Conditions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'NewCondition',         'label' => 'New'],
            ['value' => 'RefurbishedCondition', 'label' => 'Refurbished'],
            ['value' => 'UsedCondition',        'label' => 'Used'],
            ['value' => 'DamagedCondition',     'label' => 'Damaged'],
        ];
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
