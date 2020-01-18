<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Observer\Backend;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class AfterSave
 * @package Magenest\SuperEasySeo\Observer\Backend
 */
class AfterSave implements ObserverInterface
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
     * AfterSave constructor.
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\Product $product,
        \Magento\Framework\Registry $registry,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable
    ) {
        $this->productRepository = $productRepository;
        $this->product = $product;
        $this->registry = $registry;
        $this->configurable = $configurable;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            /** @var \Magento\Catalog\Model\Product $product $product */
            $product = $observer->getProduct();  // you will get product
            $isEnable = $product->getData('image-tag-enable');
            if ($isEnable == 1) {
                $variable = $product->getData('image-tag-variable');
                $name = $product->getName();
                $variables = explode(" ", $variable);
                $existingMediaGalleryEntries = $product->getMediaGalleryEntries();
                foreach ($existingMediaGalleryEntries as $key => $entry) {
                    $id = " ".$entry->getId();
                    $val = isset($variables[$key]) ? " ".$variables[$key] : "";
                    $entry->setLabel($name.$val.$id);
                }
                $product->setMediaGalleryEntries($existingMediaGalleryEntries);
                $product->save();
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
        }
    }
}
