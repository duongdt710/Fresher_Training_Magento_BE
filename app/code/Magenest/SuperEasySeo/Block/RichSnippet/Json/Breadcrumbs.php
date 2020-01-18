<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\Json;

/**
 * Class Breadcrumbs
 * @package Magenest\SuperEasySeo\Block\RichSnippet\Json
 */
abstract class Breadcrumbs extends \Magenest\SuperEasySeo\Block\RichSnippet\AbstractJson
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Breadcrumbs
     */
    protected $configBreadcrumbs;

    /**
     * @var string
     */
    protected $breadcrumbsBlockName = 'breadcrumbs';

    /**
     * @return array
     */
    abstract protected function getBreadcrumbs();

    /**
     * Breadcrumbs constructor.
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Breadcrumbs $configBreadcrumbs
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Breadcrumbs $configBreadcrumbs,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->configBreadcrumbs = $configBreadcrumbs;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function getMarkupHtml()
    {
        $html = '';

        if (!$this->configBreadcrumbs->isEnabledSnippet()) {
            return $html;
        }
        $breadcrumbsJsonData = $this->getJsonBreadcrumbsData();
        $breadcrumbsJson = $breadcrumbsJsonData  ? json_encode($breadcrumbsJsonData) : '';

        if ($breadcrumbsJsonData) {
            $html .= '<script type="application/ld+json">' . $breadcrumbsJson . '</script>';
        }

        return $html;
    }

    /**
     * @return array
     */
    protected function getJsonBreadcrumbsData()
    {
        $breadcrumbsBlock = $this->getBreadcrumbsBlock();
        if (!$breadcrumbsBlock) {
            return [];
        }

        $cacheKeyInfo = $breadcrumbsBlock->getCacheKeyInfo();

        if (false && !empty($cacheKeyInfo['crumbs'])) {
            $crumbsArray = unserialize(base64_decode($cacheKeyInfo['crumbs']));
        } else {
            $crumbsArray = $this->getBreadcrumbs();
        }

        if (empty($crumbsArray)) {
            return [];
        }

        $crumbs    = array_values($crumbsArray);
        $listitems = [];

        $data = [];
        $data['@context'] = 'http://schema.org';
        $data['@type']    = 'BreadcrumbList';

        for ($i = 0; $i < count($crumbs); $i++) {
            $listItem          = [];
            $listItem['@type'] = 'ListItem';

            if (!empty($crumbs[$i]['link'])) {
                $listItem['item']['@id']  = $crumbs[$i]['link'];
            }
            $listItem['item']['name'] = $crumbs[$i]['label'];
            $listItem['position']     = $i;

            $listitems[]              = $listItem;
        }
        $data['itemListElement'] = $listitems;

        return !empty($data) ? $data : [];
    }

    /**
     * @return bool|\Magento\Framework\View\Element\BlockInterface|null
     */
    protected function getBreadcrumbsBlock()
    {
        $block = $this->_layout->getBlock($this->breadcrumbsBlockName);

        if (!($block instanceof \Magento\Theme\Block\Html\Breadcrumbs)) {
            return null;
        }

        return $block;
    }

    /**
     * @param array $crumbs
     * @return mixed
     */
    protected function getHomeBreadcrumbs($crumbs = [])
    {
        return $this->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' =>__('Go to Home Page'),
                'link'  => $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB)
            ],
            $crumbs
        );
    }

    /**
     * @param $crumbName
     * @param $crumbInfo
     * @param $crumbs
     * @param bool $after
     * @return mixed
     */
    protected function addCrumb($crumbName, $crumbInfo, $crumbs, $after = false)
    {
        $crumbInfo = $this->prepareArray($crumbInfo, ['label', 'title', 'link', 'first', 'last', 'readonly']);
        if ((!isset($crumbs[$crumbName])) || (!$crumbs[$crumbName]['readonly'])) {
            $crumbs[$crumbName] = $crumbInfo;
        }

        return $crumbs;
    }

    /**
     * @param $arr
     * @param array $elements
     * @return mixed
     */
    protected function prepareArray(&$arr, array $elements = [])
    {
        foreach ($elements as $element) {
            if (!isset($arr[$element])) {
                $arr[$element] = null;
            }
        }

        return $arr;
    }
}
