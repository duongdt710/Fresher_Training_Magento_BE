<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Pager;

use Magenest\SuperEasySeo\Model\Config;
use Magento\Framework\Model\Context;
use Magento\Framework\DataObject;

/**
 * Class Collection
 * @package Magenest\SuperEasySeo\Model\Pager
 */
class Collection extends DataObject
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var int
     */
    protected $pageSize;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var array
     */
    protected $collection = [];

    /**
     * @param Config  $config
     * @param Context $context
     */
    public function __construct(
        Config $config,
        Context $context
    ) {
        $this->config = $config;
        $this->context = $context;
        parent::__construct();
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getLastPageNumber()
    {
        return ceil(count($this->collection)/$this->getSize());
    }

    /**
     * @return int
     */
    public function getCurPage()
    {
        return $this->currentPage;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setPageSize($size)
    {
        $this->pageSize = $size;

        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setCurPage($page)
    {
        $this->currentPage = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * @param array $collection
     *
     * @return void
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function getCollection()
    {
        return $this->collection;
    }
}
