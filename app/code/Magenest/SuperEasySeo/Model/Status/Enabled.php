<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Status;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Enabled
 * @package Magenest\SuperEasySeo\Model\Status
 */
class Enabled implements ArrayInterface
{

    /**@#+
     * constant
     */
    const STATUS_ENABLED= 1;
    const STATUS_DISABLED = 0;


    /**
     * Options array
     *
     * @var array
     */
    protected $_options = [
        self::STATUS_ENABLED => 'Enabled',
        self::STATUS_DISABLED => 'Disabled',
    ];

    /**
     * Return options array
     * @return array
     */
    public function toOptionArray()
    {
        $res = [];
        foreach ($this->toArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }

        return $res;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        return [
            self::STATUS_ENABLED => 'Enabled',
            self::STATUS_DISABLED => 'Disabled',
        ];
    }
}
