<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Block\Adminhtml;

/**
 * Class Brand
 * @package Magenest\SuperEasySeo\Block\Adminhtml
 */
class Brand extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var \Magenest\SuperEasySeo\Model\ResourceModel\Brand\CollectionFactory
     */
    protected $brand;

    /**
     * Brand constructor.
     * @param \Magenest\SuperEasySeo\Model\ResourceModel\Brand\CollectionFactory $brand
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\ResourceModel\Brand\CollectionFactory $brand
    )
    {
        $this->brand = $brand;
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        $obj = \Magento\Framework\App\ObjectManager::getInstance();
        $this->_options = $this->getAvailableGroups();
        return $this->_options;
    }

    /**
     * @return array
     */
    private function getAvailableGroups()
    {
        $collection = $this->brand->create()->getData();
        $result = [];
        $result[] = ['value' => ' ', 'label' => 'Select...'];
        foreach ($collection as $group) {
            $result[] = ['value' => $group['brand_id'], 'label' => $group['brand_name']];
        }
        return $result;
    }
}