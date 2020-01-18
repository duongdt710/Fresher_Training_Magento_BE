<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Observer\Backend\Product;

use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;
use Magenest\SuperEasySeo\Model\TemplateFactory;
use Magenest\SuperEasySeo\Helper\RenderTemplateRule;
use Magenest\SuperEasySeo\Model\AutolinkFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\UrlRewrite\Model\UrlPersistInterface;

/**
 * Class Save
 * @package Magenest\SuperEasySeo\Observer\Backend
 */
class Save implements ObserverInterface
{
    /**
     * @var ProductUrlRewriteGenerator
     */
    protected $productUrlRewriteGenerator;

    /**
     * @var UrlPersistInterface
     */
    protected $urlPersist;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var Filesystem
     */
    protected $_filesystem;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var TemplateFactory
     */
    protected $template;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Action
     */
    protected $action;

    /**
     * @var RenderTemplateRule
     */
    protected $helperRender;

    /**
     * @var AutolinkFactory
     */
    protected $autolinkFactory;

    /**
     * URL instance
     *
     * @var \Magento\Framework\UrlFactory
     */
    protected $urlFactory;

    /** @var UrlFinderInterface */
    protected $urlFinder;

    /** @var \Magento\Catalog\Model\Product */
    protected $product;

    /**
     * Save constructor.
     * @param RequestInterface $request
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManagerInterface
     * @param LoggerInterface $logger
     * @param TemplateFactory $templateFactory
     * @param ProductFactory $productFactory
     * @param RenderTemplateRule $renderTemplateRule
     * @param \Magento\Catalog\Model\ResourceModel\Product\Action $action
     * @param AutolinkFactory $autolinkFactory
     */
    public function __construct(
        \Magento\Framework\UrlFactory $urlFactory,
        RequestInterface $request,
        Filesystem $filesystem,
        StoreManagerInterface $storeManagerInterface,
        LoggerInterface $logger,
        TemplateFactory $templateFactory,
        ProductFactory $productFactory,
        RenderTemplateRule $renderTemplateRule,
        \Magento\Catalog\Model\ResourceModel\Product\Action $action,
        AutolinkFactory $autolinkFactory,
        \Magento\UrlRewrite\Model\UrlFinderInterface $urlFinder,
        ProductUrlRewriteGenerator $productUrlRewriteGenerator,
        UrlPersistInterface $urlPersist
    ) {
        $this->urlFinder = $urlFinder;
        $this->urlFactory = $urlFactory;
        $this->action = $action;
        $this->template = $templateFactory;
        $this->productFactory = $productFactory;
        $this->storeManager = $storeManagerInterface;
        $this->_request = $request;
        $this->_filesystem = $filesystem;
        $this->_logger = $logger;
        $this->helperRender = $renderTemplateRule;
        $this->autolinkFactory = $autolinkFactory;
        $this->productUrlRewriteGenerator = $productUrlRewriteGenerator;
        $this->urlPersist = $urlPersist;
    }

    /**
     * Set new customer group to all his quotes
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();
        $this->builderAutolink($product);
        return;
    }

    /**
     * @param $storeId
     * @param $category
     */
    public function builderAutolink($product)
    {
        $modelAutolink = $this->autolinkFactory->create()->getCollection()
            ->setOrder('sort_order', 'DESC')
            ->addFieldToFilter('enabled', 1);
        $storeId = $product->getStoreId();
        /** @var  \Magenest\SuperEasySeo\Model\Autolink $model */
        foreach ($modelAutolink as $model) {
            $storeApply = explode(",", $model->getStore());
            if (in_array($storeId, $storeApply)) {
                if (!empty($product->getDescription()) && $model->getUseProductDescription() == 1) {
                    $text = $this->getRenderAutoLink($product->getDescription(), $model);
                    $this->action->updateAttributes([$product->getId()], ['description' => $text], $storeId);
                }
                if (!empty($product->getShortDescription()) && $model->getUseProductShortDescription() == 1) {
                    $text = $this->getRenderAutoLink($product->getShortDescription(), $model);
                    $this->action->updateAttributes([$product->getId()], ['short_description' => $text], $storeId);
                }
            }
        }
    }

    /**
     * @param $string
     * @param $model
     * @return string
     */
    public function getRenderAutoLink($string, $model)
    {
        /** @var \Magenest\SuperEasySeo\Model\Autolink $model */
        $result = $this->helperRender->renderLink($string, $model->getRenderHtml(), trim($model->getKeyword()));

        return $result;
    }
}
