<?php

namespace Magenest\CourseType\Model\ResourceModel\Attachment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    public function _construct()
    {
        $this->_init(\Magenest\CourseType\Model\Attachment::class,\Magenest\CourseType\Model\ResourceModel\Attachment::class);
    }
}
