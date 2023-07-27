<?php

namespace Magenest\DeliveryTime\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\ScopeInterface;

class CustomDatePick implements ConfigProviderInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfiguration;
    protected $deliveryTimeCollection;
    protected $jsonSerializer;
    protected $storeManager;
    protected $_customerSession;


    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfiguration
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfiguration,
        \Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime\CollectionFactory $deliveryTimeCollection,
        \Magento\Framework\Serialize\SerializerInterface $jsonSerializer,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->scopeConfiguration = $scopeConfiguration;
        $this->deliveryTimeCollection = $deliveryTimeCollection;
        $this->jsonSerializer = $jsonSerializer;
        $this->storeManager = $storeManager;
        $this->_customerSession = $customerSession;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $showHide = [];
        $deliveryTimeCollection = $this->deliveryTimeCollection->create();
        $deliveryTimeOption = [];

        foreach($deliveryTimeCollection as $deliveryTime)
        {
            $deliveryTimeStoreView = $deliveryTime->getData('store_id');
            $deliveryTimeCustomerGroup = $deliveryTime->getData('group_id');
//            if (
//                in_array($this->storeManager->getStore()->getId(), $this->jsonSerializer->unserialize($deliveryTimeStoreView)) ||
//                in_array($this->_customerSession->getCustomer()->getGroupId(), $this->jsonSerializer->unserialize($deliveryTimeCustomerGroup))
//            )
//            {
                foreach($this->jsonSerializer->unserialize($deliveryTime->getRangeTime()) as $rangeTime)
                {
                    $deliveryTimeOption[] = (object)[
                        'label' =>  $rangeTime['from'].':00 - '.$rangeTime['to'].':00',
                        'value' =>  $rangeTime['from'].' - '.$rangeTime['to']
                    ];
                }
//            }
        }
        $enabled = $this->scopeConfiguration->getValue('deliveryTime/general/enable_comments', ScopeInterface::SCOPE_STORE);
        $maxDate = $this->scopeConfiguration->getValue('deliveryTime/general/maximum_waiting_time', ScopeInterface::SCOPE_STORE);
        $minDate = $this->scopeConfiguration->getValue('deliveryTime/general/minimum_waiting_time', ScopeInterface::SCOPE_STORE);
        $noDeliveryDay = $this->scopeConfiguration->getValue('deliveryTime/general/days_not_receiving_goods', ScopeInterface::SCOPE_STORE);
        $enableComments = $this->scopeConfiguration->getValue('deliveryTime/general/enable_comments', ScopeInterface::SCOPE_STORE);
        $showHide['show_hide_custom_block'] = ($enabled)?true:false;
        $showHide['max_date'] = $maxDate;
        $showHide['min_date'] = $minDate;
        $showHide['noDeliveryDay'] = explode(',', (string)$noDeliveryDay);
        $showHide['deliveryTimeOption'] = $deliveryTimeOption;
        $showHide['enable_comments'] = $enableComments;
        return $showHide;
    }
}

