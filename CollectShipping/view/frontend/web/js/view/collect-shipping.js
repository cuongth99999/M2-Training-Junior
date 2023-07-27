define(
    [
        'jquery',
        'ko',
        'uiComponent'
    ],
    function ($, ko, Component) {
        "use strict";

        return Component.extend({
            defaults: {
                template: 'Magenest_CollectShipping/collect-shipping'
            },
            isRegisterNewsletter: true
        });
    }
);
