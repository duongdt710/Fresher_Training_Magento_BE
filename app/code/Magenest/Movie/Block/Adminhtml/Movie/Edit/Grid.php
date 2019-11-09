<?php
namespace Magenest\Movie\Block\Adminhtml\Subscription;
use Magento\Backend\Block\Widget\Grid as WidgetGrid;
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
/*** @var \Magenest\Movie\Model\Resource\Movie\Collection
*/
protected $_movieCollection;
/**
* @param \Magento\Backend\Block\Template\Context $context
* @param \Magento\Backend\Helper\Data $backendHelper
* @param \Magenest\Movie\Model\ResourceModel\Movie\Collection $movieCollection
* @param array $data
*/
public function __construct(
\Magento\Backend\Block\Template\Context $context,
\Magento\Backend\Helper\Data $backendHelper,
\Magenest\Movie\Model\ResourceModel\Movie\Collection
$movieCollection,
array $data = []
) {
$this->_movieCollection = $movieCollection;
parent::__construct($context, $backendHelper, $data);
$this->setEmptyText(__('No Subscriptions Found'));
}
/**
* Initialize the subscription collection
*
* @return WidgetGrid
*/
protected function _prepareCollection()
{
$this->setCollection($this->_movieCollection);
return parent::_prepareCollection();
}
}