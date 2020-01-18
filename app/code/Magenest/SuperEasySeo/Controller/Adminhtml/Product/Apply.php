<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Product;

use Magenest\SuperEasySeo\Helper\RenderTemplateRule;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magenest\SuperEasySeo\Model\TemplateFactory as Template;

/**
 * Class Apply
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Product
 */
class Apply extends \Magento\Backend\App\Action
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var CollectionFactory
     */
    protected $productCollection;

    /**
     * @var RenderTemplateRule
     */
    protected $helperRender;

    /**
     * @var Template
     */
    protected $templateFactory;


    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManage;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Action
     */
    protected $action;

    /**
     * Apply constructor.
     * @param Context $context
     * @param LoggerInterface $logger
     * @param CollectionFactory $collectionFactory
     * @param RenderTemplateRule $renderTemplateRule
     * @param Template $templateFactory
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
     */
    public function __construct(
        Action\Context $context,
        LoggerInterface $logger,
        \Magento\Catalog\Model\ProductFactory $collectionFactory,
        RenderTemplateRule $renderTemplateRule,
        Template $templateFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Catalog\Model\ResourceModel\Product\Action $action
    ) {
    
        parent::__construct($context);
        $this->logger = $logger;
        $this->productCollection = $collectionFactory;
        $this->helperRender = $renderTemplateRule;
        $this->templateFactory = $templateFactory;
        $this->categoryFactory = $categoryFactory;
        $this->storeManage = $storeManagerInterface;
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $params = $this->_request->getParams();
        /** @var \Magenest\SuperEasySeo\Model\Template $collections */
        $model = $this->templateFactory->create()->load($params['id']);

        $categoryApply = explode(",", $model->getApplyCategory());
        $storeId = $model->getStore();

        $products = $this->productCollection->create()->getCollection()
            ->addAttributeToSelect('*')
            ->setStore($storeId);


        $assignType = $model->getAssignType();

        if ($assignType == 2) {
            $products->addFieldToFilter('attribute_set_id', $model->getAttributeSet());
        }
        if ($assignType == 3) {
            $arrayProduct = explode(",", $model->getApplyProduct());
            $products->addFieldToFilter('entity_id', ['in' => $arrayProduct]);
        }

        $totals = 0;
        try {
            foreach ($products as $product) {
                /** @var \Magenest\SuperEasySeo\Model\Template $item */
                $categoryIds = $product->getCategoryIds();
                $size = sizeof(array_intersect($categoryApply, $categoryIds));
                if ($size > 0) {
                    $this->renderTemplate($product, $model);
                }
                $totals++;
            }
            $this->messageManager->addSuccess(__('The template has apply for %1 product(s) .', $totals));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, __('Something went wrong while apply .'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $id
     * @param $model
     * @param bool $getRootInstead
     * @return bool
     */
    public function renderTemplate($product, $model)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $store = $model->getStore();
        $arrayText = ['Description', 'ShortDescription', 'MetaTitle', 'MetaDescription'];

        foreach ($arrayText as $key => $value) {
            $callFun = 'get'.$value;
            if (!empty($model->$callFun())) {
                $this->renderValue($model->$callFun(), $key, $product, $store);
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
            $name = 'description';
        }

        if ($key == 1) {
            $name = 'short_description';
        }

        if ($key == 2) {
            $name = 'meta_title';
        }

        if ($key == 3) {
            $name = 'meta_description';
        }

        $this->action->updateAttributes([$product->getId()], [$name => $render], $store);
    }
}
