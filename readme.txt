=== Social Menu Icons ===
Contributors: ronalfy
Tags: social menu icons, social menu widget, social icons, social media icons
Requires at least:4.7
Tested up to: 4.9
Stable tag: 1.0.0
Requires PHP: 5.6
Donate link: https://mediaron.com/give/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Social Menu Icons allows you to use the built-in WordPress menu system to create social menus should your theme not support it.

== Description ==

Social Menu Icons allows you to use the built-in WordPress menu system to create social menus should your theme not support it.

This plugin uses <a href="https://github.com/Automattic/social-logos">Social Logos</a> by <a href="https://github.com/Automattic">Automattic</a>.

AFeatures:

You can adjust the:
* Icon size
* Icon color (using pre-configured colors or selecting a custom one)
* Layout

https://www.youtube.com/watch?v=LBCjN9qLQ_M?rel=0

== Installation ==

1. Create the menu
2. Add social sharing options
3. Display on your sidebar or use the snippet below.

`
wp_nav_menu( 
	array( 
		'theme_location' => 'smi-social',
	)
);
`

Where `smi-social` is the slug for the new social menu. 

== Frequently Asked Questions ==

= Why Would I Need This =

If your theme doesn't support custom social networking, this is the perfect plugin for you.

= My Theme Already Has a Social Menu - Do I need this? =

Probably not, but the customizer settings make this plugin gold.

== Screenshots ==

1. Adjust the customizer settings
2. Social Menu Icons Output

== Changelog ==

= 1.0.0 =
* Released 2018-09-20
* Initial release. 

== Upgrade Notice ==

= 1.0.0 =
Initial release.