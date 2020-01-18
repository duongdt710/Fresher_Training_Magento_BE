<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Observer\Layout;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class Load
 * @package Magenest\SuperEasySeo\Observer\Layout
 */
class Load implements ObserverInterface
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $product;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable
     */
    protected $configurable;

    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magenest\SuperEasySeo\Model\GalleryFactory
     */
    protected $galleryFactory;

    /**
     * Load constructor.
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable
     * @param RequestInterface $requestInterface
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magenest\SuperEasySeo\Model\GalleryFactory $galleryFactory
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\Product $product,
        \Magento\Framework\Registry $registry,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
        RequestInterface $requestInterface,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magenest\SuperEasySeo\Model\GalleryFactory $galleryFactory
    ) {

        $this->productRepository = $productRepository;
        $this->product = $product;
        $this->registry = $registry;
        $this->configurable = $configurable;
        $this->productFactory = $productFactory;
        $this->_request = $requestInterface;
        $this->galleryFactory = $galleryFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $fullActionName = $observer->getEvent()->getFullActionName();
        /** @var \Magento\Framework\View\Layout $layout */
        $layout = $observer->getEvent()->getLayout();
        if ($fullActionName == 'catalog_product_edit') {
            try {
                $params = $this->_request->getParams();
                $id = $params['id'];
                $product = $this->productRepository->getById($id);
                if ($product->getTypeId() === "configurable") {
                    $productTypeInstance = $product->getTypeInstance();
                    $usedProducts = $productTypeInstance->getUsedProducts($product);

                    foreach ($usedProducts as $child) {
                        $_id = $child->getId(); //Child Product Id
                        $_product = $this->productRepository->getById($_id);
                        $isEnable = $_product->getData('image-tag-enable');
                        if ($isEnable == 1) {
                            $variable = $_product->getData('image-tag-variable');
                            $variables = explode(" ", $variable);
                            $sku = $_product->getSku();
                            $skuArr = explode("-", $sku);
                            $superParentSku = $skuArr[0];
                            $skuArr[0] = $this->productRepository->get($superParentSku)->getName();
                            $skuArr = array_reverse($skuArr);
                            $sku = implode(" ", $skuArr);
                            $existingMediaGalleryEntries = $_product->getMediaGalleryEntries();
                            foreach ($existingMediaGalleryEntries as $key => $entry) {
                                $id = " " . $entry->getId();
                                $val = isset($variables[$key]) ? " " . $variables[$key] : "";
                                $label = $sku . $val . $id;
                                $collection = $this->galleryFactory->create()->getCollection()->addFieldToFilter('entity_id', $_id)->getFirstItem();
                                if (empty($collection->getData()['label'])) {
                                    $collection->addData(['label' => $label])->save();
                                }
                            }
                        }
                    }
                }
            } catch (\Exception $exception) {
            }
        }
    }
}
