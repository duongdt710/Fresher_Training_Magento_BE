<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class OptimizerConfig
 *
 * @package Magenest\SuperEasySeo\Model
 *
 * @method int getOptimizerId()
 * @method string getTitle()
 * @method string getCreatedAt()
 * @method int getBathSize()
 * @method string getPath()
 * @method int getUse64bit()
 * @method string getUtilitiesPath()
 * @method string getGifUtility()
 * @method string getGifUtilityExactPath()
 * @method string getGifUtilityOptions()
 * @method string getJpgUtility()
 * @method string getJpgUtilityExactPath()
 * @method string getJpgUtilityOptions()
 * @method string getPngUtility()
 * @method string getPngUtilityExactPath()
 * @method string getPngUtilityOptions()
 */
class OptimizerConfig extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\ResourceModel\OptimizerConfig');
    }
}
