<?php 
namespace Yaoli\Tracking\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;
use \Yaoli\Tracking\Plateform\AbstractPlateform;

class Tag extends AbstractHelper
{
	protected $_objectManager;

    protected $storeManager;

    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\ObjectManagerInterface $objectManager
    )
    {
        $this->_objectManager = $objectManager;
        $this->storeManager   = $storeManager;
        parent::__construct($context);
    }

	//Mage::helper('tracking/tag')->createTracking($this->getOrderId(), 'gl', 'cj', '')->outputHtmlTag(true);
	public function createTracking($orderId, $web = 'gd', $_platform = 'cj', $source = '')
	{
		if ($_platform == '')
			$_platform = $this->scopeConfig->getValue('tracking/general/cookie_name');

		if (!$orderId) exit('No plateform...');

		$_order  = $_order = $this->_objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);

		$_pltObj = $this->_objectManager->create('Yaoli\Tracking\Plateform\Type\\'.AbstractPlateform::$classes[$_platform]);

		$_pltObj->setOrder($_order);
		$_pltObj->setWeb($web);
		$_pltObj->setPlateForm($_platform);

		return $_pltObj;
	}
}