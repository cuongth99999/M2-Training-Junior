<?php

namespace Magenest\CourseType\Model\ResourceModel;

class Attachment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init('magenest_attachment', 'entity_id');
    }
}
