<?php
namespace Packt\HelloWorld\Model\ResourceModel\Subscription;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'subscription_id';

    protected function _construct()
    {
        $this->_init('Packt\HelloWorld\Model\Subscription','Packt\HelloWorld\Model\ResourceModel\Subscription');
    }
}
