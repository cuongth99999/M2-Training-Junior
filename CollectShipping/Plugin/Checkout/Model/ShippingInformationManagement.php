<?php

namespace Magenest\CollectShipping\Plugin\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\CartTotalRepositoryInterface;

class ShippingInformationManagement
{
    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var CartTotalRepositoryInterface
     */

    protected $checkoutSession;
    protected $_request;

    protected $cartTotalsRepository;

    public function __construct
    (
        CartRepositoryInterface $quoteRepository,
        CartTotalRepositoryInterface $cartTotalsRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Webapi\Rest\Request $request
    )
    {
        $this->quoteRepository = $quoteRepository;
        $this->cartTotalsRepository = $cartTotalsRepository;
        $this->checkoutSession = $checkoutSession;
        $this->_request = $request;
    }

    public function beforeSaveAddressInformation
    (
        \Magento\Checkout\Model\ShippingInformationManagement $shippingInformationManagement,
                                                              $cartId,
        ShippingInformationInterface $addressInformation
    )
    {
        $params = $this->_request->getBodyParams();
        $accountNumber = (!empty($params['addressInformation']['shipping_address']['extension_attributes']['account_number']))?$params['addressInformation']['shipping_address']['extension_attributes']['account_number']:null;
        $quote = $this->quoteRepository->getActive($cartId);
        if($quote->getCustomerId() > 0){
            $quote->setCustomerIsGuest(0);
        }
        foreach($quote->getExtensionAttributes()->getShippingAssignments() as $shippingAssignment)
        {
            $shippingAssignment->getShipping()->getAddress()->setAccountNumber($accountNumber)->save();
        }

        return [$cartId,$addressInformation];
    }
}

