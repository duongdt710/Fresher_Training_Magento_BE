<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\CanonicalTag;

/**
 * Class Product
 * @package Magenest\SuperEasySeo\Block\CanonicalTag
 */
class Product extends \Magenest\SuperEasySeo\Block\CanonicalTag
{

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if(!$this->setTag(1))
            return "";
        $href = $this->cleanUrl();

        return '<link rel="canonical" href="'.$href.'" />';
    }
}
