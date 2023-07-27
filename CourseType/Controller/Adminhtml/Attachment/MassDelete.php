<?php

namespace Magenest\CourseType\Controller\Adminhtml\Attachment;

use Magento\Backend\App\Action\Context;
use Magenest\CourseType\Model\AttachmentFactory;
use Magenest\CourseType\Model\ResourceModel\Attachment\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $modelAttachment;
    protected $attachmentCollectionFactory;
    protected $filter;
    protected $_filer;

    public function __construct
    (
        AttachmentFactory $modelAttachment,
        CollectionFactory $attachmentCollectionFactory,
        Filter $filter,
        Context $context
    )
    {
        $this->modelAttachment = $modelAttachment;
        $this->attachmentCollectionFactory = $attachmentCollectionFactory;
        $this->_filer = $filter;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->_filer->getCollection($this->attachmentCollectionFactory->create());
        $ids = $collection->getAllIds();
        $model = $this->modelAttachment->create();
        $model->deleteMultiple($ids);
        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', count($ids))
        );
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->setPath('course/attachment/index');
    }
}
