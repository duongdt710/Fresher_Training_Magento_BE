<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Ui\Component\Listing\Columns;

use Magento\Ui\Component\Listing\Columns\Column;
use Magenest\SuperEasySeo\Model\Status\Enabled as Status;

/**
 * Class Enabled
 * @package Magenest\SuperEasySeo\Ui\Component\Listing\Columns
 */
class Enabled extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if ($item['enabled'] && $item['enabled'] == Status::STATUS_ENABLED) {
                    $class = 'notice';
                    $label = 'Enabled';
                } else {
                    $class = 'critical';
                    $label = 'Disabled';
                }
                $item['enabled'] = '<span class="grid-severity-'
                    . $class .'">'. $label .'</span>';
            }
        }
        return $dataSource;
    }
}
