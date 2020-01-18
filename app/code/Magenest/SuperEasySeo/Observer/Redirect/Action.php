<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Observer\Redirect;

/**
 * Class Action
 * @package Magenest\SuperEasySeo\Observer\Redirect
 */
class Action implements \Magento\Framework\Event\ObserverInterface
{
    protected $logger;
    protected $resultRedirectFactory;

    /**
     * Action constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->_request = $request;
        $this->logger = $logger;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
    }
}
