<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\DataObject;
use Magento\Framework\Filter\FilterManager;

/**
 * Class UrlRewrite
 * @package Magenest\SuperEasySeo\Helper
 */
class UrlRewrite extends AbstractHelper
{
    /**
     * @var FilterManager
     */
    protected $filter;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $configB = [];

    /**
     * UrlRewrite constructor.
     * @param FilterManager $filter
     * @param Context $context
     */
    public function __construct(
        FilterManager $filter,
        Context $context
    ) {
        $this->filter = $filter;
        $this->urlManager = $context->getUrlBuilder();
        $this->scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
    }

    /**
     * @param $module
     * @param $isEnabled
     * @return $this
     */
    public function setRewriteMode($module, $isEnabled)
    {
        $this->config[$module]['_ENABLED'] = $isEnabled;

        return $this;
    }

    /**
     * @param $module
     * @param $path
     * @return $this
     */
    public function registerBasePath($module, $path)
    {
        $this->config[$module]['_BASE_PATH'] = $path;
        $this->configB[$path] = $module;

        return $this;
    }

    /**
     * @param $module
     * @param $type
     * @param $template
     * @param $action
     * @param array $params
     * @return $this
     */
    public function registerPath($module, $type, $template, $action, $params = [])
    {
        $this->config[$module][$type] = $template;
        $this->configB[$module . '_' . $type]['ACTION'] = $action;
        $this->configB[$module . '_' . $type]['PARAMS'] = $params;

        return $this;
    }

    /**
     * @param $module
     * @param $type
     * @param null $entity
     * @return string
     */
    public function getUrl($module, $type, $entity = null)
    {
        $basePath = $this->config[$module]['_BASE_PATH'];
        $configUrlSuffix = $this->scopeConfig->getValue('catalog/seo/product_url_suffix');
        $basePath = $this->urlManager->getDirectUrl($basePath.$configUrlSuffix);

        return $basePath;
    }

    /**
     * Math path
     *
     * @param string $pathInfo
     * @return bool|DataObject
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)0
     *  @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function match($pathInfo)
    {
        $identifier = trim($pathInfo, '/');
        $parts = explode('/', $identifier);
        if (count($parts) == 1) {
            $configUrlSuffix = $this->scopeConfig->getValue('catalog/seo/product_url_suffix');
            if ($configUrlSuffix != '' && $configUrlSuffix[0] != '.') {
                $configUrlSuffix = '.' . $configUrlSuffix;
            }
            $key = str_replace($configUrlSuffix, '', $parts[0]);
            $parts[0] = $key;
        }

        if (isset($this->configB[$parts[0]])) {
            $module = $this->configB[$parts[0]];
            $urlKey = '';

            # check on static urls (urls for static pages, ex. lists)
            $type = $rewrite = false;
            foreach ($this->config[$module] as $key => $value) {
                if ($value === $urlKey) {
                    if ($key == '_BASE_PATH') {
                        continue;
                    }
                    $type = $key;
                    break;
                }
            }

            if ($type) {
                $action = $this->configB[$module . '_' . $type]['ACTION'];
                $params = $this->configB[$module . '_' . $type]['PARAMS'];
                $result = new DataObject();
                $actionParts = explode('_', $action);

                $result->addData([
                    'route_name' => $actionParts[0],// routes name frontend
                    'module_name' => $actionParts[0],// module name frontend
                    'controller_name' => $actionParts[1],// index
                    'action_name' => $actionParts[2],// index
                    'action_params' => $params,
                ]);

                if ($rewrite) {
                    $result->setData('entity_id', $rewrite->getEntityId());
                }

                return $result;
            }

            return false;
        }
        return false;
    }
}
