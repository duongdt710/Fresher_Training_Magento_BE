<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class OptimizerImage
 *
 * @package Magenest\SuperEasySeo\Model
 *
 * @method int getImageId()
 * @method int getOptimizerId()
 * @method string getPathImage()
 * @method int getStatus()
 * @method string getErrorMessage()
 * @method string getSizeBefore()
 * @method string getSizeAfter()
 * @method string getOptimizedAt()
 */
class OptimizerImage extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magenest\SuperEasySeo\Model\ResourceModel\OptimizerImage');
    }
}
