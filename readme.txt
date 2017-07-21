=== Enhanced Mediapicker ===
Contributors: codepress, tschutter, davidmosterd
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZDZRSYLQ4Z76J
Tags: mediapicker, attachments, items, medialibrary, grid, list, more, popup, rows, wordpress
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: 0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enhances the mediapicker with some nice features. It will add a grid-list view, the option to show more then 10 items and a preview.

== Description ==

This plugin will add some nice features to the mediapicker. It will seemlesly integrate with your mediapicker, and it will let you:

* Switch from List to Grid view
* The option to show more then 10 items!
* Display your uploads only
* Preview images without opening them

It will *display a large preview* of the media items by hovering over it.

Check out the <a href="http://wordpress.org/extend/plugins/enhanced-mediapicker/screenshots/">screenshots</a> for the results.

= User specific =

The preferences set for the mediapicker are saved to the user profile. So each user can set it's own personal viewing preferences.

== Installation ==

1. Upload enhanced-mediapicker to the /wp-content/plugins/ directory
2. Activate 'Enhanced Mediapicker' through the 'Plugins' menu in WordPress
3. That's it, no configuration needed! You will see the extra options appear in the top of your Mediapicker.

== Frequently Asked Questions ==

= Can I change the default value for the number of media items that are displayed? =

Yes, if you want to set a different default value for all users in your theme functions.php you can use:

`
<?php
add_filter('cp_mediapicker_limit', 'my_mediapicker_limit');
function my_mediapicker_limit () {
	return 20; // set your own number of items
}
?>
`

For individual users you can add the User ID to the filter name. In this example
we will change the default value for User with User ID = 3.

`
<?php
add_filter('cp_mediapicker_limit_3', 'my_mediapicker_limit');
function my_mediapicker_limit () {
	return 40; // set your own number of items
}
?>
`

== Screenshots ==

1. Mediapicker with Grid View
2. Mediapicker with List Preview
2. Mediapicker with Grid Preview

== Changelog ==

= 0.2 =

* fixed preview dimensions for small thumbnails

= 0.1 =

* Initial release.