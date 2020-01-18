<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block;

/**
 * Class CanonicalTag
 * @package Magenest\SuperEasySeo\Block
 */
class CanonicalTag extends \Magento\Framework\View\Element\Template
{
    const CANONICAL_TAGS = 'super_easy_seo/canonicalization/canonical_tags';


    /**
     * @return mixed
     */
    protected function getConfig()
    {
        $model = \Magento\Framework\App\ObjectManager::getInstance()->create('Magento\Framework\App\Config\ScopeConfigInterface');
        $pattern = $model->getValue(self::CANONICAL_TAGS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $pattern;
    }

    /**
     * @param $pattern
     * @return bool
     */
    protected function setTag($tag)
    {
        $config = $this->getConfig();
        $config = explode(",",$config);
        if(in_array($tag,$config))
            return true;

        return false;
    }

    /**
     * @return string
     */
    protected function cleanUrl()
    {
        $url=strtok($this->getRequest()->getServer()["REQUEST_URI"],'?');

        return $url;
    }


    /**
     * @return string
     */
    protected function _toHtml()
    {

        return parent::_toHtml();
    }
}
