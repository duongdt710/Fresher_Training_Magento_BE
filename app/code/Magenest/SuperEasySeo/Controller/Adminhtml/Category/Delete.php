<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Category;

use Magenest\SuperEasySeo\Model\TemplateFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Delete
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Category
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var TemplateFactory
     */
    protected $template;

    /**
     * Delete constructor.
     * @param Context $context
     * @param TemplateFactory $templateFactory
     * @param \Psr\Log\LoggerInterface $loggerInterface
     */
    public function __construct(
        Context $context,
        \Magenest\SuperEasySeo\Model\TemplateFactory $templateFactory,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        parent::__construct($context);
        $this->logger = $loggerInterface;
        $this->template = $templateFactory;
    }

    /**
     * delete attributes
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $templateId = $this->getRequest()->getParam('id');
        $model = $this->template->create();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($templateId) {
            $model->load($templateId);
            $model->delete();
            try {
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The template has been deleted.'));
                return $resultRedirect->setPath('seo/category/index', ['_current'=>true]);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('We can\'t delete the template right now.')
                );
                $this->_redirect('seo/category/edit', ['id' => $templateId, '_current' => true]);
                return $resultRedirect->setPath('seo/category/edit', ['id' => $templateId, '_current' => true]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
