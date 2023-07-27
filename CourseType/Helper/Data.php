<?php

namespace Magenest\CourseType\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magenest\CourseType\Model\ResourceModel\Attachment\CollectionFactory as AttachmentCollection;

class Data extends AbstractHelper
{
    protected $storeManager;
    protected $objectManager;
    protected $attachmentCollection;

    const XML_PATH_MODULE_GENERAL = 'module/general/';

    public function __construct
    (
        AttachmentCollection $attachmentCollection,
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager
    )
    {
        $this->attachmentCollection = $attachmentCollection;
        $this->objectManager = $objectManager;
        $this->storeManager  = $storeManager;
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
    }


    public function getModuleStatus($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_MODULE_GENERAL  . $code, $storeId);
    }

    public function getCourseDocument($name)
    {
        $attachmentCollection = $this->attachmentCollection->create();
        return $attachmentCollection
            ->addFieldToFilter('file_name', ['like' => '%'.$name.'%'])
            ->getFirstItem();
    }
}
