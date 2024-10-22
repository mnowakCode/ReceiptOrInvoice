define([
    'jquery',
    'mage/utils/wrapper',
    'MNowakCode_ReceiptInvoiceButton/js/model/assigner'
], function ($, wrapper, assigner) {
    'use strict';

    return function (placeOrderAction) {
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            assigner(paymentData);

            return originalAction(paymentData, messageContainer);
        });
    };
});
