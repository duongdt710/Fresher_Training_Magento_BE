<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class RegisterUrlRewriteObserver
 * @package Magenest\SuperEasySeo\Observer
 */
class RegisterUrlRewriteObserver implements ObserverInterface
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Config
     */
    protected $config;

    /**
     * @var \Magenest\SuperEasySeo\Helper\UrlRewrite
     */
    protected $urlRewrite;

    /**
     * RegisterUrlRewriteObserver constructor.
     * @param \Magenest\SuperEasySeo\Model\Config $config
     * @param \Magenest\SuperEasySeo\Helper\UrlRewrite $mstcoreUrlrewrite
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config $config,
        \Magenest\SuperEasySeo\Helper\UrlRewrite $mstcoreUrlrewrite
    ) {
        $this->config = $config;
        $this->urlRewrite = $mstcoreUrlrewrite;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->urlRewrite->setRewriteMode('SEO', true);
        $this->urlRewrite->registerBasePath('SEO', $this->config->getSitemapUrlWrite());
        $this->urlRewrite->registerPath('SEO', 'MAP', '', 'seo_index_index');
    }
}
