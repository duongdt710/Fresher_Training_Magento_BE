<?php
/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Magenest\SuperEasySeo\Block\RichSnippet\Json;

/**
 * Class Seller
 * @package Magenest\SuperEasySeo\Block\RichSnippet\Json
 */
class Seller extends \Magenest\SuperEasySeo\Block\RichSnippet\AbstractJson
{
    /**
     * @var \Magenest\SuperEasySeo\Model\Config\RichSnippet\Seller
     */
    protected $configSeller;

    /**
     * Seller constructor.
     * @param \Magenest\SuperEasySeo\Model\Config\RichSnippet\Seller $configSeller
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magenest\SuperEasySeo\Model\Config\RichSnippet\Seller $configSeller,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        $this->configSeller = $configSeller;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function getMarkupHtml()
    {
        $html = '';

        if (!$this->configSeller->isEnabledSnippet()) {
            return $html;
        }
        $sellerJsonData = $this->getJsonOrganizationData();
        $sellerJson = $sellerJsonData ? json_encode($sellerJsonData) : '';

        if ($sellerJsonData) {
            $html .= '<script type="application/ld+json">' . $sellerJson . '</script>';
        }

        return $html;
    }

    /**
     * @return array
     */
    protected function getJsonOrganizationData()
    {
        $data = [];
        $data['@context'] = 'http://schema.org';
        $data['@type'] = $this->configSeller->getType();

        $name = $this->configSeller->getName();
        if ($name) {
            $data['name'] = $name;
        }

        $description = $this->configSeller->getDescription();
        if ($description) {
            $data['description'] = $description;
        }

        $phone = $this->configSeller->getPhone();
        if ($phone) {
            $data['telephone'] = $phone;
        }

        $email = $this->configSeller->getEmail();
        if ($email) {
            $data['email'] = $email;
        }

        $price_range = $this->configSeller->getPriceRange();
        if ($price_range) {
            $data['priceRange'] = $price_range;
        }

        $image = $this->configSeller->getImage();
        if ($image) {
            $data['image'] = $image;
        }

        $fax = $this->configSeller->getFax();
        if ($fax) {
            $data['faxNumber'] = $fax;
        }

        $address = $this->getAddress();
        if ($address && count($address) > 1) {
            $data['address'] = $address;
        }

        $socialLinks = $this->configSeller->getSameAsLinks();

        if (is_array($socialLinks) && !empty($socialLinks)) {
            $data['sameAs'] = [];
            $data['sameAs'][] = $socialLinks;
        }

        $data['url'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);

        return $data;
    }

    /**
     * @return array
     */
    protected function getAddress()
    {
        $data = [];
        $data['@type'] = 'PostalAddress';
        $data['addressLocality'] = $this->configSeller->getLocation();
        $data['addressRegion'] = $this->configSeller->getRegionAddress();
        $data['streetAddress'] = $this->configSeller->getStreetAddress();
        $data['postalCode'] = $this->configSeller->getPostCode();

        return $data;
    }
}
