<?php

namespace Magenest\DeliveryTime\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{
    /*
     * @return bool
     */
    public function getValue($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'deliveryTime/general/delivery_display_on',
            $scope
        );
    }
}
