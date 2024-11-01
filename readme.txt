=== ZigWidgetClass ===
Contributors: ZigPress
Donate link: https://www.zigpress.com/donations/
Tags: widgets, widget, widget instance, custom class, classes, css, widget logic, widget context, display widgets, wp page widgets, zig, zigpress, classicpress
Requires at least: 4.0
Tested up to: 5.4
Requires PHP: 5.3
Stable tag: 1.0

Lets you add a custom CSS class to each widget instance.

== Description ==

**Due to abuse received from plugin repository users we are ceasing development of free WordPress plugins and this is the last release of this plugin. It will be removed from the repository in due course. Our pro-bono plugin development will now be exclusively for the ClassicPress platform.**

ZigWidgetClass adds a free text field to each widget control form on your widget admin page. Enter a CSS class name in the box and it will be added to the classes that WordPress applies to that widget instance. To add multiple classes, simply separate them with a space.

It has been tested and verified to work with the Widget Logic plugin, the Widget Context plugin, the WP Page Widget plugin and the Display Widgets plugin. If you have problems getting it to work with one of those plugins, make sure you are using the latest version(s).

It only works with widgets that were created by properly using WordPress's Widgets API. If it appears not to work on a certain widget, that widget probably breaks the API rules somehow.

Also, if you have trouble getting it to work with the WP Page Widget plugin, you should create and save each page widget first, before adding the CSS class, then save again.

Requires WordPress 4.0+ and PHP 5.3+. 

Compatible with ClassicPress.

For further information and support, please visit [the ZigWidgetClass home page](https://www.zigpress.com/plugins/zigwidgetclass/).

== Installation ==

1. Unzip the installer and upload the resulting 'zigwidgetclass' folder into the `/wp-content/plugins/` directory.  Alternatively, go to Admin > Plugins > Add New and enter ZigWidgetClass in the search box.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

For further information and support, please visit [the ZigWidgetClass home page](https://www.zigpress.com/plugins/zigwidgetclass/).

== Changelog ==

= 1.0 =
* Notice of cessation of free WordPress plugin development
= 0.9.2 =
* Verified compatibility with WordPress 5.3.x
* Verified compatibility with ClassicPress 1.1.x
= 0.9.1 =
* Verified compatibility with WordPress 5.2.x
* Verified compatibility with ClassicPress 1.0.x
= 0.9 =
* Verified compatibility with WordPress 4.9.8
* Verified compatibility with ClassicPress 1.0.0-beta1
= 0.8.3 =
* Confirmed compatibility with WordPress 4.9.7
= 0.8.2 =
* Confirmed compatibility with WordPress 4.9
= 0.8.1 =
* Confirmed compatibility with WordPress 4.8.x
= 0.8 =
* Confirmed compatibility with WordPress 4.8
* Better way of obtaining plugin folder URL
* Smoother self-deactivation if PHP and core version requirements not met
* Admin screen content and link updates
= 0.7.8 =
* Confirmed compatibility with WordPress 4.7
= 0.7.7 =
* Confirmed compatibility with WordPress 4.6.1
= 0.7.6 =
* Confirmed compatibility with WordPress 4.5.3
= 0.7.5 =
* Confirmed compatibility with WordPress 4.4
* Increased minimum WordPress version to 4.0 in accordance with ZigPress policy of gradually dropping support for deprecated platforms
= 0.7.4 =
* Confirmed compatibility with WordPress 4.3
= 0.7.3 =
* Confirmed compatibility with WordPress 4.2
* Increased minimum PHP version to 5.3 in accordance with ZigPress policy of gradually dropping support for deprecated platforms
= 0.7.2 =
* Confirmed compatibility with WordPress 4.1
= 0.7.1 =
* Added tiny credit link to widget control panel
* Input field label now reads 'CSS Classes' (instead of 'CSS Class'
* Tested successfully with the Display Widgets plugin
* Various documentation improvements (in this readme and on the plugin admin page)
= 0.7 =
* Confirmed compatibility with WordPress 4.0
* Added admin information page
= 0.6.2 =
* Confirmed compatibility with WordPress 3.9
* Confirmed continued compatibility with WP Page Widgets plugin
* Confirmed continued compatibility with Widget Logic plugin
* Confirmed continued compatibility with Widget Context plugin
= 0.6.1 =
* Confirmed compatibility with WordPress 3.8
* Confirmed continued compatibility with WP Page Widgets plugin
* Confirmed continued compatibility with Widget Logic plugin
* Confirmed continued compatibility with Widget Context plugin
* Increased minimum WordPress version to 3.6 in accordance with ZigPress policy of encouraging WordPress updates
= 0.6 =
* Now compatible with WP Page Widget plugin - thanks to Edwin Ricaurte for suggesting that it should be
* Confirmed continued compatibility with Widget Logic plugin
* Confirmed continued compatibility with Widget Context plugin
* Confirmed compatibility with WordPress 3.7.1
= 0.5 =
* Confirmed continued compatibility with Widget Logic plugin
* Tested and verified compatibility with Widget Context plugin
* Custom class box is now simply labelled "CSS Class"
* Confirmed compatibility with WordPress 3.5.2
* Set minimim WordPress version to 3.5
= 0.4.1 =
* Confirmed compatibility with WordPress 3.5
= 0.4 =
* Coding style improvements and refactoring
* Updated plugin URL
* Confirmed compatibility with WordPress 3.4.2
= 0.3.2 =
* Confirmed compatibility with WordPress 3.4.x
= 0.3.1 =
* Confirmed compatibility with WordPress 3.3.x
= 0.3 =
* Now does actually work in conjunction with Widget Logic (so much for earlier testing)
* Updated PHP version requirement in readiness for WordPress 3.2
* Updated WordPress version requirement as new code only tested on most recent versions
= 0.2 =
* Confirmed compatibility with WordPress 3.1.1
= 0.1 =
* First public release
