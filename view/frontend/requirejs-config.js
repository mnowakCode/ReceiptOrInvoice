var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'Mano_ReceiptInvoiceButton/js/model/place-order-mixin': true
            },
            'Magento_Checkout/js/action/set-payment-information': {
                'Mano_ReceiptInvoiceButton/js/model/set-payment-information-mixin': true
            }
        }
    }
};
