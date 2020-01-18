<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;

/**
 * Class RobotOptions
 * @package Magenest\SuperEasySeo\Model\Config\Source
 */
class RobotOptions extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var OptionFactory
     */
    protected $optionFactory;

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        /* your Attribute options list*/
        $this->_options = [
            ['label' => 'INDEX, FOLLOW', 'value' => '1'],
            ['label' => 'NOINDEX, FOLLOW', 'value' => '2'],
            ['label' => 'INDEX, NOFOLLOW', 'value' => '3'],
            ['label' => 'NOINDEX, NOFOLLOW', 'value' => '4']
        ];

        return $this->_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }

        return false;
    }
}
