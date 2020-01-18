<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magenest\SuperEasySeo\Helper\RichSnippet\Product;

/**
 * Class RenderTemplateRule
 * @package Magenest\SuperEasySeo\Helper
 */
class RenderTemplateRule extends AbstractHelper
{
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManage;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var Product
     */
    protected $attributeProduct;

    /**
     * RenderTemplateRule constructor.
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param CategoryFactory $categoryFactory
     * @param StoreManagerInterface $storeManagerInterface
     * @param Product $attributeProduct
     */
    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        CategoryFactory $categoryFactory,
        StoreManagerInterface $storeManagerInterface,
        Product $attributeProduct
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->categoryFactory = $categoryFactory;
        $this->storeManage = $storeManagerInterface;
        $this->attributeProduct = $attributeProduct;
    }

    /**
     * Generate code
     *
     * @return mixed
     */
    public function renderTemplate($string, $data, $store, $type = 'product')
    {
        $text = rtrim(ltrim($string, "["), "]");
        $arrays = explode("][", $text);
        $finalArray = [];
        $i = 0;
        foreach ($arrays as $key => $value) {
            $values =  $this->renderText(trim($value), $data, $store, $type);
            $finalArray[$i] = trim($values);
            $i++;
        }
        $result = implode(" ", $finalArray);

        return $result;
    }

    /**
     * render string to text
     *
     * @param $string
     * @return mixed|string
     */
    public function renderText($string, $data, $store, $type)
    {
        $check = strpos($string, ")");

        if (isset($check) && $check > 0) {
            $result = $this->getText($string);
        } else {
            $result = $this->getVariable($string, $data, $store, $type);
        }

        return $result;
    }

    /**
     * render text
     *
     * @param $string
     * @return string
     */
    public function getText($string)
    {
        $start = rtrim(ltrim($string, "("), ")");
        $result = $this->arrayRandom($start);

        return $result;
    }

    /**
     * render variable
     *
     * @param $string
     * @return mixed
     */
    public function getVariable($string, $data, $store, $type)
    {
        $getString = $this->arrayRandom($string);
        $result = $this->renderVariable($getString);
        if ($type == 'product') {
            $value = $data->$result();
            if (!isset($value) || empty($value)) {
                $value = $this->attributeProduct->getAttributeValueByCode($data, $getString);
            }
        }
        if ($type == 'category') {
            $value = $data->$result();
        }
        if (!isset($value) || empty($value)) {
            $value = '';
        }
        return $value;
    }

    /**
     * @param $string
     * @return mixed
     */
    public function arrayRandom($string)
    {
        $check = strpos($string, "||");
        if (isset($check) && $check > 0) {
            $array = explode("||", $string);
            $arrayRan = array_rand($array, 1);
            $result = $array[$arrayRan];
        } else {
            $result = $string;
        }

        return $result;
    }

    /**
     * @param $string
     * @return string
     */
    public function renderVariable($string)
    {
        $result = ucwords($string);
        $check = strpos($result, "_");
        if (isset($check) && $check > 0) {
            $array = explode("_", $string);
            $finalArray = [];
            $i = 0;
            foreach ($array as $key => $value) {
                $finalArray[$i] = ucwords($value);
                $i++;
            }
            $result = implode("", $finalArray);
        }

        return 'get'.$result;
    }

    /**
     * @param $string
     * @param $addLink
     * @param $count
     * @return string
     */
    public function renderLink($string, $addLink, $keyword)
    {
        $array = explode(" ", trim($string));
        $i = 0;
        $resultArray = [];
        foreach ($array as $key => $value) {
            $text = trim($value);
            if ($value == $keyword) {
                $text = $addLink;
            }
            $resultArray[$i] = $text;
            $i++;
        }
        $result = implode(" ", $resultArray);

        return $result;
    }
}
