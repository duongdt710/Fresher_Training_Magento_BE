<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\System\Config\Source;

/**
 * Class Cmspage
 * @package Magenest\SuperEasySeo\Model\System\Config\Source
 */
class Cmspage implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\CollectionFactory
     */
    protected $pageCollectionFactory;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory
     * @param \Magento\Framework\App\Request\Http                     $request
     * @param \Magento\Store\Model\StoreManagerInterface              $storeManager
     */
    public function __construct(
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->request = $request;
        $this->storeManager = $storeManager;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->pageCollectionFactory->create()->addFieldToFilter('is_active', true);

        return $collection->toOptionArray();
    }
}
