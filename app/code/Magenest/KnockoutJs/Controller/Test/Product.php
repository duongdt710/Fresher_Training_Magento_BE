<?php

namespace Magenest\KnockoutJs\Controller\Test;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;

class Product extends \Magento\Framework\App\Action\Action
{
    protected $productFactory;
    protected $imageHelper;
    protected $listProduct;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        ProductFactory $productFactory,
        StoreManager $storeManager,
        Image $imageHelper
    )
    {
        $this->productFactory = $productFactory;
        $this->imageHelper = $imageHelper;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    public function getCollection()
    {
        return $this->productFactory->create()
            ->getCollection()
            ->addAttributeToSelect('*')
            ->setPageSize(5)
            ->setCurPage(1);
    }

    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id')){
            $product = $this->productFactory->create()->load($id);
            $productData = [
                'entity_id' => $product->getId(),
                'name' => $product->getName(),
                'price' => '$' . $product->getPrice(),
                'src' => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
            ];

            echo json_encode($productData);
            return;
        }
    }
}