=== Seraphinite Alternative Slugs Manager ===
Contributors: seraphinitesoft
Donate link: https://www.s-sols.com/products/wordpress/old-slugs-mgr#offer
Tags: old slug,alternative slugs,slug,editor,manager
Requires PHP: 5.4
Requires at least: 4.5
Tested up to: 6.4
Stable tag: 1.4
License: GPLv2 or later (if another license is not provided)
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Privacy policy: https://www.s-sols.com/privacy-policy

Avoid URL redirection errors by managing old and alternative slugs to improve SEO.

== Description ==

Avoid URL redirection errors by managing old and alternative slugs to improve SEO. Allows to edit, delete and add new slugs to posts. See more [how to use it](https://www.s-sols.com/docs/wordpress/old-slugs-mgr/getting-started-osm).

**Features**

*	**All post types support**
	Particular post types can be chosen in the [settings](https://www.s-sols.com/docs/wordpress/old-slugs-mgr/getting-started-osm#settings) including media.
*	**Old slugs**
	Viewing and correction.
*	**Alternative slugs**
	Full managing.

**Premium features**

*	**No promotions**
	No promotions of other related plugins.
*	**Support**
	Personal prioritized [support](https://www.s-sols.com/support)

[More details](https://www.s-sols.com/products/wordpress/old-slugs-mgr).

**Requirements**

*	[WordPress](https://wordpress.org/download) 4.5 or higher.
*	PHP 5.4 or higher.
*	Browser (Google Chrome, Firefox, IE).

== Installation ==

1. Choose the plugin from the WordPress repository, or choose the plugin's archive file in 'Upload Plugin' section in WordPress 'Plugins\Add New', or upload and extract the plugin archive to the '/wp-content/plugins' directory manually.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. It will appear in the admin UI as shown in the [screenshots](http://wordpress.org/plugins/seraphinite-old-slugs-mgr/screenshots).

== Screenshots ==

1. Post slugs editor.
2. Settings.

== Changelog ==

= 1.4 =

Improvements:

* Alternative searching.
* Auto-renaming (while activation or upgrading from Base version) plugin's directory to appended by '-ext' to avoid external wrong overwriting by Base version.
* CSRF checking while settings saving, resetting and importing.
* Changing text 'Already done' to 'Dismiss' in review notification.
* Decreasing CPU using while asynchronous tasks execution.
* Direct link to a new plugin version in plugins list.
* Direct link to download full version in upgrade message.
* Forced overwriting temp files if the existed one is a directory.
* License activation and upgrade to full version.
* License block in base plugin version.
* Limiting log files to 2 MB size  and maximum 50 count.
* On all notifications that requires confirming the close 'X' button was removed.
* Plugin's custom directory name support.
* Settings restoring confirmation.

Fixes:

* 'Upgrade to base plugin version is not supported' error on some hostings.
* Admin Interface: Elements' widths are broken if other plugins use the CSS class name "block".
* Ajax requests could be blocked by another plugins.
* Can't update plugin from file if its directory is renamed.
* Decrypting is not working after changing salts.
* Localization is unavailable when Translate Press plugin is used.
* Plugin's scripts and styles are loaded incorrectly if WP plugins directory is not under WP root directory.
* Possible warning while theme customization about 'cannot modify header information'.
* Restoring and importing settings without privileges.
* Sometimes Ext, Full versions are updated to Base version.
* Sometimes error appears about call to undefined function 'get_plugins'.

= 1.3 =

Improvements:

* If EULA is not accepted then showing minimal UI.
* Import/export of settings.
* Input-output security improvements.
* Minimum WordPress version is 4.5.
* Options: Multisite support.
* Premium update.
* The support button now opens the site page instead of the email client.
* Upgrading from free version to full.

Fixes:

* Admin scripts.
* Localization is not reloaded on 'change_locale' event.
* Mismatched version is always shown as new.
* Sometimes Ext, Full versions are updated to Base version.
* The activation panel is not visible if the server is unavailable.
* Unable to upgrade Extended and Premium version.
* Update terminates due to timeout on some hosting.
* Updating to full version is not always working.

= 1.2.1 =

Improvements:

* Russian localization correction.
* Upgrading to preview version trough downloading.

= 1.2 =

New features:

* Polylang plugin support.

Improvements:

* Backup previous settings structure.
* Making backups when change .htaccess.
* Not meeting minimum requirements notifications.
* Reset settings.
* Security: sanitizing input parameters.

Fixes:

* 'Key' buttons might have background on some themes.
* Compatibility issues with Polylang plugin.
* Frontend plugin queries are not valid for some sites.
* License block is invisible just after installation if remote configuration is unavailable.
* Output on some sites might be broken.
* PHP 8: Fatal error on plugin initialization (call_user_func).
* PHP Compatibility Checker by WPEngine detects issues with PHP 7.3.
* Settings: 'Save changes' button is always in English.

= 1.1.1 =

Improvements:

* Behavior changes notification warning.
* Checkboxes inner select links are now in Combo style.
* Download Preview and Full bundles by current version.
* List items operations animation.
* Storing settings in JSON format to ensure import/export of data.

Fixes:

* "Key" link after "Order" button is invalid.
* Block editor: If save more one time the new slug is duplicated.
* Block's help button is shifted to right.
* Call to undefined function: wpml_element_type_filter.
* In rare cases admin UI is blocked.
* In the admin panel, the warning 'Undefined index' is shown, if DEBUG mode is enabled.
* Inline comboboxes too short in WP 5.3 or higher.
* Multiple appearing of Change Version warning.
* Numeric slugs are not updated.
* On some systems, script loading fails, resulting in a site loading error.
* Separator line is invisible under WordPress 5.2 or higher.
* Settings layout is too wide on some themes.
* Unable to upgrade Extended and Premium version.

= 1.1 =

Improvements:

* Attachments are supported.

Fixes:

* PHP 5.4 'empty' operator compatibility.

= 1.0.9 =

Fixes:

* Save settings result message is blocked by security plugins.

= 1.0.8 =

Improvements:

* Help and documentation.

Fixes:

* Localization.

= 1.0.7 =

Improvements:

* Localization - Russian.

Fixes:

* 'Delete' button icon.

