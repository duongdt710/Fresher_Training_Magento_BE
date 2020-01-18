<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Ui\Component\Listing\Columns;

use Magento\Ui\Component\Listing\Columns\Column;
use Magenest\SuperEasySeo\Model\Status\Enabled as Status;

/**
 * Class Preview
 * @package Magenest\SuperEasySeo\Ui\Component\Listing\Columns
 */
class Preview extends Column
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
                $class = 'preview_category_seo';
                $label = 'Preview';
                $id = $item['entity_id'];
                $item['entity_id'] = '<button id="'.$id.'" class="'.$class.'">'.$label.'</button>';
            }
        }
        return $dataSource;
    }
}
