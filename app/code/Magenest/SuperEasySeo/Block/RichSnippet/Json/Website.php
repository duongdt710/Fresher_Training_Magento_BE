<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\Json;

/**
 * Class Website
 * @package Magenest\SuperEasySeo\Block\RichSnippet\Json
 */
class Website extends \Magenest\SuperEasySeo\Block\RichSnippet\AbstractJson
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website
     */
    protected $configWebsite;

    /**
     * Website constructor.
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website $configWebsite
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website $configWebsite,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->configWebsite = $configWebsite;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function getMarkupHtml()
    {
        $html = '';

        if (!$this->configWebsite->isEnabledSnippet()) {
            return $html;
        }

        $websiteJsonData = $this->getJsonWebSiteData();
        $websiteJson     = $websiteJsonData ? json_encode($websiteJsonData) : '';

        if ($websiteJsonData) {
            $html .= '<script type="application/ld+json">' . $websiteJson . '</script>';
        }

        return $html;
    }

    /**
     * @return array
     */
    protected function getJsonWebSiteData()
    {
        $data = [];
        $data['@context']  = 'http://schema.org';
        $data['@type']     = 'WebSite';
        $data['url']       = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);

        $siteName = $this->configWebsite->getName();
        if ($siteName) {
            $data['name'] = $siteName;
        }

        $siteAbout = $this->configWebsite->getAboutInfo();
        if ($siteAbout) {
            $data['about'] = $siteAbout;
        }

        return $data;
    }
}
