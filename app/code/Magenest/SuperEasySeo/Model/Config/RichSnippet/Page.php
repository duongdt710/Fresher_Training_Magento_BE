<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\RichSnippet;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Page
 * @package Magenest\SuperEasySeo\Model\Config\RichSnippet
 */
class Page
{
    /*
     * XML config setting paths
     */
    const XML_PATH_PAGE_ENABLED_GRAPH               = 'super_easy_seo/richsnippet/page/enabled_graph';
    const XML_PATH_PAGE_ENABLED_TW                  = 'super_easy_seo/richsnippet/page/enabled_tw';
    const XML_PATH_COMMON_USERNAME_TWITTER          = 'super_easy_seo/richsnippet/common/username_tw';

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
    public function isEnabledGraph($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_PAGE_ENABLED_GRAPH,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isEnabledTw($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_PAGE_ENABLED_TW,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Retrieve twitter username
     *
     * @param int|null $storeId
     * @return string
     */
    public function getTwUsername($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_COMMON_USERNAME_TWITTER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
