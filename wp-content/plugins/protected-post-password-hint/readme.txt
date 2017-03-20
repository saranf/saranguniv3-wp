=== Protected Post Password Hint ===
Contributors: abelcheung
Tags: post,posts,protected post,password,password form,password hint
Requires at least: 2.7
Tested up to: 3.4
Stable tag: RELEASE-2-0-2
License: BSD

Replace boiler-plate password form shown in protected posts with a form containing hints taken from 'password_hint' custom field.

== Description ==

Traditionally all password protected posts contain a boiler-plate password form without any hints. Without any capability to change the string, one must provide the hint in another post, which is a bit clumsy. Not to mention, people viewing the single protected post only will be unable to see the hint at all. With this plugin protected posts are more usable.

The password hint is taken from a certain custom field within the protected post, with key name ‘password_hint’. If this key is present, the value of key is immediately taken as the password hint. Without the key, the standard password form is shown again.

== Installation ==

= New install =
1. Decompress zip file.
2. Copy protected-post-password-hint.php to plugin subfolder (usually wp-content/plugins/).
3. Activate plugin in WordPress admin page. No configuration needed.

= Upgrade =
1. Deactivate the plugin in WordPress admin page.
2. Remove the plugin file.
3. Upload new plugin and activate again.

(I usually just replace the file without deactivating the plugin. But this is not official, you know the deal :-)

== Frequently Asked Questions ==

= How to use it? =

Note that the custom field is hidden by default for Wordpress 3.x and need to be manually enabled from Screen Options pulldown menu on top right corner while writing posts.

Under post writing page, add a custom field with key name 'password_hint'. The value will be taken as the hint shown on top of password form.

= I have problem not described here. =

[Don't hesitate to write email to me](http://me.abelcheung.org/aboutme/) .

== Screenshots ==
http://me.abelcheung.org/devel/protected-post-password-hint/

== Changelog ==

= 2.0.2 =
* Fix serious typo error that caused PHP fatal error.

= 2.0.1 =
* Add compatibility for WP >= 2.7.

= 2.0 =
* Rewritten to adopt change in WP 3.4 (removal of wp-pass.php).

== Upgrade Notice ==

= 2.0.2 =
2.0.1 doesn't work at all (PHP fatal error)

= 2.0.1 =
This is a rewritten version that works on WP 2.7-3.4. Don't use version 2.0 of this plugin since it **only** works on WP 3.4.

