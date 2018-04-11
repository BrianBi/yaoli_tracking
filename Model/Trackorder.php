<?php 

namespace Yaoli\Tracking\Model;

use Magento\Framework\Model\AbstractModel;

class Trackorder extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        //初始化资源模型
        $this->_init('Yaoli\Tracking\Model\ResourceModel\Trackorder');
    }

}