<?php
namespace Packt\HelloWorld\Model\ResourceModel;
class Subscription extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    public function _construct() {
    $this->_init('packt_helloworld_subscription', 'subscription_id');
    }
}