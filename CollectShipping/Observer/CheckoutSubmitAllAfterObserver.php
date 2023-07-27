<?php

namespace Magenest\CollectShipping\Observer;

class CheckoutSubmitAllAfterObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        if (empty($order) || empty($quote)) {
            return $this;
        }

        $shippingAddress = $quote->getShippingAddress();
        if ($shippingAddress->getAccountNumber()) {
            $orderShippingAddress = $order->getShippingAddress();
            $orderShippingAddress->setAccountNumber(
                $shippingAddress->getAccountNumber()
            )->save();
        }

        return $this;
    }
}
