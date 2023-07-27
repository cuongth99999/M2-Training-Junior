<?php

namespace Magenest\CancelOrder\Model\Api;

use Magenest\CancelOrder\Api\OrderDetailInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrderDetail implements OrderDetailInterface
{
    protected $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @inheritdoc
     */
    public function getOrderDetail($orderId)
    {
        try {
            return $this->orderRepository->get($orderId);
        } catch (\Exception $e) {
            // Handle exception if order not found or any other error
            return ['error' => $e->getMessage()];
        }
    }
}
