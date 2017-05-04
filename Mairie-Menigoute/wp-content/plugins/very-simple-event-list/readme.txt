=== Very Simple Event List ===
Contributors: Guido07111975
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=donation%40guidovanderleest%2enl
Version: 5.7
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 4.6
Tested up to: 4.6
Stable tag: trunk
Tags: simple, upcoming, past, current, event, list, manager, widget


This is a very simple plugin to display a list of events. Use a shortcode to display events on a page or use the widget.


== DESCRIPTION ==
= About =
This is a very simple plugin to display a list of events. 

* Use shortcode `[vsel]` to display upcoming events (including today)
* Use shortcode `[vsel-past-events]` to display past events
* Use shortcode `[vsel-current-events]` to display current events

You can also list events in your sidebar using the widget.

For more info please take a look at the Installation section.

= Question? = 
Please take a look at the Installation and FAQ section.

= Translation =
Not included but plugin supports WordPress language packs.

More [translations](https://translate.wordpress.org/projects/wp-plugins/very-simple-event-list) are very welcome!

= Credits =
Without the WordPress codex and help from the WordPress community I was not able to develop this plugin, so: thank you!

Enjoy!


== INSTALLATION == 
= How to use =
After installation go to Events and start adding your events.

* Use shortcode `[vsel]` to display upcoming events (including today)
* Use shortcode `[vsel-past-events]` to display past events
* Use shortcode `[vsel-current-events]` to display current events

= Widget =
You can also list events in your sidebar using the widget.

The pagination is hidden because it's not working properly in a widget. 

But you can set a link to a page with all events.

= Settingspage =
Via Settings > VSEL you can:

* Hide date
* Show a summary instead of all content
* Link title to the event page
* Hide elements in event list
* Keep events and settings when uninstalling plugin

= Shortcode attributes =
Events from certain categories: `[vsel event_cat="first-category, second-category"]`

You should enter the category slug (a slug is not always the same as category name).

Set amount of events per page: `[vsel posts_per_page=5]` 

This will overwrite amount set in Settings > Reading.

= Change labels =
* Change date label: `[vsel date_label="Event date: %s"]`
* Change start date label: `[vsel start_label="Event start date: %s"]`
* Change end date label: `[vsel end_label="Event end date: %s"]`
* Change time label: `[vsel time_label="Event time: %s"]` 
* Change location label: `[vsel location_label="Event location: %s"]` 
* Hide a label: `[vsel date_label="%s"]`

Multiple attributes: `[vsel posts_per_page=5 date_label="Event date: %s"]` 

= Widget attributes =
The widget supports the same attributes.

= Examples =
* Events from certain categories: `event_cat="first-category, second-category"`
* Set amount of events per page: `posts_per_page=5` 
* Change date label: `date_label="Event date: %s"`
* Hide a label: `date_label="%s"`
* Multiple attributes: `posts_per_page=5 date_label="Event date: %s"` 

= Single event =
Single event display is supported and template file single.php is used for that. It's located in your theme folder.

If you want to customize the single event display you can add a file called single-event.php in your theme folder.

= Event category page =
It will only display properly when using the shortcode on a page.

Example: `[vsel event_cat="first-category, second-category"]`

= Uninstall =
If you uninstall plugin via WP dashboard all events and settings are removed from database.

It deletes all posts with (custom) post type 'event'.

You can avoid this via Settings > VSEL.


== Frequently Asked Questions ==
= How can I change date format? =
You can set date format in WP dashboard via Settings > General.

The datepicker and date input field in backend accept 2 numeric date formats: day-month-year (30-01-2016) and year-month-day (2016-01-30).

If the date format set in WP dashboard is not numeric it will be changed into 1 of these 2 numeric date formats.  

= How do I set plugin language? =
Plugin uses the WP Dashboard language, set in Settings > General.

If plugin language pack is not available, language fallback will be English.

= How do I style the event list? =
You can change style (CSS) using for example the [Very Simple Custom Style](https://wordpress.org/plugins/very-simple-custom-style) plugin.

If you want to customize the single event display you can add a file called single-event.php in your theme folder.

= What do you mean with current events? =
Current events are events I can visit today. So this can be an one-day or multi-day event.

= Are events also listed on time? =
No, because input field for time is a regular text input this is not possible.
 
= How can I set number of events on a page? =
You can find more info about this at the Installation section.

= Can I display a summary instead of all content? =
You can find more info about this at the Installation section.

= Can I change the summary lenght? =
Yes, you can set a custom summary while adding an event. This will replace the default summary.

= Can I display certain events only? =
You can find more info about this at the Installation section.

= Is it possible to display events in a widget? =
You can find more info about this at the Installation section.

= Why is a single event not displayed properly? =
You can find more info about this at the Installation section.

= Why is the event category page not displayed properly? =
You can find more info about this at the Installation section.

= Can I hide the event labels? =
You can find more info about this at the Installation section.

= What do you mean with link and link label? =
It's a link to another page or website for more info. 

You can enter the full URL or without the http part (the http part will be auto added if not entered).

= Can I use multiple shortcodes on the same page? =
Yes, as far as I know there are no issues when using multiple shortcodes.

= Why an error message instead of a date? =
It's displayed in case start date begins after end date. To solve this please reset date.

= Why no start date in dashboard? =
Because I have added this feature in version 4.1.

All events posted before version 4.1 have 1 date only. But you can set a start and end date for each event afterwards.

= Why no event info, featured image, event categories while adding an event? =
If these boxes are not present, they might be unchecked in Screen Options. 

= Why a 404 (nothing found) when I click the title link? =
This is mostly caused by a wrong permalink setting. Please reset it via Settings > Permalinks. 

= How do I list events in a template file? =
For upcoming events: `<?php echo do_shortcode( '[vsel]' ); ?>` 

For past events: `<?php echo do_shortcode( '[vsel-past-events]' ); ?>`

For current events: `<?php echo do_shortcode( '[vsel-current-events]' ); ?>`

= What happens with my events when I uninstall VSEL? =
You can find more info about this at the Installation section.

= How can I make a donation? =
You like my plugin and you're willing to make a donation? Nice! There's a PayPal donate link on the WordPress plugin page and my website.

= Other question or comment? =
Please open a topic in plugin forum.


== Changelog ==
= Version 5.7 =
* file vsel-single: forgot to change class .vsel-info into .vsel-image-info

= Version 5.6 =
* hide image or event info in widget, instead of both simultaneously
* changed class .vsel-info into .vsel-image-info
* added class .vsel-info to event info
* updated shortcode files
* updated file vsel-options

= Version 5.5 =
* file vsel-widget: fixed php7 error (thanks nx3d)

= Version 5.4 =
* file vsel-upcoming: forgot to support multi-day events as well (thanks Tom)
* changed class .hide into .vsel-hide to avoid conflict with css in other stylesheets

For all versions please check file changelog.


== Screenshots == 
1. Very Simple Event List (Twenty Sixteen theme).
2. Very Simple Event List single event (Twenty Sixteen theme).
3. Very Simple Event List widget (Twenty Sixteen theme).
4. Very Simple Event List (dashboard).
5. Very Simple Event List single event (dashboard).
6. Very Simple Event List widget (dashboard).
7. Very Simple Event List settingspage (dashboard).