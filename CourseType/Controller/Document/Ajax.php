<?php

namespace Magenest\CourseType\Controller\Document;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magenest\CourseType\Model\ResourceModel\Attachment\CollectionFactory as AttachmentCollection;

class Ajax extends \Magento\Framework\App\Action\Action
{
    private $resultJsonFactory;
    private $attachmentCollection;

    protected $layout;

    public function __construct
    (
        AttachmentCollection $attachmentCollection,
        JsonFactory $resultJsonFactory,
        Context $context
    )
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->attachmentCollection = $attachmentCollection;
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $keyword = $this->getRequest()->getParam('keyword');
        $result = [];

        if($keyword === "" || strlen((string)$keyword) <3)
        {
            $result = [];
        } else {
            $attachmentCollection = $this->attachmentCollection->create();
            $docs = $attachmentCollection
                ->addFieldToFilter('file_name', ['like' => '%'.$keyword.'%'])
                ->getItems();
            foreach ($docs as $id => $doc)
            {
                $result[$id]['file_name'] = $doc->getFileName();
            }
        }

        return $resultJson->setData($result);
    }
}
