<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Redirect;

use Magento\Backend\App\Action;

/**
 * Class Save
 *
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Redirect
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magenest\SuperEasySeo\Model\RedirectFactory
     */
    protected $redirect;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param \Magenest\SuperEasySeo\Model\RedirectFactory $redirectFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        \Magenest\SuperEasySeo\Model\RedirectFactory $redirectFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->redirect = $redirectFactory;
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
            $model = $this->redirect->create();
            if (!empty($data['redirect_id'])) {
                $model->load($data['redirect_id']);
                if ($data['redirect_id'] != $model->getRedirectId()) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Wrong template rule.'));
                }
            }
            $info = [
                'enabled' => $data['enabled'],
                'request_url'     => trim($data['request_url']),
                'target_url' =>  $data['target_url'],
//                'comment' => $data['comment'],
                'store' => implode(",", $data['store']),
                'sort_order' => $data['sort_order']
            ];
            $model->addData($info);
            $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($model->getData());
            try {
                $model->save();
                $this->messageManager->addSuccess(__('The rule has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError($e, __('Something went wrong while saving the rule.'));
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);

                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
