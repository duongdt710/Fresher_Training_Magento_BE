<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork;

/**
 * Class Product
 * @package Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork
 */
class Product extends \Magenest\SuperEasySeo\Block\RichSnippet\AbstractSocialNetwork
{
    const IN_STOCK     = 'instock';
    const OUT_OF_STOCK = 'oos';

    /**
     * @var \Magenest\SuperEasySeo\Helper\RichSnippet\Product
     */
    protected $renderProduct;

    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Product
     */
    protected $configProduct;

    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website
     */
    protected $configWebsite;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Product constructor.
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Product $configProduct
     * @param \Magenest\SuperEasySeo\Helper\RichSnippet\Product $renderProduct
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website $configWebsite
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Product $configProduct,
        \Magenest\SuperEasySeo\Helper\RichSnippet\Product $renderProduct,
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website $configWebsite,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data
    ) {
        $this->configProduct      = $configProduct;
        $this->renderProduct = $renderProduct;
        $this->configWebsite      = $configWebsite;
        $this->registry           = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function getMarkupHtml()
    {
        if (!$this->configProduct->isEnabledGraph() && !$this->configProduct->isEnabledTw()) {
            return '';
        }

        return $this->getSocialProductInfo();
    }

    /**
     * @return string
     */
    protected function getSocialProductInfo()
    {
        $product = $this->registry->registry('current_product');

        if (!is_object($product)) {
            return '';
        }

        $html = '';

        if ($this->configProduct->isEnabledGraph()) {
            $siteName     = $this->escapeHtml($this->configWebsite->getName());
            $url          = $this->escapeHtml($this->renderProduct->getProductCanonicalUrl($product));
            $descr        = $this->escapeHtml($this->renderProduct->getDescriptionValue($product));
            $title        = $this->escapeHtml($product->getName());
            $color        = $this->escapeHtml($this->renderProduct->getColorValue($product));
            $categoryName = $this->escapeHtml($this->renderProduct->getCategoryValue($product));


            $weightString = $this->renderProduct->getWeightValue($product);
            $weightSep    = strpos($weightString, ' ');

            if ($weightSep !== false) {
                $weightValue  = substr($weightString, 0, $weightSep);
                $weightUnits  = $this->convertWeightUnits(substr($weightString, $weightSep + 1));
            }

            $price        = $product->getFinalPrice();
            $currency     = strtoupper($this->renderProduct->getCurrentCurrencyCode());
            $availability = $this->getAvailability($product);
            $condition    = $this->getCondition($product);

            $html .= "\n";
            $html .= "<meta property=\"og:type\" content=\"product\"/>\n";
            $html .= "<meta property=\"og:title\" content=\"" . $title . "\"/>\n";
            $html .= "<meta property=\"og:description\" content=\"" . $descr . "\"/>\n";
            $html .= "<meta property=\"og:url\" content=\"" . $url . "\"/>\n";

            if (!empty($price)) {
                $html .= "<meta property=\"product:price:amount\" content=\"" . $price . "\"/>\n";

                if ($currency) {
                    $html .= "<meta property=\"product:price:currency\" content=\"" . $currency . "\"/>\n";
                }
            }

            $html .= "<meta property=\"og:image\" content=\"" . $this->renderProduct->getProductImageUrl($product) . "\"/>\n";

            if ($color) {
                $html .= "<meta property=\"og:color\" content=\"" . $color . "\"/>\n";
            }

            if ($siteName) {
                $html .= "<meta property=\"og:site_name\" content=\"" . $siteName . "\"/>\n";
            }

            if (!empty($weightValue) && !empty($weightUnits)) {
                $html .= "<meta property=\"product:weight:value\" content=\"" . $weightValue . "\"/>\n";
                $html .= "<meta property=\"product:weight:units\" content=\"" . $weightUnits . "\"/>\n";
            }

            if ($categoryName) {
                $html .= "<meta property=\"og:category\" content=\"" . $categoryName . "\"/>\n";
            }

            $html .= "<meta property=\"og:availability\" content=\"" . $availability . "\"/>\n";

            if ($condition) {
                $html .= "<meta property=\"og:condition\" content=\"" . $condition . "\"/>\n";
            }
        }

        if ($this->configProduct->isEnabledTw()) {
            $twitterUsername = $this->configProduct->getTwUsername();
            if ($twitterUsername) {
                $html = $html ? $html : "\n";
                $html .= "<meta property=\"twitter:site\" content=\"" . $twitterUsername . "\"/>\n";
                $html .= "<meta property=\"twitter:creator\" content=\"" . $twitterUsername . "\"/>\n";
                $html .= "<meta property=\"twitter:card\" content=\"product\"/>\n";
                $html .= "<meta property=\"twitter:title\" content=\"" . $title . "\"/>\n";
                $html .= "<meta property=\"twitter:description\" content=\"" . $descr . "\"/>\n";
                $html .= "<meta property=\"twitter:url\" content=\"" . $url . "\"/>\n";

                if (!empty($price)) {
                    $html .= "<meta property=\"twitter:label1\" content=\"Price\"/>\n";
                    $html .= "<meta property=\"twitter:data1\" content=\"" . $price . "\"/>\n";
                }

                $html .= "<meta property=\"twitter:label2\" content=\"Availability\"/>\n";
                $html .= "<meta property=\"twitter:data2\" content=\"" . $availability . "\"/>\n";
            }
        }

        return $html;
    }

    /**
     * @param $product
     * @return mixed|string
     */
    protected function getCondition($product)
    {
        $condition = $this->renderProduct->getConditionValue($product);
        if ($condition) {
            $ogEnum = [
                'NewCondition'         => 'new',
                'UsedCondition'        => 'used',
                'RefurbishedCondition' => 'refurbished',
                'DamagedCondition'     => 'used'
            ];
            if (!empty($ogEnum[$condition])) {
                return $ogEnum[$condition];
            }
        }
        return '';
    }

    /**
     * @param $product
     * @return string
     */
    protected function getAvailability($product)
    {
        if ($this->renderProduct->getAvailability($product)) {
            return self::IN_STOCK;
        }
        return self::OUT_OF_STOCK;
    }

    /**
     *
     * @param string $value
     * @return string
     */
    protected function convertWeightUnits($value)
    {
        if (strtolower($value) == 'lbs') {
            return 'lb';
        }
    }
}
