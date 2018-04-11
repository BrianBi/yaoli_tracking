<?php 

namespace Yaoli\Tracking\Plateform\Type;
use Yaoli\Tracking\Plateform\AbstractPlateform;

class Cj extends AbstractPlateform
{
	public static $configs = array(
        'GD_ACTION_ID' => '385398',
        'GD_CID' => '1537320',
        'GD_CONTAINER_TAG_ID' => '14011',

        'GD_FR_ACTION_ID' => '385399',
        'GD_FR_CID' => '1537320',
        'GD_FR_CONTAINER_TAG_ID' => '14012',

        'GD_DE_ACTION_ID' => '385400',
        'GD_DE_CID' => '1537320',
        'GD_DE_CONTAINER_TAG_ID' => '14013',

        'GD_IT_ACTION_ID' => '385401',
        'GD_IT_CID' => '1537320',
        'GD_IT_CONTAINER_TAG_ID' => '14014',

        'GD_ES_ACTION_ID' => '385402',
        'GD_ES_CID' => '1537320',
        'GD_ES_CONTAINER_TAG_ID' => '14015',

        'GD_CN_ACTION_ID' => '385403',
        'GD_CN_CID' => '1537320',
        'GD_CN_CONTAINER_TAG_ID' => '14016',

        'GD_PL_ACTION_ID' => '385404',
        'GD_PL_CID' => '1537320',
        'GD_PL_CONTAINER_TAG_ID' => '14017',

        'GL_ACTION_ID' => '385405',
        'GL_CID' => '1537320',
        'GL_CONTAINER_TAG_ID' => '14018',
    );

    /**
     * nique identifier for the conversion tag. This is a static value provided by CJ.
     * @var string|number
     */
    private $containerTagId = '';

    /**
     * @return string|number
     */
    public function getContainerTagId() 
    { 
        return ($this->containerTagId = static::getConstValue($this->getWeb() . '_CONTAINER_TAG_ID')); 
    }

    /**
     * @param string|number $value
     * @return $this
     */
    public function setContainerTagId($value) 
    {
        $this->containerTagId = static::getConstValue($this->getWeb() . '_CONTAINER_TAG_ID'); 
        return $this;
    }
    
	/**
     * @param bool $noThrowsError
     * @return string
     * @throws Yaoli_Tracking_Exception
     */
    public function createTraceUrl($noThrowsError = false)
    {
        if (count($this->getOrder()->getAllItems()) < 1) return '';

        $ctid = $this->getContainerTagId();
        $cid  = static::getConstValue($this->getWeb() . "_CID");
        $oid  = $this->getOrder()->getIncrementId();
        $type = $this->getType();
        $cur  = $this->getOrder()->getOrderCurrency()->getCode();
        $dis  = abs($this->getOrder()->getDiscountAmount());
        $url  = "https://www.emjcd.com/tags/c?containerTagId={$ctid}&CID={$cid}&OID={$oid}&TYPE={$type}&CURRENCY={$cur}&DISCOUNT={$dis}";

        $i = 1;
        foreach ($this->getOrder()->getAllItems() as $item)
        {
            $url .= "&ITEM{$i}={$item->getSku()}&AMT{$i}={$item->getPrice()}&QTY{$i}=" . intval($item->getQtyOrdered());
            $i++;
        }

        return $url;
    }

	/**
     * @param bool $noThrowsError
     * @return string
     */
    public function createHtmlTag($noThrowsError = false)
    {
        $url = $this->createTraceUrl($noThrowsError);
        if (empty($url))
        {
            return '';
        }

        $html = <<<EOT
<!-- BEGIN COMMISSION JUNCTION TRACKING CODE -->
<iframe height="1" width="1" frameborder="0" scrolling="no"
    src="{$url}" name="cj_conversion" ></iframe>
<!-- END COMMISSION JUNCTION TRACKING CODE -->
EOT;
        return $html;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return static::getConstValue($this->getWeb() . "_ACTION_ID");
    }

    /**
     * @param number|string $value
     * @return $this
     */
    public function setType($value)
    {
        parent::setType($this->getType());
        return $this;
    }
}