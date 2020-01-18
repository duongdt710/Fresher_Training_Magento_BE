<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Block\RichSnippet\Json;

/**
 * Class Product
 * @package Magenest\SuperEasySeo\Block\RichSnippet\Json
 */
class Product extends \Magenest\SuperEasySeo\Block\RichSnippet\AbstractJson
{
    const IN_STOCK = 'http://schema.org/InStock';
    const OUT_OF_STOCK = 'http://schema.org/OutOfStock';
    const OFFER = 'http://schema.org/Offer';

    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Product
     */
    protected $configProduct;

    /**
     * @var \Magenest\SuperEasySeo\Helper\RichSnippet\Product
     */
    protected $renderProduct;

    /**
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var
     */
    protected $_product;

    /**
     * Product constructor.
     * @param \Magento\Framework\Registry $registry
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Product $configProduct
     * @param \Magenest\SuperEasySeo\Helper\RichSnippet\Product $renderProduct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Product $configProduct,
        \Magenest\SuperEasySeo\Helper\RichSnippet\Product $renderProduct,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        $this->registry = $registry;
        $this->configProduct = $configProduct;
        $this->renderProduct = $renderProduct;
        parent::__construct($context, $data);
    }

    /**
     *
     * {@inheritDoc}
     */
    protected function getMarkupHtml()
    {
        $html = '';

        if (!$this->configProduct->isEnabledSnippet()) {
            return $html;
        }

        $productJsonData = $this->getJsonProductData();
        $productJson = $productJsonData ? json_encode($productJsonData) : '';

        if ($productJsonData) {
            $html .= '<script type="application/ld+json">' . $productJson . '</script>';
        }

        return $html;
    }

    /**
     *
     * @return array
     */
    protected function getJsonProductData()
    {
        $product = $this->registry->registry('current_product');

        if (!$product) {
            return [];
        }

        $this->_product = $product;

        $data = [];
        $data['@context'] = 'http://schema.org';
        $data['@type'] = 'Product';
        $data['name'] = $this->_product->getName();
        $data['description'] = $this->renderProduct->getDescriptionValue($this->_product);

        $data['image'] = $this->renderProduct->getProductImageUrl($this->_product);
        $data['offers'] = $this->getOfferData();

        if (!$data['offers']['price']) {
            return false;
        }
        $aggregateRatingData = $this->renderProduct->getAggregateRatingData($this->_product, false);
        if (!empty($aggregateRatingData)) {
            $aggregateRatingData['@type'] = 'AggregateRating';
            $data['aggregateRating'] = $aggregateRatingData;
        }

        $color = $this->renderProduct->getColorValue($this->_product);
        if ($color) {
            $data['color'] = $color;
        }


        $manufacturer = $this->renderProduct->getManufacturerValue($this->_product);

        if ($manufacturer) {
            $data['manufacturer'] = $manufacturer;
        }

        $reviewCollection = $this->renderProduct->getReviewValue($this->_product);
        if ($reviewCollection) {
            $data['review'] = $reviewCollection;
        }

        $model = $this->renderProduct->getModelValue($this->_product);
        if ($model) {
            $data['model'] = $model;
        }

        $gtin = $this->renderProduct->getGtinData($this->_product);
        if (!empty($gtin['gtinType']) && !empty($gtin['gtinValue'])) {
            $data[$gtin['gtinType']] = $gtin['gtinValue'];
        }

        $skuValue = $this->renderProduct->getSkuValue($this->_product);
        if ($skuValue) {
            $data['sku'] = $skuValue;
        }

        $brandValue = $this->renderProduct->getBrand($this->_product);
        if (isset($brandValue)) {
            $data['brand'] = $brandValue;
        }

        $weightValue = $this->renderProduct->getWeightValue($this->_product);
        if ($weightValue) {
            $data['weight'] = $weightValue;
        }

        $categoryName = $this->renderProduct->getCategoryValue($this->_product);
        if ($categoryName) {
            $data['category'] = $categoryName;
        }

        $customProperties = $this->configProduct->getCustomProperties();
        if ($customProperties) {
            foreach ($customProperties as $propertyName => $propertyValue) {
                if (!$propertyName || !$propertyValue) {
                    continue;
                }
                $value = $this->renderProduct->getCustomPropertyValue($product, $propertyValue);

                if ($value) {
                    $data[$propertyName] = $value;
                }
            }
        }

        return $data;
    }

    /**
     *
     * @return array
     */
    protected function getOfferData()
    {
        $data = [];
        $data['@type'] = self::OFFER;
        $data['price'] = $this->_product->getFinalPrice();
        $data['priceCurrency'] = $this->renderProduct->getCurrentCurrencyCode();
        $data['priceValidUntil'] = '10/10/2019';

        if ($this->renderProduct->getAvailability($this->_product)) {
            $data['availability'] = self::IN_STOCK;
        } else {
            $data['availability'] = self::OUT_OF_STOCK;
        }

        $condition = $this->renderProduct->getConditionValue($this->_product);
        if ($condition) {
            $data['itemCondition'] = $condition;
        }

        return $data;
    }
}
