<?php

namespace Magenest\DeliveryTime\Model\ResourceModel;

class DeliveryTime extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init('magenest_delivery_time', 'delivery_time_id');
    }
}
