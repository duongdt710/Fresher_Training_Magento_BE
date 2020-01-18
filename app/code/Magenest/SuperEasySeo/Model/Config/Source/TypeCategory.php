<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class TypeCategory
 * @package Magenest\SuperEasySeo\Model\Config\Source
 */
class TypeCategory implements SourceInterface, OptionSourceInterface
{
    const RENDER_URL_KEY = 1;
    const RENDER_DESCRIPTION = 2;
    const RENDER_META_TITLE = 3;
    const RENDER_META_DESCRIPTION = 4;
    const RENDER_META_KEYWORD = 5;
    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        return [
            self::RENDER_URL_KEY => __('URL Key'),
            self::RENDER_DESCRIPTION => __('Description'),
            self::RENDER_META_TITLE => __('Meta Title'),
            self::RENDER_META_DESCRIPTION => __('Meta Description'),
            self::RENDER_META_KEYWORD => __('Meta Keywords')
        ];
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }

    /**
     * Get options as array
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        return $this->getAllOptions();
    }
}
