=== Table of Content Widget ===
Contributors: spencerfcloud
Donate link: spencercloud.com
Tags: widgets, table-of-contents, outline, long-form-content
Requires at least: 4.0
Tested up to: 5.0
Requires PHP: 7.0
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
 
An automatically generated table of contents for pages and posts that can be inserted into your theme's widget areas (works best in sidebars)
 
== Description ==
 
Automatically generate a table of contents for your pages and posts with longform content in the form of a widget.
The plugin automatically takes the headers of your post and puts them into usefully organized anchor links for your viewers to more easily navigate your content.
Choose whether to use them or restrict usage depending on post types.
Customize for themes with sticky headers (define the "scroll-to offset") so the header that is scrolled to is not hidden when the user clicks.
Define if you want the scrolling to be smooth or instantaneous by defining the time it takes to scroll to a header.
 
== Installation ==
 
1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to Appearance > Widgets in the WordPress Dashboard
1. Find "Table of Contents" in the list of widgets and select it
1. Select which widget area you would like the table of contents to appear (sidebars work best for this)
1. Enter a title for the widget, leave the default, or leave blank
1. If your theme uses a sticky header, enter a value under "Scroll-to Offset" to indicate how far to scroll when a user clicks a header in the widget
1. Enter a value for the "Smooth Scroll Time" option, leave the default, or enter "0" for instantaneous scroll (the value is in milliseconds, so 1000 milliseconds = 1 second)
1. Select which post types you would like to display the widget on - Posts and Pages are most common
1. Click "Save"