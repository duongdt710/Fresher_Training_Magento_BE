<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Ui\DataProvider;

use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class CategoryPreviewProvider
 * @package Magenest\SuperEasySeo\Ui\DataProvider
 */
class CategoryPreviewProvider extends AbstractDataProvider
{

    /**
     * LogDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Catalog\Model\Category')->getCollection()
            ->addFieldToFilter('level', ['gt' => 0])
            ->addAttributeToSelect('name', true)
            ->addAttributeToSelect('url_key', true)
            ->addAttributeToSelect('description', true)
            ->addAttributeToSelect('meta_title', true)
            ->addAttributeToSelect('meta_description', true);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $items = [];
        /** @var \Magento\Framework\Model\AbstractModel $attribute */
        foreach ($this->getCollection() as $attribute) {
            $items[] = $attribute->toArray();
        }

        return [
            'totalRecords' => $this->collection->getSize(),
            'items' => $items
        ];
    }
}
