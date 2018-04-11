<?php 

namespace Yaoli\Tracking\Controller\Ad;
use Magento\Framework\App\Action\Action;

class Cj extends Action
{
	/**
	 * @var \Magento\Framework\Stdlib\CookieManagerInterface
	 */
	protected $_cookieManager;

	/**
	 * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
	 */
	protected $_cookieMetadataFactory;

    public function __construct(
    	\Magento\Framework\App\Action\Context $context, 
    	\Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
    	\Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
    )
    {
        $this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
        parent::__construct($context); 
    }

	public function execute()
	{
		$_helper = $this->_objectManager->get('\Yaoli\Tracking\Helper\Data');

		$_urlStr = $this->getRequest()->getParam('url', '/');

		if ($_helper->getTrackingEnable())
		{
			$metadata = $this->_cookieMetadataFactory->createPublicCookieMetadata()->setDuration($_helper->getCookieExpired());
			$this->_cookieManager->setPublicCookie($_helper->getCookieName(), 'cj', $metadata);
		}
		
		return $this->getResponse()->setRedirect($this->_redirect->getRedirectUrl($_urlStr));
	}
}