<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs;

/**
 * Class Page
 * @package Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs
 */
class Page extends \Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs
{
    protected $cmsPageBlockName = 'cms_page';

    /**
     * @return array|mixed
     */
    protected function getBreadcrumbs()
    {
        $crumbs = $this->getHomeBreadcrumbs();
        $pageModel = $this->getPage();
        if (is_object($pageModel) && $pageModel->getTitle()) {
            $crumbs = $this->addCrumb(
                'page',
                [
                    'label' => $pageModel->getTitle(),
                    'title' => $pageModel->getTitle()
                ],
                $crumbs
            );
        }

        return $crumbs;
    }

    /**
     * Retrieve current CMS page model from layout
     *
     * @return \Magento\Cms\Model\Page|null
     */
    protected function getPage()
    {
        $block = $this->_layout->getBlock($this->cmsPageBlockName);
        if (is_object($block)) {
            $page = $block->getPage();
            if (is_object($page)) {
                return $page;
            }
        }

        return null;
    }
}
