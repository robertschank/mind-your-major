<?php

/**
 * Plugin Name: Slider WD
 * Plugin URI: https://web-dorado.com/products/wordpress-slider-plugin.html
 * Description: This is a responsive plugin, which allows adding sliders to your posts/pages and to custom location. It uses large number of transition effects and supports various types of layers.
 * Version: 1.1.85
 * Author: WebDorado
 * Author URI: https://web-dorado.com/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

define('WD_S_NAME', plugin_basename(dirname(__FILE__))); 
define('WD_S_DIR', WP_PLUGIN_DIR . "/" . WD_S_NAME);
define('WD_S_URL', plugins_url(WD_S_NAME));

define('WD_S_VERSION', '1.1.85');

function wds_use_home_url() {
  $home_url = str_replace("http://", "", home_url());
  $home_url = str_replace("https://", "", $home_url);
  $pos = strpos($home_url, "/");
  if ($pos) {
    $home_url = substr($home_url, 0, $pos);
  }
  $site_url = str_replace("http://", "", WD_S_URL);
  $site_url = str_replace("https://", "", $site_url);
  $pos = strpos($site_url, "/");
  if ($pos) {
    $site_url = substr($site_url, 0, $pos);
  }
  return $site_url != $home_url;
}

if (wds_use_home_url()) {
  define('WD_S_FRONT_URL', home_url("wp-content/plugins/" . plugin_basename(dirname(__FILE__))));
}
else {
  define('WD_S_FRONT_URL', WD_S_URL);
}

$upload_dir = wp_upload_dir();
$WD_S_UPLOAD_DIR = str_replace(ABSPATH, '', $upload_dir['basedir']) . '/slider-wd';

// Plugin menu.
function wds_options_panel() {
  $parent_slug = null;
  if( get_option( "wds_subscribe_done" ) == 1 ) {
    add_menu_page( __('Slider WD', 'wds'), __('Slider WD', 'wds'), 'manage_options', 'sliders_wds', 'wd_sliders', WD_S_URL . '/images/wd_slider.png');
    $parent_slug = "sliders_wds";
  }
  $sliders_page = add_submenu_page($parent_slug, __('Sliders', 'wds'), __('Sliders', 'wds'), 'manage_options', 'sliders_wds', 'wd_sliders');
  add_action('admin_print_styles-' . $sliders_page, 'wds_styles');
  add_action('admin_print_scripts-' . $sliders_page, 'wds_scripts');

  $global_options_page = add_submenu_page($parent_slug, __('Global Options', 'wds'), __('Global Options', 'wds'), 'manage_options', 'goptions_wds', 'wd_sliders');
  add_action('admin_print_styles-' . $global_options_page, 'wds_styles');
  add_action('admin_print_scripts-' . $global_options_page, 'wds_scripts');

  add_submenu_page($parent_slug, __('Get Pro', 'wds'), __('Get Pro', 'wds'), 'manage_options', 'licensing_wds', 'wds_licensing');

  add_submenu_page($parent_slug, __('Demo Sliders', 'wds'), __('Demo Sliders', 'wds'), 'manage_options', 'demo_sliders_wds', 'wds_demo_sliders');

  $uninstall_page = add_submenu_page($parent_slug, __('Uninstall', 'wds'), __('Uninstall', 'wds'), 'manage_options', 'uninstall_wds', 'wd_sliders');
  add_action('admin_print_styles-' . $uninstall_page, 'wds_styles');
  add_action('admin_print_scripts-' . $uninstall_page, 'wds_scripts');
}
add_action('admin_menu', 'wds_options_panel');

function wd_sliders() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('page');
  if (($page != '') && (($page == 'sliders_wds') || ($page == 'uninstall_wds') || ($page == 'WDSShortcode') || ($page == 'goptions_wds'))) {
    require_once(WD_S_DIR . '/admin/controllers/WDSController' . (($page == 'WDSShortcode') ? $page : ucfirst(strtolower($page))) . '.php');
    $controller_class = 'WDSController' . ucfirst(strtolower($page));
    $controller = new $controller_class();
    $controller->execute();
  }
}

function wds_licensing() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  wp_register_style('wds_licensing', WD_S_URL . '/licensing/style.css', array(), WD_S_VERSION);
  wp_print_styles('wds_licensing');
  require_once(WD_S_DIR . '/licensing/licensing.php');
}

function wds_demo_sliders() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_S_DIR . '/demo_sliders/demo_sliders.php');
  wp_register_style('wds_demo_sliders', WD_S_URL . '/demo_sliders/style.css', array(), WD_S_VERSION);
  wp_print_styles('wds_demo_sliders');
  spider_demo_sliders();
}

function wds_frontend() {
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('action');
  if (($page != '') && ($page == 'WDSShare')) {
    require_once(WD_S_DIR . '/frontend/controllers/WDSController' . ucfirst($page) . '.php');
    $controller_class = 'WDSController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}

add_action('wp_ajax_WDSPreview', 'wds_preview');

function wds_ajax() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('action');
  if ($page != '' && (($page == 'WDSShortcode'))) {
    require_once(WD_S_DIR . '/admin/controllers/WDSController' . ucfirst($page) . '.php');
    $controller_class = 'WDSController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}

function wds_shortcode($params) {
  $params = shortcode_atts(array('id' => 0), $params);
  ob_start();
  wds_front_end($params['id']);
  if ( is_admin() ) {
    // return ob_get_clean();
  }
  else {
    return str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean());
    // return ob_get_clean();
  }
}
add_shortcode('wds', 'wds_shortcode');

function wd_slider($id) {
  echo wds_front_end($id);
}

$wds = 0;
function wds_front_end($id, $from_shortcode = 1) {
  require_once(WD_S_DIR . '/frontend/controllers/WDSControllerSlider.php');
  $controller = new WDSControllerSlider();
  global $wds;
  $controller->execute($id, $from_shortcode, $wds);
  $wds++;
  return;
}

function wds_preview() {
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('action');
  if ($page != '' && $page == 'WDSPreview') {
    wp_print_scripts('jquery');
    wp_register_script('wds_jquery_mobile', WD_S_URL . '/js/jquery.mobile.js', array(), WD_S_VERSION);
    wp_print_scripts('wds_jquery_mobile');
    wp_register_style('wds_frontend', WD_S_URL . '/css/wds_frontend.css', array(), WD_S_VERSION);
    wp_print_styles('wds_frontend');
    wp_register_style('wds_effects', WD_S_URL . '/css/wds_effects.css', array(), WD_S_VERSION);
    wp_print_styles('wds_effects');
    wp_register_style('wds_font-awesome', WD_S_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
    wp_print_styles('wds_font-awesome');
    wp_register_script('wds_frontend', WD_S_URL . '/js/wds_frontend.js', array(), WD_S_VERSION);
    wp_print_scripts('wds_frontend');
    global $wpdb;
    $rows = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wdslayer ORDER BY `depth` ASC");
    $font_array = array();
    foreach ($rows as $row) {
      if (isset($row->google_fonts) && ($row->google_fonts == 1) && ($row->ffamily != "") && !in_array($row->ffamily, $font_array)) {
        $font_array[] = $row->ffamily;
      }
    }
    $query = implode("|", $font_array);
    if ($query != '') {
    ?>
      <link id="wds_googlefonts" media="all" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo $query . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic'; ?>" rel="stylesheet">
    <?php
    }
    $id =  WDW_S_Library::get('slider_id');
    ?>
    <div class="wds_preview_cont1">
      <div class="wds_preview_cont2">
        <?php
			wds_front_end($id, 0);
        ?>
      </div>
    </div>
    <?php
  }
  die();
}

function wds_media_button($context) {

  global $pagenow;
  if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php', 'admin-ajax.php'))) {
    $context .= '
      <a onclick="tb_click.call(this); wds_thickDims(); return false;" href="' . add_query_arg(array('action' => 'WDSShortcode', 'TB_iframe' => '1'), admin_url('admin-ajax.php')) . '" class="wds_thickbox button" style="padding-left: 0.4em;" title="Select slider">
        <span class="wp-media-buttons-icon wds_media_button_icon" style="vertical-align: text-bottom; background: url(' . WD_S_URL . '/images/wd_slider.png) no-repeat scroll left top rgba(0, 0, 0, 0);"></span>
        Add Slider WD
      </a>';
  }
  return $context;
}
  
add_filter('media_buttons_context', 'wds_media_button');

// Add the Slider button to editor.
add_action('wp_ajax_WDSShortcode', 'wds_ajax');

function wds_admin_ajax() {
  ?>
  <script>
    var wds_thickDims, wds_tbWidth, wds_tbHeight;
    wds_tbWidth = 400;
    wds_tbHeight = 200;
    wds_thickDims = function() {
      var tbWindow = jQuery('#TB_window'), H = jQuery(window).height(), W = jQuery(window).width(), w, h;
      w = (wds_tbWidth && wds_tbWidth < W - 90) ? wds_tbWidth : W - 40;
      h = (wds_tbHeight && wds_tbHeight < H - 60) ? wds_tbHeight : H - 40;
      if (tbWindow.size()) {
        tbWindow.width(w).height(h);
        jQuery('#TB_iframeContent').width(w).height(h - 27);
        tbWindow.css({'margin-left': '-' + parseInt((w / 2),10) + 'px'});
        if (typeof document.body.style.maxWidth != 'undefined') {
          tbWindow.css({'top':(H-h)/2,'margin-top':'0'});
        }
      }
    };
  </script>
  <?php
}
add_action('admin_head', 'wds_admin_ajax');

// Add images to Slider.
add_action('wp_ajax_wds_UploadHandler', 'wds_UploadHandler');
add_action('wp_ajax_addImage', 'wds_filemanager_ajax');

// Upload.
function wds_UploadHandler() {
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  WDW_S_Library::verify_nonce('wds_UploadHandler');
  require_once(WD_S_DIR . '/filemanager/UploadHandler.php');
}

function wds_filemanager_ajax() { 
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  global $wpdb;
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('action');

  if (($page != '') && (($page == 'addImage') || ($page == 'addMusic'))) {
    WDW_S_Library::verify_nonce($page);
    require_once(WD_S_DIR . '/filemanager/controller.php');
    $controller_class = 'FilemanagerController';
    $controller = new $controller_class();
    $addImages_ajax = WDW_S_Library::get('addImages_ajax');
    if ($addImages_ajax == 'addImages_ajax') {
      $load_count = WDW_S_Library::get('load_count');
      $images_list = $controller->get_images(intval($load_count));
      echo (json_encode($images_list, true));
      die;
    }
    else {
      $controller->execute(true, 1);
    }
  }
}
// Slider Widget.
if (class_exists('WP_Widget')) {
  require_once(WD_S_DIR . '/admin/controllers/WDSControllerWidgetSlideshow.php');
  add_action('widgets_init', create_function('', 'return register_widget("WDSControllerWidgetSlideshow");'));
}

// Activate plugin.
function wds_activate() {
  global $wpdb;
  wds_install();
  if (!$wpdb->get_var("SELECT * FROM " . $wpdb->prefix . "wdsslider")) {
    $wpdb->insert(
      $wpdb->prefix . 'wdsslider', 
      array(
        'id' => 1,
        'name' => 'Default slider',
        'published' => 1,
        'full_width' => 0,
        'width' => 800,
        'height' => 300,
        'bg_fit' => 'cover',
        'align' => 'center',
        'effect' => 'none',
        'time_intervval' => 5,
        'autoplay' => 1,
        'shuffle' => 0,
        'music' => 0,
        'music_url' => '',
        'preload_images' => 1,
        'background_color' => '000000',
        'background_transparent' => 100,
        'glb_border_width' => 0,
        'glb_border_style' => 'none',
        'glb_border_color' => 'FFFFFF',
        'glb_border_radius' => '',
        'glb_margin' => 0,
        'glb_box_shadow' => '',
        'image_right_click' => 0,
        'layer_out_next' => 1,
        'prev_next_butt' => 1,
        'play_paus_butt' => 0,
        'navigation' => 'hover',
        'rl_butt_style' => 'fa-angle',
        'rl_butt_size' => 40,
        'pp_butt_size' => 40,
        'butts_color' => 'FFFFFF',
        'butts_transparent' => 100,
        'hover_color' => 'CCCCCC',
        'nav_border_width' => 0,
        'nav_border_style' => 'none',
        'nav_border_color' => 'FFFFFF',
        'nav_border_radius' => '20px',
        'nav_bg_color' => 'FFFFFF',
        'bull_position' => 'bottom',
        'bull_style' => 'fa-square-o',
        'bull_size' => 20,
        'bull_color' => 'FFFFFF',
        'bull_act_color' => 'FFFFFF',
        'bull_margin' => 3,
        'film_pos' => 'none',
        'film_thumb_width' => 100,
        'film_thumb_height' => 50,
        'film_bg_color' => '000000',
        'film_tmb_margin' => 0,
        'film_act_border_width' => 0,
        'film_act_border_style' => 'none',
        'film_act_border_color' => 'FFFFFF',
        'film_dac_transparent' => 50,
        'timer_bar_type' => 'none',
        'timer_bar_size' => 5,
        'timer_bar_color' => 'FFFFFF',
        'timer_bar_transparent' => 50,
        'built_in_watermark_type' => 'none',
        'built_in_watermark_position' => 'middle-center',
        'built_in_watermark_size' => 15,
        'built_in_watermark_url' => WD_S_URL . '/images/watermark.png',
        'built_in_watermark_text' => 'web-dorado.com',
        'built_in_watermark_font_size' => 20,
        'built_in_watermark_font' => '',
        'built_in_watermark_color' => 'FFFFFF',
        'built_in_watermark_opacity' => 70,
        'css' => '',
        'stop_animation' => 0,
        'spider_uploader' => 0,
        'right_butt_url' => WD_S_URL . '/images/arrow/arrow11/1/2.png',
        'left_butt_url' => WD_S_URL . '/images/arrow/arrow11/1/1.png',
        'right_butt_hov_url' => WD_S_URL . '/images/arrow/arrow11/1/4.png',
        'left_butt_hov_url' => WD_S_URL . '/images/arrow/arrow11/1/3.png',
        'rl_butt_img_or_not' => 'style',
        'bullets_img_main_url' => WD_S_URL . '/images/bullet/bullet1/1/1.png',
        'bullets_img_hov_url' => WD_S_URL . '/images/bullet/bullet1/1/2.png',
        'bull_butt_img_or_not' => 'style',
        'play_butt_url' => WD_S_URL . '/images/button/button4/1/1.png',
        'paus_butt_url' => WD_S_URL . '/images/button/button4/1/3.png',
        'play_butt_hov_url' => WD_S_URL . '/images/button/button4/1/2.png',
        'paus_butt_hov_url' => WD_S_URL . '/images/button/button4/1/4.png',
        'play_paus_butt_img_or_not' => 'style',
        'start_slide_num' => 1,
        'effect_duration' => 800,
        'carousel' => 0,
        'carousel_image_counts' => 7,
        'carousel_image_parameters' => '0.85',
        'carousel_fit_containerWidth' => 0,
        'carousel_width' => 1000,
        'parallax_effect' => 0,
        'mouse_swipe_nav' => 0,
        'bull_hover' => 1,
        'touch_swipe_nav' => 1,
        'mouse_wheel_nav' => 0,
        'keyboard_nav' => 0,
        'possib_add_ffamily' => '',
        'show_thumbnail' => 0,
        'thumb_size' => '0.2',
        'fixed_bg' => 0,
        'smart_crop' => 0,
        'crop_image_position' => 'center center',
        'javascript' => '',
        'carousel_degree' => 0,
        'carousel_grayscale' => 0,
        'carousel_transparency' => 0,
        'bull_back_act_color' => '000000',
        'bull_back_color' => 'CCCCCC',
        'bull_radius' => '20px',
        'possib_add_google_fonts' => 0,
        'possib_add_ffamily_google' => '',
        'slider_loop' => 1,
        'hide_on_mobile' => 0,
        'twoway_slideshow' => 0,
	'full_width_for_mobile' => 0,
	'order_dir' => 'asc',
      )
    );
  }
  if (!$wpdb->get_var("SELECT * FROM " . $wpdb->prefix . "wdsslide")) {
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdsslide` VALUES(1, 1, "Slide 1", "image", "' . WD_S_URL . '/demo/1.jpg", "' . WD_S_URL . '/demo/1-150x150.jpg", 1, "", 1, 0, 0, 0)');
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdsslide` VALUES(2, 1, "Slide 2", "image", "' . WD_S_URL . '/demo/2.jpg", "' . WD_S_URL . '/demo/2-150x150.jpg", 1, "", 2, 0, 0, 0)');
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdsslide` VALUES(3, 1, "Slide 3", "image", "' . WD_S_URL . '/demo/3.jpg", "' . WD_S_URL . '/demo/3-150x150.jpg", 1, "", 3, 0, 0, 0)');
  }
}
register_activation_hook(__FILE__, 'wds_activate');

function wds_install() {
  $version = get_option("wds_version");
  $new_version = WD_S_VERSION;
  if ($version && version_compare($version, $new_version, '<')) {
    require_once WD_S_DIR . "/sliders-update.php";
    wds_update($version);
    update_option("wds_version", $new_version);
  }
  elseif (!$version) {
    require_once WD_S_DIR . "/sliders-insert.php";
    wds_insert();
    add_option("wds_theme_version", '1.0.0', '', 'no');
    add_option("wds_version", $new_version, '', 'no');
    add_option("wds_version_1.0.46", 1, '', 'no');
  }
}
if ((!isset($_GET['action']) || $_GET['action'] != 'deactivate')
  && (!isset($_GET['page']) || $_GET['page'] != 'uninstall_wds')) {
  add_action('admin_init', 'wds_install');
}

// Plugin styles.
function wds_styles() {
  wp_admin_css('thickbox');
  wp_enqueue_style('wds_tables', WD_S_URL . '/css/wds_tables.css', array(), WD_S_VERSION);
  wp_enqueue_style('wds_tables_640', WD_S_URL . '/css/wds_tables_640.css', array(), WD_S_VERSION);
  wp_enqueue_style('wds_tables_320', WD_S_URL . '/css/wds_tables_320.css', array(), WD_S_VERSION);
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $google_fonts = WDW_S_Library::get_google_fonts();
  for ($i = 0; $i < count($google_fonts); $i = $i + 150) {
    $fonts = array_slice($google_fonts, $i, 150);
    $query = implode("|", str_replace(' ', '+', $fonts));
    $url = 'https://fonts.googleapis.com/css?family=' . $query . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
    wp_enqueue_style('wds_googlefonts_' . $i, $url, null, null);
  }
  wp_enqueue_style('wds_deactivate-css',  WD_S_URL . '/wd/assets/css/deactivate_popup.css', array(), WD_S_VERSION);
}

function wds_global_options_defults() {
  $global_options = array(
    'default_layer_fweight'          => 'normal',
    'default_layer_start'            => 1000,
    'default_layer_effect_in'        => 'none',
    'default_layer_duration_eff_in'  => 1000,
    'default_layer_infinite_in'      => 1,
    'default_layer_end'              => 3000,
    'default_layer_effect_out'       => 'none',
    'default_layer_duration_eff_out' => 1000,
    'default_layer_infinite_out'     => 1,
    'default_layer_add_class'        => '',
    'default_layer_ffamily'          => 'arial',
    'default_layer_google_fonts'     => 0,
    'loading_gif'                    => 0,
    'register_scripts'               => 0,
    'spider_uploader'                => 0,
    'possib_add_ffamily'             => '',
    'possib_add_ffamily_google'      => '',
  );
  return $global_options;
}

// Plugin scripts.
function wds_scripts() {
  $wds_global_options = get_option("wds_global_options", 0);
  $global_options = json_decode($wds_global_options);
  if (!$wds_global_options) {
    $wds_global_options = wds_global_options_defults();
  }
  wp_enqueue_media();
  wp_enqueue_script('thickbox');
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('jquery-ui-draggable');
  wp_enqueue_script('jquery-ui-tooltip');
  wp_enqueue_script('wds_admin', WD_S_URL . '/js/wds.js', array(), WD_S_VERSION);
  wp_enqueue_script('jscolor', WD_S_URL . '/js/jscolor/jscolor.js', array(), '1.3.9');
  wp_enqueue_style('wds_font-awesome', WD_S_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
  wp_enqueue_style('wds_effects', WD_S_URL . '/css/wds_effects.css', array(), WD_S_VERSION);
  wp_enqueue_style('wds_tooltip', WD_S_URL . '/css/jquery-ui-1.10.3.custom.css', array(), WD_S_VERSION);
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  wp_localize_script('wds_admin', 'wds_object', array(
    "GGF" => WDW_S_Library::get_google_fonts(),
    "FGF" => WDW_S_Library::get_font_families(),
    "LDO" => $global_options,
	'translate' => array(
					'you_must_set_watermark_type' => __('You must set watermark type.', 'wds'),
					'watermark_succesfully_set' => __('Watermark Succesfully Set.', 'wds'),
					'watermark_succesfully_reset' => __('Watermark Succesfully Reset.', 'wds'),
					'items_succesfully_saved' => __('Items Succesfully Saved.', 'wds'),
					'changes_made_in_this_table_should_be_saved' => __('Changes made in this table should be saved.', 'wds'),
					'selected' => __('Selected', 'wds'),
					'item' => __('item', 'wds'),
					's' => __('s', 'wds'),
					'you_must_select_an_image_file' => __('You must select an image file','wds'),
					'you_must_select_an_audio_file' => __('You must select an audio file.', 'wds'),
					'album_thumb_dimensions' => __('Album thumb dimensions:', 'wds'),
					'album_thumb_width' => __('Album thumb width:', 'wds'),
					'drag_to_re_order' => __('Drag to re-order', 'wds'),
					'delete_layer' => __('Delete layer', 'wds'),
					'layer_title' => __('Layer title', 'wds'),
					'duplicate_layer' => __('Duplicate layer', 'wds'),
					'text' => __('Text: ', 'wds'),
					'sample_text' => __('Sample text ', 'wds'),
					'dimensions' => __('Dimensions:', 'wds'),
					'break_word' => __('Break word', 'wds'),
					'set_the_html_attribute_specified_in_the_img_tag' => __('Set the HTML attribute specified in the IMG tag.', 'wds'),
					'use_http_and_https_for_external_links' => __('Use http:// and https:// for external links.', 'wds'),
					'link' => __('Link:', 'wds'),
					'open_in_a_new_window' => __('Open in a new window', 'wds'),
					'in_addition_you_can_drag_and_drop_the_layer_to_a_desired_position' => __('In addition you can drag and drop the layer to a desired position.', 'wds'),
					'position' => __('Position:', 'wds'),
					'fixed_step_left_center_right' => __('Fixed step (left, center, right)', 'wds'),
					'published' => __('Published', 'wds'),
					'yes' => __('Yes', 'wds'),
					'no' => __('No', 'wds'),
					'color' => __('Color:', 'wds'),
					'hover_color' => __('Hover Color:', 'wds'),
					'font_family' => __('Font family:', 'wds'),
					'google_fonts' => __('Google fonts', 'wds'),
					'default' => __('Default', 'wds'),
					'font_weight' => __('Font weight:', 'wds'),
					'use_css_type_values' => __('Use CSS type values.', 'wds'),
					'padding' => __('Padding:', 'wds'),
					'background_color' => __('Background Color:', 'wds'),
					'transparent' => __('Transparent:', 'wds'),
					'value_must_be_between_0_to_100' => __('Value must be between 0 to 100.', 'wds'),
					'border' => __('Border:', 'wds'),
					'radius' => __('Radius:', 'wds'),
					'use_css_type_values_e_g_10_10_15_888888' => __('Use CSS type values (e.g. 10px 10px 5px #888888).', 'wds'),
					'this_functionality_is_disabled_in_free_version' => __('This functionality is disabled in free version.','wds'),
					'set_width_and_height_of_the_image' => __('Set width and height of the image.','wds'),
					'social_button' => __('Social button:', 'wds'),
					'effect' => __('Effect:', 'wds'),
					'effect_in' => __('Effect in:', 'wds'),
					'effect_out' => __('Effect out:', 'wds'),
					'ms' => __('ms', 'wds'),
					'start' => __('Start', 'wds'),
					'duration' => __('Duration', 'wds'),
					'iteration' => __('Iteration', 'wds'),
					'some_effects_are_disabled_in_free_version' => __('Some effects are disabled in free version.', 'wds'),
					'for_play_infinte_times' => __('0 for play infinte times', 'wds'),
					'iteration' => __('iteration', 'wds'),
					'scale' => __('Scale', 'wds'),
					'add_class' => __('Add class', 'wds'),
					'static_layer' => __('Static layer:', 'wds'),
					'the_layer_will_be_visible_on_all_slides' => __('The layer will be visible on all slides.', 'wds'),
					'add_edit_image' => __('Add/Edit Image', 'wds'),
					'add_image_layer' => __('Add image layer', 'wds'),
					'edit_thumbnail' => __('Edit Thumbnail', 'wds'),
					'duplicate_slide' => __('Duplicate slide', 'wds'),
					'delete_slide' => __('Delete slide', 'wds'),
					'add_image_by_url' => __('Add Image by URL', 'wds'),
					'embed_media' => __('Embed media', 'wds'),
					'image' => __('Image', 'wds'),
					'add_post' => __('Add post', 'wds'),
					'add_video' => __('Add video', 'wds'),
					'delete' => __('Delete', 'wds'),
					'link_the_slide_to' => __('Link the slide to:', 'wds'),
					'add_text_layer' => __('Add text layer', 'wds'),
					'add_video_layer' => __('Add video layer', 'wds'),
					'embed_media_layer' => __('Embed media layer', 'wds'),
					'add_social_buttons_layer' => __('Add social buttons layer', 'wds'),
					'add_hotspot_layer' => __('Add Hotspot Layer', 'wds'),
					'the_thumbnail_size_must_be_between_0_to_1' => __('The thumbnail size must be between 0 to 1.', 'wds'),
					'remove' => __('Remove', 'wds'),					
					'min_size' => __('Minimal size must be less than the actual size.', 'wds'),
					'font_size' => __('Size:', 'wds'),
					'text_alignment' => __('Text alignment:', 'wds'),
					'do_you_want_to_delete_selected_items' => __('Do you want to delete selected items?','wds'),
					'are_you_sure_you_want_to_reset_the_settings' => __('Are you sure you want to reset the settings?', 'wds'),
					'you_must_set_watermark_type' => __('You must set watermark type.', 'wds'),						
					'you_must_select_at_least_one_item' => __('You must select at least one item.', 'wds'),						
					'do_you_want_to_delete_slide' => __('Do you want to delete slide?', 'wds'),						
					'choose_image' => __('Choose Image', 'wds'),						
					'you_can_set_a_redirection_link_for_external_links' => __('You can set a redirection link, so that the user will get to the mentioned location upon hitting the slide. Use http:// and https:// for external links.', 'wds'),						
					'insert' => __('Insert', 'wds'),
					'color' => __('Color', 'wds'),
					'none' => __('None', 'wds'),
					'bounce' => __('Bounce', 'wds'),
					'tada' => __('Tada', 'wds'),
					'bounceInDown' => __('BounceInDown', 'wds'),
					'fadeInLeft' => __('FadeInLeft', 'wds'),
					'flash' => __('Flash', 'wds'),
					'pulse' => __('Pulse', 'wds'),
					'rubberBand' => __('RubberBand', 'wds'),
					'shake' => __('Shake', 'wds'),
					'swing' => __('Swing', 'wds'),
					'wobble' => __('Wobble', 'wds'),
					'hinge' => __('Hinge', 'wds'),
					'lightSpeedIn' => __('LightSpeedIn', 'wds'),
					'rollIn' => __('RollIn', 'wds'),
					'bounceIn' => __('BounceIn', 'wds'),
					'bounceInLeft' => __('BounceInLeft', 'wds'),
					'bounceInRight' => __('BounceInRight', 'wds'),
					'bounceInUp' => __('BounceInUp', 'wds'),
					'fadeIn' => __('FadeIn', 'wds'),
					'fadeInDown' => __('FadeInDown', 'wds'),
					'fadeInDownBig' => __('FadeInDownBig', 'wds'),
					'fadeInLeftBig' => __('FadeInLeftBig', 'wds'),
					'fadeInRight' => __('FadeInRight', 'wds'),
					'fadeInRightBig' => __('FadeInRightBig', 'wds'),
					'fadeInUp' => __('FadeInUp', 'wds'),
					'fadeInUpBig' => __('FadeInUpBig', 'wds'),
					'flip' => __('Flip', 'wds'),
					'flipInX' => __('FlipInX', 'wds'),
					'flipInY' => __('FlipInY', 'wds'),
					'rotateIn' => __('RotateIn', 'wds'),
					'rotateInDownLeft' => __('RotateInDownLeft', 'wds'),
					'rotateInDownRight' => __('RotateInDownRight', 'wds'),
					'rotateInUpLeft' => __('RotateInUpLeft', 'wds'),
					'rotateInUpRight' => __('RotateInUpRight', 'wds'),
					'zoomIn' => __('ZoomIn', 'wds'),
					'zoomInDown' => __('ZoomInDown', 'wds'),
					'zoomInLeft' => __('ZoomInLeft', 'wds'),
					'zoomInRight' => __('ZoomInRight', 'wds'),
					'zoomInUp' => __('ZoomInUp', 'wds'),
					'tada' => __('Tada', 'wds'),
					'bounceOutUp' => __('BounceOutUp', 'wds'),
					'fadeOutRight' => __('FadeOutRight', 'wds'),
					'lightSpeedOut' => __('LightSpeedOut', 'wds'),
					'rollOut' => __('RollOut', 'wds'),
					'bounceOut' => __('BounceOut', 'wds'),
					'bounceOutDown' => __('BounceOutDown', 'wds'),
					'bounceOutLeft' => __('BounceOutLeft', 'wds'),
					'bounceOutRight' =>__('BounceOutRight', 'wds'),
					'fadeOut' => __('FadeOut', 'wds'),
					'fadeOutDown' => __('FadeOutDown', 'wds'),
					'fadeOutDownBig' => __('FadeOutDownBig', 'wds'),
					'fadeOutLeft' => __('FadeOutLeft', 'wds'),
					'fadeOutLeftBig' => __('FadeOutLeftBig', 'wds'),
					'fadeOutRightBig' => __('FadeOutRightBig', 'wds'),
					'fadeOutUp' => __('FadeOutUp', 'wds'),
					'fadeOutUpBig' => __('FadeOutUpBig', 'wds'),
					'flip' => __('Flip', 'wds'),
					'flipOutX' => __('FlipOutX', 'wds'),
					'flipOutY' => __('FlipOutY', 'wds'),
					'rotateOut' => __('RotateOut', 'wds'),
					'rotateOutDownLeft' => __('RotateOutDownLeft', 'wds'),
					'rotateOutDownRight' => __('RotateOutDownRight', 'wds'),
					'rotateOutUpLeft' => __('RotateOutUpLeft', 'wds'),
					'rotateOutUpRight' => __('RotateOutUpRight', 'wds'),
					'zoomOut' => __('ZoomOut', 'wds'),
					'zoomOutDown' => __('ZoomOutDown', 'wds'),
					'zoomOutLeft' => __('ZoomOutLeft', 'wds'),
					'zoomOutRight' => __('ZoomOutRight', 'wds'),
					'zoomOutUp' => __('ZoomOutUp', 'wds'),
					)
  ));

  wp_enqueue_script('wds-deactivate-popup', WD_S_URL.'/wd/assets/js/deactivate_popup.js', array(), WD_S_VERSION, true );
  $admin_data = wp_get_current_user();

  wp_localize_script( 'wds-deactivate-popup', 'wdsWDDeactivateVars', array(
    "prefix" => "wds" ,
    "deactivate_class" =>  'wds_deactivate_link',
    "email" => $admin_data->data->user_email,
    "plugin_wd_url" => "https://web-dorado.com/products/wordpress-slider-plugin.html",
  ));
}

function wds_front_end_scripts() {
  global $wpdb;
  $rows = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wdslayer ORDER BY `depth` ASC");
  $font_array = array();
  foreach ($rows as $row) {
    if (isset($row->google_fonts) && ($row->google_fonts == 1) && ($row->ffamily != "") && !in_array($row->ffamily, $font_array)) {
      $font_array[] = $row->ffamily;
	  }
  }
  $query = implode("|", $font_array);
  if ($query != '') {
    $url = 'https://fonts.googleapis.com/css?family=' . $query . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
  }

  $wds_register_scripts = get_option("wds_register_scripts");

  if (!$wds_register_scripts) {
    wp_enqueue_script('wds_jquery_mobile', WD_S_FRONT_URL . '/js/jquery.mobile.js', array('jquery'), WD_S_VERSION);

    wp_enqueue_script('wds_frontend', WD_S_FRONT_URL . '/js/wds_frontend.js', array('jquery'), WD_S_VERSION);

    wp_enqueue_style('wds_frontend', WD_S_FRONT_URL . '/css/wds_frontend.css', array(), WD_S_VERSION);
    wp_enqueue_style('wds_effects', WD_S_FRONT_URL . '/css/wds_effects.css', array(), WD_S_VERSION);

    wp_enqueue_style('wds_font-awesome', WD_S_FRONT_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
    if ($query != '') {
      wp_enqueue_style('wds_googlefonts', $url, null, null);
    }
  }
  else {
    wp_register_script('wds_jquery_mobile', WD_S_FRONT_URL . '/js/jquery.mobile.js', array('jquery'), WD_S_VERSION);

    wp_register_script('wds_frontend', WD_S_FRONT_URL . '/js/wds_frontend.js', array('jquery'), WD_S_VERSION);

    wp_register_style('wds_frontend', WD_S_FRONT_URL . '/css/wds_frontend.css', array(), WD_S_VERSION);
    wp_register_style('wds_effects', WD_S_FRONT_URL . '/css/wds_effects.css', array(), WD_S_VERSION);

    wp_register_style('wds_font-awesome', WD_S_FRONT_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
    if ($query != '') {
      wp_register_style('wds_googlefonts', $url, null, null);
    }
  }
}
add_action('wp_enqueue_scripts', 'wds_front_end_scripts');

// Languages localization.
function wds_language_load() {
  load_plugin_textdomain('wds', FALSE, basename(dirname(__FILE__)) . '/languages');
}
add_action('init', 'wds_language_load');

function wds_get_sliders() {
  global $wpdb;
  $results = $wpdb->get_results("SELECT `id`,`name` FROM `" . $wpdb->prefix . "wdsslider`", OBJECT_K);
  $sliders = array();
  foreach ($results as $id => $slider) {
    $sliders[$id] = isset($slider->name) ? $slider->name : '';
  }
  return $sliders;
}

function wds_overview() {
  if (is_admin() && !isset($_REQUEST['ajax'])) {
    if (!class_exists("DoradoWeb")) {
      require_once(WD_S_DIR . '/wd/start.php');
    }
    global $wds_options;
    $wds_options = array(
      "prefix" => "wds",
      "wd_plugin_id" => 69,
      "plugin_title" => __('Slider WD', 'wds'),
      // from web-dorado.com,
      "plugin_wordpress_slug" => "slider-wd",
      "plugin_dir" => WD_S_DIR,
      "plugin_main_file" => __FILE__,
      "description" => __('Slider WD is a responsive plugin, which allows adding sliders to your posts/pages and to custom location. It uses large number of transition effects and supports various types of layers.', 'wds'),
      // from web-dorado.com
      "plugin_features" => array(
        0 => array(
          "title" => __("Responsive", "wds"),
          "description" => __("Sleek, powerful and intuitive design and layout brings the slides on a new level, for perfect and fast web surfing. Ways that users interact with 100% responsive Slider WD guarantees better and brave experience.", "wds"),
        ),
        1 => array(
          "title" => __("SEO Friendly", "wds"),
          "description" => __("Slider WD has developed the best practices in SEO field. The plugin supports all functions necessary for top-rankings.", "wds"),
        ),
        2 => array(
          "title" => __("Drag & Drop Back-End Interface", "wds"),
          "description" => __("Arrange each and every layer via user friendly drag and drop interface in seconds. This function guarantees fast and effective usability of the plugin without any development skills.", "wds"),
        ),
        3 => array(
          "title" => __("Touch Swipe Navigation", "wds"),
          "description" => __("Touch the surface of your mobile devices and experience smooth finger navigation. In desktop devices you can experience the same navigation using mouse dragging.", "wds"),
        ),
        4 => array(
          "title" => __("Navigation Custom Buttons", "wds"),
          "description" => __("You can choose among variety of navigation button designs included in the plugin or upload and use your custom ones, based on preferences.", "wds"),
        )
      ),
      // user guide from web-dorado.com
      "user_guide" => array(
        0 => array(
          "main_title" => __("Installing the Slider WD", "wds"),
          "url" => "https://web-dorado.com/wordpress-slider-wd/installing.html",
          "titles" => array()
        ),
        1 => array(
          "main_title" => __("Adding Images to Sliders", "wds"),
          "url" => "https://web-dorado.com/wordpress-slider-wd/adding-images.html",
          "titles" => array()
        ),
        2 => array(
          "main_title" => __("Adding Layers to The Slide", "wds"),
          "url" => "https://web-dorado.com/wordpress-slider-wd/adding-layers.html",
          "titles" => array()
        ),
        3 => array(
          "main_title" => __("Changing/Modifying Slider Settings", "wds"),
          "url" => "https://web-dorado.com/wordpress-slider-wd/changing-settings.html",
          "titles" => array()
        ),
        4 => array(
          "main_title" => __("Publishing the Created Slider", "wds"),
          "url" => "https://web-dorado.com/wordpress-slider-wd/publishing-slider.html",
          "titles" => array()
        ),
        5 => array(
          "main_title" => __("Importing/Exporting Sliders", "wds"),
          "url" => "https://web-dorado.com/wordpress-slider-wd/import-export.html",
          "titles" => array()
        ),
      ),
      "video_youtube_id" => "xebpM_-GwG0",  // e.g. https://www.youtube.com/watch?v=acaexefeP7o youtube id is the acaexefeP7o
      "plugin_wd_url" => "https://web-dorado.com/products/wordpress-slider-plugin.html",
      "plugin_wd_demo_link" => "http://wpdemo.web-dorado.com/slider/",
      "plugin_wd_addons_link" => "",
      "after_subscribe" => admin_url('admin.php?page=overview_wds'), // this can be plagin overview page or set up page
      "plugin_wizard_link" => '',
      "plugin_menu_title" => __("Slider WD", "wds"),
      "plugin_menu_icon" => WD_S_URL . '/images/wd_slider.png',
      "deactivate" => true,
      "subscribe" => true,
      "custom_post" => 'sliders_wds',
      "menu_position" => null,
    );

    dorado_web_init($wds_options);
  }
}
add_action('init', 'wds_overview');

function wds_topic() {
  $page = isset($_GET['page']) ? $_GET['page'] : '';
  $user_guide_link = 'https://web-dorado.com/wordpress-slider-wd/';
  $support_forum_link = 'https://wordpress.org/support/plugin/slider-wd';
  $pro_link = 'https://web-dorado.com/files/fromslider.php';
  $pro_icon = WD_S_URL . '/images/wd_logo.png';
  $support_icon = WD_S_URL . '/images/support.png';
  $prefix = 'wds';
  $is_free = TRUE;
  switch ($page) {
    case 'sliders_wds': {
      $help_text = 'create, edit and delete sliders';
      $user_guide_link .= 'adding-images.html';
      break;
    }
    case 'goptions_wds': {
      $help_text = 'edit global options for sliders';
      $user_guide_link .= 'adding-images.html';
      break;
    }
    case 'licensing_wds': {
      $help_text = '';
      $user_guide_link .= 'adding-images.html';
      break;
    }
    default: {
      return '';
      break;
    }
  }
  ob_start();
  ?>
  <style>
    .wd_topic {
      background-color: #ffffff;
      border: none;
      box-sizing: border-box;
      clear: both;
      color: #6e7990;
      font-size: 14px;
      font-weight: bold;
      line-height: 44px;
      padding: 0 0 0 15px;
      vertical-align: middle;
      width: 98%;
    }
    .wd_topic .wd_help_topic {
      float: left;
    }
    .wd_topic .wd_help_topic a {
      color: #0073aa;
    }
    .wd_topic .wd_help_topic a:hover {
      color: #00A0D2;
    }
    .wd_topic .wd_support {
      float: right;
      margin: 0 10px;
    }
    .wd_topic .wd_support img {
      vertical-align: middle;
    }
    .wd_topic .wd_support a {
      text-decoration: none;
      color: #6E7990;
    }
    .wd_topic .wd_pro {
      float: right;
      padding: 0;
    }
    .wd_topic .wd_pro a {
      border: none;
      box-shadow: none !important;
      text-decoration: none;
    }
    .wd_topic .wd_pro img {
      border: none;
      display: inline-block;
      vertical-align: middle;
    }
    .wd_topic .wd_pro a,
    .wd_topic .wd_pro a:active,
    .wd_topic .wd_pro a:visited,
    .wd_topic .wd_pro a:hover {
      background-color: #D8D8D8;
      color: #175c8b;
      display: inline-block;
      font-size: 11px;
      font-weight: bold;
      padding: 0 10px;
      vertical-align: middle;
    }
  </style>
  <div class="update-nag wd_topic">
    <?php
    if ($help_text) {
      ?>
      <span class="wd_help_topic">
      <?php echo sprintf(__('This section allows you to %s.', $prefix), $help_text); ?>
        <a target="_blank" href="<?php echo $user_guide_link; ?>">
        <?php _e('Read More in User Manual', $prefix); ?>
      </a>
    </span>
      <?php
    }
    if ($is_free) {
      $text = strtoupper(__('Upgrade to paid version', $prefix));
      ?>
    <div class="wd_pro">
      <a target="_blank" href="<?php echo $pro_link; ?>">
        <img alt="web-dorado.com" title="<?php echo $text; ?>" src="<?php echo $pro_icon; ?>" />
        <span><?php echo $text; ?></span>
      </a>
    </div>
      <?php
    }
    if (FALSE) {
      ?>
    <span class="wd_support">
      <a target="_blank" href="<?php echo $support_forum_link; ?>">
        <img src="<?php echo $support_icon; ?>" />
        <?php _e('Support Forum', $prefix); ?>
      </a>
    </span>
      <?php
    }
    ?>
  </div>
  <?php
  echo ob_get_clean();
}
add_action('admin_notices', 'wds_topic', 11);
