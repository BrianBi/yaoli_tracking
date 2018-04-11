<?php 

namespace Yaoli\Tracking\Plateform;
use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;

abstract class AbstractPlateform
{
	const ERR_CODE_CREATE_HTML_TAG_METHOD_ABSTRACT = 'METHOD_MUST_BE_OVERRIDE';
    const ERR_MSG_CREATE_HTML_TAG_METHOD_ABSTRACT = 'The method "%s" must be override';

    /** @var array 常量配置 */
    public static $configs = array();

    /** @var bool  */
    private $wasOutputHtmlTag = false;

    /** @var Order */
    protected $_order = null;

    protected $web = 'GD';

    /** @var  string */
    protected $type;

    /** @var  string */
    protected $plateform;

	/** @var classes */
	public static $classes = [
		'cj' => 'Cj',
	];

    /**
     * @return int
     */
    public function getPlateForm() { return $this->plateform; }

    /**
     * @param string|number $value
     * @return $this
     */
    public function setPlateForm($value) { $this->plateform = $value; return $this; }

	/**
     * @return string
     */
    public function getWeb() { return $this->web; }

    /**
     * @param string $value
     * @return $this
     */
    public function setWeb($value) { $this->web = is_string($value) ? strtoupper(trim("{$value}")) : 'GD'; return $this; }

    /**
     * @return int
     */
    public function getType() { return $this->type; }

    /**
     * @param string|number $value
     * @return $this
     */
    public function setType($value) { $this->type = $value; return $this; }


	/**
     * @return bool
     */
    public function getWasOutputHtmlTag() { return $this->wasOutputHtmlTag; }

    protected final function _afterDoRequest($data)
    {
        if (false === $data)
        {
            $this->wasOutputHtmlTag = false;
        }
        else
        {
            $this->wasOutputHtmlTag = true;
        }
    }

    /**
     * @return $this
     */
    public final function insertIntoDb()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $trackOrder    = $objectManager->create('Yaoli\Tracking\Model\Trackorder');
        $_order        = $this->getOrder();

        $qty = 0;
        $mny = 0;
        $sku = '';
        foreach ($_order->getAllItems() as $item)
        {
            $qty += intval($item->getQtyOrdered());
            $mny += intval($item->getQty()) * floatval($item->getPrice());
            $sku .= $item->getSku() . ',';
        }

        $trackOrder->setTrackingPlatform($this->getPlateForm());
        $trackOrder->setTrackingOrderId($_order->getIncrementId());
        $trackOrder->setTrackingPosted($_order->getProtectCode());
        $trackOrder->setTrackingPostTryCount(0);
        $trackOrder->setTrackingActionId(static::getConstValue($this->getWeb() . "_CID"));
        $trackOrder->setTrackingCreatedAt(new \DateTime());
        $trackOrder->setTrackingSku($sku);
        $trackOrder->setTrackingTotalQty($qty);
        $trackOrder->setTrackingTotalMoney($_order->getSubtotal() ? $_order->getSubtotal() : $mny);
        $trackOrder->setTrackingCurrency($_order->getOrderCurrencyCode());
        $trackOrder->setTrackingDiscount($_order->getDiscountAmount());
        $trackOrder->setTrackingSource($this->getPlateForm());
        $trackOrder->setTrackingCoupon($_order->getCouponCode());

        try {
            $trackOrder->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return;
    }

    /**
     * get order
     * @param string
     *
     * @return Order
     */
    public function getOrder()
    {
    	return $this->_order;
    }

    /**
     * set Order
     */
    public function setOrder($order)
    {
    	$this->_order = $order;
    	return $this;
    }

	/**
     * @param bool $autoSaveIntoDb    是否自动保存到数据库？
     * @return $this
     */
    public final function outputHtmlTag($autoSaveIntoDb = true)
    {
        if (!$this->wasOutputHtmlTag)
        {
            if (count($this->getOrder()->getAllItems()) < 1)
            {
                return $this;
            }

            $this->wasOutputHtmlTag = true;
            if ($autoSaveIntoDb)
            {
                $this->insertIntoDb();
            }
        }

        echo $this->createHtmlTag(true);
        return $this;
    }

	/**
     * @param bool $noThrowsError
     * @return string
     */
    public function createHtmlTag($noThrowsError = false)
    {
        throw new Yaoli_Tracking_Exception(
            static::ERR_CODE_CREATE_HTML_TAG_METHOD_ABSTRACT,
            sprintf(static::ERR_MSG_CREATE_HTML_TAG_METHOD_ABSTRACT, get_class($this) . '::createHtmlTag')
        );
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function getConstValue($key)
    {
        $key = strtoupper(trim("{$key}"));
        if (empty($key))
        {
            return null;
        }

        $arr = static::$configs;
        if (array_key_exists($key, $arr))
        {
            return $arr[$key];
        }
        else
        {
            return $key;
        }
    }
}