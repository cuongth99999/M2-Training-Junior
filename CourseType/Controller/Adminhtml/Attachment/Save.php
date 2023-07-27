<?php

namespace Magenest\CourseType\Controller\Adminhtml\Attachment;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magenest\CourseType\Model\ResourceModel\Attachment;
use Magenest\CourseType\Model\AttachmentFactory;

class Save extends Action
{
    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;

    protected $attachmentResource;
    protected $attachmentFactory;
    protected $fileUploaderFactory;


    public function __construct
    (
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Psr\Log\LoggerInterface $logger,
        Attachment $attachmentResource,
        AttachmentFactory $attachmentFactory,
        \Magenest\CourseType\Model\FileUploaderFactory $fileUploaderFactory,
        Context $context
    )
    {
        $this->assetRepo = $assetRepo;
        $this->logger = $logger;
        $this->attachmentResource = $attachmentResource;
        $this->attachmentFactory = $attachmentFactory;
        $this->fileUploaderFactory = $fileUploaderFactory->create();
        parent::__construct($context);
    }

    public function execute()
    {
        /**
         * @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect
         */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            try {
                $id = $this->getRequest()->getParam('entity_id')?:null;
                $customModel = $this->attachmentFactory->create()->load($id);
                if($data['attachment_type'] == 'file'){
                    $data['icon'] = 'https://training.junior.com/media/attachment/images/icons-file.png';
                } if($data['attachment_type'] == 'image') {
                    $data['icon'] = 'https://training.junior.com/media/attachment/images/icons-image.png';
                }
                $data['customer_group'] = json_encode($data['customer_group']);
                $data['mine_type'] = $data['file_path'][0]['type'];
                $data['file_size'] = $data['file_path'][0]['size'];

                if($this->fileUploaderFactory->checkFileExists($this->fileUploaderFactory->getBaseTmpPath().'/'.$data['file_path'][0]['name']))
                {
                    $data['file_path'][0]['path'] = str_replace($this->fileUploaderFactory->getBaseTmpPath(),$this->fileUploaderFactory->getBasePath(),$data['file_path'][0]['path']);
                    $data['file_path'][0]['url'] = str_replace($this->fileUploaderFactory->getBaseTmpPath(),$this->fileUploaderFactory->getBasePath(),$data['file_path'][0]['url']);
                    $data['file_link'] = $data['file_path'][0]['url'];
                    $this->fileUploaderFactory->moveFileFromTmp($data['file_path'][0]['name']);
                }

                $data['file_path'] = json_encode($data['file_path']);
                $customModel->setData($data)->setId($id);
                $customModel->save();
                $this->messageManager->addSuccessMessage(__('You saved the Attachment.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $customModel->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Attachment.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Retrieve url of a view file
     *
     * @param string $fileId
     * @param array $params
     * @return string
     */
    public function getViewFileUrl($fileId, array $params = [])
    {
        try {
            $params = array_merge(['_secure' => $this->getRequest()->isSecure()], $params);
            return $this->assetRepo->getUrlWithParams($fileId, $params);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->logger->critical($e);
            return $this->_backendUrl->getUrl('', ['_direct' => 'core/index/notFound']);
        }
    }
}
