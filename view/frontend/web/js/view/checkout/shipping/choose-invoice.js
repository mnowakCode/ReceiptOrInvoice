define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Mano_ReceiptInvoiceButton/checkout/shipping/choose_invoice'
        }
    });
});
