<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Autolink
 *
 * @package Magenest\SuperEasySeo\Model
 *
 * @method int getAutolinkId()
 * @method string getKeyword()
 * @method string getTitle()
 * @method string getUrlTarget()
 * @method string getUrl()
 * @method string getStore()
 * @method int getMaxReplace()
 * @method int getSortOrder()
 * @method int getEnabled()
 * @method int getUseProductDescription()
 * @method int getUseProductShortDescription()
 * @method int getUseCategory()
 * @method int getUseCms()
 * @method string getRenderHtml()
 */
class Autolink extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\ResourceModel\Autolink');
    }
}
