<?php

namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magenest\DeliveryTime\Model\DeliveryTimeFactory;

class Save extends Action
{
    private $deliveryTimeFactory;

    public function __construct(
        Context $context,
        DeliveryTimeFactory $deliveryTimeFactory
    ) {
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
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('delivery_time_id')?:null;
            $model = $this->deliveryTimeFactory->create()->load($id);
            $data['store_view'] = json_encode($data['store_view']);
            $data['customer_group'] = json_encode($data['customer_group']);
            $data['range_time'] = json_encode($data['range_time']);
            $model->setData($data)->setId($id);
            $model->save();
            try {
                $this->messageManager->addSuccessMessage(__('You saved the Brand.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Brand.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['delivery_time_id' => $this->getRequest()->getParam('delivery_time_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

