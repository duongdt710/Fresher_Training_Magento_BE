<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magenest\SuperEasySeo\Model\ResourceModel\Redirect\CollectionFactory as RedirectFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class Redirect
 * @package Magenest\SuperEasySeo\Controller\Adminhtml
 */
abstract class Redirect extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var RedirectFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var Filter
     */
    protected $_filter;


    /**
     * Redirect constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param RedirectFactory $redirect
     * @param ForwardFactory $resultForwardFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        RedirectFactory $redirect,
        ForwardFactory $resultForwardFactory,
        Filter $filter
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_collectionFactory = $redirect;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_filter = $filter;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_SuperEasySeo::redirect')
            ->addBreadcrumb(__('Redirect Template'), __('Redirect Template'));
        $resultPage->getConfig()->getTitle()->set(__('Redirect Template'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_SuperEasySeo::redirect');
    }
}
