<?php
namespace Magenest\Movie\Observer;
use Magento\Framework\Event\ObserverInterface;
class RegisterVisitObserver implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $category = $observer->getCategory();

        $this->logger->debug(print_r($product->debug(), true));
        $this->logger->debug(print_r($category->debug(), true));
//        $this->logger->debug('Registered');
    }
}