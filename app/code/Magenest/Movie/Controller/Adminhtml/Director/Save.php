<?php
namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magento\Framework\App\Action\Context;
class Save extends \Magento\Framework\App\Action\Action
{
    protected $member;
    public function __construct(Context $context, \Magenest\Movie\Model\DirectorFactory $member)
    {
        $this->member = $member;
        parent::__construct($context);
    }
    public function execute()
    {
//        $data = $this->getRequest()->getPostValue();
//        $mem = $this->member->create();
//        $mem->setData($data)->save();
//        $this->messageManager->addSuccessMessage('Add Done !');
//        $this->_redirect('movie/actor');

        $data = $this->getRequest()->getPostValue();
        $mem = $this->member->create();
        $mem->setData($data)->save();
        $this->messageManager->addSuccessMessage('Add Director Susscessfully!');
        $this->_redirect('movie/director');
    }
}

