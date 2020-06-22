=== WooCommerce Postpay Payment Gateway ===
Contributors: mongkok
Requires at least: 4.4
Tested up to: 5.4
Requires PHP: 5.6
Stable tag: 0.2.1
Version: 0.2.1
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Tags: wordpress,woocommerce,payment,gateway,postpay

Buy now and pay later with zero interest and zero fees.

== Description ==

Postpay is a payment solution that allows customers to "buy now, pay later" seamlessly with absolutely zero interest and no fees.

Select Postpay on checkout at one of our partner retailers and we split your total purchase into four equal instalments. The first instalment (25%) is processed immediately and the merchant ships your purchase to you as normal, so you can enjoy now and pay later.

The remaining three instalments are due every two weeks thereafter. Absolutely no interest and zero fees are charged as-long-as all repayments are processed successfully on time. So in short, at the end of the six weeks you only pay for what you ordered!

We benefit most when our customers complete instalments early and so if you want to pay off your instalments early, you can do so at absolutely no extra cost.

For more information about Postpay please go to https://postpay.io.

== Installation ==

Please note, this payment gateway requires WooCommerce 3.0 and above.

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of the WooCommerce Postpay plugin, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "Postpay" and click Search Plugins. Once you’ve found our plugin you can install it by simply clicking "Install Now", then "Activate".

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your web server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation).

== Frequently Asked Questions ==

= Who can use Postpay? =

To use Postpay, you must be over 18 years old and have a valid ID Card and mobile number.

= Who can use Postpay? =

The easiest way to sign up to Postpay is to select Postpay as your payment method at one of our partner retailers. Once you have selected to Postpay simply follow the steps to checkout and you will have an account linked to your mobile phone and ID number.

= How much can I spend? =

Your limit will change with regards to several key factors including but not limited to, the nature of the items you are purchasing, the retail merchant where you are purchasing these items and of course your history with Postpay. In short, the longer you have been purchasing using Postpay and successfully repaying on time, the higher your limit will be. We restrict the limits of new shoppers as we need to get to know you better. That being mentioned, we evaluate your repayment capability every time you use Postpay.

= Is there any interest charged or fees for using postpay? =

There is absolutely no interest and zero fees when using postpay.

= Is this different from credit? =

Postpay offers an interest-free and fees-free alternative to traditional credit that favors you, the customer. This means that you will have a seamless experience and not pay anything more for it!

= Is postpay secure? =

We agree that your security is of utmost importance. We are a PCI DSS compliant company which means that we undergo strict compliance tests from the the Payment Card Industry (PCI) to ensure that your data is safely stored in our systems. Please visit our PCI DSS page to learn more https://postpay.io/pci-dss.

== Screenshots ==

1. Buy now and pay later with zero interest and zero fees.
2. Select Pospat payment method.
3. Checkout with Postpay.
4. Instalment plan approved.

== Changelog ==

= 0.2.1 - 2020-06-22 =
* Improved checkout widgets settings
* Added widgets locale attribute

= 0.2.0 - 2020-05-29 =
* Added Pay Now payment gateway
* Improved unit price on product widget

= 0.1.11 - 2020-05-19 =
* Removed checkout cancelled notes
* Renamed payment method widget to payment summary
* Modified in-context checkout default value

= 0.1.10 - 2020-05-15 =
* Added Payment Method Widget to settings

= 0.1.9 - 2020-05-13 =
* Added instalment plan widget
* Removed max_amount and min amount settings

= 0.1.8 - 2020-05-06 =
* Added theme to settings
* Removed widget amount validation

= 0.1.7 - 2020-05-05 =
* Fixed interface declaration compatible

= 0.1.6 - 2020-04-28 =
* Added priority parameter to widget hooks

= 0.1.5 - 2020-04-24 =
* Added gateway icon
* Changed default description

= 0.1.4 - 2020-04-23 =
* Fixed sandbox setting name
* Allowed empty shipping method

= 0.1.3 - 2020-04-21 =
* Added max amount and min amount settings
* Added checkout API error message

= 0.1.2 - 2020-03-30 =
* Disabled module if merchantId is not defined
* Added is_available method to WC_Postpay_Gateway
* Returned WP_Error instance on refund errors

= 0.1.1 - 2020-03-25 =
* Renamed plugin
* Added minor improvements

= 0.1.0 - 2020-03-25 =
* First release
