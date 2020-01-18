<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\SuperEasySeo\Block\Adminhtml\Product\Content;

use Magento\Backend\Block\Template;
use Magento\Catalog\Model\ProductFactory;

/**
 * Class Content
 * @package Magenest\SuperEasySeo\Block\Adminhtml\Product\Content
 */
class Content extends Template
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * Default Template
     *
     * @var string
     */
    protected $_template = "Magenest_SuperEasySeo::product/content/content.phtml";

    /**
     * Content constructor.
     * @param Template\Context $context
     * @param ProductFactory $productFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductFactory $productFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productFactory = $productFactory;
    }

    /**
     * @return mixed
     */
    public function getPostData()
    {
        $data = unserialize($this->getFeedback());

        return $data;
    }

    public function getProductInfo()
    {
        $request = unserialize($this->getFeedback());
        $productId = $request['id'];

        $products = $this->productFactory->create()->getCollection()->addAttributeToSelect('*');
        if (isset($request['store'])) {
            $products->setStore($request['store']);
        }
        $products->addFieldToFilter('entity_id', $productId)->getFirstItem();

        $returnArray = '';
        if (!empty($products->getData())) {
            $i = 1;
            foreach ($products as $product) {
                $metaDescription = $product->getMetaDescription();
                $metaTitle = $product->getMetaTitle();
//                $urlKey = $product->getUrlKey();
                $productURL = $product->getProductUrl();
                $description = trim(strip_tags($product->getDescription()));
                $checkInput = $this->checkInputText($request['requestText'], $description);
                $checkInputWithMetaTitle = $this->checkInputWithMetaTitle($request['requestText'], $metaTitle);
                $checkInputWithMetaDes = $this->checkInputWithMetaDes($request['requestText'], $metaDescription);
                $checkKeyUrl = $this->checkKeyUrl($request['requestText'], $productURL);
                $checkMetaDescription = $this->checkMetaDescription($metaDescription);
                $checkMetaTitle = $this->checkMetaTitle($metaTitle);
                $checkDescription = $this->checkDescription($description);
                $checkParagraph = $this->checkParagraph($request['requestText'], $description);

                $returnArray = [
                    'checkMetaTitle' => $checkInputWithMetaTitle,
                    'checkMetaDes' => $checkInputWithMetaDes,
                    'checkKeyUrl' => $checkKeyUrl,
                    'inputText' => $checkInput,
                    'metaDes' => $checkMetaDescription,
                    'metaTitle' => $checkMetaTitle,
                    'description' => $checkDescription,
                    'paragraph' => $checkParagraph,
                ];
                if ($i > 1) {
                    break;
                }
            }
        }

        return $returnArray;
    }

    /**
     * @param $inputText
     * @param $description
     * @return array
     */
    public function checkInputText($inputText, $description)
    {
        $count = 0;
        $lengthDes = (int)str_word_count($description);
        $lengthInput = (int)str_word_count($inputText);
        if (strpos($description, $inputText) !== false) {
            str_replace($inputText, "KkkK", $description, $count);
            $percent = round((($lengthInput*$count) / $lengthDes)*100, 2);
            $text = 'under';
            if ($percent > 2.5) {
                $text = 'over';
            }
            $report = 'The keyword density is '. $percent .'% , which is '.$text.' the advised 2.5% maximum; the focus keyword was found '. $count .' times.';
            return [
                'check' => 'true',
                'content' => $report
            ];
        } else {
            return [
                'check' => 'true',
                'content' => 'The keyword density is 0% , which is under the advised 2.5% maximum; the focus keyword was found 0 times.'
            ];
        }

        return [
            'check' => 'false',
            'content' => 'No focus keyword was set for this page. If you do not set a focus keyword, no score can be calculated.'
        ];
    }

    /**
     * @param $inputText
     * @param $metaTitle
     * @param $metaDescription
     * @return array
     */
    public function checkInputWithMetaTitle($inputText, $metaTitle)
    {
        if (strpos($metaTitle, $inputText) !== false) {
            return [
                'check' => 'true',
                'content' => 'This keyword appear in the meta title'
            ];
        }

        return [
            'check' => 'false',
            'content' => 'This keyword doesn\'t appear in the meta title'
        ];
    }

    /**
     * @param $inputText
     * @param $description
     * @return array
     */
    public function checkInputWithMetaDes($inputText, $description)
    {
        if (strpos($description, $inputText) !== false) {
            return [
                'check' => 'true',
                'content' => 'This keyword appear in the meta description'
            ];
        }

        return [
            'check' => 'false',
            'content' => 'This keyword doesn\'t appear in the meta description'
        ];
    }

    /**
     * check keywordwith Url
     *
     * @param $inputText
     * @param $url
     * @return array
     */
    public function checkKeyUrl($inputText, $url)
    {

        if (strpos($url, $inputText) !== false) {
            $report = 'The focus keyword appears in the URL for this page';
            return [
                'check' => 'true',
                'content' => $report
            ];
        }

        return [
            'check' => 'false',
            'content' => 'The focus keyword does not appear in the URL for this page. If you decide to rename the URL be sure to check the old URL 301 redirects to the new one!'
        ];
    }

    /**
     * check meta description
     *
     * @param $metaDes
     * @return array
     */
    public function checkMetaDescription($metaDes)
    {
        if (!empty($metaDes)) {
            return [
                'check' => 'true',
                'content' => 'Meta description has been specified'
            ];
        } else {
            return [
                'check' => 'false',
                'content' => 'No meta description has been specified. Search engines will display copy from the page instead.'
            ];
        }
    }

    /**
     * check meta title
     *
     * @param $metaTitle
     * @return array
     */
    public function checkMetaTitle($metaTitle)
    {
        if (!empty($metaTitle)) {
            $length = strlen($metaTitle);
            $content = '';
            if ($length < 30) {
                $content = 'The page title is too short. Try to add keyword variations or create compelling call-to-action copy.';
            }
            if (30 < $length && $length <71) {
                $content = 'The page title is good.';
            }

            if ($length > 71) {
                $content = 'The page title is too long.';
            }
            return [
                'check' => 'true',
                'content' => $content
            ];
        } else {
            return [
                'check' => 'false',
                'content' => 'No meta title has been specified.'
            ];
        }
    }

    /**
     * check meta title
     *
     * @param $metaTitle
     * @return array
     */
    public function checkDescription($description)
    {
        if (!empty($description)) {
            $length = (int)str_word_count($description);
            ;
            $content = 'The text contains '.$length.' words. The recommended minimum of 300 words.';
            return [
                'check' => 'true',
                'content' => $content
            ];
        } else {
            return [
                'check' => 'false',
                'content' => 'No description has been specified.'
            ];
        }
    }

    /**
     * check meta title
     *
     * @param $metaTitle
     * @return array
     */
    public function checkParagraph($input, $description)
    {
        $array = explode(' ', $description);
        $i = 0;
        $text = '';
        foreach ($array as $data) {
            $text .= $data.' ';
            if ($i > 100) {
                break;
            }
        }
        if (strpos($text, $input) !== false) {
            return [
                'check' => 'true',
                'content' => 'The keyword appear in the first 100 words of the paragraph'
            ];
        }
        return [
            'check' => 'false',
            'content' => 'The keyword doesn not appear in the first 100 words of the paragraph'
        ];
    }
}
