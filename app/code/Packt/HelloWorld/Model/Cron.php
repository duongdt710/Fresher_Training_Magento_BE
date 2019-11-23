<?php
namespace Packt\HelloWorld\Model;
class Cron {
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;
    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $objectManager;
    public function __construct(
        \Psr\Log\LoggerInterface
        $logger,\Magento\Framework\ObjectManagerInterface$objectManager
    ) {
        $this->logger = $logger;
        $this->objectManager = $objectManager;
    }
    public function checkSubscriptions() {
        $subscription = $this->objectManager->create('Packt\HelloWorld\Model\Subscription');
        $subscription->setFirstname('Cron');
        $subscription->setLastname('Job');
        $subscription->setEmail('cron.job@example.com');
        $subscription->setMessage('Created from cron');
        $subscription->save();
        $this->logger->debug('Test subscription added');
    }
}