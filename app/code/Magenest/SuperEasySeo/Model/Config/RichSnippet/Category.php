<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\RichSnippet;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Category
 * @package Magenest\SuperEasySeo\Model\Config\RichSnippet
 */
class Category
{
    /**
     * XML config setting paths
     */
    const XML_PATH_CATEGORY_ENABLED_SNIPPET                 = 'super_easy_seo/richsnippet/category/enabled_snippet';
    const XML_PATH_CATEGORY_ENABLED_GRAPH                   = 'super_easy_seo/richsnippet/category/enabled_graph';
    const XML_PATH_CATEGORY_USE_PRODUCT_OFFERS              = 'super_easy_seo/richsnippet/category/add_product_offers';
    const XML_PATH_CATEGORY_USE_ROBOTS_RESTRICTION          = 'super_easy_seo/richsnippet/category/robots_restriction';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Category constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isEnabledSnippet($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CATEGORY_ENABLED_SNIPPET,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isEnabledGraph($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CATEGORY_ENABLED_GRAPH,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isUseProductOffer($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CATEGORY_USE_PRODUCT_OFFERS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isUseRobotsRestriction($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CATEGORY_USE_ROBOTS_RESTRICTION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
