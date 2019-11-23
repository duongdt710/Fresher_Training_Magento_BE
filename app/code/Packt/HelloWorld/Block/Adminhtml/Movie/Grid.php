<?php
namespace Packt\HelloWorld\Block\Adminhtml\Movie;
use Magento\Backend\Block\Widget\Grid as WidgetGrid;
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /*** @var \Packt\HelloWorld\Model\Resource\Movie\Collection
    */
    protected $_movieCollection;
    /**
    * @param \Magento\Backend\Block\Template\Context $context
    * @param \Magento\Backend\Helper\Data $backendHelper
    * @param \Packt\HelloWorld\Model\ResourceModel\Subscription\Collection $subscriptionCollection
    * @param array $data
    */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Magento\Backend\Helper\Data $backendHelper,
    \Packt\HelloWorld\Model\ResourceModel\Movie\Collection
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
    /**
    * Prepare grid columns
    *
    * @return $this
    */
    protected function _prepareColumns()
    {
    $this->addColumn(
        'movie_id',
        [
        'header' => __('ID'),
        'index' => 'movie_id',
        ]
    );
        $this->addColumn(
        'name',
        [
        'header' => __('Name'),
        'index' => 'name',
        ]
    );
        $this->addColumn(
        'description',
        [
        'header' => __('Description'),
        'index' => 'description',
        ]
    );
        $this->addColumn(
        'rating',
        [
        'header' => __('Rating'),
        'index' => 'rating',
        ]
    );
        $this->addColumn(
        'director_id',
        [
        'header' => __('Director Id'),
        'index' => 'director_id',
        ]
    );
    return $this;
    }
}