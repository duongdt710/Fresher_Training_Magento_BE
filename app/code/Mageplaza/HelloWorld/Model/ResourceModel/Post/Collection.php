<?php
namespace Mageplaza\HelloWorld\Model\ResourceModel\Post;
/**
* Subscription Collection
*/
class Collection extends
\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
    * Initialize resource collection
    *
    * @return void
    */
    public function _construct() {
    $this->_init('Packt\HelloWorld\Model\Post',
    'Packt\HelloWorld\Model\ResourceModel\Post');
    }
}