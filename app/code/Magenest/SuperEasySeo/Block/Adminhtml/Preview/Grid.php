<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Preview;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $productFactory;
    public function __construct(
        \Magento\Backend\Block\Template\Context     $context,
        \Magento\Backend\Helper\Data    $backendHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        array   $data = []
    ) {

        $this->productFactory   =   $productFactory;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No	Product	Found'));
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->productFactory->create()->getCollection()
//            ->addAttributeToFilter('visibility', 4)
            ->addAttributeToSelect(
                '*'
            );
        $this->setCollection($collection);
        return  parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    public function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header'    =>  __('ID'),
                'index'     =>  'entity_id',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header'    =>  __('Name'),
                'index'     =>  'name',
            ]
        );
        $this->addColumn(
            'thumbnail',
            [
                'header' => __('Thumbnail'),
                'index' => 'thumbnail',
                'class' =>'thumbnail',
                'renderer'  => 'Magenest\SuperEasySeo\Block\Adminhtml\Preview\Renderer\Image',
            ]
        );
        $this->addColumn(
            'url_key',
            [
                'header'    =>  __('Url Key'),
                'index'     =>  'url_key',
            ]
        );
        $this->addColumn(
            'meta_title',
            [
                'header'    =>  __('Meta Title'),
                'index'     =>  'meta_title',
                'currency_code' => __('$')
            ]
        );
        $this->addColumn(
            'length_meta_title',
            [
                'header' => __('Length Meta Title'),
                'index' => 'meta_title',
                'class' =>'meta_title',
                'renderer'  => 'Magenest\SuperEasySeo\Block\Adminhtml\Preview\Renderer\LengthTitle',
            ]
        );
        $this->addColumn(
            'meta_description',
            [
                'header'    =>  __('Meta Description'),
                'index'     =>  'meta_description',
            ]
        );
        $this->addColumn(
            'length_meta_description',
            [
                'header' => __('Length Meta Description'),
                'index' => 'meta_description',
                'class' =>'meta_description',
                'renderer'  => 'Magenest\SuperEasySeo\Block\Adminhtml\Preview\Renderer\LengthDescription',
            ]
        );
        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => 'catalog/product/edit'
                        ],
                        'field' => 'id'
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );
        $this->addColumn(
            'preview',
            [
                'header' => __('Preview'),
                'type' => 'button',
                'getter' => 'getId',
                'class' => 'upload',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );
        return  parent::_prepareColumns();
    }
}
