<?php
namespace Jeff\Contacts\Model\ResourceModel\Contact;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'jeff_contacts_contact_id';

    protected function _construct()
    {
        $this->_init('Jeff\Contacts\Model\Contact','Jeff\Contacts\Model\ResourceModel\Contact');
    }
}
