=== Flexible Captcha ===
Contributors: foomagoo
Donate link: http://www.jsterup.com/donate/
Tags: Flexible Captcha
Requires at least: 3.1
Tested up to: 4.0.1
Stable tag: 2.0.2

This plugin allows you to create image captcha for any form.  
It has a shortcode that can be placed on any page and a simple function call that will validate the captcha for you if you are using a custom form.  It can automatically be included on the comment, registration, and log in forms.
It includes an interface to set the colors of the font and background gradient for the rendered images.  You can set whether the captcha will be case sensitive or not.  You can also upload font files to change the font used in the images.

== Description ==

This plugin allows you to create image captcha for any form.  
It has a shortcode that can be placed on any page and a simple function call that will validate the captcha for you if you are using a custom form.  It can automatically be included on the comment, registration, and log in forms.
It includes an interface to set the colors of the font and background gradient for the rendered images.  You can set whether the captcha will be case sensitive or not.  You can also upload font files to change the font used in the images.

== Installation ==

1. Extract the downloaded Zip file.
2. Upload the 'flexible-captcha' directory to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to the <a href="http://www.jsterup.com/dev/wordpress/plugins/flexible-captcha/documentation">documentation page</a> to see ways to use the captcha.

NOTE:  The GD library with FreeType support enabled is required to run this plugin.

== Frequently Asked Questions ==

Q. What is the shortcode to add captcha to a page?

A. [FC_captcha_fields]


Q. I have installed the plugin and set it up why arent the images appearing on my form?

A. You need to have the GD library with FreeType support enabled.


Q. I have set up a custom form and added the shortcode to it and the captcha image appears.  When I submit the form why isnt the captcha required?

A. You need to handle the form submission.  Its up to you to figure out how to do that.  Go to http://www.jsterup.com/dev/wordpress/plugins/flexible-captcha/documentation for an example of how to do this with a form created with the contact form 7 plugin.

== Screenshots ==

1. Plugin admin page example.
2. Contact Form 7 Form Example.
3. Comment Form Example.
4. Admin login Page Example.

== Changelog ==

= 2.0.2 =
Removed duplicate single quotes around strings in sql queries.

= 2.0.1 =
Fixed activation problem on multi site installs.

= 2.0 =
Added abaility to add multiple colors for fonts and background.
Added new background type random shapes
Fixed a bug where captcha was not appearing for logged in users.

= 1.2 =
Moved the settings page under the settings item in the admin menu.
Added error message to the settings page if the GD library is not installed.

= 1.1 =
Fixed a bug that wouldn't allow multiple captchas on the same page.
Fixed the captcha purge to ensure the same timezone is used as the insert.

= 1.0 =
Added captcha to login and registration forms
Fixed a problem if font files were missing.  will now restore the default fonts.
Streamlined the admin page.

= 0.4 =
Fixed problem with replying to comments on the dashboard.  0.3 didnt work with replying from the page or post edit screens.

= 0.3 =
Fixed problem with replying to comments on the dashboard.
Removed PHP notice when checking for captcha request.

= 0.2 =
Changed hook to place field on comment form to after fields.
Changed ajax loader image.
Modified javascript to regenerate captcha image.  Added ajax loader image.

= 0.1 =
Initial version.

== Upgrade Notice ==

= 2.0.2 =
Removed duplicate single quotes around strings in sql queries.