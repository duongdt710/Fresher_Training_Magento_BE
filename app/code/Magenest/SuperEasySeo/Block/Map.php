<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block;

use Magento\Store\Model\ScopeInterface;

/**
 * Class Map
 * @package Magenest\SuperEasySeo\Block
 */
class Map extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Pager\CollectionFactory
     */
    protected $pagerCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var \Magenest\SuperEasySeo\Model\Config
     */
    protected $config;

    /**
     * @var \Magento\Framework\App\Resource
     */
    protected $resource;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var \Magento\Catalog\Helper\Category
     */
    protected $catalogCategory;


    /**
     * @var \Magenest\SuperEasySeo\Helper\Data
     */
    protected $seoSitemapData;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $dbResource;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Framework\View\Element\Template\Context
     */
    protected $context;

    /**
     * @var \Magenest\SuperEasySeo\Api\Config\CmsSitemapConfigInterface
     */
    protected $cmsSitemapConfig;

    /**
     * @var \Magenest\SuperEasySeo\Api\Config\LinkSitemapConfigInterface
     */
    protected $linkSitemapConfig;

    /**
     * Map constructor.
     * @param \Magenest\SuperEasySeo\Api\Config\CmsSitemapConfigInterface $cmsSitemapConfig
     * @param \Magenest\SuperEasySeo\Api\Config\LinkSitemapConfigInterface $linkSitemapConfig
     * @param \Magenest\SuperEasySeo\Model\Pager\CollectionFactory $pagerCollectionFactory
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory
     * @param \Magenest\SuperEasySeo\Model\Config $config
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Catalog\Helper\Category $catalogCategory
     * @param \Magenest\SuperEasySeo\Helper\Data $seoSitemapData
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magento\Framework\App\ResourceConnection $dbResource
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Api\Config\CmsSitemapConfigInterface $cmsSitemapConfig,
        \Magenest\SuperEasySeo\Api\Config\LinkSitemapConfigInterface $linkSitemapConfig,
        \Magenest\SuperEasySeo\Model\Pager\CollectionFactory $pagerCollectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory,
        \Magenest\SuperEasySeo\Model\Config $config,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Catalog\Helper\Category $catalogCategory,
        \Magenest\SuperEasySeo\Helper\Data $seoSitemapData,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Framework\App\ResourceConnection $dbResource,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->cmsSitemapConfig = $cmsSitemapConfig;
        $this->linkSitemapConfig = $linkSitemapConfig;
        $this->pagerCollectionFactory = $pagerCollectionFactory;
        $this->categoryFactory = $categoryFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->config = $config;
        $this->resource = $resource;
        $this->date = $date;
        $this->catalogCategory = $catalogCategory;
        $this->seoSitemapData = $seoSitemapData;
        $this->moduleManager = $moduleManager;
        $this->dbResource = $dbResource;
        $this->request = $context->getRequest();
        $this->context = $context;
        $this->pageConfig = $context->getPageConfig();
        parent::__construct($context, $data);
    }

    /**
     * @var array
     */
    protected $categoriesTree = [];

    /**
     * @var array
     */
    protected $itemLevelPositions = [];

    /**
     * @var bool
     */
    protected $isMagentoEe = false;

    /**
     * @var
     */
    protected $collection;

    /**
     * @return \Magenest\SuperEasySeo\Api\Config\CmsSitemapConfigInterface
     */
    public function getCmsSitemapConfig()
    {
        return $this->cmsSitemapConfig;
    }

    /**
     * @return \Magenest\SuperEasySeo\Api\Config\LinkSitemapConfigInterface
     */
    public function getLinkSitemapConfig()
    {
        return $this->linkSitemapConfig;
    }

    /**
     * @return \Magenest\SuperEasySeo\Model\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return array
     */
    public function getExcludeLinks()
    {
        return $this->getLinkSitemapConfig()->getExcludeLinks();
    }

    /**
     * add breadcrum
     */
    protected function addBreadcrumbs()
    {
        /** @var \Magento\Theme\Block\Html\Breadcrumbs $breadcrumbsBlock */
        if ($this->_scopeConfig->getValue('web/default/show_cms_breadcrumbs', ScopeInterface::SCOPE_STORE) &&
            $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')
        ) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );
            $breadcrumbsBlock->addCrumb('cms_page', [
                'label' => $this->config->getMetaTitle(),
                'title' => $this->config->getMetaTitle()
            ]);
        }
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        $this->addBreadcrumbs();
        $this->pageConfig->getTitle()->set($this->config->getMetaTitle());
        $this->pageConfig->setKeywords($this->config->getMetaKeywords());
        $this->pageConfig->setDescription($this->config->geMetaDescription());

        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle($this->escapeHtml($this->config->getFrontendSitemapH1()));
        }

        $collection = $this->pagerCollectionFactory->create();
        $collection->setCollection($this->getCategoriesTree());
        if ($this->getLimitPerPage()) {
            $pagerBlock = $this->getLayout()->createBlock('\Magenest\SuperEasySeo\Block\Map\Pager', 'map.pager')
                            ->setShowPerPage(false)
                            ->setShowAmounts(false);
            $pagerBlock->setLimit($this->getLimitPerPage())->setCollection($collection);
            $this->append($pagerBlock);
        }
        $this->collection = $collection;

        return parent::_prepareLayout();
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return bool
     */
    public function isFirstPage()
    {
        if (!$this->getLimitPerPage()) {
            return true;
        }

        return $this->getCollection()->getCurPage() == 1;
    }

    /**
     * @return int
     */
    public function getLimitPerPage()
    {
        return (int) $this->config->getFrontendLinksLimit();
    }

    /**
     * @return array|string
     */
    public function getCategoryLimitedSortedTree()
    {
        $page = $this->request->getParam('p') ?: 1;
        $beginPageValue = ($page * $this->getLimitPerPage()) - $this->getLimitPerPage();
        $categories = $this->getCategoriesTree();
        $categories = array_splice($categories, $beginPageValue, $this->getLimitPerPage());

        return $categories;
    }

    /**
     * @return \Magento\Framework\Data\Tree\Node\Collection
     */
    protected function getStoreCategories()
    {
        return $this->catalogCategory->getStoreCategories();
    }

    /**
     * @param $category
     * @param int $level
     * @return string
     */
    protected function _getCategoriesTree($category, $level = 0)
    {
        if (!$category->getIsActive()) {
            return '';
        }

        $children = $category->getChildren();
        if (!is_object($children) || !$children->count()) {
            return '';
        }

        // select active children
        $activeChildren = [];
        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $activeChildren[] = $child;
            }
        }
        $j = 0;
        foreach ($activeChildren as $child) {
            if (!$this->seoSitemapData->checkArrayPattern($this->getCategoryUrl($child), $this->getExcludeLinks())) {
                $this->categoriesTree[] = $child;
            } else {
                $arrKey = count($this->categoriesTree);
                if ($arrKey > 0) {
                    $arrKey = $arrKey - 1;
                }
                $this->categoriesTree[$arrKey.'-hidden'] = $child;
            }
            $this->_getCategoriesTree($child, $level + 1);
            ++$j;
        }
    }

    /**
     * @var \Magento\Catalog\Model\Category
     */
    protected $categoryInstance;

    /**
     * @return \Magento\Catalog\Model\Category
     */
    protected function _getCategoryInstance()
    {
        if ($this->categoryInstance === null) {
            $this->categoryInstance = $this->categoryFactory->create();
        }

        return $this->categoryInstance;
    }

    /**
     * Get url for category data.
     *
     * @param \Magento\Catalog\Model\Category $category
     *
     * @return string
     */
    public function getCategoryUrl($category)
    {
        if ($category instanceof \Magento\Catalog\Model\Category) {
            $url = $category->getUrl();
        } else {
            $url = $this->_getCategoryInstance()
                ->setData($category->getData())
                ->getUrl();
        }

        return $url;
    }

    /**
     * Return item position representation in menu tree.
     *
     * @param int $level
     *
     * @return string
     */
    protected function _getItemPosition($level)
    {
        if ($level == 0) {
            $zeroLevelPosition = isset($this->itemLevelPositions[$level]) ? $this->itemLevelPositions[$level] + 1 : 1;
            $this->itemLevelPositions = [];
            $this->itemLevelPositions[$level] = $zeroLevelPosition;
        } elseif (isset($this->itemLevelPositions[$level])) {
            ++$this->itemLevelPositions[$level];
        } else {
            $this->itemLevelPositions[$level] = 1;
        }

        $position = [];
        for ($i = 0; $i <= $level; ++$i) {
            if (isset($this->itemLevelPositions[$i])) {
                $position[] = $this->itemLevelPositions[$i];
            }
        }

        return implode('-', $position);
    }

    /**
     * @return void
     */
    protected function prepareCategoryTree()
    {
        $result = [];
        foreach ($this->categoriesTree as $key => $category) {
            if (!$this->excludeCategory($category)) {
                if (!$this->isHidden($key)) {
                    $category->setUrl($this->getCategoryUrl($category));
                    $result[] = $category;
                }
                if ($this->getConfig()->getIsShowProducts()) {
                    $products = $this->getSitemapProductCollection($category);
                    foreach ($products as $product) {
                        if ($product->getVisibility() != 1 && !$this->excludeProduct($product)) {
                            $product->setLevel($category->getLevel() + 1);
                            $product->setUrl($product->getProductUrl());
                            $result[] = $product;
                        }
                    }
                }
            }
        }

        $this->categoriesTree = $result;
    }

    /**
     * @param int $level
     * @return array
     */
    public function getCategoriesTree($level = 0)
    {
        if ($this->categoriesTree) {
            return $this->categoriesTree;
        }

        $activeCategories = [];
        foreach ($this->getStoreCategories() as $child) {
            if ($child->getIsActive()) {
                $activeCategories[] = $child;
            }
        }
        $activeCategoriesCount = count($activeCategories);
        $hasActiveCategoriesCount = ($activeCategoriesCount > 0);

        if (!$hasActiveCategoriesCount) {
            return [];
        }

        $j = 0;
        foreach ($activeCategories as $category) {
            if (!$this->seoSitemapData->checkArrayPattern($this->getCategoryUrl($category), $this->getExcludeLinks())) {
                $this->categoriesTree[] = $category;
            } else {
                $arrKey = count($this->categoriesTree);
                if ($arrKey > 0) {
                    $arrKey = $arrKey - 1;
                }
                $this->categoriesTree[$arrKey.'-hidden'] = $category;
            }
            $this->_getCategoriesTree($category, $level);
            ++$j;
        }

        $this->prepareCategoryTree();

        return $this->categoriesTree;
    }

    /**
     * @param string $category
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getSitemapProductCollection($category)
    {
        $category = $this->_getCategoryInstance()
                    ->setData($category->getData());
        $collection = $this->productCollectionFactory->create()
            ->addStoreFilter()
            ->addCategoryFilter($category)
            ->addAttributeToFilter('visibility', ['neq' => 1])
            ->addAttributeToFilter('status', 1)
            ->addAttributeToSelect('*')
            ->addUrlRewrite();

        return $collection;
    }


    /**
     * @return string
     */
    public function getH1Title()
    {
        return $this->config->getFrontendSitemapH1();
    }

    /**
     * @param string $category
     * @return bool
     */
    public function excludeCategory($category)
    {
        return $this->seoSitemapData->checkArrayPattern($category->getUrl(), $this->getExcludeLinks());
    }

    /**
     * @param string $product
     * @return bool
     */
    public function excludeProduct($product)
    {
        return $this->seoSitemapData->checkArrayPattern($product->getProductUrl(), $this->getExcludeLinks());
    }

    /**
     * @return $this
     */
    public function getCmsPages()
    {
        $ignore = $this->cmsSitemapConfig->getIgnoreCmsPages();
        $collection = $this->pageCollectionFactory->create()
                         ->addStoreFilter($this->context->getStoreManager()->getStore())
                         ->addFieldToFilter('is_active', true)
                         ->addFieldToFilter('main_table.identifier', ['nin' => $ignore]);

        return $collection;
    }

    /**
     * @param string $page
     * @return string
     */
    public function getCmsPageUrl($page)
    {
        $pageIdentifier = ($this->isMagentoEe && $page->getHierarchyRequestUrl()) ? $page->getHierarchyRequestUrl() :
            $page->getIdentifier();

        return $this->context->getUrlBuilder()->getUrl(null, ['_direct' => $pageIdentifier]);
    }

    /**
     * @return \Magento\Store\Api\Data\StoreInterface[]
     */
    public function getStores()
    {
        return $this->context->getStoreManager()->getStores();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isHidden($key)
    {
        if (strpos($key, 'hidden') === false) {
            return false;
        }

        return true;
    }
}
