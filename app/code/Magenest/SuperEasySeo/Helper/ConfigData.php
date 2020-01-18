<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Helper;

use Magento\Framework\App\Helper\Context;

/**
 * Class ConfigData
 * @package Magenest\SuperEasySeo\Helper
 */
class ConfigData extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * ConfigData constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getEnable()
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getCms()
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/general/cms',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getNonCms()
    {
        return $this->scopeConfig->getValue(
            'super_easy_seo/general/noncms',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
