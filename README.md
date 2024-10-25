# Receipt Invoice Button - module from mnowakCode

Description
-----------
MNowakCode_ReceiptInvoiceButton module was created to show a button that adds the possibility choose a receipt or invoice in the checkout process.

Compatibility
-------------
- Magento >= 2.4

per the [official Magento 2 requirements](https://experienceleague.adobe.com/en/docs/commerce-operations/installation-guide/system-requirements)

Installation Instructions
-------------------------
Install using composer by adding to your composer file using commands:
```
$ composer require m-nowak-code/module-receipt-invoice-button
$ composer update
$ bin/magento setup:upgrade
```

REST API
--------
To use REST API to get data about which document the client chosen, use this endpoint ```/V1/order/document/:orderId```

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).
