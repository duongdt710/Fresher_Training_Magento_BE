<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\SuperEasySeo\Model\Config\Source;

/**
 * Class Toolbar
 * @package Magenest\SuperEasySeo\Model\Config\Source
 */
class Toolbar implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Full Action Name')],
            ['value' => 2, 'label' => __('Canonical URL')],
            ['value' => 3, 'label' => __('H1 Header')],
            ['value' => 4, 'label' => __('Meta Title')],
            ['value' => 5, 'label' => __('Meta Description')],
            ['value' => 6, 'label' => __('Meta Keywords')],
            ['value' => 7, 'label' => __('Image Alt')],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            1 => __('Full Action Name'),
            2 => __('Canonical URL'),
            3 => __('H1 Header'),
            4 => __('Meta Title'),
            5 => __('Meta Description'),
            6 => __('Meta Keywords'),
            7 => __('Image Alt'),
        ];
    }
}
