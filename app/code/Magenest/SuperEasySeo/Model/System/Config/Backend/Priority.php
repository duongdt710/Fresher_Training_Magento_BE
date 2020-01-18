<?php

namespace MMagenest\SuperEasySeo\Model\System\Config\Backend;

/**
 * Class Priority
 * @package MMagenest\SuperEasySeo\Model\System\Config\Backend
 */
class Priority extends \Magento\Framework\Config\Data
{
    /**
     * @return $this
     * @throws \Exception
     */
    public function beforeSave()
    {
        $value = trim($this->getValue());
        $value = (float) $value;
        if ($value < 0 || $value > 1) {
            throw new \Exception(__('Priority must be between 0 and 1'));
        }

        return $this;
    }
}
