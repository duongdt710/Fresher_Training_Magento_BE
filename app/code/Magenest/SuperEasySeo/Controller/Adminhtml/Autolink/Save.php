<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Autolink;

use Magento\Backend\App\Action;

/**
 * Class Save
 *
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Autolink
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magenest\SuperEasySeo\Model\AutolinkFactory
     */
    protected $autolink;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param \Magenest\SuperEasySeo\Model\AutolinkFactory $autolinkFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        \Magenest\SuperEasySeo\Model\AutolinkFactory $autolinkFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->autolink = $autolinkFactory;
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
            $model = $this->autolink->create();
            if (!empty($data['autolink_id'])) {
                $model->load($data['autolink_id']);
                if ($data['autolink_id'] != $model->getAutolinkId()) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Wrong template rule.'));
                }
            }
            $info = [
                'enabled' => $data['enabled'],
                'keyword'     => trim($data['keyword']),
                'title' =>  $data['title'],
                'url' => $data['url'],
                'url_target' => $data['url_target'],
                'store' => implode(",", $data['store']),
                'sort_order' => $data['sort_order'],
                'use_product_description' => $data['use_product_description'],
                'use_product_short_description' => $data['use_product_short_description'],
                'use_category' => $data['use_category'],
                'use_cms' => $data['use_cms'],
                'render_html' => $this->renderHtml($data),
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

    public function renderHtml($data)
    {
        $url = $data['url'];
        $title = $data['title'];
        $target = $data['url_target'] == 1 ? '_self' : '_blank';
        $keyword = trim($data['keyword']);
        $result = "<a class=\"crosslink\" href=\"" . $url . "\" target=\"" . $target . "\" alt=\"" . $title . "\" title=\"" . $title . "\">" . $keyword . "</a>";

        return $result;
    }
}
