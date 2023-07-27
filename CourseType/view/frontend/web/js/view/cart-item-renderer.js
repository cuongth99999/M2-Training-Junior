/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Magento_Customer/js/model/customer/address'
], function ($, Component, customerData, CustomerAddress) {
    'use strict';

    return Component.extend({
        /**
         * Prepare the product name value to be rendered as HTML
         *
         * @param {String} productName
         * @return {String}
         */
        getProductNameUnsanitizedHtml: function (productName) {
            // product name has already escaped on backend
            return productName;
        },

        /**
         * Prepare the given option value to be rendered as HTML
         *
         * @param {String} optionValue
         * @return {String}
         */
        getOptionValueUnsanitizedHtml: function (optionValue) {
            // option value has already escaped on backend
            return optionValue;
        },

        increCartQty: function (idElement) {
            var customer = customerData.get('customer');
            console.log(customer().fullname);
            $( "#html-body" ).prepend( "<script>\n" +
                "  var _cdp365Analytics = {\n" +
                "       user_identify: {\n" +
                "          login_id: ,\n" +
                "          user_name: "+ customer().fullname +",\n" +
                "          phone: ,\n" +
                "          email: \n" +
                "       }\n" +
                "}\n" +
                "</script>" );
            $(idElement).on('click', function(){
                var obj = $(this);
                var currentQty = obj.siblings('.cart-item-qty').val();
                var iid = obj.siblings('.update-cart-item').attr('data-cart-item');
                var newAdd = parseInt(currentQty)+parseInt(1);
                obj.siblings('.cart-item-qty').val(newAdd);
                obj.siblings('.cart-item-qty').attr('data-item-qty',newAdd);
            });
        },

        decreCartQty: function (idElement) {
            $(idElement).on('click', function(){
                var obj = $(this);
                var currentQty = obj.siblings('.cart-item-qty').val();
                var iid = obj.siblings('.update-cart-item').attr('data-cart-item');
                var newAdd = parseInt(currentQty)-parseInt(1);
                obj.siblings('.cart-item-qty').val(newAdd);
                obj.siblings('.cart-item-qty').attr('data-item-qty',newAdd);
            });
        },

        // getDocByProdId: function(id) {
        //     var self = this;
        //     var customurl = 'https://testmagento244.local/course/document/AjaxDocProdId',
        //         returnIcon = '';
        //     $.ajax({
        //         url: customurl,
        //         type: 'POST',
        //         dataType: 'json',
        //         data: {
        //             product_id: id,
        //         },
        //         complete: function(response) {
        //             var resultArr = Object.entries(response.responseJSON);
        //             $('#icon-'+ id).append(resultArr[0][1]);
        //             $('#label-'+ id).append(resultArr[1][1]);
        //         },
        //         error: function (xhr, status, errorThrown) {
        //             console.log(xhr, status, errorThrown);
        //         }
        //     });
        // }
    });
});
