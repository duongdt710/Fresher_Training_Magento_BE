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
use Magenest\SuperEasySeo\Model\AutolinkFactory;
use Magenest\SuperEasySeo\Helper\RenderTemplateRule;
use Magento\Catalog\Model\ProductFactory;

/**
 * Class SaveBefore
 * @package Magenest\SuperEasySeo\Observer\Backend
 */
class SaveBefore implements ObserverInterface
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
    protected $autolink;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * SaveBefore constructor.
     * @param RequestInterface $request
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManagerInterface
     * @param LoggerInterface $logger
     * @param TemplateFactory $templateFactory
     * @param ProductFactory $productFactory
     * @param RenderTemplateRule $renderTemplateRule
     * @param \Magento\Catalog\Model\ResourceModel\Product\Action $action
     * @param AutolinkFactory $autolinkFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        RequestInterface $request,
        Filesystem $filesystem,
        StoreManagerInterface $storeManagerInterface,
        LoggerInterface $logger,
        TemplateFactory $templateFactory,
        ProductFactory $productFactory,
        RenderTemplateRule $renderTemplateRule,
        \Magento\Catalog\Model\ResourceModel\Product\Action $action,
        AutolinkFactory $autolinkFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->autolink = $autolinkFactory;
        $this->action = $action;
        $this->template = $templateFactory;
        $this->productFactory = $productFactory;
        $this->storeManage = $storeManagerInterface;
        $this->_request = $request;
        $this->_filesystem = $filesystem;
        $this->_logger = $logger;
        $this->helperRender = $renderTemplateRule;
        $this->productRepository = $productRepository;
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

        $isImgTag = $product->getData('image-tag-enable');
        if (isset($isImgTag) && $isImgTag == 1) {
            $this->setImageTag($product);
        }
        $params = $this->_request->getParams();
        $storeId = 0;
        if (isset($params['store'])) {
            $storeId = $params['store'];
        }
        $modelTem = $this->template->create()->getCollection()
            ->addFieldToFilter('type', 'product')
            ->setOrder('sort_order', 'DESC')
            ->addFieldToFilter('store', $storeId)
            ->addFieldToFilter('enabled', 1);
        $categoris = $product->getCategoryIds();
        if (!isset($categoris) || empty($categoris)) {
            $categoris = [];
        }
        /** @var  \Magenest\SuperEasySeo\Model\Template $model */
        foreach ($modelTem as $model) {
            $applyFor = $model->getApplyFor();
            $checkNew = 1;
            if ($applyFor == 0) {
                if (isset($params['id']) && $params['id'] >0) {
                    $checkNew = 0;
                }
            }
            if ($checkNew == 1) {
                $categoryApply = $model->getApplyCategory();
                $arrayCategory = [];
                if (!empty($categoryApply)) {
                    $arrayCategory = explode(",", $categoryApply);
                }
                if (sizeof(array_intersect($categoris, $arrayCategory)) > 0) {
                    $this->getRenderText($params, $model, $product);
                }
            }
        }

        return;
    }

    /**
     * @param $product
     */
    public function setImageTag($product)
    {
        $variable = $product->getData('image-tag-variable');
        $variables = explode(" ", $variable);
        $sku = $product->getSku();
        $skuArr = explode("-", $sku);
        $superParentSku = $skuArr[0];
        $skuArr[0] = $this->productRepository->get($superParentSku)->getName();
        $skuArr = array_reverse($skuArr);
        $sku = implode(" ", $skuArr);

        $existingMediaGalleryEntries = $product->getMediaGalleryEntries();
        foreach ($existingMediaGalleryEntries as $key => $entry) {
            $id = " " . $entry->getId();
            $val = isset($variables[$key]) ? " " . $variables[$key] : "";
            $entry->setLabel($sku . $val . $id);
        }
        $product->setMediaGalleryEntries($existingMediaGalleryEntries);
    }
    /**
     * @param $params
     * @param $model
     * @param $product
     */
    public function getRenderText($params, $model, $product)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $attSet = $product->getAttributeSetId();
        $store = $params['store'];
        /** @var \Magenest\SuperEasySeo\Model\Template $model*/
        $assignType = $model->getAssignType();
        $checkRender = 1;
        if ($assignType == 2) {
            $attrTem = $model->getAttributeSet();
            if ($attSet != $attrTem) {
                $checkRender = 0;
            }
        } elseif ($assignType == 3) {
            if (isset($params['id'])) {
                $applyProduct = $model->getApplyProduct();
                $size = sizeof(array_intersect([$params['id']], explode(",", $applyProduct)));
                if ($size < 1) {
                    $checkRender = 0;
                }
            } else {
                $checkRender = 0;
            }
        }
        if ($checkRender == 1) {
            $arrayText = ['UrlKey', 'Description', 'ShortDescription', 'MetaTitle', 'MetaDescription'];

            foreach ($arrayText as $key => $value) {
                $callFun = 'get'.$value;
                if (!empty($model->$callFun())) {
                    $this->renderValue($model->$callFun(), $key, $product, $store);
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
    public function renderValue($text, $key, $product, $store)
    {
        $render = $this->helperRender->renderTemplate($text, $product, $store, 'product');
        $name = '';
        if ($key == 0) {
            $name = 'setUrlKey';
            $render =  preg_replace('#[^0-9a-z]+#i', '-', strtolower(trim($render)));
            if (strlen($text) > 30) {
                $render = substr($text, 0, 30);
            }
        }
        if ($key == 1) {
            $name = 'setDescription';
        }
        if ($key == 2) {
            $name = 'setShortDescription';
        }
        if ($key == 3) {
            $name = 'setMetaTitle';
        }
        if ($key == 4) {
            $name = 'setMetaDescription';
        }
        $product->$name($render);
    }
}
