<?php

namespace Magenest\CollectShipping\Observer;

use Magento\Quote\Model\Quote;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;

class FreeShipping implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        // fetch quote data
        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        if($quote->getShippingAddress()->getShippingMethod() === 'flatrate_flatrate' && !empty($quote->getShippingAddress()->getAccountNumber()))
        {
            /** Fetch Address related data */
            $shippingAssignment = $observer->getEvent()->getShippingAssignment();
            $address = $shippingAssignment->getShipping()->getAddress();
            // fetch totals data
            $total = $observer->getEvent()->getTotal();

            $allTotalAmounts = $total->getAllTotalAmounts();
            $allBaseTotalAmounts = $total->getAllBaseTotalAmounts();
            unset($allTotalAmounts['shipping']);
            unset($allBaseTotalAmounts['shipping']);
            $grandTotal = array_sum($allTotalAmounts);
            $baseGrandTotal = array_sum($allBaseTotalAmounts);
            $address->setGrandTotal($grandTotal);
            $address->setBaseGrandTotal($baseGrandTotal);
            $address->setShippingAmount(0);
            $address->setBaseShippingAmount(0);
            $quote->setGrandTotal($grandTotal);
            $quote->setBaseGrandTotal($baseGrandTotal);
            $total->setGrandTotal($grandTotal);
            $total->setBaseGrandTotal($baseGrandTotal);
            $total->setShippingAmount(0);
            $total->setBaseShippingAmount(0);
        }
    }
}
