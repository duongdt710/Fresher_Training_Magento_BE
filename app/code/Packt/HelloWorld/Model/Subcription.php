<?php
namespace Packt\HelloWorld\Model;
class Subscription extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'packt_helloworld';

    protected $_eventPrefix = 'subscription';
    protected $_eventObject = 'subscription';

    protected function _construct()
    {
        $this->_init('Packt\HelloWorld\Model\ResourceModel\Subscription');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}