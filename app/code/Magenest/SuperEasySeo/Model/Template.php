<?php
/**
 * Copyright © 2015 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Template
 *
 * @package Magenest\SuperEasySeo\Model
 *
 * @method int getTemplateId()
 * @method int getType()
 * @method int getStore()
 * @method int getEnabled()
 * @method int getAssignType()
 * @method string getNameTemplate()
 * @method int getApplyFor()
 * @method int getApplyCron()
 * @method string getAttributeSet()
 * @method string getApplyProduct()
 * @method string getApplyCategory()
 * @method string getUrlKey()
 * @method string getDescription()
 * @method string getShortDescription()
 * @method string getMetaTitle()
 * @method string getMetaDescription()
 */
class Template extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\ResourceModel\Template');
    }
}
