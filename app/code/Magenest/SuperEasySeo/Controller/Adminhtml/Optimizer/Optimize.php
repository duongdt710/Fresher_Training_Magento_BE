<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer;

/**
 * Class Optimize
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer
 */
class Optimize extends \Magento\Backend\App\Action
{
    /**
     * @var \Magenest\SuperEasySeo\Helper\Optimizer\Data
     */
    public $dataHelper;

    /**
     * @var \Magenest\SuperEasySeo\Model\OptimizerImageFactory
     */
    protected $imageOptimizer;

    /**
     * Optimize constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magenest\SuperEasySeo\Helper\Optimizer\Data $dataHelper
     * @param \Magenest\SuperEasySeo\Model\OptimizerImageFactory $imageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magenest\SuperEasySeo\Helper\Optimizer\Data $dataHelper,
        \Magenest\SuperEasySeo\Model\OptimizerImageFactory $imageFactory
    ) {
        $this->dataHelper = $dataHelper;
        $this->imageOptimizer     = $imageFactory;
        parent::__construct($context);
    }
    
    /**
     * Optimizer action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        set_time_limit(18000);
        /** @var \Magenest\SuperEasySeo\Model\OptimizerImage $modelImage */
        $modelImage = $this->imageOptimizer->create()->getCollection()
            ->addFieldToFilter('optimizer_id', $id)
            ->addFieldToFilter('status', 1);
        try {
            $this->dataHelper->optimize($id);
            foreach ($modelImage as $model) {
                $path = $model->getPathImage();
                $size = ((int)filesize($path))/1000;
                $array = [
                    'status' => 2,
                    'size_after' => $size
                ];
                $model->addData($array)->save();
            }
            $this->messageManager->addSuccessMessage(
                __('Optimization operations completed successfully.')
            );
        } catch (\Exception $e) {
            $message = __('Optimization failed.');
            $this->messageManager->addErrorMessage($message);
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        return $resultRedirect->setPath('seo/optimizer/edit', ['id' => $id]);
    }
}
