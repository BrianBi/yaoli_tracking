<?php 
namespace Yaoli\Tracking\Observer;
use Magento\Framework\Event\ObserverInterface;
use \Yaoli\Tracking\Helper\Data as trackingHelper;
use Magento\Sales\Model\Order;

class saveTrackingData implements ObserverInterface
{
	protected $_objectManager;

    protected $logger;

    protected $_trackingHelper;

    protected $_cookieManager;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Psr\Log\LoggerInterface $logger,
        trackingHelper $_trackingHelper,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
    )
    {
        $this->_trackingHelper = $_trackingHelper;
        $this->_objectManager   = $objectManager;
        $this->_cookieManager = $cookieManager;
        $this->logger = $logger;
    }

	/**
     * @param Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
    	$_order = $observer->getOrder();

        $_platform = $this->_cookieManager->getCookie('affiliateplus_map_index');

        if(!$_order->getId()) return $this;

        if ($_order->getStatus() !== Order::STATE_COMPLETE) return $this;

        if (!$_platform || !in_array($_platform, ['webgains', 'cj', 'mopubi', 'tradedoubler'])) return $this;

        $trackCollection = $this->_objectManager->create('Yaoli\Tracking\Model\Trackorder');

        $_trackModels = $trackCollection->getCollection()
        				->addFieldToFilter('tracking_order_id', $_order->getIncrementId())
        				->addFieldToFilter('tracking_platform', $_platform);

        if (count($_trackModels) > 0) return $this;

        $this->saveTrackOrder($_order, $_platform);

        return $this;
    }

    /**
     * save track data
     * @param Order
     * 
     * @return bool
     */
    protected function saveTrackOrder($_order, $_platform)
    {
    	// 
        $qty = 0;
        $mny = 0;
        $sku = '';
        $trackCollection = $this->_objectManager->create('Yaoli\Tracking\Model\Trackorder');

        foreach($_order->getAllItems() as $item)
        {
			$qty += intval($item->getQtyOrdered());
            $mny += intval($item->getQty()) * floatval($item->getPrice());
            $sku .= $item->getSku() . ',';
		}

        $trackCollection->setTrackingPlatform($_platform);
		$trackCollection->setTrackingOrderId($_order->getIncrementId());
		$trackCollection->setTrackingPosted($_order->getProtectCode());
		$trackCollection->setTrackingPostTryCount(0);
		$trackCollection->setTrackingActionId(0);
		$trackCollection->setTrackingCreatedAt();
		$trackCollection->setTrackingSku($sku);
		$trackCollection->setTrackingTotalQty($qty);
		$trackCollection->setTrackingTotalMoney($_order->getSubtotal() ? $_order->getSubtotal() : $mny);
		$trackCollection->setTrackingCurrency($_order->getOrderCurrencyCode());
		$trackCollection->setTrackingDiscount($_order->getDiscountAmount());
		$trackCollection->setTrackingSource($_platform);
		$trackCollection->setTrackingCoupon($_order->getCouponCode());

		try {
            $trackCollection->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return true;
    }
}