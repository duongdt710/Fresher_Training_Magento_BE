<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Map;

/**
 * Class Pager
 * @package Magenest\SuperEasySeo\Block\Map
 */
class Pager extends \Magento\Theme\Block\Html\Pager
{
    /**
     * @param \Magento\Framework\Data\Collection $collection
     * @return void
     */
    public function setCollection($collection)
    {
        if ((int) $this->getLimit()) {
            $collection->setPageSize($this->getLimit());
        }

        parent::setCollection($collection);
    }

    /**
     * @return string
     */
    public function getPreviousPageUrl()
    {
        return $this->getPageUrl($this->getCollection()->getCurPage() - 1);
    }

    /**
     * @return string
     */
    public function getNextPageUrl()
    {
        return $this->getPageUrl($this->getCollection()->getCurPage() + 1);
    }

    /**
     * @param array $params
     * @return string
     */
    public function getPagerUrl($params = [])
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (count($params) > 0 && $params['p'] != 1) {
            $query = http_build_query($params);
            $url .= '?'.$query;
        }

        return $url;
    }
}
