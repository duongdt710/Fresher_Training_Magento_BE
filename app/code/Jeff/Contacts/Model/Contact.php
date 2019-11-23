<?php
namespace Jeff\Contacts\Model;
class Contact extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'jeff_contacts_contact';

    protected function _construct()
    {
        $this->_init('Jeff\Contacts\Model\ResourceModel\Contact');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}