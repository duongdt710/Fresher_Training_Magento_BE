<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Framework\Url;
use Magenest\SuperEasySeo\Helper\UrlRewrite;

/**
 * Class Router
 * @package Magenest\SuperEasySeo\Controller
 */
class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var UrlRewrite
     */
    protected $urlRewrite;


    /**
     * Router constructor.
     * @param ActionFactory $actionFactory
     * @param EventManagerInterface $eventManager
     * @param UrlRewrite $urlRewrite
     */
    public function __construct(
        ActionFactory $actionFactory,
        EventManagerInterface $eventManager,
        UrlRewrite $urlRewrite
    ) {
        $this->actionFactory = $actionFactory;
        $this->eventManager = $eventManager;
        $this->urlRewrite = $urlRewrite;
    }

    /**
     * {@inheritdoc}
     */
    public function match(RequestInterface $request)
    {
        /** @var \Magento\Framework\App\Request\Http $request */

        $identifier = trim($request->getPathInfo(), '/');

        $this->eventManager->dispatch(
            'core_controller_router_match_before',
            [
                'router'    => $this,
                'condition' => new DataObject(['identifier' => $identifier, 'continue' => true])
            ]
        );

        $pathInfo = $request->getPathInfo();

        $result = $this->urlRewrite->match($pathInfo);

        if ($result) {
            $params = [];
            if ($result->getEntityId()) {
                $params['id'] = $result->getEntityId();
            }
            $params = array_merge($params, $result->getActionParams());

            $request
                ->setModuleName($result->getModuleName())
                ->setControllerName($result->getControllerName())
                ->setActionName($result->getActionName())
                ->setParams($params)
                ->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);

            return $this->actionFactory->create(
                'Magento\Framework\App\Action\Forward',
                ['request' => $request]
            );
        }

        return false;
    }
}
