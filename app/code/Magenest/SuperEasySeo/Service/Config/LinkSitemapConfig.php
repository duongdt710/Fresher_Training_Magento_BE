<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Service\Config;

/**
 * Class LinkSitemapConfig
 * @package Magenest\SuperEasySeo\Service\Config
 */
class LinkSitemapConfig implements \Magenest\SuperEasySeo\Api\Config\LinkSitemapConfigInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param null|string $store
     * @return array
     */
    public function getAdditionalLinks($store = null)
    {
        $conf = $this->scopeConfig->getValue(
            'super_easy_seo/frontend/additional_links',
            \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );
        $links = [];
        $ar = explode("\n", $conf);
        foreach ($ar as $v) {
            $p = explode(',', $v);
            if (isset($p[0]) && isset($p[1])) {
                $links[] = new \Magento\Framework\DataObject([
                    'url' => trim($p[0]),
                    'title' => trim($p[1]),
                ]);
            }
        }

        return $links;
    }

    /**
     * @param null|string $store
     * @return array
     */
    public function getExcludeLinks($store = null)
    {
        $conf = $this->scopeConfig->getValue(
            'super_easy_seo/frontend/exclude_links',
            \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $store
        );

        $links = explode("\n", trim($conf));
        $links = array_map('trim', $links);

        $links = array_diff($links, [0, null]);

        return $links;
    }
}
