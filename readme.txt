=== Flexible Captcha ===
Contributors: foomagoo
Donate link: 
Tags: Flexible Captcha
Requires at least: 3.1
Tested up to: 3.5.1
Stable tag: 1.0

This plugin allows you to create image captcha for any form.  It can be placed on any page with a shortcode or automatically included on the comment and registration forms.  It includes an interface to set the colors of the font and background gradient for the rendered images.  You can set whether the captcha will be case sensitive or not.  You can also upload font files to change the font used in the images.

== Description ==

This plugin allows you to create image captcha for any form.  It can be placed on any page with a shortcode or automatically included on the comment and registration forms.  It includes an interface to set the colors of the font and background gradient for the rendered images.  You can set whether the captcha will be case sensitive or not.  You can also upload font files to change the font used in the images.

== Installation ==

1. Extract the downloaded Zip file.
2. Upload the 'flexible-captcha' directory to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to the <a href="http://www.jsterup.com/dev/wordpress/plugins/flexible-captcha/documentation">documentation page</a> to see ways to use the captcha.

== Frequently Asked Questions ==

Q. What is the shortcode to add captcha to a page?
A. [FC_captcha_fields]

== Screenshots ==

1. Plugin admin page example.
2. Contact Form 7 Form Example.
3. Comment Form Example.
4. Registartion Page Example.

== Changelog ==

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
