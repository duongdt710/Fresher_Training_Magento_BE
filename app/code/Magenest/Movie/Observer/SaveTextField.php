<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveTextField implements ObserverInterface
{
    protected $_scopeConfigInterface;
    protected $configWriter;
    public function __construct(
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
    ){
        $this->_scopeConfigInterface = $scopeConfigInterface;
        $this->configWriter = $configWriter;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $value = $this->_scopeConfigInterface->getValue('movie/moviepage/text_field', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if($value == "ping"){
            $value = "pong";
        }
        $this->configWriter->save('movie/moviepage/text_field',  $value, $scope = \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT , $scopeId = 0);
    }
}