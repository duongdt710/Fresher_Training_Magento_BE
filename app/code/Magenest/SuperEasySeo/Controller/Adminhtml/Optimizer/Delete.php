<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Delete
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magenest\SuperEasySeo\Model\OptimizerConfigFactory
     */
    protected $config;

    /**
     * @var \Magenest\SuperEasySeo\Model\OptimizerImageFactory
     */
    protected $image;

    /**
     * Delete constructor.
     * @param Context $context
     * @param \Magenest\SuperEasySeo\Model\OptimizerConfigFactory $configFactory
     * @param \Magenest\SuperEasySeo\Model\OptimizerImageFactory $imageFactory
     * @param \Psr\Log\LoggerInterface $loggerInterface
     */
    public function __construct(
        Context $context,
        \Magenest\SuperEasySeo\Model\OptimizerConfigFactory $configFactory,
        \Magenest\SuperEasySeo\Model\OptimizerImageFactory $imageFactory,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        parent::__construct($context);
        $this->logger = $loggerInterface;
        $this->config = $configFactory;
        $this->image = $imageFactory;
    }

    /**
     * delete attributes
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $modelConfig = $this->config->create();
        $modelImage = $this->image->create()->getCollection()->addFieldToFilter('optimizer_id', $id);
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $modelConfig->load($id);
                $modelConfig->delete();
                foreach ($modelImage as $image) {
                    $image->delete();
                }
                $this->messageManager->addSuccessMessage(__('The template has been deleted.'));

                return $resultRedirect->setPath('seo/optimizer/index', ['_current'=>true]);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('We can\'t delete the template right now.')
                );
                $this->_redirect('seo/optimizer/edit', ['id' => $id, '_current' => true]);
                return $resultRedirect->setPath('seo/optimizer/edit', ['id' => $id, '_current' => true]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
