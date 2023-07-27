<?php

namespace Magenest\CancelOrder\Controller\Adminhtml\Order;

use Magento\Backend\App\Action\Context;
use Magenest\CancelOrder\Model\CancelOrderFactory;
use Magenest\CancelOrder\Model\ResourceModel\CancelOrder\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Api\Data\OrderInterface;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $modelCancelOrder;
    protected $cancelOrderCollectionFactory;
    protected $filter;
    protected $_filer;
    protected $orderInterface;

    public function __construct
    (
        CancelOrderFactory $modelCancelOrder,
        CollectionFactory $cancelOrderCollectionFactory,
        OrderInterface $orderInterface,
        Filter $filter,
        Context $context
    )
    {
        $this->modelCancelOrder = $modelCancelOrder;
        $this->cancelOrderCollectionFactory = $cancelOrderCollectionFactory;
        $this->_filer = $filter;
        $this->orderInterface = $orderInterface;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->_filer->getCollection($this->cancelOrderCollectionFactory->create());
        $ids = $collection->getAllIds();
        $model = $this->modelCancelOrder->create();
        $incrementIdArr[] = $collection->getData();

        foreach ($incrementIdArr[0] as $item) {
            try {
                $order = $this->orderInterface->loadByIncrementId($item['increment_id']);
                $this->orderInterface->delete($order);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('An error occurred while deleting the order with Increment ID: %1', $item['increment_id'])
                );
            }
        }

        $model->deleteMultiple($ids);

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', count($ids))
        );
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->setPath('cancel/order/index');
    }
}
