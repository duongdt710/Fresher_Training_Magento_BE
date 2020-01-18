<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model\Plugin;

use Magento\Framework\Event\ManagerInterface as EventManagerInterface;

/**
 * Class RegisterUrlRewrite
 * @package Magenest\SuperEasySeo\Model\Plugin
 */
class RegisterUrlRewrite
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * Constructor
     *
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        EventManagerInterface $eventManager
    ) {
        $this->eventManager = $eventManager;
    }

    /**
     * Dispatch our event before dispatch Frontend Controller
     *
     * @param \Magento\Framework\App\ActionInterface  $subject
     * @param \Magento\Framework\App\RequestInterface $request
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeDispatch($subject, $request)
    {
        $this->eventManager->dispatch('core_register_urlrewrite');
    }
}
