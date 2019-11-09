<?php
namespace Packt\HelloWorld\Block\Adminhtml\Director;
use Magento\Backend\Block\Widget\Grid as WidgetGrid;
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /*** @var \Packt\HelloWorld\Model\Resource\Director\Collection
    */
    protected $_directorCollection;
    /**
    * @param \Magento\Backend\Block\Template\Context $context
    * @param \Magento\Backend\Helper\Data $backendHelper
    * @param \Packt\HelloWorld\Model\ResourceModel\Director\Collection $directorCollection
    * @param array $data
    */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Magento\Backend\Helper\Data $backendHelper,
    \Packt\HelloWorld\Model\ResourceModel\Director\Collection
    $directorCollection,
    array $data = []
    ) {
        $this->_directorCollection = $directorCollection;
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
        $this->setCollection($this->_directorCollection);
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
            'director_id',
            [
            'header' => __('ID'),
            'index' => 'director_id',
            ]
        );
            $this->addColumn(
            'name',
            [
            'header' => __('Name'),
            'index' => 'name',
            'frame_callback' => [$this, 'decorateName']
            ]
            
        );


        return $this;
    }
    public function decorateName($value) {
        $class = '';
        switch ($value) {
        case 'pending':
        $class = 'grid-severity-minor';
        break;
        case 'approved':
        $class = 'grid-severity-notice';
        break;
        case 'declined':default:
        $class = 'grid-severity-critical';
        break;
        }
        return '<span class="' . $class . '"><span>' . $value . '</span>
        </span>';
        }
}