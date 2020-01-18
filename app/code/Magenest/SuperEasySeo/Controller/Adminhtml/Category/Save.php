<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Controller\Adminhtml\Category;

use Magenest\SuperEasySeo\Controller\Adminhtml\Category as AbstractCategory;
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

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $model = $this->_objectManager->create('Magenest\SuperEasySeo\Model\Template');
            $info = [
                'enabled' => $data['enabled'],
                'type'     => 'category',
                'store' =>  isset($data['store']) ? $data['store'] : null,
                'assign_type' => !empty($data['assign_type']) ? $data['assign_type'] : null,
                'name_template' => !empty($data['name_template']) ? $data['name_template'] : null,
                'url_key' => !empty($data['url_key']) ? $data['url_key'] : null,
                'description' => !empty($data['description']) ? $data['description'] : null,
                'meta_title' => !empty($data['meta_title']) ? $data['meta_title'] : null,
                'meta_description' => !empty($data['meta_description']) ? $data['meta_description'] : null,
                'apply_for' => $data['apply_for'],
                'sort_order' => $data['sort_order'],
            ];
            $info['apply_category'] = null;
            if (isset($data['assign_type']) && $data['assign_type'] == 2) {
                $info['apply_category'] = implode(",", $data['apply_category']);
            }
            $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($model->getData());
            try {
                if (!empty($data['template_id'])) {
                    $model->load($data['template_id']);
                    unset($info['store']);
                    unset($info['name_template']);
                    unset($info['assign_type']);
                    $model->addData($info);
                    $model->save();
                    $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                } else {
                    $checkRule = $this->_objectManager->create('Magenest\SuperEasySeo\Model\Template')->getCollection()
                        ->addFieldToFilter('type', 'category')
                        ->addFieldToFilter('store', $data['store'])
                        ->addFieldToFilter('assign_type', $data['assign_type']);

                    if ($data['assign_type'] == 1) {
                        if (!empty($checkRule->getFirstItem()->getData())) {
                            $this->messageManager->addErrorMessage(__('You need select other Assign Type/Store View !'));

                            return $resultRedirect->setPath('*/*/');
                        } else {
                            $model->addData($info);
                            $model->save();
                            $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                        }
                    }

                    if ($info['assign_type'] == 2) {
                        $checkRule->getFirstItem();
                        if (!empty($checkRule->getData())) {
                            $applyCategory = $checkRule->getApplyCategory();
                            $array1 = $data['apply_category'];
                            $array2 = explode(",", $applyCategory);
                            $same = sizeof(array_intersect($array1, $array2));
                            if ($same == 0) {
                                $model->addData($info);
                                $model->save();
                                $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                            } else {
                                $this->messageManager->addErrorMessage(__('You need select other Specific Category !'));

                                return $resultRedirect->setPath('*/*/');
                            }
                        } else {
                            $model->addData($info);
                            $model->save();
                            $this->messageManager->addSuccessMessage(__('The template has been saved.'));
                        }
                    }
                }
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError($e, __('Something went wrong while saving the template.'));
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);

                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
