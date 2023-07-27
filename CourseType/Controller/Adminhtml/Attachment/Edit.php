<?php

namespace Magenest\CourseType\Controller\Adminhtml\Attachment;

use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
}
