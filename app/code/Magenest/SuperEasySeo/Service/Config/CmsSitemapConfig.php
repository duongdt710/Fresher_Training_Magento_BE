<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Service\Config;

/**
 * Class CmsSitemapConfig
 * @package Magenest\SuperEasySeo\Service\Config
 */
class CmsSitemapConfig implements \Magenest\SuperEasySeo\Api\Config\CmsSitemapConfigInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * CmsSitemapConfig constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param null|string $store
     * @return bool|int
     */
    public function getIsShowCmsPages($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/is_show_cms_pages',
            \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }

    /**
     * @param null|string $store
     * @return array
     */
    public function getIgnoreCmsPages($store = null)
    {
        $value = $this->scopeConfig->getValue(
            'super_easy_seo/frontend/ignore_cms_pages',
            \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );

        return explode(',', $value);
    }
}
