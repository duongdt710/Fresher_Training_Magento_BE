<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\RichSnippet;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Website
 * @package Magenest\SuperEasySeo\Model\Config\RichSnippet
 */
class Website
{
    /**
     * XML config setting paths
     */
    const XML_PATH_WEBSITE_ENABLED_SNIPPET           = 'super_easy_seo/richsnippet/website/enabled_snippet';
    const XML_PATH_WEBSITE_ENABLED_GRAPH             = 'super_easy_seo/richsnippet/website/enabled_graph';
    const XML_PATH_WEBSITE_ENABLED_TW                = 'super_easy_seo/richsnippet/website/enabled_tw';
    const XML_PATH_WEBSITE_NAME                      = 'super_easy_seo/richsnippet/website/name';
    const XML_PATH_WEBSITE_ABOUT                     = 'super_easy_seo/richsnippet/website/description';
    const XML_PATH_MAGENTO_WEBSITE_NAME              = 'general/store_information/name';
    const XML_PATH_COMMON_USERNAME_TWITTER           = 'super_easy_seo/richsnippet/common/username_tw';

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
            self::XML_PATH_WEBSITE_ENABLED_SNIPPET,
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
            self::XML_PATH_WEBSITE_ENABLED_GRAPH,
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
            self::XML_PATH_WEBSITE_ENABLED_TW,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getName($storeId = null)
    {
        $storeName = trim($this->scopeConfig->getValue(
            self::XML_PATH_WEBSITE_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));

        if (!$storeName) {
            $storeName = trim($this->scopeConfig->getValue(
                self::XML_PATH_MAGENTO_WEBSITE_NAME,
                ScopeInterface::SCOPE_STORE,
                $storeId
            ));
        }

        return $storeName;
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getAboutInfo($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_WEBSITE_ABOUT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
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
