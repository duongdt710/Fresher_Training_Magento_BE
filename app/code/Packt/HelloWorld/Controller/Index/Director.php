<?php
namespace Packt\HelloWorld\Controller\Index;
class Director extends \Magento\Framework\App\Action\Action {
    public function execute() {
        $director = $this->_objectManager->create('Packt\HelloWorld\Model\Director');
        $director->setName('Duong');
        $director->save();
        $this->getResponse()->setBody('success');
    }
}