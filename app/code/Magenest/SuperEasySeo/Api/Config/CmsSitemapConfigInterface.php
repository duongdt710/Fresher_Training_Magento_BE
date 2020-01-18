<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Api\Config;

/**
 * Interface CmsSitemapConfigInterface
 * @package Magenest\SuperEasySeo\Api\Config
 */
interface CmsSitemapConfigInterface
{

    /**
     * @param null|string $store
     * @return array
     */
    public function getIsShowCmsPages($store);

    /**
     * @param null|string $store
     * @return array
     */
    public function getIgnoreCmsPages($store);
}
