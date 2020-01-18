<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork\Page;

/**
 * Class DefaultPage
 * @package Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork\Page
 */
class DefaultPage extends \Magenest\SuperEasySeo\Block\RichSnippet\SocialNetwork\AbstractPage
{
    /**
     * @return string
     */
    protected function getImageUrlGraph()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function getImageUrlTw()
    {
        return '';
    }

    /**
     * @return bool
     */
    protected function isEnabledGraph()
    {
        return $this->configPage->isEnabledGraph();
    }

    /**
     * @return bool
     */
    protected function isEnabledTw()
    {
        return $this->configPage->isEnabledTw() && $this->configPage->getTwUsername();
    }

    /**
     * @return string
     */
    protected function getTwUsername()
    {
        return $this->configPage->getTwUsername();
    }

    /**
     * @return string
     */
    protected function getTypeGraph()
    {
        return 'article';
    }

    /**
     * @return string
     */
    protected function getTypeTw()
    {
        return 'summary';
    }
}
