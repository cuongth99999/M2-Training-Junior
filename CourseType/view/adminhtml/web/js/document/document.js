/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'jquery',
    'mage/url',
    'Magento_Ui/js/form/element/abstract'
], function ($, url, abstract) {
    'use strict';

    return abstract.extend({
        userChanges: function () {
            this.valueChangedByUser = true;

            var customUrl = 'https://training.junior.com/course/document/ajax';
            var val = $('input[name="product[document]"]').val();
            $.ajax({
                url: customUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    keyword: val,
                },
                complete: function(response) {
                    var resultArr = Object.entries(response.responseJSON);
                    const file_name = 1;
                    $('#resultdoc').empty();
                    jQuery.each( resultArr, function( i, val ) {
                        console.log(val[file_name]['file_name']);
                        $('#resultdoc').append('<div>' + val[1]['file_name'] + '</div>');
                    });
                },
                error: function (xhr, status, errorThrown) {
                    console.log(xhr, status, errorThrown);
                }
            });
        }
    });
});
