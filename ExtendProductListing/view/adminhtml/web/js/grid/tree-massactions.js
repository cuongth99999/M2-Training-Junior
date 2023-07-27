define([
        'jquery',
        'mageUtils',
        'underscore',
        'mage/translate',
        'jquery/ui',
        'Magento_Ui/js/modal/modal'
    ],
    function (
        $,
        utils,
        _,
        $t
    ) {
        'use strict';

        var mixin = {
            submitData: function (action, data) {
                var itemsType = data.excludeMode ? 'excluded' : 'selected',
                    selections = {};

                selections[itemsType] = data[itemsType];

                if (!selections[itemsType].length) {
                    selections[itemsType] = false;
                }

                _.extend(selections, data.params || {});

                utils.submit({
                    url: action.url,
                    data: selections
                });
            },


            updateRelatedProducts: function (action, data) {
                this.showRelatedProductsModal(action, data);
            },
            showRelatedProductsModal: function (action, data) {
                var self = this;
                $('#related-products').modal({
                    wrapperClass: 'mpa-modal',
                    responsive: true,
                    innerScroll: true,
                    title: $t('Update Related Products'),
                    buttons: [],
                    opened: function() {
                        $('#massaction-related-products-btn').on('click', function () {

                            action.url = $('#massaction-related-products-submit-url').val();
                            data.params.add_related_products = $('#add-related-products').val();
                            data.params.remove_related_products = $('#remove-related-products').val();

                            self.submitData(action, data);
                        })
                    },
                    closed: function () {

                    }
                }).trigger('openModal');
            },

        };

        return function (target) {
            return target.extend(mixin);
        };
    });
