<?php 

namespace Yaoli\Tracking\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Trackorder extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('yaoli_order_tracking', 'id');
    }

}