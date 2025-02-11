=== GF Dynamic Population From Cookies ===
Contributors: eclev91
Tags: gravity forms, marketing
Requires at least: 4.5
Tested up to: 6.7.1
Requires PHP: 8.0
Stable tag: 0.1.0
Requires Plugins: gravityforms
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds cache-friendly support for dynamically populating Gravity Form fields from cookies.

== Description ==

Using Gravity Forms' existing dynamic population settings, fields can now get their value from cookies. This happens client-side so it's cache-safe.

How you set the cookies is up to you. If you're setting the cookies on the same page as the form you want to read them, be sure to set the cookie early in the page.

For example, you could simply install [Store UTM Params to Cookie](https://github.com/ethanclevenger91/store-utm-params-to-cookie), which automatically saves any `utm_` query string params to a prefixed cookie. You could then enable dynamic population for a Gravity Form field using the field name `sup_utm_term`.

== Changelog ==

= 1.0.0 =
* Initial release