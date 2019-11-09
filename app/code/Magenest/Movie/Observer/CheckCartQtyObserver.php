<?php
namespace Magenest\Movie\Observer;
use Magento\Framework\Event\ObserverInterface;
class CheckCartQtyObserver implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer
                            $observer)
    {
        if ($observer->getProduct()->getQty() %2 != 0) {
            //Odd qty
            throw new \Exception('Qty must be even');
        }
    }
}