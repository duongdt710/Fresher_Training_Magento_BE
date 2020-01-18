<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Redirect
 *
 * @package Magenest\SuperEasySeo\Model
 *
 * @method int getRedirectId()
 * @method string getRequestUrl()
 * @method string getTargetUrl()
 * @method string getNotFound()
 * @method string getComment()
 * @method int getEnabled()
 * @method string getStore()
 * @method string getSortOrder()
 */
class Redirect extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\ResourceModel\Redirect');
    }
}
