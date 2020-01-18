<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs;

/**
 * Class Catalog
 * @package Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs
 */
class Catalog extends \Magenest\SuperEasySeo\Block\RichSnippet\Json\Breadcrumbs
{
    /**
     *
     * @var \Magento\Catalog\Helper\Data
     */
    protected $helperCatalogData;

    /**
     * Catalog constructor.
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Breadcrumbs $helperBreadcrumbs
     * @param \Magento\Catalog\Helper\Data $helperCatalogData
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Breadcrumbs $helperBreadcrumbs,
        \Magento\Catalog\Helper\Data $helperCatalogData,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->helperCatalogData = $helperCatalogData;
        parent::__construct($helperBreadcrumbs, $context, $data);
    }

    /**
     * @return array|mixed
     */
    protected function getBreadcrumbs()
    {
        $crumbs = $this->getHomeBreadcrumbs();
        $path   = $this->helperCatalogData->getBreadcrumbPath();

        if (is_array($path)) {
            foreach ($path as $name => $breadcrumb) {
                $crumbs = $this->addCrumb($name, $breadcrumb, $crumbs);
            }
        }

        return $crumbs;
    }
}
