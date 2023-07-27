<?php

namespace Magenest\CollectShipping\Plugin;

class LayoutProcessorPlugin
{
    public function beforeProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $processor, $jsLayout)
    {
        $customAttributeCode = 'account_number';
        $customField = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.' . $customAttributeCode,
            'label' => 'Account Number',
            'provider' => 'checkoutProvider',
            'sortOrder' => 200,
            'validation' => [
                'validate-acccount-number-checked' => true,
                'min_text_length' => 6
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCode] = $customField;
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['collectShipping'] = [
            'component' => 'Magenest_CollectShipping/js/view/collect-shipping'
        ];
        return [$jsLayout];
    }
}
