<?php

namespace Magenest\CancelOrder\Model\Api;

use Magenest\CancelOrder\Api\OrderHistoryInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

class OrderHistory implements OrderHistoryInterface
{
    protected $orderCollectionFactory;

    public function __construct(
        OrderCollectionFactory $orderCollectionFactory
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function getOrderHistoryByCustomerId($customerId)
    {
        $orders = $this->orderCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('customer_id', $customerId)
            ->setOrder('created_at', 'desc');

        $result = [];
        foreach ($orders as $order) {
            $result[] = [
                'order_id' => $order->getId(),
                'order_number' => $order->getIncrementId(),
                'status' => $order->getStatus(),
                // Add other order information here as needed

            ];
        }

        return $result;
    }
}
