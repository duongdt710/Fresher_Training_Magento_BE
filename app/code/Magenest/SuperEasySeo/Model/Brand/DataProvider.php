<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Model\Brand;

use Magenest\SuperEasySeo\Model\ResourceModel\Brand\CollectionFactory;
use Magenest\SuperEasySeo\Model\Brand;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var collection
     */
    protected $collection;
    /**
     * @var _loadedData
     */
    protected $_loadedData;

    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $actorCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $actorCollectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $actorCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array|_loadedData
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $contact) {
            $this->_loadedData[$contact->getId()] = $contact->getData();
        }

        return $this->_loadedData;
    }

}