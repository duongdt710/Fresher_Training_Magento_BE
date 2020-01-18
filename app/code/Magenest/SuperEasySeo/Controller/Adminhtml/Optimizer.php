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
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magenest\SuperEasySeo\Model\ResourceModel\OptimizerConfig\CollectionFactory as InformationFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class Optimizer
 * @package Magenest\SuperEasySeo\Controller\Adminhtml
 */
abstract class Optimizer extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

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
     * @var InformationFactory
     */
    protected $_collectionFactory;


    /**
     * Optimizerr constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param InformationFactory $inforFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        InformationFactory $inforFactory,
        Filter $filter
    ) {
        $this->_collectionFactory = $inforFactory;
        $this->_coreRegistry = $coreRegistry;
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
        $resultPage->setActiveMenu('Magenest_SuperEasySeo::optimize_form')
            ->addBreadcrumb(__('Images Optimizer'), __('Images Optimizer'));
        $resultPage->getConfig()->getTitle()->set(__('Images Optimizer'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_SuperEasySeo::optimize_form');
    }
}
