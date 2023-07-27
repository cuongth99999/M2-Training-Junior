define([
    'jquery',
    "underscore",
    'ko',
    'uiComponent',
    'mage/calendar'
], function ($, _, ko, Component, calendar) {
    'use strict';
    var show_hide_custom_blockConfig = window.checkoutConfig.show_hide_custom_block;
    var max_date = window.checkoutConfig.max_date;
    var min_date = window.checkoutConfig.min_date;
    var noDeliveryDay = window.checkoutConfig.noDeliveryDay;
    var deliveryTimeOption = window.checkoutConfig.deliveryTimeOption;
    return Component.extend({
        defaults: {
            template: 'Magenest_DeliveryTime/view/custom-checkout'
        },

        initialize: function () {
            var self = this;
            this._super();
            self.canVisibleBlock = show_hide_custom_blockConfig;
            self.deliveryTimeInterval = ko.observableArray();
            Object.keys(deliveryTimeOption).forEach(function (index) {
                self.deliveryTimeInterval.push({
                    'label': deliveryTimeOption[index].label,
                    'value': deliveryTimeOption[index].value
                });
            });
            ko.bindingHandlers.datepicker = {
                init: function(element, valueAccessor, allBindingsAccessor) {
                    var $el = $(element);
                    //initialize datepicker with some optional options
                    var options = {
                        minDate: min_date,
                        maxDate: max_date,
                        beforeShowDay: noShippingDay
                    };
                    function noShippingDay(date){
                        return [(!noDeliveryDay.includes(date.getDay())), ''];
                    };
                    $el.datepicker(options);

                    var writable = valueAccessor();
                    if (!ko.isObservable(writable)) {
                        var propWriters = allBindingsAccessor()._ko_property_writers;
                        if (propWriters && propWriters.datepicker) {
                            writable = propWriters.datepicker;
                        } else {
                            return;
                        }
                    }
                    writable($(element).datepicker("getDate"));

                },
                update: function(element, valueAccessor)   {
                    var widget = $(element).data("DateTimePicker");
                    //when the view model is updated, update the widget
                    if (widget) {
                        var date = ko.utils.unwrapObservable(valueAccessor());
                        widget.date(date);
                    }
                }
            };
            return this;
        },
    });
});
