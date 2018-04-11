<?php 

namespace Yaoli\Tracking\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
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

    /**
     * get sendorder enable
     * @return string
     */
    public function getTrackingEnable()
    {
        return $this->scopeConfig->getValue('tracking/general/enable');
    }

    /**
     * get sendorder enable
     * @return string
     */
    public function getCookieName()
    {
        return $this->scopeConfig->getValue('tracking/general/cookie_name');
    }

    /**
     * get sendorder enable
     * @return string
     */
    public function getCookieSafeKey()
    {
        return $this->scopeConfig->getValue('tracking/general/cookie_safe_key');
    }

    /**
     * get sendorder enable
     * @return string
     */
    public function getCookieExpired()
    {
        return $this->scopeConfig->getValue('tracking/general/cookie_expired_s');
    }
}