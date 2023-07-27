/**
 * Copyright © 2020 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Magenest_LiveStreaming extension
 * NOTICE OF LICENSE
 *
 * @category Magenest
 * @package Magenest_LiveStreaming
 */
define([
    'jquery',
    'moment'
], function ($, moment) {
    'use strict';

    return function (validator) {
        validator.addRule(
            'appearance-time',
            function (value, selector) {
                return true;
            },
            $.mage.__('Please time geater than 1.')
        );

        return validator;
    };
});
