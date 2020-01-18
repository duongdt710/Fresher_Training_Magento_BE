<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Api\Config;

/**
 * Interface LinkSitemapConfigInterface
 * @package Magenest\SuperEasySeo\Api\Config
 */
interface LinkSitemapConfigInterface
{
    /**
     * @param null|string $store
     * @return array
     */
    public function getAdditionalLinks($store);

    /**
     * @param null|string $store
     * @return array
     */
    public function getExcludeLinks($store);
}
