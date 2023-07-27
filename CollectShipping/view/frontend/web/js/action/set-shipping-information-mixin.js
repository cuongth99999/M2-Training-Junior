/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote',
    'Magento_Ui/js/lib/validation/utils',
    'Magento_Ui/js/lib/validation/validator'
], function ($, wrapper, quote, utils, validator) {
    'use strict';

    validator.addRule(
        'validate-acccount-number-checked',
        function (value) {
            if($("#collect-shipping").prop('checked') === true)
            {
                return !utils.isEmpty(value);
            }
            return true;
        },
        $.mage.__('This is a required field.')
    );

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();

            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            var attribute = shippingAddress.customAttributes.find(
                function (element) {
                    return element.attribute_code === 'account_number';
                }
            );

            shippingAddress['extension_attributes']['account_number'] = attribute.value;

            // pass execution to original action ('Magento_Checkout/js/action/set-shipping-information')
            return originalAction();
        });
    };
});
