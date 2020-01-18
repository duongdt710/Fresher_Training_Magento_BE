<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork\Page;

/**
 * Class Home
 * @package Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork\Page
 */
class Home extends \Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork\AbstractPage
{
    /**
     * @return bool
     */
    protected function isEnabledGraph()
    {
        return $this->configWebsite->isEnabledGraph();
    }

    /**
     * @return bool
     */
    protected function isEnabledTw()
    {
        return $this->configWebsite->isEnabledTw() && $this->configWebsite->getTwUsername();
    }

    /**
     * @return string
     */
    protected function getImageUrlTw()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function getImageUrlGraph()
    {
        return '';
    }

    /**
     *
     * {@inheritDoc}
     */
    protected function getTwUsername()
    {
        return $this->configWebsite->getTwUsername();
    }

    /**
     * @return string
     */
    protected function getTypeGraph()
    {
        return 'website';
    }

    /**
     * @return string
     */
    protected function getTypeTw()
    {
        return 'summary_large_image';
    }
}
