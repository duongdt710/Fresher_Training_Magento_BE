<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\SuperEasySeo\Model\Config\Source;

/**
 * Class Canonical
 * @package Magenest\SuperEasySeo\Model\Config\Source
 */
class Canonical implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {

        return [
            ['value' => 1, 'label' => __('Product')],
            ['value' => 2, 'label' => __('Category')],
            ['value' => 3, 'label' => __('Page')],
            ['value' => 4, 'label' => __('Website')]
        ];
    }
}
