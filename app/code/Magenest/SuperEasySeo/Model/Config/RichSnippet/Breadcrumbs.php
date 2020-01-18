<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\RichSnippet;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Breadcrumbs
 * @package Magenest\SuperEasySeo\Helper
 */
class Breadcrumbs
{
    /**
     * XML config path for breadcrumbs setting
     */
    const XML_PATH_ENABLED_BREADCRUMBS = 'super_easy_seo/richsnippet/breadcrumbs/enabled_snippet';

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
     * Check if enabled in the breadcrumbs
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledSnippet($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_BREADCRUMBS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
