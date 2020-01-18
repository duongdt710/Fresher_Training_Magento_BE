<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Config\Source;

/**
 * Class Pages
 * @package Magenest\SuperEasySeo\Model\Config\Source
 */
class Pages implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\CollectionFactory
     */
    protected $pageCollectionFactory;

    /**
     * @param \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory
     */
    public function __construct(
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory
    ) {
        $this->pageCollectionFactory = $pageCollectionFactory;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $collection = $this->pageCollectionFactory->create()
            ->addFieldToFilter('is_active', true);
        $result = [];
        foreach ($collection as $v) {
            $result[$v['identifier']] = $v['title'];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->toArray() as $k => $v) {
            $result[] = ['value' => $k, 'label' => $v];
        }

        return $result;
    }
}
