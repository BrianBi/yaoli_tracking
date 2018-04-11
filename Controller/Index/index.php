<?php
namespace Yaoli\Tracking\Controller\Index;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/9
 * Time: 17:46
 */
use Magento\Framework\App\Action\Action;

class Index extends Action
{
	public function execute()
	{
		// $_order = $this->_objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId('000000003');
		

		$_quenelist = $this->_objectManager->create('Yaoli\Tracking\Model\Trackorder')->load(1);
		$this->_objectManager->get('\Yaoli\Tracking\Helper\Tag')->createTracking('000000003', 'gd', 'cj', '')->outputHtmlTag();

		echo $_quenelist->getId();
	}
}