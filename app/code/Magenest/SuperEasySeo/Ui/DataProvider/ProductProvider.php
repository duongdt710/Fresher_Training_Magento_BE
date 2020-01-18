<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Ui\DataProvider;

use Magento\Framework\App\RequestInterface;
use Magenest\SuperEasySeo\Model\ResourceModel\Template\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class ProductProvider
 * @package Magenest\SuperEasySeo\Ui\DataProvider
 */
class ProductProvider extends AbstractDataProvider
{
    /**
     * LogDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param RequestInterface $request
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        RequestInterface $request,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create()->addFieldToFilter('type', 'product');
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
