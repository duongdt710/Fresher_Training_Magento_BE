<?php
namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Framework\App\Action\Context;
class Save extends \Magento\Framework\App\Action\Action
{
    protected $member;
    public function __construct(Context $context, \Magenest\Movie\Model\ActorFactory $member)
    {
        $this->member = $member;
        parent::__construct($context);
    }
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $mem = $this->member->create();
//        try{
//            \Zend_Debug::dump($data);
//            $mem->setData($data)->save();
////            $mem->setData('name', 1111)->save();
//            die();
//        }catch (\Exception $e){
//            echo $e->getMessage();
//            die();
//        }
        $mem->setData($data)->save();
        $this->messageManager->addSuccessMessage('Add Done !');
        $this->_redirect('movie/actor');
    }
}

