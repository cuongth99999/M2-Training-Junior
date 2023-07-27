<?php

namespace Magenest\CollectShipping\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveOrderBeforeSalesModelQuoteObserver implements ObserverInterface
{
    protected $addressRepository;

    public function __construct
    (
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
    )
    {
        $this->addressRepository = $addressRepository;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getData('order');

        /* @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getData('quote');

        try {
            $address = $this->addressRepository->getById($quote->getShippingAddress()->getData('customer_address_id'));
            if($address && $address->getId()) {
                $address->setCustomAttribute('account_number', $quote->getShippingAddress()->getAccountNumber());
                $this->addressRepository->save($address);
            }
        } catch (\Throwable $e) {}

        $order->getShippingAddress()->setAccountNumber($quote->getShippingAddress()->getAccountNumber());
    }
}
