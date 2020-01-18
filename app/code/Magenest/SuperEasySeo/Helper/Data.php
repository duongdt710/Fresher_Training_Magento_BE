<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Helper;

/**
 * Class Data
 * @package Magenest\SuperEasySeo\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Config
     */
    protected $config;

    /**
     * @var UrlRewrite
     */
    protected $urlRewrite;

    /**
     * @var \Magento\Framework\App\Helper\Context
     */
    protected $context;

    /**
     * Data constructor.
     * @param \Magenest\SuperEasySeo\Model\Config $config
     * @param UrlRewrite $urlRewrite
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config $config,
        \Magenest\SuperEasySeo\Helper\UrlRewrite $urlRewrite,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->config = $config;
        $this->urlRewrite = $urlRewrite;
        $this->context = $context;
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getSitemapTitle()
    {
        return $this->config->getFrontendSitemapH1();
    }

    /**
     * @return string
     */
    public function getSitemapUrl()
    {
        return $this->urlRewrite->getUrl('SEO', 'MAP');
    }

    /**
     * @param string     $stringVal
     * @param string     $patternArr
     * @param bool|false $caseSensativeVal
     * @return bool
     */
    public function checkArrayPattern($stringVal, $patternArr, $caseSensativeVal = false)
    {
        if (!is_array($patternArr)) {
            return false;
        }
        foreach ($patternArr as $patternVal) {
            if ($this->checkPattern($stringVal, $patternVal, $caseSensativeVal)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $urlWithHost
     * @return mixed|string
     */
    public function removeHostUrl($urlWithHost)
    {
        $parts = parse_url($urlWithHost);
        $url = $parts['path'];
        $url = str_replace('index.php/', '', $url);
        $url = str_replace('index.php', '', $url);
        if (isset($parts['query'])) {
            $url .= '?'.$parts['query'];
        }

        return $url;
    }

    /**
     * @param string     $url
     * @param string     $pattern
     * @param bool|false $caseSensative
     * @return bool
     * @SuppressWarnings(PHPMD.CyclomaticComplexity) 
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function checkPattern($url, $pattern, $caseSensative = false)
    {
        $string = $this->removeHostUrl($url);

        if (!$caseSensative) {
            $string = strtolower($string);
            $pattern = strtolower($pattern);
        }

        $parts = explode('*', $pattern);
        $index = 0;

        $shouldBeFirst = true;

        foreach ($parts as $part) {
            if ($part == '') {
                $shouldBeFirst = false;
                continue;
            }

            $index = strpos($string, $part, $index);

            if ($index === false) {
                return false;
            }

            if ($shouldBeFirst && $index > 0) {
                return false;
            }

            $shouldBeFirst = false;
            $index += strlen($part);
        }

        if (count($parts) == 1) {
            return $string == $pattern;
        }

        $last = end($parts);
        if ($last == '') {
            return true;
        }

        if (strrpos($string, $last) === false) {
            return false;
        }

        if (strlen($string) - strlen($last) - strrpos($string, $last) > 0) {
            return false;
        }

        return true;
    }
}
