<?php
namespace Mageplaza\HelloWorld\Model\ResourceModel;
class Post extends
\Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    public function _construct() {
        $this->_init('mageplaza_helloworld_post', 'post_id');
    }
}