<?php

namespace Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'delivery_time_id';

    public function _construct()
    {
        $this->_init(\Magenest\DeliveryTime\Model\DeliveryTime::class,\Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime::class);
    }
}
