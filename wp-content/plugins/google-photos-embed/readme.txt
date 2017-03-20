=== Google Photos embed ===
Contributors: enomoto celtislab
Tags: Google Photos, embed, image
Requires at least: 4.0
Tested up to: 4.4
Stable tag: 0.9.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Using shared short URL of Google Photos, you can embed the image easy to blog.

== Description ==

You can easily embed the image use a shared URL of Google Photos. 


= Usage =

 * Open the google photo site (https://photos.google.com/)
 * Choose an embedded image you want to blog in Google Photos.
 * Click the Share button, you get a shareable link.
 * Copy the shared link (https://goo.gl/photos/xxxxxxx) and paste it into the blog content. 

= Notice =
 
 * Image URL is the unofficial way to get from OGP image. If the specification to share Google photo has been changed, there are times when it can not be used.


= Customize =

* It is displaying the OGP data as a caption.
* The size of the image, alignment, captions, etc. specified in the parameter.

General Parameter

 * width   : pixsels (width="400") 
 * height  : pixsels (height="400")
 * align   : alignnone / aliginleft / aligncenter / alignright (align="aligncenter")
 * caption : caption text. If the non-display caption="false" set. 
 * type    : gif (default jpg) If possible, displayed in a GIF animation format.

e.g. [embed width="320" height="150" align="alignright" type="gif" caption="xxxxxxx"]https://goo.gl/photos/xxxxxxx[/embed]


Special Parameter (picopt)

 * w  : width pixsels
 * h  : height pixsels
 * s  : long side pixsels
 * r  : rotete image 90/180/270
 * c  : Trimming from the center of the image
 * p  : Trimming centered on the person or the like in the image
 * no : Meybe. If possible, video->GIF animation conversion

e.g. [embed picopt="w320-h150-r90-p"]https://goo.gl/photos/xxxxxxx[/embed]

*※ Parameters of picopt is unofficial. (estimated from picasa image customization options)*


[日本語の説明](http://celtislab.net/wp_plugin_google_photos_embed/ "Documentation in Japanese")


== Installation ==

1. Upload the `google-photos-embed` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress


== Screenshots ==

1. Get Google Photos share url. Copy & Paste embed.


== Changelog ==

= 0.9.1 =
* 2015-12-24
* Add a link to the Google photos page in the image.
* If possible, add the option type = "gif" to embed the video in GIF animation format.

= 0.9.0 =
* 2015-11-06  Release
 