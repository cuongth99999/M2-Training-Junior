<?php

namespace Magenest\CancelOrder\Model;

use Magento\Framework\Model\AbstractModel;

class CancelOrder extends AbstractModel
{
    public function _construct()
    {
        $this->_init(\Magenest\CancelOrder\Model\ResourceModel\CancelOrder::class);
    }

    public function deleteMultiple($dataArr)
    {
        $size = count($dataArr);
        if (!is_array($dataArr) && $size == 0) {
            return;
        }
        $collectionIds = implode(', ', $dataArr);
        $this->getResource()->getConnection()->delete(
            $this->getResource()->getMainTable(),
            "{$this->getIdFieldName()} in ({$collectionIds})"
        );
    }
}
