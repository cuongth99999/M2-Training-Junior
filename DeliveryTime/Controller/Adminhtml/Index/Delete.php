<?php

namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magenest\DeliveryTime\Model\DeliveryTimeFactory;
use Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime;

class Delete extends Action
{
    private $deliveryTimeResourceModel;
    private $deliveryTimeFactory;

    public function __construct(
        Context $context,
        DeliveryTime $deliveryTimeResourceModel,
        DeliveryTimeFactory $deliveryTimeFactory
    ) {
        $this->deliveryTimeResourceModel = $deliveryTimeResourceModel;
        $this->deliveryTimeFactory = $deliveryTimeFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /**
         * @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect
         */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();
        if ($data) {
            $id = $this->getRequest()->getParam('id');
            $model = $this->deliveryTimeFactory->create();
            $this->deliveryTimeResourceModel->load($model, $id);
            try {
                $this->deliveryTimeResourceModel->delete($model);
                $this->messageManager->addSuccessMessage(__('You delete the Brand.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Brand.'));
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
