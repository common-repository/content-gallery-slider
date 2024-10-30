=== Content Gallery Slider ===
Contributors: Module Express
Donate link: http://beautiful-module.com/
Tags: responsive Content Gallery Slider,Content Gallery Slider,mobile touch Content Gallery Slider,image slider,responsive footer gallery slider,responsive banner slider,responsive footer banner slider,footer banner slider,responsive slideshow,footer image slideshow
Requires at least: 3.5
Tested up to: 4.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A quick, easy way to add an Responsive footer Image Gallery Vertical OR Responsive Content Gallery Slider inside wordpress page OR Template. Also mobile touch Content Gallery Slider

== Description ==

This plugin add a Responsive Content Gallery Slider in your website. Also you can add Responsive Content Gallery Slider page and mobile touch slider in to your wordpress website.

View [DEMO](http://beautiful-module.com/demo/content-gallery-slider/) for additional information.

= Installation help and support =

The plugin adds a "Responsive Content Gallery Slider" tab to your admin menu, which allows you to enter Image Title, Content, Link and image items just as you would regular posts.

To use this plugin just copy and past this code in to your footer.php file or template file 
<code><div class="headerslider">
 <?php echo do_shortcode('[sp_content.gallery]'); ?>
 </div></code>

You can also use this Content Gallery Slider inside your page with following shortcode 
<code>[sp_content.gallery] </code>

Display Content Gallery Slider catagroies wise :
<code>[sp_content.gallery cat_id="cat_id"]</code>
You can find this under  "Content Gallery Slider-> Gallery Category".

= Complete shortcode is =
<code>[sp_content.gallery cat_id="9" rows="2" columns="2" space="20" autoplay_interval="3000"]</code>
 
Parameters are :

* **limit** : [sp_content.gallery limit="-1"] (Limit define the number of images to be display at a time. By default set to "-1" ie all images. eg. if you want to display only 5 images then set limit to limit="5")
* **cat_id** : [sp_content.gallery cat_id="2"] (Display Image slider catagroies wise.) 
* **rows** : [sp_content.gallery rows="2"] (Set number of rows.)
* **columns** : [sp_content.gallery columns="2"] (Set number of columns.)
* **space** : [sp_content.gallery space="20"] (Set space between items.)
* **width** : [sp_content.gallery width="500"] (Set width of slider by pixel or percentage.)
* **autoplay_interval** : [sp_content.gallery autoplay="true" autoplay_interval="3000"] (Set autoplay interval)

= Features include: =
* Mobile touch slide
* Responsive
* Shortcode <code>[sp_content.gallery]</code>
* Php code for place image slider into your website footer  <code><div class="headerslider"> <?php echo do_shortcode('[sp_content.gallery]'); ?></div></code>
* Content Gallery Slider inside your page with following shortcode <code>[sp_content.gallery] </code>
* Easy to configure
* Smoothly integrates into any theme
* CSS and JS file for custmization

== Installation ==

1. Upload the 'content-gallery-slider' folder to the '/wp-content/plugins/' directory.
2. Activate the 'Content Gallery Slider' list plugin through the 'Plugins' menu in WordPress.
3. If you want to place Content Gallery Slider into your website footer, please copy and paste following code in to your footer.php file  <code><div class="headerslider"> <?php echo do_shortcode('[sp_content.gallery limit="-1"]'); ?></div></code>
4. You can also display this Images slider inside your page with following shortcode <code>[sp_content.gallery limit="-1"] </code>


== Frequently Asked Questions ==

= Are there shortcodes for Content Gallery Slider items? =

If you want to place Content Gallery Slider into your website footer, please copy and paste following code in to your footer.php file  <code><div class="headerslider"> <?php echo do_shortcode('[sp_content.gallery limit="-1"]'); ?></div>  </code>

You can also display this Content Gallery Slider inside your page with following shortcode <code>[sp_content.gallery limit="-1"] </code>



== Screenshots ==
1. Designs Views from admin side
2. Catagroies shortcode

== Changelog ==

= 1.0 =
Initial release