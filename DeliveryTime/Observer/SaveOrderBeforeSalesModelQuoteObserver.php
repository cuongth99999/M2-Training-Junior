<?php

namespace Magenest\DeliveryTime\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\ScopeInterface;

class SaveOrderBeforeSalesModelQuoteObserver implements ObserverInterface
{
    protected $addressRepository;
    protected $scopeConfiguration;

    public function __construct
    (
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfiguration
    )
    {
        $this->addressRepository = $addressRepository;
        $this->scopeConfiguration = $scopeConfiguration;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getData('order');

        /* @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getData('quote');

        if($this->scopeConfiguration->getValue('deliveryTime/general/disable_same_day_delivery_after', ScopeInterface::SCOPE_STORE))
        {
            $collectionTime = $this->scopeConfiguration->getValue('deliveryTime/general/collection_time', ScopeInterface::SCOPE_STORE);
            if (time() >= strtotime(str_replace(',',':',$collectionTime))) {
                $datetime = new \DateTime('tomorrow');
                $order->setCreatedAt($datetime->format('Y-m-d H:i:s'));
            }
        }

        $order->getShippingAddress()->setDeliveryDate($quote->getShippingAddress()->getDeliveryDate());
        $order->getShippingAddress()->setDeliveryTimeInterval($quote->getShippingAddress()->getDeliveryTimeInterval());
        $order->getShippingAddress()->setDeliveryComment($quote->getShippingAddress()->getDeliveryComment());
    }
}
