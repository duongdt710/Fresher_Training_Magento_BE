<?php
namespace Packt\HelloWorld\Controller\Adminhtml\Movie;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    public function __construct(
    Context $context,
    PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
    $resultPage = $this->resultPageFactory->create();
    $resultPage->setActiveMenu('Packt_HelloWorld::movie');$resultPage->addBreadcrumb(__('HelloWorld'), __('HelloWorld'));
    $resultPage->addBreadcrumb(__('Manage Movie'),
    __('Manage Movie'));
    $resultPage->getConfig()->getTitle()->prepend(__('Movie'));
    return $resultPage;
    }
    protected function _isAllowed()
    {
    return $this->_authorization->isAllowed('Packt_HelloWorld::movie');
    }
}