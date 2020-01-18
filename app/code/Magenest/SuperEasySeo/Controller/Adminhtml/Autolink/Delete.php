<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Autolink;

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
     * @var \Magenest\SuperEasySeo\Model\AutolinkFactory
     */
    protected $autolink;

    /**
     * Delete constructor.
     * @param Context $context
     * @param \Magenest\SuperEasySeo\Model\AutolinkFactory $autolinkFactory
     * @param \Psr\Log\LoggerInterface $loggerInterface
     */
    public function __construct(
        Context $context,
        \Magenest\SuperEasySeo\Model\AutolinkFactory $autolinkFactory,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        parent::__construct($context);
        $this->logger = $loggerInterface;
        $this->autolink = $autolinkFactory;
    }

    /**
     * delete attributes
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->autolink->create();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $model->load($id);
            $model->delete();
            try {
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The template has been deleted.'));
                return $resultRedirect->setPath('seo/autolink/index', ['_current'=>true]);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('We can\'t delete the template right now.')
                );
                $this->_redirect('seo/autolink/edit', ['id' => $id, '_current' => true]);
                return $resultRedirect->setPath('seo/autolink/edit', ['id' => $id, '_current' => true]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
