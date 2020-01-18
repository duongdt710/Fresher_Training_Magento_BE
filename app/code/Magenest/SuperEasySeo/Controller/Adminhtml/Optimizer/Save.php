<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer;

use Magento\Backend\App\Action;

/**
 * Class Save
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Optimizer
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magenest\SuperEasySeo\Model\OptimizerConfigFactory
     */
    protected $config;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param \Magenest\SuperEasySeo\Model\OptimizerConfigFactory $optimizerConfigFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        \Magenest\SuperEasySeo\Model\OptimizerConfigFactory $optimizerConfigFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->config = $optimizerConfigFactory;
        parent::__construct($context);
    }

    /**
     * Save user
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $model = $this->config->create();
            $data['created_at'] = time();
            if (!empty($data['optimizer_id'])) {
                $model->load($data['optimizer_id']);
                if ($data['optimizer_id'] != $model->getOptimizerId()) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Wrong template rule.'));
                }
            }
            $model->addData($data);
            $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($model->getData());
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('The rule has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the rule.'));
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);

                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
