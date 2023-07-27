<?php

namespace Magenest\CancelOrder\Api;

interface OrderDetailInterface
{
    /**
     * Get order detail by orderId.
     *
     * @param int $orderId
     * @return \Magento\Sales\Api\Data\OrderInterface Order interface.
     */
    public function getOrderDetail($orderId);
}
