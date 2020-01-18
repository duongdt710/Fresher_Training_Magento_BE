<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Observer\Backend\Category;

use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;
use Magenest\SuperEasySeo\Model\TemplateFactory;
use Magenest\SuperEasySeo\Helper\RenderTemplateRule;
use Magenest\SuperEasySeo\Model\AutolinkFactory;
use Magento\Catalog\Model\CategoryFactory;

/**
 * Class Save
 * @package Magenest\SuperEasySeo\Observer\Backend\Category
 */
class Save implements ObserverInterface
{
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
    protected $storeManage;

    /**
     * @var TemplateFactory
     */
    protected $template;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var RenderTemplateRule
     */
    protected $helperRender;

    /**
     * @var AutolinkFactory
     */
    protected $autolinkFactory;

    /**
     * Save constructor.
     * @param RequestInterface $request
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManagerInterface
     * @param LoggerInterface $logger
     * @param TemplateFactory $templateFactory
     * @param CategoryFactory $categoryFactory
     * @param RenderTemplateRule $renderTemplateRule
     * @param AutolinkFactory $autolinkFactory
     */
    public function __construct(
        RequestInterface $request,
        Filesystem $filesystem,
        StoreManagerInterface $storeManagerInterface,
        LoggerInterface $logger,
        TemplateFactory $templateFactory,
        CategoryFactory $categoryFactory,
        RenderTemplateRule $renderTemplateRule,
        AutolinkFactory $autolinkFactory
    ) {
        $this->template = $templateFactory;
        $this->categoryFactory = $categoryFactory;
        $this->storeManage = $storeManagerInterface;
        $this->_request = $request;
        $this->_filesystem = $filesystem;
        $this->_logger = $logger;
        $this->helperRender = $renderTemplateRule;
        $this->autolinkFactory = $autolinkFactory;
    }

    /**
     * Set new customer group to all his quotes
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = $observer->getEvent()->getCategory();
        $params = $this->_request->getParams();
        $storeId = 0;
        if (isset($params['store_id'])) {
            $storeId = $params['store_id'];
        }

        /** @var  \Magenest\SuperEasySeo\Model\Template $modelTem */
        $modelTem = $this->template->create()->getCollection()
            ->addFieldToFilter('type', 'category')
            ->addFieldToFilter('store', $storeId)
            ->addFieldToFilter('enabled', 1);
        if (empty($modelTem->getData())) {
            $this->builderAutolink($category, '');
        } else {
            foreach ($modelTem as $model) {
                $applyFor = $model->getApplyFor();
                $checkNew = 1;
                if ($applyFor == 0) {
                    if (isset($params['entity_id']) && $params['entity_id'] >0) {
                        $checkNew = 0;
                    }
                }
                if ($checkNew == 1) {
                    $this->getRenderText($model, $category);
                }
            }
        }

        return;
    }

    /**
     * @param $storeId
     * @param $category
     */
    public function builderAutolink($category, $string, $check = false)
    {
        $modelAutolink = $this->autolinkFactory->create()->getCollection()
            ->setOrder('sort_order', 'DESC')
            ->addFieldToFilter('use_category', 1)
            ->addFieldToFilter('enabled', 1);

        /** @var  \Magenest\SuperEasySeo\Model\Autolink $model */
        foreach ($modelAutolink as $model) {
            $storeApply = explode(",", $model->getStore());
            if (in_array($category->getStoreId(), $storeApply)) {
                if (!empty($category->getDescription())) {
                    $string = $check ? $string : $category->getDescription();
                    $text = $this->getRenderAutoLink($string, $model);
                    $category->setDescription($text);
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

    /**
     * @param $params
     * @param $model
     * @param $product
     */
    public function getRenderText($model, $category)
    {
        $params = $this->_request->getParams();
        /** @var \Magento\Catalog\Model\Category $category */
        $categoryId = $category->getId();
        /** @var \Magenest\SuperEasySeo\Model\Template $model*/
        $assignType = $model->getAssignType();
        $checkRender = 1;
        if (isset($categoryId) && !empty($category)) {
            if ($assignType == 2) {
                $applyCategory = $model->getApplyCategory();
                $size = sizeof(array_intersect([$categoryId], explode(",", $applyCategory)));
                if ($size < 1) {
                    $checkRender = 0;
                }
            }
        } else {
            $checkRender = 1;
        }

        if ($checkRender == 1) {
            $arrayText = ['UrlKey', 'Description', 'MetaTitle', 'MetaDescription'];

            foreach ($arrayText as $key => $value) {
                $callMethod = 'get'.$value;
                $setMethod = 'set'.$value;
                if (!empty($model->$callMethod())) {
                    $result = $this->renderValue($model->$callMethod(), $key, $category, $params['store_id']);
//                    $this->_logger->debug(print_r($result, true));
                    $category->$setMethod($result);
                    if ($key == 1) {
                        $this->builderAutolink($category, $result, true);
                    }
                }
            }
        }
    }

    /**
     * @param $text
     * @param $key
     * @param $productId
     * @param $store
     */
    public function renderValue($text, $key, $category, $store)
    {
        $render = $this->helperRender->renderTemplate($text, $category, $store, 'category');
        if ($key == 0) {
            $render = str_replace(" ", "-", strtolower($render));
            if (strlen($text) > 30) {
                $render = substr($text, 0, 30);
            }
        }

        return $render;
    }
}
