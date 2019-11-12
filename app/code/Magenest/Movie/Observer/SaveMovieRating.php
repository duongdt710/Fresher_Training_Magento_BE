<?php
namespace Magenest\Movie\Observer;
use Magenest\Movie\Model\Movie;
use Magento\Framework\Event\ObserverInterface;

class SaveMovieRating implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var Movie $movie */
        $movie=$observer->getMovie();
        $movie->setData('rating', 0);
    }
}