<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Preview\Category;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory as ResultJsonFactory;
use Magento\Catalog\Model\CategoryFactory;

/**
 * Class ShowPreview
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Preview
 */
class ShowPreview extends \Magento\Framework\App\Action\Action
{

    /**
     * @var ResultJsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * ShowPreview constructor.
     * @param Context $context
     * @param ResultJsonFactory $resultJsonFactory
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        Context $context,
        ResultJsonFactory $resultJsonFactory,
        CategoryFactory $categoryFactory
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * execute
     */
    public function execute()
    {
        $data = $this->_getDataJson();
        $resultJson = $this->resultJsonFactory->create();

        return $resultJson->setData($data);
    }

    /**
     * @return string
     */
    protected function _getDataJson()
    {

        $data = $this->getRequest()->getParams();
        if (!(isset($data['id']) && $data['id'])) {
            return [];
        }
        $productId = $data['id'];
        $categoryModel = $this->categoryFactory->create()->load($productId);
        $path = $categoryModel->getUrlModel()->getUrlInStore($categoryModel, $additional = []);
        $array = [
            'url_key' => $path,
            'name' => $categoryModel->getName(),
            'meta_title' => $categoryModel->getMetaTitle(),
            'size' => strlen($categoryModel->getMetaTitle()),
            'meta_description' => $categoryModel->getMetaDescription()
        ];

        return $array;
    }
}
