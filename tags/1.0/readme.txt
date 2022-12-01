=== Valhalla CF - Simple and Effective Contact Form with Google Maps ===
Contributors: pierreamgabriel
Tags: contact, form, contact form, google maps
Requires at least: 4.7
Tested up to: 5.6
Stable tag: 1.0
License: GPL

A responsive contact form with Google Maps and CAPTCHA. It's simple but effective, and you can customize labels, messages, and colors in the WordPress Customizer.

== Description ==
Valhalla CF is a simple form with only name, email, phone, subject, and message fields, but it gets its job done very well. After installing it, you just have to use the shortcode [valhalla-cf], and you're ready to go. But in the WordPress Customizer, you can change labels, messages, the address used with Google Maps, and colors. It also has a built-in CAPTCHA that will keep spammers far away. Valhalla CF is built with Bootstrap, so it's responsive and beautiful out of the box.

= If you like this plugin, consider supporting my work =
You can buy my book "WordPress in 10 Days: Learn How to Build a Professional Theme without Knowing PHP." But if you are not interested in the book, you can buy it for the premium theme that comes with it. Links below:

[Amazon US](https://www.amazon.com/dp/B08PW472MY)
[Amazon UK](https://www.amazon.co.uk/dp/B08PW472MY)
[Amazon CA](https://www.amazon.ca/dp/B08PW472MY)
[Amazon AU](https://www.amazon.com.au/dp/B08PW472MY)
[Amazon BR](https://www.amazon.com.br/dp/B08PY7BSD8)

I listed above only a few Amazon sites, but It's available in all Amazon markets. Buying the book, you receive my exclusive Valhalla theme for free.

== Installation ==
Install it through the WordPress plugin installer.

== Screenshots ==
1. Valhalla CF screenshot

== Frequently Asked Questions ==
= How can I display the form in posts and pages?
After installing and activating the plugin, paste the shortcode [valhalla-cf] where you want the form to appear.

= Why don't the input fields have the Bootstrap style? =
It's because you're theme is overriding the Bootstrap classes. You need to remove any input[type=""], input, button, label, and textarea references from your theme style.css.

= Why am I not receiving emails? =
It's probably due to your SMTP settings. Valhalla CF uses the PHP mail() function, but not all servers have it enabled. To fix this, install the WP Mail SMTP plugin and add your desired SMTP host. Once you're able to send a test email in the Email Test tab of the WP Mail SMTP plugin, Valhalla CF will start sending all messages to your WordPress admin email address.

= How can I add or remove fields? =
This plugin is meant to be simple and ready to use after installation. It comes with only the fields any contact form must have: name, email, phone, subject, and message. If you need a more robust form, unfortunately, this plugin isn't for you.

= How can I translate or change labels and messages?
Inside your WordPress dashboard, click Appearance > Customize. In the Customizer panel, click the menu "Valhalla CF." Then, Click "Labels and messages" to customize as you wish.

= How can I change the color of labels, messages, and submit button? =
Inside your WordPress dashboard, click Appearance > Customize. In the Customizer panel, click the menu "Valhalla CF." Then, click "Colors" to customize as you wish.

= How can I hide Google Maps?
Inside your WordPress dashboard, click Appearance > Customize. In the Customizer panel, click the menu "Valhalla CF." Then, click "Google Maps" and uncheck "Display Google Maps".

