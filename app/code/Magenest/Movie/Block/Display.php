<?php namespace Magenest\Movie\Block;

use Magento\Framework\View\Element\Template;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory;

class Display extends Template
{
    protected $_collectionFactory;

    public function __construct(CollectionFactory $collectionFactory ,Template\Context $context, array $data = [])
    {
        $this->_collectionFactory=$collectionFactory;
        parent::__construct($context, $data);
    }

    public function getDataDisplay()
    {
        $item=$this->_collectionFactory->create();
        return $item->getData();
    }
}