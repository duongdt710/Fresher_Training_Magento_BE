<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Noroute;

/**
 * Class Index
 * @package Magenest\SuperEasySeo\Controller\Noroute
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magenest\SuperEasySeo\Model\RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Magenest\SuperEasySeo\Model\RedirectFactory $redirectFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magenest\SuperEasySeo\Model\RedirectFactory $redirectFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->redirectFactory = $redirectFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Render CMS 404 Not found page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $urlRequest = \Magento\Framework\App\ObjectManager::getInstance()
            ->get('Magento\Framework\UrlInterface')->getCurrentUrl();
        /** @var \Magenest\SuperEasySeo\Model\Redirect $redirectModel */
        $redirectModel = $this->redirectFactory->create()->getCollection()
            ->setOrder('sort_order', 'ASC')
            ->addFieldToFilter('enabled', 1);
        $storeId = $this->_storeManager->getStore()->getStoreId();
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        $lengthUrl = strlen($baseUrl);
        $text = substr($urlRequest, $lengthUrl);
        if (sizeof($redirectModel) > 0) {
            $resultRedirect = $this->resultRedirectFactory->create();
            foreach ($redirectModel as $redirect) {
                $requestUrl = $redirect->getRequestUrl();
                if ($requestUrl == '/'.$text) {
                    $targetUrl = substr($redirect->getTargetUrl(), 1);
                    $store = explode(",", $redirect->getStore());
                    if (in_array(0, $store) || in_array($storeId, $store)) {
                        return $resultRedirect->setPath($targetUrl);
                    }
                }
                $checkRequest = strpos($requestUrl, '*');
                if ($checkRequest > 0) {
                    $requestPath = trim(str_replace('*', '', substr($requestUrl, 1)));
                    if (strpos($text, $requestPath) !== false) {
                        $targetUrl = substr($redirect->getTargetUrl(), 1);
                        $store = explode(",", $redirect->getStore());
                        if (in_array(0, $store) || in_array($storeId, $store)) {
                            return $resultRedirect->setPath($targetUrl);
                        }
                    }
                }
            }
        }

        $pageId = $this->_objectManager->get(
            'Magento\Framework\App\Config\ScopeConfigInterface',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )->getValue('web/default/cms_no_route', 'store');
        /** @var \Magento\Cms\Helper\Page $pageHelper */
        $pageHelper = $this->_objectManager->get('Magento\Cms\Helper\Page');
        $resultPage = $pageHelper->prepareResultPage($this, $pageId);
        if ($resultPage) {
            $resultPage->setStatusHeader(404, '1.1', 'Not Found');
            $resultPage->setHeader('Status', '404 File not found');
            return $resultPage;
        } else {
            /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->setController('index');
            $resultForward->forward('defaultNoRoute');

            return $resultForward;
        }
    }
}
