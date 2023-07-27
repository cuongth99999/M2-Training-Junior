<?php

namespace Magenest\DeliveryTime\Plugin\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\CartTotalRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class ShippingInformationManagement
{
    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var CartTotalRepositoryInterface
     */
    protected $cartTotalsRepository;
    protected $checkoutSession;
    protected $_request;
    protected $orderCollectionFactory;
    protected $transportBuilder;

    public function __construct
    (
        CartRepositoryInterface $quoteRepository,
        CartTotalRepositoryInterface $cartTotalsRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Webapi\Rest\Request $request,
        CollectionFactory $orderCollectionFactory,
        TransportBuilder $transportBuilder
    )
    {
        $this->quoteRepository = $quoteRepository;
        $this->cartTotalsRepository = $cartTotalsRepository;
        $this->checkoutSession = $checkoutSession;
        $this->_request = $request;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->transportBuilder = $transportBuilder;
    }

    public function beforeSaveAddressInformation
    (
        \Magento\Checkout\Model\ShippingInformationManagement $shippingInformationManagement,
                                                              $cartId,
        ShippingInformationInterface $addressInformation
    )
    {
        $params = $this->_request->getBodyParams();
        $deliveryDate = (!empty($params['addressInformation']['shipping_address']['extension_attributes']['delivery_date']))?$params['addressInformation']['shipping_address']['extension_attributes']['delivery_date']:null;
        $deliveryTime = (!empty($params['addressInformation']['shipping_address']['extension_attributes']['delivery_time_interval']))?$params['addressInformation']['shipping_address']['extension_attributes']['delivery_time_interval']:null;
        $deliveryComment = (!empty($params['addressInformation']['shipping_address']['extension_attributes']['delivery_comment']))?$params['addressInformation']['shipping_address']['extension_attributes']['delivery_comment']:null;
        $quote = $this->quoteRepository->getActive($cartId);
        if($quote->getCustomerId() > 0){
            $quote->setCustomerIsGuest(0);
        }
        foreach($quote->getExtensionAttributes()->getShippingAssignments() as $shippingAssignment)
        {
            $shippingAssignment->getShipping()
                ->getAddress()
                ->setDeliveryDate($deliveryDate)
                ->setDeliveryTimeInterval($deliveryTime)
                ->setDeliveryComment($deliveryComment)
                ->save();
        }

        return [$cartId,$addressInformation];
    }
}
