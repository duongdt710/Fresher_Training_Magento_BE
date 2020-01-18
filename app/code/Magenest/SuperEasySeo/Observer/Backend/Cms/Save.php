<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Observer\Backend\Cms;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magenest\SuperEasySeo\Helper\RenderTemplateRule;
use Magenest\SuperEasySeo\Model\AutolinkFactory;

/**
 * Class Save
 * @package Magenest\SuperEasySeo\Observer\Backend\Cms
 */
class Save implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var RenderTemplateRule
     */
    protected $helperRender;

    /**
     * @var AutolinkFactory
     */
    protected $autolinkFactory;

    /**
     * Save constructor.
     * @param LoggerInterface $logger
     * @param RenderTemplateRule $renderTemplateRule
     * @param AutolinkFactory $autolinkFactory
     */
    public function __construct(
        LoggerInterface $logger,
        RenderTemplateRule $renderTemplateRule,
        AutolinkFactory $autolinkFactory
    ) {
        $this->_logger = $logger;
        $this->helperRender = $renderTemplateRule;
        $this->autolinkFactory = $autolinkFactory;
    }

    /**
     * Set new customer group to all his quotes
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $page = $observer->getEvent()->getPage();
        $this->builderAutolink($page);
        return;
    }

    /**
     * @param $page
     */
    public function builderAutolink($page)
    {
        $modelAutolink = $this->autolinkFactory->create()->getCollection()
            ->setOrder('sort_order', 'DESC')
            ->addFieldToFilter('use_cms', 1)
            ->addFieldToFilter('enabled', 1);

        /** @var  \Magenest\SuperEasySeo\Model\Autolink $model */
        foreach ($modelAutolink as $model) {
            if (!empty($page->getContent())) {
                $text = $this->getRenderAutoLink($page->getContent(), $model);
                $page->setContent($text);
            }
        }
    }

    /**
     * @param $string
     * @param $model
     * @return string
     */
    public function getRenderAutoLink($string, $model)
    {
        /** @var \Magenest\SuperEasySeo\Model\Autolink $model */
        $result = $this->helperRender->renderLink($string, $model->getRenderHtml(), trim($model->getKeyword()));

        return $result;
    }
}
