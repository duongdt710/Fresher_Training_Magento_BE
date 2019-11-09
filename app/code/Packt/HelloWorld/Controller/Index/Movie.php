<?php
namespace Packt\HelloWorld\Controller\Index;
class Movie extends \Magento\Framework\App\Action\Action {
    public function execute() {
        $movie = $this->_objectManager->create('Packt\HelloWorld\Model\Movie');
        $movie->setName('Duong');
        $movie->setRating('3');
        $movie->setDescription('Depverloper');
        $movie->save();
        $this->getResponse()->setBody('success');
    }
}