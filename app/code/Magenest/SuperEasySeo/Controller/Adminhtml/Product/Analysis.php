<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Product;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory as ResultJsonFactory;

/**
 * Class Analysis
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Product
 */
class Analysis extends \Magento\Framework\App\Action\Action
{

    /**
     * @var ResultJsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;


    /**
     * Analysis constructor.
     * @param Context $context
     * @param ResultJsonFactory $resultJsonFactory
     * @param \Magento\Framework\View\LayoutInterface $layout
     */
    public function __construct(
        Context $context,
        ResultJsonFactory $resultJsonFactory,
        \Magento\Framework\View\LayoutInterface $layout
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_layout = $layout;
        parent::__construct($context);
    }

    /**
     * execute
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if (!(isset($data['id']) && $data['id'] && $data['requestText'])) {
            return [];
        }
        $feedback = serialize($data);
        $resultLayout = $this->_layout->createBlock('Magenest\SuperEasySeo\Block\Adminhtml\Product\Content\Content')->setFeedback($feedback)->toHtml();

        $result = json_encode($resultLayout);
        $resultJson = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $sendResult = $resultJson->setData($result);

        return $sendResult;
    }
}
