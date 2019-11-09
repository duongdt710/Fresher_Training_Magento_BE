<?php
namespace Packt\HelloWorld\Block;
use Magento\Framework\View\Element\Template;
class Newproducts extends Template
{
    private $_productCollectionFactory;
    
    public function __construct(
    Template\Context $context,
    \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
    $productCollectionFactory,
    array $data = [])
    {
        parent::__construct($context, $data);
        $this->_productCollectionFactory = $productCollectionFactory;
    }
    public function getSubscription() 
    {
        //khởi tạo một bộ sản phẩm 
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('firstname');
        // ->setOrder('created_at')
        // ->setPageSize(10);
        return $collection;
        }
}