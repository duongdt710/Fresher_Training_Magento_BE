<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\Json;

/**
 * Class Category
 * @package Magenest\SuperEasySeo\Block\RichSnippet\Json
 */
class Category extends \Magenest\SuperEasySeo\Block\RichSnippet\AbstractJson
{
    /**
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Category
     */
    protected $configCategory;


    /**
     * @var \Magenest\SuperEasySeo\Helper\RichSnippet\Product
     */
    protected $renderProduct;

    /**
     * Category constructor.
     * @param \Magento\Framework\Registry $registry
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Category $configCategory
     * @param \Magenest\SuperEasySeo\Helper\RichSnippet\Product $renderProduct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Category $configCategory,
        \Magenest\SuperEasySeo\Helper\RichSnippet\Product $renderProduct,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->registry                   = $registry;
        $this->configCategory             = $configCategory;
        $this->renderProduct  = $renderProduct;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function getMarkupHtml()
    {
        $html = '';

        if (!$this->configCategory->isEnabledSnippet()) {
            return $html;
        }

        if ($this->configCategory->isUseProductOffer() && $this->isNoindexPage()) {
            return $html;
        }

        $categoryJsonData = $this->getJsonCategoryData();
        $categoryJson     = $categoryJsonData  ? json_encode($categoryJsonData) : '';

        if ($categoryJsonData) {
            $html .= '<script type="application/ld+json">' . $categoryJson . '</script>';
        }

        return $html;
    }

    protected function getJsonCategoryData()
    {
        $category = $this->registry->registry('current_category');
        if (!is_object($category)) {
            return false;
        }

        $productCollection = $this->getProductCollection();

        $data = [];
        $data['@context']    = 'http://schema.org';
        $data['@type']       = 'WebPage';
        $data['url']         = $this->_urlBuilder->getCurrentUrl();
        $data['mainEntity']                    = [];
        $data['mainEntity']['@context']        = 'http://schema.org';
        $data['mainEntity']['@type']           = 'ItemList';
        $data['mainEntity']['name']            = $category->getName();
        $data['mainEntity']['url']             = $this->_urlBuilder->getCurrentUrl();
        $data['mainEntity']['numberOfItems']   = count($productCollection->getItems());
        $data['mainEntity']['itemListElement'] = [];

        foreach ($productCollection as $product) {
            $data['mainEntity']['itemListElement'][] = $this->getProductData($product);
        }

        return $data;
    }

    /**
     * @param $product
     * @return array
     */
    protected function getProductData($product)
    {
        $data = [];
        $data['@type']    = "Product";
        $data['url']      = $product->getUrlModel()->getUrl($product, ['_ignore_category' => true]);
        $data['name']     = $product->getName();
        $data['image'] = $this->renderProduct->getProductImageUrl($product);

        if ($this->configCategory->isUseProductOffer()) {
            $offerData        = $this->getOfferData($product);
            if (!empty($offerData['price'])) {
                $data['offers'] = $offerData;
            }
        }

        return $data;
    }

    /**
     * @param $product
     * @return array
     */
    protected function getOfferData($product)
    {
        $data          = [];
        $data['@type'] = \Magenest\SuperEasySeo\Block\RichSnippet\Json\Product::OFFER;
        $data['price'] = $product->getFinalPrice();
        $data['priceCurrency'] = $this->renderProduct->getCurrentCurrencyCode();


        if ($this->renderProduct->getAvailability($product)) {
            $data['availability'] = \Magenest\SuperEasySeo\Block\RichSnippet\Json\Product::IN_STOCK;
        } else {
            $data['availability'] = \Magenest\SuperEasySeo\Block\RichSnippet\Json\Product::OUT_OF_STOCK;
        }

        $condition = $this->renderProduct->getConditionValue($product);
        if ($condition) {
            $data['itemCondition'] = $condition;
        }

        return $data;
    }

    /**
     * @return \Magento\Eav\Model\Entity\Collection\AbstractCollection|null
     */
    protected function getProductCollection()
    {
        $productList = $this->_layout->getBlock('category.products.list');

        if (is_object($productList) && ($productList instanceof \Magento\Catalog\Block\Product\ListProduct)) {
            return $productList->getLoadedProductCollection();
        }

        $pager = $this->_layout->getBlock('product_list_toolbar_pager');
        if (!is_object($pager)) {
            $pager = $this->getPagerFromToolbar();
        } elseif (!$pager->getCollection()) {
            $pager = $this->getPagerFromToolbar();
        }

        if (!is_object($pager)) {
            return null;
        }

        return $pager->getCollection();
    }

    /**
     * @return null
     */
    protected function getPagerFromToolbar()
    {
        $toolbar = $this->_layout->getBlock('product_list_toolbar');
        if (is_object($toolbar)) {
            $pager = $toolbar->getChild('product_list_toolbar_pager');
        }

        return is_object($pager) ? $pager : null;
    }

    /**
     * @return bool
     */
    protected function isNoindexPage()
    {
        $robots = $this->pageConfig->getRobots();

        if ($robots && stripos($robots, 'noindex') !== false) {
            return true;
        }

        return false;
    }
}
