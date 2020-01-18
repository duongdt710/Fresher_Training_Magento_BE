<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Model\Config\RichSnippet;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Seller
 * @package Magenest\SuperEasySeo\Model\Config\RichSnippet
 */
class Seller
{
    /**
     * XML config setting paths
     */
    const XML_PATH_SELLER_ENABLED = 'super_easy_seo/richsnippet/seller/enabled_snippet';
    const XML_PATH_SELLER_TYPE = 'super_easy_seo/richsnippet/seller/type';
    const XML_PATH_SELLER_NAME = 'super_easy_seo/richsnippet/seller/name';
    const XML_PATH_SELLER_DESCRIPTION = 'super_easy_seo/richsnippet/seller/description';
    const XML_PATH_SELLER_PHONE = 'super_easy_seo/richsnippet/seller/phone';
    const XML_PATH_SELLER_FAX = 'super_easy_seo/richsnippet/seller/fax';
    const XML_PATH_SELLER_EMAIL = 'super_easy_seo/richsnippet/seller/email';
    const XML_PATH_SELLER_LOCATION = 'super_easy_seo/richsnippet/seller/location';
    const XML_PATH_SELLER_REGION = 'super_easy_seo/richsnippet/seller/region';
    const XML_PATH_SELLER_STREET = 'super_easy_seo/richsnippet/seller/street';
    const XML_PATH_SELLER_POST_CODE = 'super_easy_seo/richsnippet/seller/postcode';
    const XML_PATH_SAME_AS_LINKS = 'super_easy_seo/richsnippet/seller/same_as_links';
    const XML_PATH_SELLER_PRICE_RANGE = 'super_easy_seo/richsnippet/seller/price_range';
    const XML_PATH_SELLER_IMAGE = 'super_easy_seo/richsnippet/seller/upload_image_id';

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
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param null $storeId
     * @return bool
     */
    public function isEnabledSnippet($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_SELLER_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getType($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_TYPE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getName($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getDescription($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_DESCRIPTION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getPhone($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_PHONE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getFax($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_FAX,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getEmail($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_EMAIL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getPriceRange($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_PRICE_RANGE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getImage($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_IMAGE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getLocation($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_LOCATION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getRegionAddress($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_REGION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getStreetAddress($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_STREET,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getPostCode($storeId = null)
    {
        return trim($this->scopeConfig->getValue(
            self::XML_PATH_SELLER_POST_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
    }

    /**
     * @param null $storeId
     * @return array
     */
    public function getSameAsLinks($storeId = null)
    {
        $linksString = $this->scopeConfig->getValue(
            self::XML_PATH_SAME_AS_LINKS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        $linksArray = array_filter(preg_split('/\r?\n/', $linksString));
        $linksArray = array_map('trim', $linksArray);

        return array_filter($linksArray);
    }
}
