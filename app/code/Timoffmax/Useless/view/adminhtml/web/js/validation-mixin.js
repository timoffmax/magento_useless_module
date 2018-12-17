define([
    'jquery'
], function ($) {
    'use strict';

    return function () {
        $.validator.addMethod(
            'validate-rate',
            function (value) {
                return value >= 0.1 && value <= 2;
            },
            $.mage.__('Rate must be between 0.1 and 2.0')
        );
    }
});
