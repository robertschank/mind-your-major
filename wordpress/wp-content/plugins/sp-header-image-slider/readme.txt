=== WP Header image slider and carousel ===
Contributors: wponlinesupport, anoopranawat
Tags: image slider, header image slider, captions, image slider with captions  banner slider, header banner slider, slideshow, custom post type, header image slideshow
Requires at least: 3.1
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A quick, easy way to add an Header image slider with captions OR image slider with captions inside wordpress page.

== Description ==
This plugin add a Header image slider with captions in your website.

Check [DEMO](http://wponlinesupport.com/wp-plugin/wp-header-image-slider-carousel/) for additional information.

Check [PRO DEMO and Features ](http://wponlinesupport.com/wp-plugin/wp-header-image-slider-carousel/) to know more.

Download our all [FREE 34 WordPress Plugins](https://www.wponlinesupport.com/wp-online-support-all-free-34-plugins/?utm_source=wp&event=fd).

The plugin adds a "Header image slider" tab to your admin menu, which allows you to enter Image Title, link and image items just as you would regular posts.

= WP Header image slider contains 3 shortcodes =

* Image slideshow with captions/without captions 
<code>[sp_imageslider]</code>

* Image Carousel
<code>[sp_imagecarousel]</code>

* Thumbnail pager
<code>[sp_imagethumbnail_pager]</code>

To use this plugin just copy and past this code in to your header.php file or template file 
<code><?php echo do_shortcode('[sp_imageslider'); ?></code>


= Features include: =
* Php code to place image slider into your website header  
<code><?php echo do_shortcode('[sp_imageslider limit="-1"]'); ?> </code>
* Shortcode parameter for each shortcode
* Fully responsive - will adapt to any device
* Horizontal, vertical, and fade modes
* Advanced touch / swipe support built-in
* Uses CSS transitions for slide animation (native hardware acceleration!)
* Browser support: Firefox, Chrome, Safari, iOS, Android, IE7+
* Easy to configure
* Smoothly integrates into any theme
* CSS and JS file for custmization

= Sortcode parameters =

<code>[sp_imagecarousel] and [sp_imagethumbnail_pager]</code>

* **Limit** : [sp_imageslider limit="10"] and [sp_imagethumbnail_pager limit="10"](Limit number of slides. By default it display all latest slide with shortcode ).
* **Effect** : [sp_imageslider effect="fade"] and [sp_imagethumbnail_pager effect="fade"]  (Choose Slider effect. You can use 'fade', 'horizontal', 'vertical').
* **Captions**: [sp_imageslider captions="true"] and [sp_imagethumbnail_pager captions="true"](Display title on image in slider. Values are "true OR false" ).
* **Autoplay** : [sp_imageslider autoplay="true" ] and [sp_imagethumbnail_pager autoplay="true" ](Start Slider automatically. Values are "true OR false").
* **Autoplay Interval** : [sp_imageslider autoplay_interval="3000" ] and [sp_imagethumbnail_pager autoplay_interval="3000" ](Control time interval between two slide.).
* **Speed** : [sp_imageslider speed="2000"] and [sp_imagethumbnail_pager speed="2000"](Control Slider Speed).
* **Auto Controls** : [sp_imageslider auto_controls="true" ] and [sp_imagethumbnail_pager auto_controls="true" ]  (Display Slider Controls).
* **Infinite**: [sp_imageslider loop="true"] and [sp_imagethumbnail_pager loop="true"]  (Run Slider Contineously).
* **Start Slide** : [sp_imageslider start_slide="1"] and [sp_imagethumbnail_pager start_slide="1"] ( Slider Starts with given number Slide. Take 0 for first slide.)
* **Random Start**: [sp_imageslider random_start="true"] and [sp_imagethumbnail_pager random_start="true"](Start Slider with random number slide. Values are "true OR false")
* **Dots** :  [sp_imageslider dots="true" ] (Display dots on  slider. Values are "true OR false" )

= Sortcode parameters =

<code>[sp_imagecarousel]</code>

* **Limit** : [sp_imagecarousel limit="10"] (Limit number of slides. By default it display all latest slide with shortcode).
* **Autoplay** : [sp_imagecarousel autoplay="true" ] (Start Slider automatically. Values are "true OR false").
* **Autoplay Interval** : [sp_imagecarousel autoplay_interval="3000" ](Control time interval between two slide.).
* **slide_width** : [sp_imagecarousel slide_width="200"] (Set slider width).
* **min_slides**: [sp_imagecarousel min_slides="2"] (The minimum number of slides to be shown. Slides will be sized down if carousel becomes smaller than the original size. ).
* **max_slides** : [sp_imagecarousel max_slides="2" ] (The maximum number of slides to be shown. Slides will be sized up if carousel becomes larger than the original size.).
* **Speed** : [sp_imagecarousel speed="2000"] (Control Slider Speed: Slide transition duration (in ms)).
* **slide_margin** : [sp_imagecarousel slide_margin="10" ] (Margin between each slide).
* **Dots** :  [sp_imagecarousel dots="true" ] (Display dots on  slider. Values are "true OR false" )

= PRO Features Added : =
> <strong>Premium Version</strong><br>
>
> * WP header image slider is replaced with WP Slick Slider and Carousel
> * Added 16 Pro designs
> * 10 Image Slider Designs
> * 6 Image Carousel Slider
> * Display content with image and link in Carousel mode   
> * Simple & Easy to Use
>
> Check [PRO DEMO and Features](http://wponlinesupport.com/wp-plugin/wp-header-image-slider-carousel/) to know more.
>



== Installation ==

1. Upload the 'sp-header-image-slider' folder to the '/wp-content/plugins/' directory.
2. Activate the 'SP Header image slider' list plugin through the 'Plugins' menu in WordPress.
3. If you want to place image slider into your website header, please copy and paste following code in to your header.php file  <code><div class="headerslider"> <?php echo do_shortcode('[sp_imageslider limit="-1"]'); ?></div></code>
4. You can also display this Image slider inside your page with following shortcode <code>[sp_imageslider limit="-1"] </code>


== Screenshots ==

1. Image slideshow with captions
2. Image slideshow with carousel
3. Thumbnail pager
4. All

== Changelog ==

= 1.3 =
* [+] Added **dots** new shortcode paramneter to show/hide pagination/dots
* [+] Added **autoplay**, **autoplay_interval**, **dots** to the shortcode [sp_imagecarousel]

= 1.2 =
* Added 'How it Works' page for better user interface.
* Removed 'Design' page.

= 1.1 =
* Fixed so many bugs
* Added 3 shortcode with parameters
* Responsive
* Added mata box for external link

= 1.0 =
* Initial release.


== Upgrade Notice ==

= 1.3 =
* [+] Added **dots** new shortcode paramneter to show/hide pagination/dots
* [+] Added **autoplay**, **autoplay_interval**, **dots** to the shortcode [sp_imagecarousel]

= 1.2 =
* Added 'How it Works' page for better user interface.
* Removed 'Design' page.

= 1.1 =
* Fixed so many bugs
* Added 3 shortcode with parameters
* Responsive
* Added mata box for external link

= 1.0 =
Initial release.