<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork;

/**
 * Class Category
 * @package Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork
 */
class Category extends \Magenest\SuperEasySeo\Block\RichSnippet\AbstractSocialNetwork
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Category
     */
    protected $configCategory;

    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website
     */
    protected $configWebsite;

    /**
     * Category constructor.
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Category $configCategory
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website $configWebsite
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Category $configCategory,
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Website $configWebsite,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data
    ) {
        $this->configCategory = $configCategory;
        $this->configWebsite  = $configWebsite;
        parent::__construct($context, $data);
    }

    protected function getMarkupHtml()
    {
        if (!$this->configCategory->isEnabledGraph()) {
            return '';
        }

        \Magento\Framework\App\ObjectManager::getInstance()->create('Psr\Log\LoggerInterface')
            ->debug(print_r($this->getSocialCategoryInfo(), true));
        return $this->getSocialCategoryInfo();
    }

    /**
     * @return string
     */
    protected function getSocialCategoryInfo()
    {
        $type        = 'product.group';
        $title       = $this->escapeHtml($this->pageConfig->getTitle()->get());
        $description = $this->escapeHtml($this->pageConfig->getDescription());
        $siteName    = $this->escapeHtml($this->configWebsite->getName());

        list($urlRaw) = explode('?', $this->_urlBuilder->getCurrentUrl());
        $url = rtrim($urlRaw, '/');

        $html  = "\n<meta property=\"og:type\" content=\"" . $type . "\"/>\n";
        $html .= "<meta property=\"og:title\" content=\"" . $title . "\"/>\n";
        $html .= "<meta property=\"og:description\" content=\"" . $description . "\"/>\n";
        $html .= "<meta property=\"og:url\" content=\"" . $url . "\"/>\n";
        if ($siteName) {
            $html .= "<meta property=\"og:site_name\" content=\"" . $siteName . "\"/>\n";
        }

        return $html;
    }
}
