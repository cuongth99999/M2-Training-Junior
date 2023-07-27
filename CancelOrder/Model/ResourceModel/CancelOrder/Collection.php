<?php

namespace Magenest\CancelOrder\Model\ResourceModel\CancelOrder;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    public function _construct()
    {
        $this->_init(\Magenest\CancelOrder\Model\CancelOrder::class,\Magenest\CancelOrder\Model\ResourceModel\CancelOrder::class);
    }
}
