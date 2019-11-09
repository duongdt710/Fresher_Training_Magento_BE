<?php
namespace Magenest\Movie\Block\Adminhtml\Director\Edit;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
/**
 * Class GenericButton
 */
class GenericButton implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $_authorization;
    /**
     * @param Context $context
     * @param \Magento\Framework\AuthorizationInterface $authorization
     */
    public function __construct(
        Context $context,
        \Magento\Framework\AuthorizationInterface $authorization
    ) {
        $this->context = $context;
        $this->_authorization = $authorization;
    }
    /**
     * Return the Banner ID
     *
     * @return int
     */
    public function getMovieId()
    {
        return (int)$this->context->getRequestParam("id");
    }
    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrl($route, $params);
    }
    /**
     * {@inheritdoc}
     */
    public function getButtonData()
    {
        return [];
    }
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}