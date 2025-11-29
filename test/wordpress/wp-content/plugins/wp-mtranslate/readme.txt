=== Wp-mtranslate ===
Contributors: veto
Tags: translate domains, google translate, automatic translate
Requires PHP: 8.2.0
Requires at least: 6.7
Tested up to: 6.8
Stable Tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Plugin URI: **https://wp-mtranslate.myridia.com/**


The automatic translation of a WordPress website based on its domain.

== Description ==

Domain-Trnalsate is an automatic Website Translation based on your domainame, its integrates directly with the Google Translate JavaScript API to provide instant, machine-powered translation of your entire WordPress website content.
This includes posts, pages, widgets, and other dynamic content.
There is no database modifications, execpt for the plugin options settins. Unlike traditional multilingual plugins that store translated content in your database,
this plugin translates content dynamically in the user's browser, meaning no additional database tables or content duplication are required.
This simplifies maintenance and reduces server load.
Its lightweight and efficient, because by leveraging Google's robust infrastructure, the plugin remains lightweight on your server, as the translation processing occurs client-side.
It as broad language support, its benefits from the extensive language support offered byGoogle Translate, enabling your website to be translated into a wide array of languages.

== Privacy ==
* It uses https://translate.google.com/translate_a/element.js Google Translate Service
* The Website HTML is send to the Google Translate Service
* Googles Privacy and Terms:  https://policies.google.com/privacy?hl=en-GB#intro

=== List of information collected by google ==
* Google will collect the website user GPS and other sensor data from your device
* Google will collect the website user IP address
* Google will collect the  Activity on Google services; for example, from your searches or places that you label such as home or work


As a website operator employing this plugin, you have the prerogative to obtain consent from your visitors.
This can be archived by such by GDPR and CCPA plugins.



== Demo Page ==
* https://shock.se


== How it Works ==

The plugin checks your domain and if its setup for a translation it injects the Google Translate JavaScript API into your WordPress website's frontend.
The Google Translate script intercepts the page's content and dynamically translates it in the user's browser.
This process happens client-side, meaning the original content on your server remains in its primary language,
and the translated version is rendered directly for the end-user.

== Installation ==

Download the plugin (if applicable, from the WordPress plugin repository or a provided ZIP file).
Upload the plugin to your WordPress installation via Plugins > Add New > Upload Plugin or by uploading the unzipped folder to the /wp-content/plugins/ directory.
Activate the plugin through the 'Plugins' menu in WordPress.
Configure the plugin settings (found under Settings > Domain-Translate ) to customize language and domain options.

== Usage ==

The translation is performed automatically by Google Translate based on your domain and language settings.

== Limitations ==

=== Machine Translation Accuracy ===

While Google Translate is highly advanced, machine translations may not always be perfectly accurate or contextually appropriate.
Human review for critical content is always recommended.

=== SEO Considerations ===

Since the translation happens client-side, search engines typically index only the original language content of your website.[
This plugin is primarily for user experience and accessibility, not for improving multilingual SEO.
For robust multilingual SEO, dedicated multilingual plugins that store translated content are generally preferred.


== Support ==

For support, please refer to the plugin's documentation or the support forums on WordPress.org.


== Frequently Asked Questions ==
* Can I suggest/request a feature to be added? ===
** Yes, we really need any feedback and requests <a href="mailto:domain-translate@myridia.com">email</a>.


== Changelog == 

== Upgrade Notice == 

== Screenshots ==

