=== WCP OpenWeather ===
Contributors: webcodin
Tags:  weather, forecast, current weather, forecast widget, openweathermap, local weather, shortcode, sidebar, weather forecasts, weather widget, widgets, options, user options, plugin skin, plugin theme, Weather API, conditions, current conditions, weather by city, city name, google autocomplete, autocomplete, location, units, temperature, wind speed, pressure, multilanguage, multi language, language
Requires at least: 3.5.0
Tested up to: 4.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: trunk

The multilanguage weather forecast plugin based on OpenWeatherMap API that includes various sidebar widgets and shortcodes.

== Description ==     

> **NB!** OpenWeatherMap changed conditions of free API ussage without API Key. Currently, OpenWeatherMap API **doesn't work without API key** any more. You need to add free or paid API key in the plugin settings: "WCP OpenWeather" > "Settings" > "API Key". You can get API key [here](http://openweathermap.org/appid#get).

> **NB!** Usage of the Google Maps APIs now requires a key. If you are using the Google Maps API on localhost or your domain was not active **prior to June 22nd, 2016**, it will require a key going forward. To fix this problem, please see the Google Maps APIs documentation to get a key and add it to your application: [https://developers.google.com/maps/documentation/javascript/get-api-key](https://developers.google.com/maps/documentation/javascript/get-api-key). You can add this key in the plugin settings: "WCP OpenWeather" > "Settings" > "Google API Key".

WCP OpenWeather plugin allows you to add various widgets and shortcodes with current weather or forecast for your city.   

Our plugin is based on free [OpenWeatherMap API](http://openweathermap.org/) and works with free API key for weather data receiving with limitation for this plan, but you can buy any key for [paid plans](http://openweathermap.org/price/) and use it for your purposes.

In additional, plugin supports different themes, but currently is available only one default theme. We are working on creation of new themes for widgets/shortcodes, so it will be added soon. With default theme you are able to customize background/text colors for widgets/shortcodes.

More information about our plugin as well as plugin support you can find on our [demo site](http://wpdemo.webcodin.com/):

* [**actual plugin documentation**](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/getting-started/);
* [**FAQ**](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/faq/);
* [**support**](http://wpdemo.webcodin.com/stay-in-touch/);
* [**live demo**](http://wpdemo.webcodin.com/weather-forecast/).

If you find issues or have any questions about the plugin, please feel free to ask questions:

* directly via [**support form**](http://wpdemo.webcodin.com/stay-in-touch/) on our demo site;
* directly via support email address **support@webcodin.com**;
* [**Support Tab**](https://wordpress.org/support/plugin/wcp-openweather) on WordPress.ORG.

> Minimum required PHP version is **5.3.0**;

= Plugin Features =

* Current weather and forecast widgets for sidebars and shortcode for page;
* Weather forecast provided by FREE OpenWeatherMap API;
* Conversion measurements and settings for temperature, wind and pressure;
* Default plugin options and personal widgets/shortcodes options for site administrator;
* Optional widget/shortcode user options for weather forecast on the site frontend for site visitors;
* Plugin themes support; You can change active theme in the plugin settings.
* Possibility to use OpenWeatherMap API key for free and [paid plans](http://openweathermap.org/price/);
* City name with Google Map Place Autocomplete;
* Full adaptive translation of the plugin interface including the name of the city.
* Multilanguage functionality (limited languages list – will be improved soon);
* TinyMCE toolbar button for shortcode with visual settings;
* Added the ability to determine the weather for the GeoIP coordinates via [ipInfo](https://ipinfo.io/). To use of this feature you need to left blank value for the "City" option in a shortcode constructor or a widget parameters.

= Default Theme Features =

* Widget with 2 templates: default & compact;
* Mini Widget;
* Shortcode with 2 templates: default & compact;
* Customization of background and text colors;

= Metro Theme Features =

* Widget with 2 templates: default & compact;
* Mini Widget;
* Shortcode with 2 templates: default & compact;
* Extended background and text color customization;
* Personal background images for widgets and shortcodes;
* Font-based weather icons.

= Multilanguage Functionality = 


> If you want to help with plugin translation on your language please let us know via demo site [contact form](http://wpdemo.webcodin.com/stay-in-touch/) or directly via support@webcodin.com. We will send you .xlsx or .po files with necessary variables for translations.
> Please note, in case if you add translation manually it will be overwritten after plugin update.

First of all, we want to say **great thanks** for all people who help us with plugin translation!

Available Languages:

* English (United States) – default;
* Russian (Russia);
* Ukrainian (Ukraine);
* Albanian (Albania) – great thanks for Erjon;
* Dutch (Nederland);
* Dutch (Belgium) – great thanks for Christophe;
* Serbian (Serbia) - great thanks for Nikola;
* Lithuanian (Lithuania) - great thanks for Mantas; 
* Spanish(Ecuador) - great thanks for Otto;
* Spanish(Spain) - great thanks for Marco;
* Portuguese (Portugal) - great thanks for Carlos;
* Romanian (Romania) - great thanks for Robert;
* Slovenian (Slovenia) - great thanks for Žiga;
* German (Germany) - great thanks for Robert;
* Italian (Italy) - great thanks for Antonio;
* Turkish (Turkey) - great thanks for Raşit;
* Croatian (Croatia) - great thanks for Podrška Cedar;
* Bulgarian (Bulgaria) - great thanks for Valentin;
* Catalan (Catalonia) - great thanks for Ana;
* Persian (Iran) - great thanks for Morteza; 
* Greek (Greece) - great thanks for Antreas;
* Polish (Poland);
* French (France);
* Danish (Denmark) - great thanks for Kim;

Multilanguage functionality has limitation based on [OpenWeatherMap API](http://openweathermap.org/forecast16#multi) languages support, i.e. city name has no translation for city name by default and description of weather conditions have translation only for languages form [OpenWeatherMap](http://openweathermap.org/forecast16#multi) API list.

Currently, translation of the city names realized via Google autocomplete for city name based on active language for the plugin. 

**NB!** Translation of the city name to the active language occurs when you choose city from the Google Autocomplete list. When You change the current language then city name in the existing shortcodes and widgets will not be automatically translated to the new language. To do this, select the city again, and save the changes.

More information you can find in the [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/getting-started/) on our demo site.

= Notes =

* **NB!** Minimum required **PHP version** is **5.3.0**.
* **NB!** We use cookies to storage user options; 
* **NB!** OpenWeatherMap API **doesn't work without API key** any more. You need to add free or paid API key in the plugin settings: "WCP OpenWeather" > "Settings" > "API Key". You can get API key [here](http://openweathermap.org/appid#get).
* **NB!** Free OpenWeatherMap has [limitation to API request](http://openweathermap.org/price/).
* **NB!** Free ipInfo has [limitation to API request](https://ipinfo.io/pricing).
* **NB!** Unfortunately, at the moment our plugin **do not support** adding of manual translation from the user side. We **do not provide any guarantee** of properly work of the plugin for manually added custom translations and also **do not provide any guarantee** that manually added translation won’t be overwritten after plugin update.

More information you can find in the [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/notes-and-requirements/) on our demo site. 

== Installation ==

**Installation form WordPress.ORG**

1. Download a copy of the plugin;
2. Unzip and upload "wcp-openweather" to a sub directory in "/wp-content/plugins/";
3. Activate the plugins through the ‘Plugins’ menu in WordPress;
4. Click on "WCP Weather" in your WordPress Dashboard left side menu pane. Under "WCP Weather" section you can find "Settings" page where you are able to configure general plugin parameters including OpenWeatherMap API key and "Theme Settings" page where you are able to configure general parameters of active theme.


**Installation form WordPress Admin Panel**

1. Log into your WordPress Dashboard;
2. Go to "Plugins" > "Add New" and search for the plugin "WCP OpenWeather";
3. Click "Install" and then click on "Activate" to install and activate the plugin so you can use it;
4. Click on "WCP Weather" in your WordPress Dashboard left side menu pane. Under "WCP Weather" section you can find "Settings" page where you are able to configure general plugin parameters including OpenWeatherMap API key and "Theme Settings" page where you are able to configure general parameters of active theme.

More information you can find in the [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/getting-started/plugin-installation/) on our demo site.

WCP OpenWeather plugin supports variouse widgets and shordcodes based on [selected plugin theme](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/themes/).


== Frequently Asked Questions ==

> Please note, [ actual plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/getting-started/), [FAQ](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/faq/) and [plugin support](http://wpdemo.webcodin.com/stay-in-touch/) you can find on our demo site.

If you find issues or have any questions about the plugin, please feel free to ask questions:

* directly via [**support form**](http://wpdemo.webcodin.com/stay-in-touch/) on our demo site;
* directly via support email address **support@webcodin.com**;
* [**Support Tab**](https://wordpress.org/support/plugin/wcp-openweather) on WordPress.ORG.

You can find most popular users question to plugin support devided by groups from the plugin [**FAQ**](http://wpdemo.webcodin.com/wordpress-plugin-wcp-openweather/documentation/faq/) section below.

**General Questions**

*Common questions about WCP OpenWeather plugn*

* [How can I add current weather/forecast to a page?](http://wpdemo.webcodin.com/hrf_faq/how-can-i-add-current-weatherforecast-to-a-page/)
* [How can I add current weather/forecast to a sidebar?](http://wpdemo.webcodin.com/hrf_faq/how-can-i-add-current-weatherforecast-to-a-sidebar/)
* [Where can I change plugin theme?](http://wpdemo.webcodin.com/hrf_faq/where-can-i-change-plugin-theme/)
* [Where can I change active theme styling?](http://wpdemo.webcodin.com/hrf_faq/where-can-i-change-active-theme-styling/)
* [Where can I find default plugin options?](http://wpdemo.webcodin.com/hrf_faq/where-can-i-find-default-plugin-options/)
* [Where can I find default weather options?](http://wpdemo.webcodin.com/hrf_faq/where-can-i-find-default-weather-options/)

**OpenWeatherMap API**

*Questions related to issues with OpenWeatherMap API*

* [Where can I add OpenWeatherMap API key?](http://wpdemo.webcodin.com/hrf_faq/can-add-openweathermap-api-key/)
* [I have following notice "Please add free or paid OpenWeatherMap API key in the plugin settings!"](http://wpdemo.webcodin.com/hrf_faq/following-notice-please-add-free-paid-openweathermap-api-key-plugin-settings/) 

**Location**

*Questions that related to location*

* [How can I use automatic location detection?](http://wpdemo.webcodin.com/hrf_faq/can-use-automatic-location-detection/)

**Languages and plugin translation**

*Questions that related to plugin translation*

* [Where can I change plugin language?](http://wpdemo.webcodin.com/hrf_faq/where-can-i-change-plugin-language/)
* [How can I get multilingual city name?](http://wpdemo.webcodin.com/hrf_faq/can-get-multilingual-city-name/)
* [Why weather condition do not have translation to my language?](http://wpdemo.webcodin.com/hrf_faq/weather-condition-not-translation-language/) 
* [How can I add own translation to the plugin?](http://wpdemo.webcodin.com/hrf_faq/can-add-translation-plugin/)

**Other**

*Miscellaneous questions*

* [What should I do if I have an issue with Google Maps or other features from Google if your plugin is activated?](http://wpdemo.webcodin.com/hrf_faq/issue-google-maps-features-google-plugin-activated/) 
* [I have "Parse error: syntax error, unexpected T_STRING, expecting T_CONSTANT_ENCAPSED_STRING" after the plugin installation.](http://wpdemo.webcodin.com/hrf_faq/i-have-parse-error-syntax-error-unexpected-t_string-expecting-t_constant_encapsed_string-after-the-plugin-installation/) 
* [I have "Bad Request. Your browser sent a request that this server could not understand. Size of a request header field exceeds server limit. Cookie" error.](http://wpdemo.webcodin.com/hrf_faq/i-have-bad-request-your-browser-sent-a-request-that-this-server-could-not-understand-size-of-a-request-header-field-exceeds-server-limit-cookie-error/) 
* [How can I use shortcode with default configuration from plugin settings manually?](http://wpdemo.webcodin.com/hrf_faq/how-can-i-use-shortcode-with-default-configuration-from-plugin-settings-manually/)  



== Screenshots ==
1. Default Theme
2. Metro Theme
3. User Options Popup
4. TinyMCE actionbar Button
5. Default Theme Shordcode Generator
6. Metro Theme Shordcode Generator
7. Default Theme Widget 
8. Metro Theme Widget
9. Admin Panel :: Settings :: Weather Tab
10. Admin Panel :: Settings :: Plugin Tab
11. Admin Panel :: Settings :: API Tab
12. Admin Panel :: Default Theme Settings
13. Admin Panel :: Metro Theme Settings

== Changelog ==
= 2.5.0 =
* Fixed issue with displaying 5-day weather forecast for API-keys of new registered OpenWeathwerMap users
* Minor changes

= 2.4.1 =
* Added translation to the Danish (Denmark) language
* Compatibility up to WP 4.8

= 2.4.0 =
* Fixed issue with Google Map API
* Added new parameter for required Google API Key in admin panel
* Changed translations

= 2.3.0 =

> **NB! We've made a lot of changes in the plugin styles, templates and translation files. In case if you made plugin manual customization via plugin files and styles or manually add plugin translation, please make a backup of your customization to prevent files overwrite during plugin update. Also, we do not provide any garantee that your manual customization will work properly after plugin updates.**

* Compatibility up to WP 4.6
* Added translation to the Greek language
* Update admin panel UI/UX
* Gloabl changes in the plugin styles, templates and translation files 
* Cleanup and actualization of plugin documentation

= 2.2.3 =
* Added translation to the Persian language

= 2.2.2 =
* Added translation to the Catalan (Catalonia) language

= 2.2.1 =
* Added translation to the Spanish (Spain) language

= 2.2.0 = 
* Added translation to the Polish (Poland) language
* Added new "Compact" templates for the weather widgets and shortcodes in "Metro" theme
* Added the ability to determine the weather for the GeoIP coordinates. To use of this feature you need to left blank value for the "City" option in a shortcode constructor or a widget parameters.
* Minor changes for compatibility with WordPress 4.4

= 2.1.3 =
* Changed method of checking for minimum required PHP version on a server
* Changed method of checking for required cURL library on a server
* Added new "Enable Google Maps API" parameter to a "Plugin" tab of the plugin setting page in WP admin panel. This parameter allow enable/disable Google Maps API Autocomplete for the "City" field for more compatible with other plugins, which are include and use personal Google Map API library.
* Added translations for the new "Enable Google Maps API" parameter
* Minor changes

= 2.1.2 =
* Added translation to the Bulgarian (Bulgaria) language

= 2.1.1 =
* Minor changes

= 2.1.0 =
* Added : Check of the minimum required PHP version on a server
* Added : Check of the required cURL library on a server

= 2.0.9 =
* Updated plugin screenshots
* Code optimization
* Minor changes

= 2.0.8 =
* Added translation to the Croatian (Croatia) language

= 2.0.7 =
* Fixed issue with missing "WCP Weather" menu item in the WP admin panel

= 2.0.6 =
* Toolbar button fix for theme options of the "Enigma" theme

= 2.0.5 =
* Added translation to the Turkish (Turkey) language

= 2.0.4 =
* Added translation to the Italian (Italy) language

= 2.0.3 =
* Added translation to the Dutch (Nederland) language
* Added translation to the German (Germany) language
* Minor bugfixing    

= 2.0.2 =
* Minor bugfixing    

= 2.0.1 =
* Added translation to the Romanian (Romania) language

= 2.0.0 =
* Added new "Metro" theme for the plugin
* Added extended background and text customization
* Added personal background image in widgets and shortcodes
* Added new icons list for the weather conditions
* Added translation to the Slovenian (Slovenia) language
* Minor bugfix and styling cleanup for "Default" theme

= 1.2.8 =
* Added translation to the Portuguese (Portugal) language

= 1.2.7 =
* changed: Minor loading speed optimization

= 1.2.6 =
* Added fix for broken links of plugin assets for some specific site configurations

= 1.2.5 =
* Added translation to the Spanish(Ecuador) language

= 1.2.4 =
* Fixed trouble with incorrect commit to ugly WordPress SVN

= 1.2.3 = 
* Added filter hook 'wcp_get_settings' that allow to modify weather attributes for getting personal weather conditions
* Added AJAX user options submit functionality
* Code optimization
* Minor changes

= 1.2.2 =
* Added translation to the Lithuanian (Lithuania) language

= 1.2.1 =
* Minor bugfixing     

= 1.2.0 =
* Added translation to the Serbian (Serbia) language
* Added ability to use different templates in the weather widgets and shortcodes
* Added new "Compact" templates for the weather widgets and shortcodes
* Added ability to use "clouds" parameter in the templates
* Changed rule of displaying humidity value. At now "0%" value is displaying as "-"

= 1.1.9 =
* Corrections for Albanian language

= 1.1.8 =
* Fixed issue with the difference between current date of the plugin and current date of the website based on a "Timezone" parameter of the Wordpress

= 1.1.7 =
* Added translation to the Dutch (Belgium) language

= 1.1.6 =
* Added translations to the Albanian and French languages

= 1.1.5 =
* Fixed issue with the error "mysqli::mysqli(): (HY000/2005): Unknown MySQL server host"

= 1.1.4 =
* Changed: Removed "uniqueId" parameter from the shortcodes generator result

= 1.1.3 =
* Minor bugfixing

= 1.1.2 =
* Fixed the issue with the error "Bad Request. Your browser sent a request that this server could not understand. Size of a request header field exceeds server limit. Cookie"

= 1.1.1 =
* Minor bugfixing

= 1.1.0 =
* Added: multilanguage support
* Added: visual shortcode generator for TinyMCE editor
* Added: additional parameters of the plugin settings
* Changed: display rules for some visual elements
* Minor changes in the style of the default theme
* Minor changes of the plugin core
* Documentation update

= 1.0.1 =
* Changed: layout of the "Settings" page
* Added: link to live demo site in description of the plugin
* Minor changes of the plugin core

= 1.0.0 =
* Initial release.
