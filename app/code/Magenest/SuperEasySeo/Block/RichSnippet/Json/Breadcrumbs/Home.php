<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs;

/**
 * Class Home
 * @package Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs
 */
class Home extends \Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs
{
    /**
     * @return array
     */
    protected function getBreadcrumbs()
    {
        $crumbs = $this->getHomeBreadcrumbs();

        return $crumbs;
    }
}
