<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;
use Magento\Framework\DataObject;

/**
 * Class ListImages
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Edit\Tab
 */
class ListImages extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Count totals
     *
     * @var boolean
     */
    protected $_countTotals = true;

    /**
     * @var \Magenest\SuperEasySeo\Model\ResourceModel\OptimizerImage\Collection
     */
    protected $imageCollection;

    /**
     * Totals
     *
     * @var \Magento\Framework\DataObject
     */
    protected $_varTotals;

    /**
     * Grid constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magenest\SuperEasySeo\Model\ResourceModel\OptimizerImage\Collection $loggerCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magenest\SuperEasySeo\Model\OptimizerImageFactory $loggerCollection,
        array $data = []
    ) {
        $this->imageCollection = $loggerCollection;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No	Image Found'));
    }

    /**
     * Get Totals
     *
     * @return \Magento\Framework\DataObject
     */
    public function getTotals()
    {
        $this->_varTotals = new DataObject;
        $fields = [
            'size_before' => 0.0000,
            'size_after' => 0.0000,
        ];
        foreach ($this->getCollection() as $image) {
            foreach ($fields as $field => $value) {
                $fields[$field] += $image->getData($field);
            }
        }
        $fields['image_id']='Totals';
        $this->_varTotals->setData($fields);
        return $this->_varTotals;
    }

    /**
     * Initialize the subscription collection
     *
     * @return WidgetGrid
     */
    protected function _prepareCollection()
    {
        $id = $this->_request->getParam('id');
        $collection = $this->imageCollection->create()->getCollection()->addFilter('optimizer_id', $id);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'image_id',
            [
                'header' => __('ID'),
                'index' => 'image_id',
            ]
        );
        $this->addColumn(
            'path_image',
            [
                'header' => __('Path'),
                'index' => 'path_image',
            ]
        );
        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'renderer'  => '\Magenest\SuperEasySeo\Block\Adminhtml\Optimizer\Grid\Renderer\Status',
            ]
        );
        $this->addColumn(
            'size_before',
            [
                'header' => __('Size Before (kB)'),
                'index' => 'size_before',
            ]
        );
        $this->addColumn(
            'size_after',
            [
                'header' => __('Size After (kB)'),
                'index' => 'size_after',
            ]
        );

        return $this;
    }

//    /**
//     * @return $this
//     * add action in box action
//     */
//    protected function _prepareMassaction()
//    {
//
//        $this->setMassactionIdField('image_id');
//        $this->getMassactionBlock()->setTemplate('Magento_Backend::widget/grid/massaction_extended.phtml');
//        $this->getMassactionBlock()->setFormFieldName('list_image');
//
//        $this->getMassactionBlock()->addItem(
//            'delete_list_image',
//            [
//                'label' => __('Delete'),
//                'url' => $this->getUrl('*/*/massDeleteImage', ['id'=> $this->_request->getParam('id')]),
//                'confirm' => __('Are you sure to delete ?')
//            ]
//        );
//
//        return $this;
//    }
}
