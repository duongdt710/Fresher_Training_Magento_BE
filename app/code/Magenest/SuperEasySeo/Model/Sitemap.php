<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model;
define ('EOL', "\n");

/**
 * Class Sitemap
 * @package Magenest\SuperEasySeo\Model
 */
class Sitemap extends \Magento\Sitemap\Model\Sitemap
{
    /**
     * @var \Magenest\SuperEasySeo\Api\Config\CmsSitemapConfigInterface
     */
    protected $cmsSitemapConfig;

    /**
     * @var \Magenest\SuperEasySeo\Api\Config\LinkSitemapConfigInterface
     */
    protected $linkSitemapConfig;

    /**
     * @var \Magenest\SuperEasySeo\Helper\Data
     */
    protected $seoSitemapData;

    /**
     * Sitemap constructor.
     * @param \Magenest\SuperEasySeo\Api\Config\CmsSitemapConfigInterface $cmsSitemapConfig
     * @param \Magenest\SuperEasySeo\Api\Config\LinkSitemapConfigInterface $linkSitemapConfig
     * @param \Magenest\SuperEasySeo\Helper\Data $seoSitemapData
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Sitemap\Helper\Data $sitemapData
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Sitemap\Model\ResourceModel\Catalog\CategoryFactory $categoryFactory
     * @param \Magento\Sitemap\Model\ResourceModel\Catalog\ProductFactory $productFactory
     * @param \Magento\Sitemap\Model\ResourceModel\Cms\PageFactory $cmsFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $modelDate
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Api\Config\CmsSitemapConfigInterface $cmsSitemapConfig,
        \Magenest\SuperEasySeo\Api\Config\LinkSitemapConfigInterface $linkSitemapConfig,
        \Magenest\SuperEasySeo\Helper\Data $seoSitemapData,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Escaper $escaper,
        \Magento\Sitemap\Helper\Data $sitemapData,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Sitemap\Model\ResourceModel\Catalog\CategoryFactory $categoryFactory,
        \Magento\Sitemap\Model\ResourceModel\Catalog\ProductFactory $productFactory,
        \Magento\Sitemap\Model\ResourceModel\Cms\PageFactory $cmsFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $modelDate,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->cmsSitemapConfig = $cmsSitemapConfig;
        $this->linkSitemapConfig = $linkSitemapConfig;
        $this->seoSitemapData = $seoSitemapData;
        parent::__construct($context, $registry, $escaper, $sitemapData, $filesystem, $categoryFactory, $productFactory, $cmsFactory, $modelDate, $storeManager, $request, $dateTime, $resource, $resourceCollection, $data);
    }


    /**
     * Initialize sitemap items
     *
     * @return void
     */
    protected function _initSitemapItems()
    {
        /** @var $helper \Magento\Sitemap\Helper\Data */
        $helper = $this->_sitemapData;
        $idStore = $this->getStoreId();

        $this->_sitemapItems[] = new \Magento\Framework\DataObject(
            [
                'changefreq' => $helper->getCategoryChangefreq($idStore),
                'priority' => $helper->getCategoryPriority($idStore),
                'collection' => $this->_categoryFactory->create()->getCollection($idStore),
            ]
        );

        $this->_sitemapItems[] = new \Magento\Framework\DataObject(
            [
                'changefreq' => $helper->getProductChangefreq($idStore),
                'priority' => $helper->getProductPriority($idStore),
                'collection' => $this->_productFactory->create()->getCollection($idStore),
            ]
        );

        $this->_sitemapItems[] = new \Magento\Framework\DataObject(
            [
                'changefreq' => $helper->getPageChangefreq($idStore),
                'priority' => $helper->getPagePriority($idStore),
                'collection' => $this->getCmsPages($idStore),
            ]
        );

        $this->_tags = [
            self::TYPE_INDEX => [
                self::OPEN_TAG_KEY => '<?xml version="1.0" encoding="UTF-8"?>' .
                    EOL .
                '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' .
                    EOL,
                self::CLOSE_TAG_KEY => '</sitemapindex>',
            ],
            self::TYPE_URL => [
                self::OPEN_TAG_KEY => '<?xml version="1.0" encoding="UTF-8"?>' .
                    EOL .
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' .
                ' xmlns:content="http://www.google.com/schemas/sitemap-content/1.0"' .
                ' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' .
                    EOL,
                self::CLOSE_TAG_KEY => '</urlset>',
            ],
        ];
    }

    /**
     * @param $idStore
     * @return array
     */
    protected function getCmsPages($idStore)
    {
        $ignore = $this->cmsSitemapConfig->getIgnoreCmsPages();
        $links = $this->linkSitemapConfig->getAdditionalLinks();
        $cmsPages = $this->_cmsFactory->create()->getCollection($idStore);
        foreach ($cmsPages as $cmsKey => $cms) {
            if (in_array($cms->getUrl(), $ignore)) {
                unset($cmsPages[$cmsKey]);
            }
        }

        if ($links) {
            $cmsPages = array_merge($cmsPages, $links);
        }

        return $cmsPages;
    }


    /**
     * Write sitemap row
     *
     * @param string $row
     * @return void
     */
    protected function _writeSitemapRowXml($row)
    {
        $this->_getStream()->write($row . EOL);
    }

    /**
     * @return $this
     */
    public function generateXml()
    {
        $this->_initSitemapItems();
        $excludedlinks = $this->linkSitemapConfig->getExcludeLinks();
        /** @var $sitemapItem \Magento\Framework\DataObject */
        foreach ($this->_sitemapItems as $sitemapItem) {
            $changefreq = $sitemapItem->getChangefreq();
            $priority = $sitemapItem->getPriority();
            foreach ($sitemapItem->getCollection() as $item) {
                if ($this->seoSitemapData->checkArrayPattern($item->getUrl(), $excludedlinks)) {
                    continue;
                }
                $xmlFile = $this->_getSitemapRow(
                    $item->getUrl(),
                    $item->getUpdatedAt(),
                    $changefreq,
                    $priority,
                    $item->getImages()
                );
                if ($this->_isSplitRequired($xmlFile) && $this->_sitemapIncrement > 0) {
                    $this->_finalizeSitemap();
                }
                if (!$this->_fileSize) {
                    $this->_createSitemap();
                }
                $this->_writeSitemapRowXml($xmlFile);
                // Increase counters
                $this->_lineCount++;
                $this->_fileSize += strlen($xmlFile);
            }
        }
        $this->_finalizeSitemap();

        if ($this->_sitemapIncrement == 1) {
            // In case when only one increment file was created use it as default sitemap
            $path = rtrim(
                $this->getSitemapPath(),
                '/'
            ) . '/' . $this->_getCurrentSitemapFilename(
                $this->_sitemapIncrement
            );
            $destination = rtrim($this->getSitemapPath(), '/') . '/' . $this->getSitemapFilename();

            $this->_directory->renameFile($path, $destination);
        } else {
            // Otherwise create index file with list of generated sitemaps
            $this->_createSitemapIndex();
        }

        // Push sitemap to robots.txt
        if ($this->_isEnabledSubmissionRobots()) {
            $this->_addSitemapToRobotsTxt($this->getSitemapFilename());
        }

        $this->setSitemapTime($this->_dateModel->gmtDate('Y-m-d H:i:s'));
        $this->save();

        return $this;
    }
}
