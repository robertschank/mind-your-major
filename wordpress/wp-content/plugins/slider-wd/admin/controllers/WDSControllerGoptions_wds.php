<?php

class WDSControllerGoptions_wds {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
   
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public function execute() {
    $task = WDW_S_Library::get('task');
    $id = WDW_S_Library::get('current_id', 0);
    $message = WDW_S_Library::get('message');
    echo WDW_S_Library::message_id($message);
    if (method_exists($this, $task)) {
      check_admin_referer('nonce_wd', 'nonce_wd');
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  public function display() {
    require_once WD_S_DIR . "/admin/models/WDSModelGoptions_wds.php";
    $model = new WDSModelGoptions_wds();

    require_once WD_S_DIR . "/admin/views/WDSViewGoptions_wds.php";
    $view = new WDSViewGoptions_wds($model);
    $view->display();
  }
  
   public function save_font_family() {
    $wds_global_options = json_decode(get_option("wds_global_options"), true);
    $possib_add_ffamily = (isset($_REQUEST['possib_add_ffamily']) ? esc_html($_REQUEST['possib_add_ffamily']) : '');
    $possib_add_ffamily_google = (isset($_REQUEST['possib_add_ffamily_google']) ? esc_html($_REQUEST['possib_add_ffamily_google']) : '');
    
    $wds_global_options['possib_add_ffamily'] = $possib_add_ffamily;
    $wds_global_options['possib_add_ffamily_google'] = $possib_add_ffamily_google;
    $global_options = json_encode($wds_global_options);
    update_option("wds_global_options", $global_options);
    
    $page = WDW_S_Library::get('page');
    WDW_S_Library::spider_redirect(add_query_arg(array( 'page'    => $page,
                                                        'task'    => 'display',
                                                        'message' => 1,
                                                 ), admin_url('admin.php')));
  }

  public function save() {
    $register_scripts = (isset($_REQUEST['register_scripts']) ? (int) $_REQUEST['register_scripts'] : 0);
    $loading_gif = (isset($_REQUEST['loading_gif']) ? esc_html($_REQUEST['loading_gif']) : 0);
    $default_layer_fweight = (isset($_REQUEST['default_layer_fweight']) ? esc_html($_REQUEST['default_layer_fweight']) : '');
    $default_layer_start = (isset($_REQUEST['default_layer_start']) ? esc_html($_REQUEST['default_layer_start']) : 0);
    $default_layer_effect_in = (isset($_REQUEST['default_layer_effect_in']) ? esc_html($_REQUEST['default_layer_effect_in']) : '');
    $default_layer_duration_eff_in = (isset($_REQUEST['default_layer_duration_eff_in']) ? esc_html($_REQUEST['default_layer_duration_eff_in']) : 0);
    $default_layer_infinite_in = (isset($_REQUEST['default_layer_infinite_in']) ? esc_html($_REQUEST['default_layer_infinite_in']) : 1);
    $default_layer_end = (isset($_REQUEST['default_layer_end']) ? esc_html($_REQUEST['default_layer_end']) : 0);
    $default_layer_effect_out = (isset($_REQUEST['default_layer_effect_out']) ? esc_html($_REQUEST['default_layer_effect_out']) : '');
    $default_layer_duration_eff_out = (isset($_REQUEST['default_layer_duration_eff_out']) ? esc_html($_REQUEST['default_layer_duration_eff_out']) : 0);
    $default_layer_infinite_out = (isset($_REQUEST['default_layer_infinite_out']) ? esc_html($_REQUEST['default_layer_infinite_out']) : 1);
    $default_layer_add_class = (isset($_REQUEST['default_layer_add_class']) ? esc_html($_REQUEST['default_layer_add_class']) : '');
    $default_layer_ffamily = (isset($_REQUEST['default_layer_ffamily']) ? esc_html($_REQUEST['default_layer_ffamily']) : '');
    $default_layer_google_fonts = (isset($_REQUEST['default_layer_google_fonts']) ? esc_html($_REQUEST['default_layer_google_fonts']) : 0);
    $spider_uploader = (isset($_REQUEST['spider_uploader']) ? esc_html($_REQUEST['spider_uploader']) : 0);
    $possib_add_ffamily = (isset($_REQUEST['possib_add_ffamily']) ? esc_html($_REQUEST['possib_add_ffamily']) : '');
    $possib_add_ffamily_google = (isset($_REQUEST['possib_add_ffamily_google']) ? esc_html($_REQUEST['possib_add_ffamily_google']) : '');
    $global_options = array(
      'default_layer_fweight'          => $default_layer_fweight,
      'default_layer_start'            => $default_layer_start,
      'default_layer_effect_in'        => $default_layer_effect_in,
      'default_layer_duration_eff_in'  => $default_layer_duration_eff_in,
      'default_layer_infinite_in'      => $default_layer_infinite_in,
      'default_layer_end'              => $default_layer_end,
      'default_layer_effect_out'       => $default_layer_effect_out,
      'default_layer_duration_eff_out' => $default_layer_duration_eff_out,
      'default_layer_infinite_out'     => $default_layer_infinite_out,
      'default_layer_add_class'        => $default_layer_add_class,
      'default_layer_ffamily'          => $default_layer_ffamily,
      'default_layer_google_fonts'     => $default_layer_google_fonts,
      'register_scripts'               => $register_scripts,
      'loading_gif'                    => $loading_gif,
      'spider_uploader'                => $spider_uploader,
      'possib_add_ffamily'             => $possib_add_ffamily,
      'possib_add_ffamily_google'      => $possib_add_ffamily_google,
    );
    $global_options = json_encode($global_options);
    update_option("wds_global_options", $global_options);
    $page = WDW_S_Library::get('page');
    WDW_S_Library::spider_redirect(add_query_arg(array( 'page'    => $page,
                                                        'task'    => 'display',
                                                        'message' => 1,
                                                 ), admin_url('admin.php')));
  }

  public function change_layer_options() {
    global $wpdb;
    $lay_option = (isset($_POST["lay_option"]) ? esc_html($_REQUEST['lay_option']) : '');
    $default_layer_add_class = (isset($_POST["default_layer_add_class"]) ? esc_html($_REQUEST['default_layer_add_class']) : '');
    $default_layer_fweight = (isset($_POST["default_layer_fweight"]) ? esc_html($_REQUEST['default_layer_fweight']) : '');
    $default_layer_ffamily = (isset($_POST["default_layer_ffamily"]) ? esc_html($_REQUEST['default_layer_ffamily']) : '');
    $default_layer_google_fonts = (isset($_POST["default_layer_google_fonts"]) ? esc_html($_REQUEST['default_layer_google_fonts']) : 0);
    $default_layer_start = (isset($_POST["default_layer_start"]) ? esc_html($_REQUEST['default_layer_start']) : 0);
    $default_layer_effect_in = (isset($_POST["default_layer_effect_in"]) ? esc_html($_REQUEST['default_layer_effect_in']) : '');
    $default_layer_duration_eff_in = (isset($_POST["default_layer_duration_eff_in"]) ? esc_html($_REQUEST['default_layer_duration_eff_in']) : 0);
    $default_layer_infinite_in = (isset($_POST["default_layer_infinite_in"]) ? esc_html($_REQUEST['default_layer_infinite_in']) : 1);
    $default_layer_end = (isset($_POST["default_layer_end"]) ? esc_html($_REQUEST['default_layer_end']) : 0);
    $default_layer_effect_out = (isset($_POST["default_layer_effect_out"]) ? esc_html($_REQUEST['default_layer_effect_out']) : '');
    $default_layer_duration_eff_out = (isset($_POST["default_layer_duration_eff_out"]) ? esc_html($_REQUEST['default_layer_duration_eff_out']) : 0);
    $default_layer_infinite_out = (isset($_POST["default_layer_infinite_out"]) ? esc_html($_REQUEST['default_layer_infinite_out']) : 1);
    $colls = array();
    switch ( $lay_option ) {
      case "add_class":
        $colls = array(
          '`add_class`="' . $default_layer_add_class . '"',
        );
        break;
      case "fweight":
        $colls = array(
          '`fweight`="' . $default_layer_fweight . '"',
        );
        break;
      case "font_family":
        $colls = array(
          '`ffamily`="' . $default_layer_ffamily . '"',
          '`google_fonts`="' . $default_layer_google_fonts . '"',
        );
        break;
      case "effectin":
        $colls = array(
          '`start`=' . $default_layer_start,
          '`layer_effect_in`="' . $default_layer_effect_in . '"',
          '`duration_eff_in`=' . $default_layer_duration_eff_in,
          '`infinite_in`=' . $default_layer_infinite_in,
        );
        break;
      case "effectout":
        $colls = array(
          'end=' . $default_layer_end,
          'layer_effect_out="' . $default_layer_effect_out . '"',
          'duration_eff_out=' . $default_layer_duration_eff_out,
          'infinite_out=' . $default_layer_infinite_out,
        );
        break;
    }
    $save = $wpdb->query('UPDATE ' . $wpdb->prefix . 'wdslayer SET ' . implode(',', $colls) . '');

    $messaage = $wpdb->last_error ? 2 : 1;
    $page = WDW_S_Library::get('page');
    WDW_S_Library::spider_redirect(add_query_arg(array( 'page'    => $page,
                                                        'task'    => 'display',
                                                        'message' => $messaage,
                                                 ), admin_url('admin.php')));
  }
}