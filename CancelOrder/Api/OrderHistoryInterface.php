<?php

namespace Magenest\CancelOrder\Api;

interface OrderHistoryInterface
{
    /**
     * @param int $customerId
     * @return \Magento\Sales\Api\Data\OrderInterface Order interface.
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getOrderHistoryByCustomerId(int $customerId);
}
