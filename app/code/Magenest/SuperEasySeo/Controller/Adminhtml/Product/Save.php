<?php
/**
 * Copyright © 2015 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Magenest_SuperEasySeo extension
 * NOTICE OF LICENSE
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Product;

use Magenest\SuperEasySeo\Controller\Adminhtml\Product as AbstractProduct;
use Magento\Backend\App\Action;

/**
 * Class Save
 *
 * @package Magenest\SuperEasySeo\Controller\Adminhtml\Product
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magenest\SuperEasySeo\Model\TemplateFactpry
     */
    protected $template;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param \Magenest\SuperEasySeo\Model\TemplateFactpry $templateFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        \Magenest\SuperEasySeo\Model\TemplateFactory $templateFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->template = $templateFactory;
        parent::__construct($context);
    }

    /**
     * Save user
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
//        $this->logger->debug(print_r($data, true));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $model = $this->_objectManager->create('Magenest\SuperEasySeo\Model\Template');

            $info = [
                'enabled' => $data['enabled'],
                'type'     => 'product',
                'store' =>  isset($data['store']) ? $data['store'] : null,
                'assign_type' => !empty($data['assign_type']) ? $data['assign_type'] : null,
                'name_template' => !empty($data['name_template']) ? $data['name_template'] : null,
                'url_key' => !empty($data['url_key']) ? $data['url_key'] : null,
                'description' => !empty($data['description']) ? $data['description'] : null,
                'short_description' => !empty($data['short_description']) ? $data['short_description'] : null,
                'meta_title' => !empty($data['meta_title']) ? $data['meta_title'] : null,
                'meta_description' => !empty($data['meta_description']) ? $data['meta_description'] : null,
                'sort_order' => $data['sort_order'],
                'apply_for' => $data['apply_for'],
            ];
            $info['apply_category'] = null;
            $info['attribute_set'] = null;
            $info['apply_product'] = null;
            if (isset($data['apply_category'])) {
                $info['apply_category'] = implode(",", $data['apply_category']);
            }

            if (isset($data['assign_type']) && $data['assign_type'] == 2) {
                $info['attribute_set'] = $data['attribue_set'];
            }
            if (isset($data['assign_type']) && $data['assign_type'] == 3) {
                if ($data['apply_product'] == null) {
                    $this->messageManager->addErrorMessage(__(" You need select product(s)  to template with type 'specific products'! "));

                    return  $resultRedirect->setPath('*/*/');
                } else {
                    $info['apply_product'] = $data['apply_product'];
                }
            }
            $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($model->getData());
            try {
                if (isset($data['template_id']) && !empty($data['template_id'])) {
                    $model->load($data['template_id']);
                    unset($info['store']);
                    unset($info['apply_category']);
                    unset($info['name_template']);
                    unset($info['assign_type']);
                    unset($info['attribute_set']);
                    $model->addData($info);
                    $model->save();
                    $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                } else {
                    $checkRule = $this->_objectManager->create('Magenest\SuperEasySeo\Model\Template')->getCollection()
                        ->addFieldToFilter('type', 'product')
                        ->addFieldToFilter('store', $data['store'])
                        ->addFieldToFilter('assign_type', $data['assign_type']);

                    if ($data['assign_type'] == 1) {
                        if (!empty($checkRule->getFirstItem()->getData())) {
                            $check = $this->checkCategory($checkRule->getFirstItem(), $info['apply_category']);
                            if ($check == 0) {
                                $model->addData($info);
                                $model->save();
                                $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                            } else {
                                $this->messageManager->addErrorMessage(__('You need select other Auto Render/Store View !'));

                                return $resultRedirect->setPath('*/*/');
                            }
                        } else {
                            $model->addData($info);
                            $model->save();
                            $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                        }
                    }
                    if ($data['assign_type'] == 2) {
                        $checkRule->addFieldToFilter('attribute_set', $info['attribute_set']);
                        if (!empty($checkRule->getFirstItem()->getData())) {
                            $check = $this->checkCategory($checkRule->getFirstItem(), $info['apply_category']);
                            if ($check == 0) {
                                $model->addData($info);
                                $model->save();
                                $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                            } else {
                                $this->messageManager->addErrorMessage(__('You need select other Attribute Set  !'));

                                return $resultRedirect->setPath('*/*/');
                            }
                        } else {
                            $model->addData($info);
                            $model->save();
                            $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                        }
                    }
                    if ($data['assign_type'] == 3) {
                        $checkRule->getFirstItem();
                        if (!empty($checkRule->getData())) {
                            $applyProduct = $checkRule->getApplyProduct();
                            $array1 = explode(",", $data['apply_product']);
                            $array2 = explode(",", $applyProduct);
                            $same = sizeof(array_intersect($array1, $array2));
                            if ($same == 0) {
                                $model->addData($info);
                                $model->save();
                                $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                            } else {
                                $this->messageManager->addErrorMessage(__('You need select other Specific Product(s) !'));

                                return $resultRedirect->setPath('*/*/');
                            }
                        } else {
                            $model->addData($info);
                            $model->save();
                            $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                        }
                    }
                }

                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the template.'));
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);

                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $checkRule
     * @param $data
     * @return int
     */
    public function checkCategory($checkRule, $data)
    {
        /** @var  \Magenest\SuperEasySeo\Model\Template $checkRule */
        $applyCategory = $checkRule->getApplyCategory();
        $check = 0;
        if ($data != null) {
            $array1 = explode(",", $data);
            $array2 = explode(",", $applyCategory);
            $check = sizeof(array_intersect($array1, $array2));
        }

        return $check;
    }
}
