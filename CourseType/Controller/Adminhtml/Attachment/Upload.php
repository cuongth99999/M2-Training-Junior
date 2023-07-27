<?php

namespace Magenest\CourseType\Controller\Adminhtml\Attachment;

use Magento\Framework\Controller\ResultFactory;

class Upload extends \Magento\Backend\App\Action
{
    public $uploader;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magenest\CourseType\Model\FileUploader $uploader
    ) {
        parent::__construct($context);
        $this->uploader = $uploader;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_CourseType::attachment');
    }

    public function execute()
    {
        try {
            $imageId = $this->_request->getParam('param_name', 'file_path');
            $result = $this->uploader->saveFileToTmpDir($imageId);
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
