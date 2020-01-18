<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Preview\Edit;

/**
 * Class Form
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Preview\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_template = 'preview/snippet.phtml';

    /**
     * @var
     */
    protected $_prepareForm;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $product;

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Review\Model\ReviewFactory
     */
    protected $_reviewFactory;

    /**
     * Form constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        array $data = []
    ) {
    
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_systemStore = $systemStore;
        $this->product = $productFactory;
        $this->_reviewFactory = $reviewFactory;
    }

    public function getInformation()
    {
        $productId = $this->_request->getParam('id');
        $model = $this->product->create()->load($productId);
        $additional = [];
        $path = $model->getUrlModel()->getUrl($model, $additional);
        $this->_reviewFactory->create()->getEntitySummary($model, $this->_storeManager->getStore()->getId());
        $review_counts = $model->getRatingSummary()->getReviewsCount();
        $rating_summary = $model->getRatingSummary()->getRatingSummary();
        $metaTitle = $model->getMetaTitle();
        $metaDescription =  $model->getMetaDescription();
        $array = [
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'url_path' => $path,
            'rating_summary' => $rating_summary,
            'reviews_count' => $review_counts
        ];

        return $array;
    }

}
