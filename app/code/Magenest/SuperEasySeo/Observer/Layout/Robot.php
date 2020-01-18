<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Observer\Layout;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class Robot
 * @package Magenest\SuperEasySeo\Observer\Layout
 */
class Robot implements ObserverInterface
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
     * @var \Magenest\SuperEasySeo\Helper\ConfigData
     */
    protected $config;

    /**
     * Robot constructor.
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable
     * @param RequestInterface $requestInterface
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magenest\SuperEasySeo\Helper\ConfigData $configData
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\Product $product,
        \Magento\Framework\Registry $registry,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
        RequestInterface $requestInterface,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magenest\SuperEasySeo\Helper\ConfigData $configData
    ) {
        $this->productRepository = $productRepository;
        $this->product = $product;
        $this->registry = $registry;
        $this->configurable = $configurable;
        $this->productFactory = $productFactory;
        $this->_request = $requestInterface;
        $this->config = $configData;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $fullActionName = $observer->getEvent()->getFullActionName();
            if ($this->config->getEnable()) {
                foreach ($this->config->getCms() as $key => $child) {
                    $layout = explode("\r\n", $child);
                    foreach ($layout as $val) {
                        try {
                            $val = str_replace("/", "-", $val);
                            $val = str_replace(' ', '', $val);
                            $val = str_replace('*', '', $val);
                            if ($val === "") {
                                break;
                            }
                            $regex = "/$val/";
                            if (preg_match($regex, $fullActionName)) {
                                switch ($key) {
                                    case "i_f":
                                        $this->setIndexFollow();
                                        break;
                                    case "ni_f":
                                        $this->setNoIndexFollow();
                                        break;
                                    case "i_nf":
                                        $this->setIndexNoFollow();
                                        break;
                                    case "ni_nf":
                                        $this->setNoIndexNoFollow();
                                        break;
                                    default:
                                        break;
                                }
                            }
                        } catch (\Exception $exception) {
                        }
                    }
                }
                foreach ($this->config->getNonCms() as $key => $child) {
                    $regex = "/^$key/";
                    if (preg_match($regex, $fullActionName)) {
                        switch ($child) {
                            case "1":
                                $this->setIndexFollow();
                                return;
                            case "2":
                                $this->setNoIndexFollow();
                                return;
                            case "3":
                                $this->setIndexNoFollow();
                                return;
                            case "4":
                                $this->setNoIndexNoFollow();
                                return;
                            default:
                                return;
                        }
                    }
                }
            }

            $data = $this->_request->getParams();
            if (isset($data['id'])) {
                $product = $this->productFactory->create()->load($data['id']);
                $isRobotTagEnable = $product->getData('robot-tag-enable');
                if ($isRobotTagEnable) {
                    $value = $product->getData('robot-tag-option');
                    switch ($value) {
                        case "1":
                            $this->setIndexFollow();
                            return;
                        case "2":
                            $this->setNoIndexFollow();
                            return;
                        case "3":
                            $this->setIndexNoFollow();
                            return;
                        case "4":
                            $this->setNoIndexNoFollow();
                            return;
                        default:
                            return;
                    }
                }
            }
        } catch (\Exception $exception) {
        }
    }

    /**
     * index , no follow
     */
    public function setIndexNoFollow()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\View\Page\Config $_page_config */
        $_page_config = $objectManager->get('Magento\Framework\View\Page\Config');
        $_page_config->setRobots("INDEX, NOFOLLOW");
    }

    /**
     * no index , follow
     */
    public function setNoIndexFollow()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\View\Page\Config $_page_config */
        $_page_config = $objectManager->get('Magento\Framework\View\Page\Config');
        $_page_config->setRobots("NOINDEX, FOLLOW");
    }

    /**
     * no index , no follow
     */
    public function setNoIndexNoFollow()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\View\Page\Config $_page_config */
        $_page_config = $objectManager->get('Magento\Framework\View\Page\Config');
        $_page_config->setRobots("NOINDEX, NOFOLLOW");
    }

    /**
     * index , follow
     */
    public function setIndexFollow()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\View\Page\Config $_page_config */
        $_page_config = $objectManager->get('Magento\Framework\View\Page\Config');
        $_page_config->setRobots("INDEX, FOLLOW");
    }
}
