define([
    'jquery'
], function ($) {
    'use strict';

    return function (paymentData) {
        var value;

        value = $('input[name="chooseInvoice"]:checked').val();

        if (paymentData['extension_attributes'] === undefined) {
            paymentData['extension_attributes'] = {};
        }

        paymentData['extension_attributes']['receiptOrInvoice'] = value;
    };
});
