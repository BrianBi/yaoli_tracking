<?php 

namespace Yaoli\Tracking\Block\Adminhtml;

class Trackorder extends \Magento\Backend\Block\Widget\Grid\Container
{
	protected function _construct()
    {
        $this->_controller = 'adminhtml_trackorder';
        $this->_blockGroup = 'Yaoli_Trackorder';
        $this->_headerText = __('Tracking lists');
        parent::_construct();
    }
}