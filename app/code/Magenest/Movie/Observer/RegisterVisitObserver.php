<?php
namespace Magenest\Movie\Observer;
use Magento\Customer\Model\Customer;
use Magento\Framework\Event\ObserverInterface;
class RegisterVisitObserver implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;
    protected $_request;
    protected $_layout;
    protected $_objectManager = null;
    protected $_customerGroup;
    protected $_customerRepositoryInterface;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    )
    {;
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->logger = $logger;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->logger->debug('Magenest');
        /** @var Customer $customer */
        $customer = $observer->getCustomer();
        $customer->setFirstname('Magenest');
    }
}