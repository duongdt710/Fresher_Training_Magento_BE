<?php
namespace Magenest\Movie\Model;
class Movie extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'magenest_movie';

    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\ResourceModel\Movie');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}