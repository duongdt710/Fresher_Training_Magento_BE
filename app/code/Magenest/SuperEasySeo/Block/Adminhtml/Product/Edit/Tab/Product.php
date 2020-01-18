<?php
/**
 * Copyright © 2015 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 *
 *
 * Magenest_Ticket extension
 * NOTICE OF LICENSE
 *
 * @category  Magenest
 * @package   Magenest_Ticket
 * @author ThaoPV <thaopw@gmail.com>
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Product\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data  as BackendHelper;
use Magento\Framework\Registry;

/**
 * Class Product
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Product\Edit\Tab
 */
class Product extends Extended
{
    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * Product constructor.
     * @param Context $context
     * @param BackendHelper $backendHelper
     * @param Registry $coreRegistry
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        BackendHelper $backendHelper,
        Registry $coreRegistry,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        array $data = []
    ) {
        $this->_productFactory = $productFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Prepare collection
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_productFactory->create()->getCollection()
            ->addAttributeToFilter('visibility', 4)
            ->addAttributeToSelect(
                'name'
            )->addAttributeToSelect(
                'sku'
            )->addAttributeToSelect(
                'price'
            );

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare Columns
     *
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'use_product',
            [
                'type'             => 'checkbox',
                'name'             => 'use_product',
            //                'values'           => $this->_getSelectedProducts(),
                'index'            => 'entity_id',
                'header_css_class' => 'col-select col-massaction',
                'column_css_class' => 'col-select col-massaction',
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header'           => __('ID'),
                'sortable'         => true,
                'index'            => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn('name', ['header' => __('Name'), 'index' => 'name']);
        $this->addColumn('type_id', ['header' => __('Type'), 'index' => 'type_id']);
        $this->addColumn('sku', ['header' => __('SKU'), 'index' => 'sku']);
        $this->addColumn(
            'price',
            [
                'header'        => __('Price'),
                'type'          => 'currency',
                'currency_code' => (string) $this->_scopeConfig->getValue(
                    \Magento\Directory\Model\Currency::XML_PATH_CURRENCY_BASE,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
                'index'         => 'price',
            ]
        );
        return parent::_prepareColumns();
    }
}
