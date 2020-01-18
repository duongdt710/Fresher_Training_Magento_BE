<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Preview\Category;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

/**
 * Class Grid
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Preview\Category
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_template = 'preview/category.phtml';
    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $catoryFactory;

    /**
     * Grid constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context     $context,
        \Magento\Backend\Helper\Data    $backendHelper,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array   $data = []
    ) {
        $this->catoryFactory = $categoryFactory;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No	Category	Found'));
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        $collection = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Catalog\Model\Category')->getCollection()
            ->addFieldToFilter('level', ['gt' => 0])
            ->addAttributeToSelect('name', true)
            ->addAttributeToSelect('url_key', true)
            ->addAttributeToSelect('description', true)
            ->addAttributeToSelect('meta_title', true)
            ->addAttributeToSelect('meta_description', true);

        return $collection;
    }

    /**
     * @param $id
     * @return string
     */
    public function returnCategory($id)
    {
        return $this->getUrl('catalog/category/edit', ['id' => $id]);
    }

    /**
     * @return string
     */
    public function getPreviewUrl()
    {
        return $this->getUrl('seo/preview/showPreview', ['_secure' => true]);
    }

    /**
     * @return mixed
     */
    public function getToolbarContent()
    {
        $layout = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template')->setTemplate('Magenest_SuperEasySeo::preview/toolbar.phtml')->toHtml();

        return $layout;
    }
}
