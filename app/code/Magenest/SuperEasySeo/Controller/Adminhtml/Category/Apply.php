<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Category;

use Magenest\SuperEasySeo\Helper\RenderTemplateRule;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magenest\SuperEasySeo\Model\TemplateFactory as Template;

/**
 * Class Apply
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Category
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
    protected $categoryCollection;

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
     * Apply constructor.
     * @param Context $context
     * @param LoggerInterface $logger
     * @param CollectionFactory $collectionFactory
     * @param RenderTemplateRule $renderTemplateRule
     * @param Template $templateFactory
     */
    public function __construct(
        Action\Context $context,
        LoggerInterface $logger,
        CollectionFactory $collectionFactory,
        RenderTemplateRule $renderTemplateRule,
        Template $templateFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
    ) {
    
        parent::__construct($context);
        $this->logger = $logger;
        $this->categoryCollection = $collectionFactory;
        $this->helperRender = $renderTemplateRule;
        $this->templateFactory = $templateFactory;
        $this->categoryFactory = $categoryFactory;
        $this->storeManage = $storeManagerInterface;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $params = $this->_request->getParams();
        /** @var \Magenest\SuperEasySeo\Model\Template $collections */
        $collections = $this->templateFactory->create()->load($params['id']);
        $storeId = $collections->getStore();
        $categories = $this->categoryCollection->create()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('level', ['gt' => 0])
            ->setStore($storeId);
        $totals = 0;
        try {
            foreach ($categories as $category) {
                /** @var \Magenest\SuperEasySeo\Model\Template $item */
                $this->renderTemplate($category, $collections);
                $totals++;
            }

            $this->messageManager->addSuccess(__('The template has apply for category .'));
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
    public function renderTemplate($categoryModel, $model, $getRootInstead = false)
    {
        /** @var \Magento\Catalog\Model\Category $category */

        /** @var \Magenest\SuperEasySeo\Model\Template $model*/
        $assignType = $model->getAssignType();
        $checkRender = 1;
        if ($assignType == 2) {
            $applyCategory = $model->getApplyCategory();
            $size = sizeof(array_intersect([$categoryModel->getId()], explode(",", $applyCategory)));
            if ($size < 1) {
                $checkRender = 0;
            }
        }
        if ($checkRender == 1) {
            $arrayText = ['UrlKey', 'Description', 'MetaTitle', 'MetaDescription'];
            $i = 0;
            $data = [];
            foreach ($arrayText as $key => $value) {
                $callMethod = 'get'.$value;
                if (!empty($model->$callMethod())) {
                    $result = $this->renderValue($model->$callMethod(), $key, $categoryModel, $model->getStore());
                    $name = '';
                    if ($key == 0) {
                        $name = 'url_key';
                    }
                    if ($key == 1) {
                        $name = 'description';
                    }
                    if ($key == 2) {
                        $name = 'meta_title';
                    }
                    if ($key == 3) {
                        $name = 'meta_description';
                    }
                    $data[$name] = $result;
                }
                $i++;
            }
            if (in_array('url_key', $data)) {
                $data ['url_path'] = $data['url_key'];
                $data ['url_key_create_redirect'] = $data['url_key'];
            }

            $category =  $this->_initCategory($categoryModel, $model->getStore());
            $category->addData($data)->save();
        }
    }

    /**
     * @param $text
     * @param $key
     * @param $productId
     * @param $store
     */
    public function renderValue($text, $key, $categoryModel, $store)
    {
        $render = $this->helperRender->renderTemplate($text, $categoryModel, $store, 'category');
        if ($key == 0) {
            $render = str_replace(" ", "-", strtolower($render));
            if (strlen($text) > 30) {
                $render = substr($text, 0, 30);
            }
        }

        return $render;
    }

    /**
     * Initialize requested category and put it into registry.
     * Root category can be returned, if inappropriate store/category is specified
     *
     * @param bool $getRootInstead
     * @return \Magento\Catalog\Model\Category|false
     */
    protected function _initCategory($categoryModel, $storeId, $getRootInstead = false)
    {
        $categoryId = $categoryModel->getId();
        $category = $this->_objectManager->create('Magento\Catalog\Model\Category');
        $category->setStoreId($storeId);

        if ($categoryId) {
            $category->load($categoryId);
            if ($storeId) {
                $rootId = $this->_objectManager->get(
                    'Magento\Store\Model\StoreManagerInterface'
                )->getStore(
                    $storeId
                )->getRootCategoryId();
                if (!in_array($rootId, $category->getPathIds())) {
                    // load root category instead wrong one
                    if ($getRootInstead) {
                        $category->load($rootId);
                    } else {
                        return false;
                    }
                }
            }
        }

        return $category;
    }
}
