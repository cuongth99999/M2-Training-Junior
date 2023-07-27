<?php

namespace Magenest\CourseType\Controller\Adminhtml\Attachment;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class Index extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;

    public function __construct
    (
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        Context $context
    )
    {
        $this->_resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Course Attachments Management'));
        return $resultPage;
    }
}
