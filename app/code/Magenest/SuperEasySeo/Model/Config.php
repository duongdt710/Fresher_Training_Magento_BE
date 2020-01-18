<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 * @package Magenest\SuperEasySeo\Model
 */
class Config
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Model\Context
     */
    protected $context;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Model\Context                   $context
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Model\Context $context
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->context = $context;
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getSitemapUrlWrite($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/url_rewrite',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getMetaTitle($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/meta_title',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }

    /**
     * @param null $store
     * @return mixed
     */

    public function getMetaKeywords($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/meta_keywords',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function geMetaDescription($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/meta_description',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getFrontendSitemapH1($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/sitemap_h1',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getIsShowProducts($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/show_products',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getIsShowStores($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/show_stores',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getFrontendLinksLimit($store = null)
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/frontend/links_limit',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
    }
}
