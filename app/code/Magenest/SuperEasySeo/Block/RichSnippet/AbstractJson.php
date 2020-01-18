<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet;

/**
 * Class AbstractJson
 * @package Magenest\SuperEasySeo\Block\RichSnippet
 */
abstract class AbstractJson extends \Magenest\SuperEasySeo\Block\RichSnippet
{
    /**
     * @return mixed
     */
    abstract protected function getMarkupHtml();

    /**
     * @return string
     */
    protected function _toHtml()
    {
        return $this->getMarkupHtml();
    }
}
