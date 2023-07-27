<?php

namespace Magenest\CancelOrder\Model\ResourceModel;

class CancelOrder extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init('magenest_cancel_order', 'entity_id');
    }
}
