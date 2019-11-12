<?php
namespace Magenest\Movie\Controller\Index;
class Event extends \Magento\Framework\App\Action\Action {
    /** @var \Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    public function execute() {
        $resultPage = $this->resultPageFactory->create();
//        $parameters = [ 'product' => $this->_objectManager->create('Magento\Catalog\Model\Product')->load(2055),
//                    'category' => $this->_objectManager->create('Magento\Catalog\Model\Product')->load(41),];
//        $this->_eventManager->dispatch('helloworld_register_visit', $parameters);
        return $resultPage;
    }
}