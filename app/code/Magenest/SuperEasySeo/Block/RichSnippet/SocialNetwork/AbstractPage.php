<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork;

/**
 * Class AbstractPage
 * @package Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork
 */
abstract class AbstractPage extends \Magenest\SuperEasySeo\Block\RichSnippet\AbstractSocialNetwork
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Page
     */
    protected $configPage;

    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website
     */
    protected $configWebsite;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @return mixed
     */
    abstract protected function getImageUrlGraph();

    /**
     * @return mixed
     */
    abstract protected function getImageUrlTw();

    /**
     * @return mixed
     */
    abstract protected function isEnabledGraph();

    /**
     * @return mixed
     */
    abstract protected function isEnabledTw();

    /**
     * @return mixed
     */
    abstract protected function getTwUsername();

    /**
     * @return mixed
     */
    abstract protected function getTypeGraph();

    /**
     * @return mixed
     */
    abstract protected function getTypeTw();

    /**
     * AbstractPage constructor.
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Page $configPage
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website $configWebsite
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Page $configPage,
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website $configWebsite,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data
    ) {
        $this->configPage         = $configPage;
        $this->configWebsite      = $configWebsite;
        $this->registry           = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function getMarkupHtml()
    {
        $html  = '';
        if (!$this->isEnabledGraph() && !$this->isEnabledTw()) {
            return $html;
        }
        if ($this->isEnabledGraph()) {
            $html .= $this->getOpenGraphPageInfo();
        }
        if ($this->isEnabledTw()) {
            $html .= $this->getTwitterPageInfo();
        }

        return $html;
    }

    /**
     * @return string
     */
    protected function getOpenGraphPageInfo()
    {
        $imageUrl = $this->getImageUrlGraph();

        $title       = $this->escapeHtml($this->pageConfig->getTitle()->get());
        $description = $this->escapeHtml($this->pageConfig->getDescription());
        $siteName    = $this->escapeHtml($this->configWebsite->getName());

        list($urlRaw) = explode('?', $this->_urlBuilder->getCurrentUrl());
        $url = rtrim($urlRaw, '/');

        $html = "\n<meta property=\"og:type\" content=\"" . $this->getTypeGraph() . "\"/>\n";
        $html .= "<meta property=\"og:title\" content=\"" . $title . "\"/>\n";
        $html .= "<meta property=\"og:description\" content=\"" . $description . "\"/>\n";
        $html .= "<meta property=\"og:url\" content=\"" . $url . "\"/>\n";
        if ($siteName) {
            $html .= "<meta property=\"og:site_name\" content=\"" . $siteName . "\"/>\n";
        }
        if ($imageUrl) {
            $html .= "<meta property=\"og:image\" content=\"" . $imageUrl . "\"/>\n";
        }

        return $html;
    }

    /**
     * @return string
     */
    protected function getTwitterPageInfo()
    {
        $twitterUsername = $this->getTwUsername();
        $imageUrl        = '';
        $title       = $this->escapeHtml($this->pageConfig->getTitle()->get());
        $description = $this->escapeHtml($this->pageConfig->getDescription());

        $html = "<meta property=\"twitter:card\" content=\"" . $this->getTypeTw() . "\"/>\n";
        $html .= "<meta property=\"twitter:site\" content=\"" . $twitterUsername . "\"/>\n";
        $html .= "<meta property=\"twitter:title\" content=\"" . $title . "\"/>\n";
        $html .= "<meta property=\"twitter:description\" content=\"" . $description . "\"/>\n";

        if ($imageUrl) {
            $html .= "<meta property=\"twitter:image\" content=\"" . $imageUrl . "\"/>\n";
        }

        return $html;
    }
}
