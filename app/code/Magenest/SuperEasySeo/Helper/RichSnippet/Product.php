<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Helper\RichSnippet;

use Magenest\SuperEasySeo\Model\Brand;
use Magento\Review\Model\Review;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory as ReviewCollection;
use Magento\Review\Model\ReviewFactory;

/**
 * Class Product
 * @package Magenest\SuperEasySeo\Helper\RichSnippet
 */
class Product extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var
     */
    protected $configProduct;

    /**
     * @var \Magento\Catalog\Block\Product\ImageBuilder
     */
    protected $imageBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category
     */
    protected $resourceCategory;

    /**
     * @var \Magento\Review\Model\ReviewFactory
     */
    protected $reviewFactory;

    /**
     *
     * @var array|null
     */
    protected $ratingData;

    /**
     *
     * @var null|string
     */
    protected $categoryName;

    /**
     * @var array
     */
    protected $attributeValues = [];

    /**
     * @var
     */
    protected $conditionValue;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var ReviewCollection
     */
    protected $_reviewCollection;

    /**
     * Product constructor.
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Product $configProduct
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Model\ResourceModel\Category $resourceCategory
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param \Magento\Framework\App\Helper\Context $context
     * @param ReviewCollection $_reviewCollection
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Product $configProduct,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ResourceModel\Category $resourceCategory,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Framework\App\Helper\Context $context,
        \Magenest\SuperEasySeo\Model\Brand $brand,
        ReviewCollection $_reviewCollection
    )
    {
        $this->_reviewCollection = $_reviewCollection;
        $this->brand = $brand;
        $this->configProduct = $configProduct;
        $this->storeManager = $storeManager;
        $this->imageBuilder = $imageBuilder;
        $this->registry = $registry;
        $this->resourceCategory = $resourceCategory;
        $this->reviewFactory = $reviewFactory;
        parent::__construct($context);
    }

    /**
     *
     * @return string
     */
    public function getCurrentCurrencyCode()
    {
        return $this->storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    /**
     * @param $product
     * @return array|string
     */
    public function getDescriptionValue($product)
    {
        $attributeCode = $this->configProduct->getDescriptionCode();

        if ($attributeCode) {
            $description = $this->getAttributeValueByCode($product, $attributeCode);
            return $description;
        }

        return $product->getShortDescription();
    }

    /**
     * Retrieve attribute value by attribute code
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $attributeCode
     * @return string|array
     */
    public function getAttributeValueByCode($product, $attributeCode)
    {
        if (array_key_exists($attributeCode, $this->attributeValues)) {
            return $this->attributeValues[$attributeCode];
        }

        $tempValue = '';
        $value = $product->getData($attributeCode);

        if ($attribute = $product->getResource()->getAttribute($attributeCode)) {
            $attribute->setStoreId($product->getStoreId());
            $tempValue = $attribute->setStoreId($product->getStoreId())->getSource()->getOptionText($product->getData($attributeCode));
        }
        if ($tempValue) {
            $value = $tempValue;
        }
        if (!$value) {
            if ($product->getTypeId() == 'configurable') {
                $productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);

                $attributeOptions = [];
                foreach ($productAttributeOptions as $productAttribute) {
                    if ($productAttribute['attribute_code'] != $attributeCode) {
                        continue;
                    }
                    foreach ($productAttribute['values'] as $attribute) {
                        $attributeOptions[] = $attribute['store_label'];
                    }
                }
                if (count($attributeOptions) == 1) {
                    $value = array_shift($attributeOptions);
                }
            } else {
                $value = $product->getData($attributeCode);
            }
        }

        $finalValue = is_array($value) ? array_map('trim', array_filter($value)) : trim($value);

        $this->attributeValues[$attributeCode] = $finalValue;

        return $finalValue;
    }

    /**
     * @param $product
     * @return array|bool|string
     */
    public function getConditionValue($product)
    {
        if (!is_null($this->conditionValue)) {
            return $this->conditionValue;
        }

        $attributeCode = $this->configProduct->getConditionCode();
        $conditionByDefault = $this->configProduct->getConditionDefaultValue();

        if ($attributeCode) {
            $conditionValue = $this->getAttributeValueByCode($product, $attributeCode);

            switch ($conditionValue) {
                case $this->configProduct->getConditionValueForNew():
                    $conditionValue = "NewCondition";
                    break;
                case $this->configProduct->getConditionValueForUsed():
                    $conditionValue = "UsedCondition";
                    break;
                case $this->configProduct->getConditionValueForRefurbished():
                    $conditionValue = "RefurbishedCondition";
                    break;
                case $this->configProduct->getConditionValueForDamaged():
                    $conditionValue = "DamagedCondition";
                    break;
                default:
                    if ($conditionByDefault) {
                        $conditionValue = $conditionByDefault;
                    }
                    break;
            }
        } elseif ($conditionByDefault) {
            $conditionValue = $conditionByDefault;
        }

        $conditionValue = !empty($conditionValue) ? $conditionValue : false;
        $this->conditionValue = $conditionValue;

        return $this->conditionValue;
    }

    /**
     * @return string
     * @todo Retrive product canonical URL from SeoBase or Magento Canonical URL.
     */
    public function getProductCanonicalUrl($product)
    {
        if (!empty($this->productCanonicalUrl)) {
            return $this->productCanonicalUrl;
        }
        $this->productCanonicalUrl = $product->getUrlModel()->getUrl($product, ['_ignore_category' => true]);
        return $this->productCanonicalUrl;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param boolean $useMagentoBestRating
     * @return array
     */
    public function getAggregateRatingData($product, $useMagentoBestRating = true)
    {
        if (!is_null($this->ratingData)) {
            return $this->ratingData;
        }
        if (!$product->getRatingSummary()) {
            $this->reviewFactory->create()->getEntitySummary($product, $this->storeManager->getStore()->getId());
        }

        $reviewDataObject = $product->getRatingSummary();

        if (!is_object($reviewDataObject) || (is_object($reviewDataObject) && !$reviewDataObject->getData())) {
            $this->ratingData = [];
            return $this->ratingData;
        }
        $reviewData = $reviewDataObject->getData();
        if (empty($reviewData['reviews_count'])) {
            $this->ratingData = [];
            return $this->ratingData;
        }

        $reviewCount = $reviewData['reviews_count'];
        $reviewRating = $reviewData['rating_summary'];
        $data = [];

        if ($this->configProduct->getRating() && !$useMagentoBestRating) {
            $bestRating = $this->configProduct->getRating();
            $rating = round(($reviewRating / (100 / $bestRating)), 1);
        } else {
            $bestRating = 100;
            $rating = $reviewRating;
        }

        $data['ratingValue'] = $rating;
        $data['reviewCount'] = $reviewCount;
        $data['bestRating'] = $bestRating;
        $data['worstRating'] = 0;

        $this->ratingData = $data;
        return $this->ratingData;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getColorValue($product)
    {
        if ($this->configProduct->isEnabledColor()) {
            $attributeCode = $this->configProduct->getColorCode();
            if ($attributeCode) {
                return $this->getAttributeValueByCode($product, $attributeCode);
            }
        }
        return null;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getManufacturerValue($product)
    {
        if ($this->configProduct->isEnabledManufacturer()) {
            $attributeCode = $this->configProduct->getManufacturerCode();
            if ($attributeCode) {
                $text = $this->getAttributeValueByCode($product, $attributeCode);
                if ($text && !empty($text)) {
                    return $text;
                } else {
                    return $product->getAttributeText('country_of_manufacture');
                }
            }
        }
        return null;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getModelValue($product)
    {
        if ($this->configProduct->isEnabledModel()) {
            $attributeCode = $this->configProduct->getModelCode();
            if ($attributeCode) {
                return $this->getAttributeValueByCode($product, $attributeCode);
            }
        }
        return null;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getGtinData($product)
    {
        if ($this->configProduct->isEnabledGtin()) {
            $attributeCode = $this->configProduct->getGtinCode();
            if (!$attributeCode) {
                return null;
            }

            $gtinValue = $this->getAttributeValueByCode($product, $attributeCode);
            if (preg_match('/^[0-9]+$/', $gtinValue)) {
                if (strlen($gtinValue) == 8) {
                    $gtinType = 'gtin8';
                } elseif (strlen($gtinValue) == 12) {
                    $gtinValue = '0' . $gtinValue;
                    $gtinType = 'gtin13';
                } elseif (strlen($gtinValue) == 13) {
                    $gtinType = 'gtin13';
                } elseif (strlen($gtinValue) == 14) {
                    $gtinType = 'gtin14';
                }
            }
        }

        return !empty($gtinType) ? ['gtinType' => $gtinType, 'gtinValue' => $gtinValue] : null;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getSkuValue($product)
    {
        if ($this->configProduct->isEnabledSku()) {
            $attributeCode = $this->configProduct->getSkuCode();
            if ($attributeCode) {
                $sku = $this->getAttributeValueByCode($product, $attributeCode);
            } else {
                $sku = $product->getSku();
            }
            return $sku;
        }
        return null;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getBrand($product)
    {
        if (isset($product->getData()['brand_id']))
            if ($product->getData()['brand_id'] != null) {
                $brandValue = $this->brand->load($product->getData()['brand_id']);
                return $brandValue['brand_name'];
            } else {
                return "No Brand";
            }
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @return array
     */
    public function getReviewValue($product)
    {
        $reviewCollection = $this->_reviewCollection->create()
            ->addStatusFilter(
                Review::STATUS_APPROVED
            )->addEntityFilter(
                'product',
                $product->getId()
            )->setDateOrder();
        $i = 0;
        $listReview = [];
        foreach ($reviewCollection->getData() as $reviews) {
            $listReview[$i] = [
                "datePublished" => $reviews["created_at"],
                "description" => $reviews["detail"],
                "author" => $reviews["nickname"],
            ];
            $i++;
        }
        return $listReview;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getWeightValue($product)
    {
        if ($this->configProduct->isEnabledWeight()) {
            $weightValue = $product->getWeight();

            if ($weightValue) {
                $weightUnit = $this->configProduct->getWeightUnit();
                return $weightValue . ' ' . $weightUnit;
            }
        }
        return null;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $propertyName
     * @return string
     */
    public function getCustomPropertyValue($product, $propertyName)
    {
        $customProperty = $this->getAttributeValueByCode($product, $propertyName);
        return $customProperty ? $customProperty : null;
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getCategoryValue($product)
    {
        if (!$this->configProduct->isEnabledCategory()) {
            return null;
        }

        if (!is_null($this->categoryName)) {
            return $this->categoryName;
        }

        $categories = $product->getCategoryCollection()->exportToArray();
        $currentCategory = $this->registry->registry('current_category');
        $useDeepestCategory = $this->configProduct->isDeepestCateogry();

        if (is_object($currentCategory)) {
            if (!count($categories)) {
                $this->categoryName = $currentCategory->getName();
                return $this->categoryName;
            }

            if ($useDeepestCategory) {
                $currentId = $currentCategory->getId();
                $currentLevel = $currentCategory->getLevel();
                if (!is_numeric($currentLevel)) {
                    $this->categoryName = $currentCategory->getName();
                    return $this->categoryName;
                }

                foreach ($categories as $category) {
                    if ($category['level'] > $currentLevel) {
                        $currentId = $category['entity_id'];
                        $currentLevel = $category['level'];
                    }
                }
                if ($currentId != $currentCategory->getId()) {
                    $categoryName = $this->getCategoryNameById($currentId);
                }
            }
            if (empty($categoryName)) {
                $this->categoryName = $currentCategory->getName();
            }
        } else {
            if (!$useDeepestCategory || !count($categories)) {
                $this->categoryName = '';
                return $this->categoryName;
            }

            $currentId = 0;
            $currentLevel = 0;
            if (is_numeric($currentLevel)) {
                foreach ($categories as $category) {
                    if ($category['level'] >= $currentLevel) {
                        $currentId = $category['entity_id'];
                        $currentLevel = $category['level'];
                    }
                }
                if ($currentId) {
                    $this->categoryName = $this->getCategoryNameById($currentId);
                }
            }
        }

        return $this->categoryName;
    }

    /**
     * @param \Magento\Catalog\Model\Product
     * @return string
     */
    public function getProductImageUrl($product, $imageId = 'product_base_image')
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes([])
            ->create()
            ->getImageUrl();
    }

    /**
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return boolean
     */
    public function getAvailability($product)
    {
        return $product->isAvailable();
    }

    /**
     *
     * @param int $id
     * @return string
     */
    protected function getCategoryNameById($id)
    {
        if ($id) {
            $storeId = $this->storeManager->getStore()->getId();

            return $this->resourceCategory->getAttributeRawValue(
                $id,
                'name',
                $this->storeManager->getStore($storeId)
            );
        }
        return '';
    }
}
