<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\RichSnippet;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Product
 * @package Magenest\SuperEasySeo\Model\Config\RichSnippet
 */
class Product
{
    /**
     * config setting paths
     */
    const XML_PATH_PRODUCT_ENABLED                  = 'super_easy_seo/richsnippet/product/enabled_snippet';
    const XML_PATH_PRODUCT_GRAPH_ENABLED            = 'super_easy_seo/richsnippet/product/enabled_graph';
    const XML_PATH_PRODUCT_ENABLED_TW               = 'super_easy_seo/richsnippet/product/enabled_tw';
    const XML_PATH_ENABLED_CATEGORY                 = 'super_easy_seo/richsnippet/product/enabled_category';
    const XML_PATH_CATEGORY_DEEPEST                 = 'super_easy_seo/richsnippet/product/category_deepest';
    const XML_PATH_RATING                           = 'super_easy_seo/richsnippet/product/rating';
    const XML_PATH_DESCRIPTION_CODE                 = 'super_easy_seo/richsnippet/product/description_code';
    const XML_PATH_ENABLED_SKU                      = 'super_easy_seo/richsnippet/product/enabled_sku';
    const XML_PATH_SKU_CODE                         = 'super_easy_seo/richsnippet/product/sku_code';
    const XML_PATH_ENABLED_COLOR                    = 'super_easy_seo/richsnippet/product/enabled_color';
    const XML_PATH_COLOR_CODE                       = 'super_easy_seo/richsnippet/product/color_code';
    const XML_PATH_ENABLED_WEIGHT                   = 'super_easy_seo/richsnippet/product/enabled_weight';
    const XML_PATH_WEIGHT_UNIT                      = 'super_easy_seo/richsnippet/product/enabled_weight';
    const XML_PATH_ENABLED_MANUFACTURE              = 'super_easy_seo/richsnippet/product/enabled_manufacturer';
    const XML_PATH_MANUFACTURER_CODE                = 'super_easy_seo/richsnippet/product/manufacturer_code';
    const XML_PATH_ENABLED_MODEL                    = 'super_easy_seo/richsnippet/product/enabled_model';
    const XML_PATH_MODEL_CODE                       = 'super_easy_seo/richsnippet/product/model_code';
    const XML_PATH_ENABLED_GTIN                     = 'super_easy_seo/richsnippet/product/enabled_gtin';
    const XML_PATH_GTIN_CODE                        = 'super_easy_seo/richsnippet/product/gtin_code';
    const XML_PATH_ENABLED_CONDITION                = 'super_easy_seo/richsnippet/product/enabled_condition';
    const XML_PATH_CONDITION_CODE                   = 'super_easy_seo/richsnippet/product/condition_code';
    const XML_PATH_CONDITION_NEW                    = 'super_easy_seo/richsnippet/product/condition_value_new';
    const XML_PATH_CONDITION_REF                    = 'super_easy_seo/richsnippet/product/condition_value_refurbished';
    const XML_PATH_CONDITION_USED                   = 'super_easy_seo/richsnippet/product/condition_value_used';
    const XML_PATH_CONDITION_DAMAGED                = 'super_easy_seo/richsnippet/product/condition_value_damaged';
    const XML_PATH_CONDITION_DEFAULT                = 'super_easy_seo/richsnippet/product/condition_value_default';
    const XML_PATH_ENABLED_CUSTOM_PROPERTIES        = 'super_easy_seo/richsnippet/product/enabled_custom_prorerty';
    const XML_PATH_CUSTOM_PROPERTIES                = 'super_easy_seo/richsnippet/product/custom_prorerties';
    const XML_PATH_COMMON_USERNAME_TWITTER          = 'super_easy_seo/richsnippet/common/username_tw';


    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Directory\Helper\Data
     */
    protected $helperDirectoryData;

    /**
     * Product constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Directory\Helper\Data $helperDirectoryData
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Directory\Helper\Data $helperDirectoryData
    ) {
        $this->helperDirectoryData = $helperDirectoryData;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * enabled in the rich snippets
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledSnippet($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_PRODUCT_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled open graph
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledGraph($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_PRODUCT_GRAPH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled open tw
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledTw($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_PRODUCT_ENABLED_TW,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    /**
     * enabled category
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledCategory($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_CATEGORY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * use deepest category
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isDeepestCateogry($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CATEGORY_DEEPEST,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled condition
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledCondition($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_CONDITION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * description code
     *
     * @param int|null $storeId
     * @return string
     */
    public function getDescriptionCode($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DESCRIPTION_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled sku
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledSku($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_SKU,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * sku code
     *
     * @param int|null $storeId
     * @return string
     */
    public function getSkuCode($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SKU_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * rating number
     *
     * @param int|null $storeId
     * @return int
     */
    public function getRating($storeId = null)
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PATH_RATING,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * condition code
     *
     * @param int|null $storeId
     * @return string
     */
    public function getConditionCode($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CONDITION_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * condition value for new item
     *
     * @param int|null $storeId
     * @return string
     */
    public function getConditionValueForNew($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CONDITION_NEW,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * condition value for refurbished item
     *
     * @param int|null $storeId
     * @return string
     */
    public function getConditionValueForRefurbished($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CONDITION_REF,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * condition value for damaged item
     *
     * @param int|null $storeId
     * @return string
     */
    public function getConditionValueForDamaged($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CONDITION_DAMAGED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * condition value for used item
     *
     * @param int|null $storeId
     * @return string
     */
    public function getConditionValueForUsed($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CONDITION_USED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * condition value for used item
     *
     * @param int|null $storeId
     * @return string
     */
    public function getConditionDefaultValue($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CONDITION_DEFAULT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled color
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledColor($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_COLOR,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * color code
     *
     * @param int|null $storeId
     * @return string
     */
    public function getColorCode($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_COLOR_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled manufacturer
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledManufacturer($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_MANUFACTURE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * manufacturer code
     *
     * @param int|null $storeId
     * @return string
     */
    public function getManufacturerCode($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_MANUFACTURER_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled model
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledModel($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_MODEL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * model code
     *
     * @param int|null $storeId
     * @return string
     */
    public function getModelCode($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_MODEL_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled gtin
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledGtin($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_GTIN,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * gtin code
     *
     * @param int|null $storeId
     * @return string
     */
    public function getGtinCode($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_GTIN_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * enabled weight
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledWeight($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_WEIGHT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * weight unit
     *
     * @param int|null $storeId
     * @return string
     */
    public function getWeightUnit($storeId = null)
    {
        return $this->helperDirectoryData->getWeightUnit($storeId);
    }

    /**
     * enabled custom properties
     *
     * @param int|null $storeId
     * @return boolean
     */
    public function isEnabledCustomProperties($storeId = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_CUSTOM_PROPERTIES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * return string custom properties
     * @param int|null $storeId
     * @return array
     */
    public function getCustomProperties($storeId = null)
    {
        if (!$this->isEnabledCustomProperties($storeId)) {
            return [];
        }

        $rawString = $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOM_PROPERTIES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        $string = trim($rawString);
        $pairArray = array_filter(preg_split('/\r?\n/', $string));
        $pairArray = array_filter(array_map('trim', $pairArray));

        $ret = [];
        foreach ($pairArray as $pair) {
            $pair = trim($pair, ',');
            $explode = explode(',', $pair);
            if (is_array($explode) && count($explode) >= 2) {
                $key = trim($explode[0]);
                $val = trim($explode[1]);
                if ($key && $val) {
                    $ret[$key] = $val;
                }
            }
        }

        return $ret;
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
