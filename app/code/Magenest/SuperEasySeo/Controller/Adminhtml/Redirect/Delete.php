<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Redirect;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Delete
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Redirect
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magenest\SuperEasySeo\Model\RedirectFactory
     */
    protected $redirect;

    /**
     * Delete constructor.
     * @param Context $context
     * @param \Magenest\SuperEasySeo\Model\RedirectFactory $redirectFactory
     * @param \Psr\Log\LoggerInterface $loggerInterface
     */
    public function __construct(
        Context $context,
        \Magenest\SuperEasySeo\Model\RedirectFactory $redirectFactory,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        parent::__construct($context);
        $this->logger = $loggerInterface;
        $this->redirect = $redirectFactory;
    }

    /**
     * delete attributes
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->redirect->create();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $model->load($id);
            $model->delete();
            try {
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The template has been deleted.'));
                return $resultRedirect->setPath('seo/redirect/index', ['_current'=>true]);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('We can\'t delete the template right now.')
                );
                $this->_redirect('seo/redirect/edit', ['id' => $id, '_current' => true]);
                return $resultRedirect->setPath('seo/redirect/edit', ['id' => $id, '_current' => true]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
