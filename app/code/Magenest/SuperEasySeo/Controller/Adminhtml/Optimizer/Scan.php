<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer;

/**
 * Class Scan
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer
 */
class Scan extends \Magento\Backend\App\Action
{
    /**
     * @var \Magenest\SuperEasySeo\Helper\Optimizer\Data
     */
    public $dataHelper;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Scan constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magenest\SuperEasySeo\Helper\Optimizer\Data $dataHelper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magenest\SuperEasySeo\Helper\Optimizer\Data $dataHelper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->dataHelper = $dataHelper;
        $this->logger = $logger;
        parent::__construct($context);
    }
    
    /**
     * Scan and reindex action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        set_time_limit(18000);
        try {
            $this->dataHelper->scanImage($id);
            $this->messageManager->addSuccessMessage(
                __('Scan and reindex operations completed successfully.')
            );
        } catch (\Exception $e) {
            $message = __('Scanning and reindexing failed.');
            $this->messageManager->addErrorMessage($message);
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        return $resultRedirect->setPath(
            'seo/optimizer/edit',
            ['id' => $id]
        );
    }
}
