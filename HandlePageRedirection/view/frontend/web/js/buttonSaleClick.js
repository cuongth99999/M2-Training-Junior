define([
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'jquery'
], function (alert, modal, $) {

    $('#sale-button').click(function () {
        var options = {
            type: 'popup',
            title: 'Sale Products',
            buttons: [{
                text: $.mage.__('Close'),
                class: '',
                click: function () {
                    this.closeModal();
                }
            }]
        };

        var popup = modal(options, $('#modal-sale_products'));
        $('#modal-sale_products').modal('openModal');
    })
});
