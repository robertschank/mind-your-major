<?php

class WDSViewGoptions_wds {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public function display() {
    $default_layer_fweights = array(
      'lighter' => __('Lighter', 'wds'),
      'normal' => __('Normal', 'wds'),
      'bold' => __('Bold', 'wds'),
    );
    $default_layer_effects_in = array(
      'none'          => __('None', 'wds'),
      'bounce'        => __('Bounce', 'wds'),
      'flash'         => __('Flash', 'wds'),
      'pulse'         => __('Pulse', 'wds'),
      'rubberBand'    => __('RubberBand', 'wds'),
      'shake'         => __('Shake', 'wds'),
      'swing'         => __('Swing', 'wds'),
      'tada'          => __('Tada', 'wds'),
      'wobble'        => __('Wobble', 'wds'),
      'hinge'         => __('Hinge', 'wds'),
      'lightSpeedIn'  => __('LightSpeedIn', 'wds'),
      'rollIn'        => __('RollIn', 'wds'),
      'bounceIn'      => __('BounceIn', 'wds'),
      'bounceInDown'  => __('BounceInDown', 'wds'),
      'bounceInLeft'  => __('BounceInLeft', 'wds'),
      'bounceInRight' => __('BounceInRight', 'wds'),
      'bounceInUp'    => __('BounceInUp', 'wds'),
      'fadeIn'         => __('FadeIn', 'wds'),
      'fadeInDown'     => __('FadeInDown', 'wds'),
      'fadeInDownBig'  => __('FadeInDownBig', 'wds'),
      'fadeInLeft'     => __('FadeInLeft', 'wds'),
      'fadeInLeftBig'  => __('FadeInLeftBig', 'wds'),
      'fadeInRight'    => __('FadeInRight', 'wds'),
      'fadeInRightBig' => __('FadeInRightBig', 'wds'),
      'fadeInUp'       => __('FadeInUp', 'wds'),
      'fadeInUpBig'    => __('FadeInUpBig', 'wds'),
      'flip'    => __('Flip', 'wds'),
      'flipInX' => __('FlipInX', 'wds'),
      'flipInY' => __('FlipInY', 'wds'),
      'rotateIn'          => __('RotateIn', 'wds'),
      'rotateInDownLeft'  => __('RotateInDownLeft', 'wds'),
      'rotateInDownRight' => __('RotateInDownRight', 'wds'),
      'rotateInUpLeft'    => __('RotateInUpLeft', 'wds'),
      'rotateInUpRight'   => __('RotateInUpRight', 'wds'),
      'zoomIn'      => __('ZoomIn', 'wds'),
      'zoomInDown'  => __('ZoomInDown', 'wds'),
      'zoomInLeft'  => __('ZoomInLeft', 'wds'),
      'zoomInRight' => __('ZoomInRight', 'wds'),
      'zoomInUp'    => __('ZoomInUp', 'wds'),
    );
    $default_layer_effects_out = array(
      'none'       => __('None', 'wds'),
      'bounce'     => __('Bounce', 'wds'),
      'flash'      => __('Flash', 'wds'),
      'pulse'      => __('Pulse', 'wds'),
      'rubberBand' => __('RubberBand', 'wds'),
      'shake'      => __('Shake', 'wds'),
      'swing'      => __('Swing', 'wds'),
      'tada'       => __('Tada', 'wds'),
      'wobble'     => __('Wobble', 'wds'),
      'hinge'      => __('Hinge', 'wds'),
      'lightSpeedOut' => __('LightSpeedOut', 'wds'),
      'rollOut'       => __('RollOut', 'wds'),
      'bounceOut'      => __('BounceOut', 'wds'),
      'bounceOutDown'  => __('BounceOutDown', 'wds'),
      'bounceOutLeft'  => __('BounceOutLeft', 'wds'),
      'bounceOutRight' => __('BounceOutRight', 'wds'),
      'bounceOutUp'    => __('BounceOutUp', 'wds'),
      'fadeOut'         => __('FadeOut', 'wds'),
      'fadeOutDown'     => __('FadeOutDown', 'wds'),
      'fadeOutDownBig'  => __('FadeOutDownBig', 'wds'),
      'fadeOutLeft'     => __('FadeOutLeft', 'wds'),
      'fadeOutLeftBig'  => __('FadeOutLeftBig', 'wds'),
      'fadeOutRight'    => __('FadeOutRight', 'wds'),
      'fadeOutRightBig' => __('FadeOutRightBig', 'wds'),
      'fadeOutUp'       => __('FadeOutUp', 'wds'),
      'fadeOutUpBig'    => __('FadeOutUpBig', 'wds'),
      'flip'     => __('Flip', 'wds'),
      'flipOutX' => __('FlipOutX', 'wds'),
      'flipOutY' => __('FlipOutY', 'wds'),
      'rotateOut'          => __('RubberBand', 'wds'),
      'rotateOutDownLeft'  => __('RotateOutDownLeft', 'wds'),
      'rotateOutDownRight' => __('RotateOutDownRight', 'wds'),
      'rotateOutUpLeft'    => __('RotateOutUpLeft', 'wds'),
      'rotateOutUpRight'   => __('RotateOutUpRight', 'wds'),
      'zoomOut'      => __('ZoomOut', 'wds'),
      'zoomOutDown'  => __('ZoomOutDown', 'wds'),
      'zoomOutLeft'  => __('ZoomOutLeft', 'wds'),
      'zoomOutRight' => __('ZoomOutRight', 'wds'),
      'zoomOutUp'    => __('ZoomOutUp', 'wds'),
    );
    $font_families = WDW_S_Library::get_font_families();
    $google_fonts = WDW_S_Library::get_google_fonts();
    $loading_gifs = array(
      0 => __('Loading default', 'wds'),
      1 => __('Loading1', 'wds'),
      2 => __('Loading2', 'wds'),
      3 => __('Loading3', 'wds'),
      4 => __('Loading4', 'wds'),
      5 => __('Loading5', 'wds'),
    );

    $wds_global_options = get_option("wds_global_options", 0);
    $global_options = json_decode($wds_global_options);
    if ( !$wds_global_options ) {
      $global_options = (object) wds_global_options_defults();
      $global_options->loading_gif = get_option("wds_loading_gif", 0);
      $global_options->register_scripts = get_option("wds_register_scripts", 0);
    }

    ?>
    <div class="clear"></div>
    <form class="wrap wds_form" id="sliders_form" method="post" action="admin.php?page=goptions_wds" style="width: 98%;" enctype="multipart/form-data">
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <div class="wds-options-page-banner">
        <div class="wds-options-logo"></div>
				<div class="wds-options-logo-title">
					<?php _e('Global Options', 'wds'); ?>
				</div>
        <div class="wds-page-actions">
			   <button class="wds_button-secondary wds_save_slider" onclick="spider_set_input_value('task', 'save');">
          <span></span>
          <?php _e('Save', 'wds'); ?>
				 </button>
		  	</div>	
      </div>
      <table>
			  <tbody>
          <tr>
            <td class="spider_label"><label><?php _e('Include scripts/styles only on necessary pages', 'wds'); ?>:</label></td>
               <td>
                <input type="radio" id="register_scripts1" name="register_scripts" <?php echo (($global_options->register_scripts == 1)? "checked='checked'" : ""); ?> value="1" /><label <?php echo ($global_options->register_scripts ? 'class="selected_color"' : ''); ?> for="register_scripts1"><?php _e('Yes', 'wds'); ?></label>
                <input type="radio" id="register_scripts0" name="register_scripts" <?php echo (($global_options->register_scripts == 0)? "checked='checked'" : ""); ?> value="0" /><label <?php echo ($global_options->register_scripts ? '' : 'class="selected_color"'); ?> for="register_scripts0"><?php _e('No', 'wds'); ?></label>
                <div class="spider_description"><?php _e('Helps to decrease page load time. Might not function with some custom themes.', 'wds'); ?></div>
             </td>
          </tr>
          <tr>
            <td class="spider_label">
              <label for="loading_gif"><?php _e('Loading icon:', 'wds'); ?></label>
            </td>
            <td>
              <select class="select_icon select_icon_320 select_gif" name="loading_gif" id="loading_gif" onchange="wds_loading_gif(jQuery(this).val(), '<?php echo WD_S_URL ?>')">
                <?php
                foreach ($loading_gifs as $key => $loading_gif) {
                  ?>
              <option value="<?php echo $key; ?>" <?php if ($global_options->loading_gif == $key) echo 'selected="selected"'; ?>><?php echo $loading_gif; ?></option>
                  <?php
                }
                ?>
              </select>
              <fieldset class="wds_fieldset wds_center">
                <legend><?php _e('Preview', 'wds'); ?></legend>
                <img id="load_gif_img" class="load_gif_img" src="<?php echo WD_S_URL . '/images/loading/' . $global_options->loading_gif . '.gif'; ?>" />
              </fieldset>
              <div class="spider_description"></div>
            </td>
          </tr>
          <tr>
            <td class="spider_label"><label><?php _e('Turn SliderWD Media Upload', 'wds'); ?>:</label></td>
            <td>
              <input type="radio" id="spider_uploader1" name="spider_uploader" <?php echo (($global_options->spider_uploader == 1)? "checked='checked'" : ""); ?> value="1" /><label <?php echo ($global_options->spider_uploader ? 'class="selected_color"' : ''); ?> for="spider_uploader1"><?php _e('Yes', 'wds'); ?></label>
              <input type="radio" id="spider_uploader0" name="spider_uploader" <?php echo (($global_options->spider_uploader == 0)? "checked='checked'" : ""); ?> value="0" /><label <?php echo ($global_options->spider_uploader ? '' : 'class="selected_color"'); ?> for="spider_uploader0"><?php _e('No', 'wds'); ?></label>
              <div class="spider_description"><?php _e('Choose the option to use the custom media upload instead of the WordPress default for adding images.', 'wds'); ?></div>
            </td>
          </tr>
          <tr>
            <td class="spider_label"><label for="possib_add_ffamily_input"><?php _e('Add font-family:', 'wds'); ?> </label></td>
            <td>
              <input type="text" id="possib_add_ffamily_input" value="" class="spider_box_input"/>
              <input type="hidden" id="possib_add_ffamily" name="possib_add_ffamily" value="<?php echo $global_options->possib_add_ffamily; ?>"/>
              <input type="hidden" id="possib_add_ffamily_google" name="possib_add_ffamily_google" value="<?php echo $global_options->possib_add_ffamily_google; ?>"/>
              <input id="possib_add_google_fonts" type="checkbox" name="possib_add_google_fonts" value="1"/><label for="possib_add_google_fonts"><?php _e('Add to Google fonts', 'wds'); ?></label>
              <input id="add_font_family" class="wds_not_image_buttons" type="button" onclick="set_ffamily_value();spider_set_input_value('task', 'save_font_family');spider_form_submit(event, 'sliders_form')" value="<?php _e('Add font-family', 'wds'); ?>"/>
              <div class="spider_description"><?php _e('The added font family will appear in the drop-down list of fonts.', 'wds'); ?></div>
            </td>
          </tr>
        </tbody>
      </table>
      <fieldset class="wds_fieldset" disabled="disabled">
        <legend><?php _e('Default options for layers', 'wds'); ?></legend>
        <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;"><?php _e('This functionality is disabled in free version.', 'wds'); ?></div>
        <table>
          <tbody>
            <tr>
              <td class="spider_label">
                <label for="default_layer_ffamily"><?php _e('Font family:', 'wds'); ?></label>
              </td>
              <td>
                <select class="select_icon select_icon_320" style="width: 200px;" id="default_layer_ffamily" onchange="wds_change_fonts('', 1)" name="default_layer_ffamily">
                  <?php
                  $fonts = (isset($global_options->default_layer_google_fonts) && $global_options->default_layer_google_fonts) ? $google_fonts : $font_families;
                  foreach ($fonts as $key => $font_family) {
                    ?>
                    <option value="<?php echo $key; ?>" <?php echo (($global_options->default_layer_ffamily == $key) ? 'selected="selected"' : ''); ?>><?php echo $font_family; ?></option>
                    <?php
                  }
                  ?>
                </select>
                <input id="default_layer_google_fonts1" type="radio" name="default_layer_google_fonts" value="1" <?php echo (($global_options->default_layer_google_fonts) ? 'checked="checked"' : ''); ?> onchange="wds_change_fonts()" />
                <label for="default_layer_google_fonts1"><?php __('Google fonts', 'wds'); ?></label>
                <input id="default_layer_google_fonts0" type="radio" name="default_layer_google_fonts" value="0" <?php echo (($global_options->default_layer_google_fonts) ? '' : 'checked="checked"'); ?> onchange="wds_change_fonts()" />
                <label for="default_layer_google_fonts0"><?php _e('Default', 'wds'); ?></label>
                <div class="spider_description"></div>
              </td>
            </tr>
            <tr>
              <td class="spider_label">
                <label for="default_layer_fweight"><?php _e('Font weight:', 'wds'); ?></label>
              </td>
              <td>
                <select class="select_icon select_icon_320" style="width:70px" id="default_layer_fweight"  name="default_layer_fweight">
                  <?php
                  foreach ($default_layer_fweights as $key => $default_layer_fweight) {
                    ?>
                    <option value="<?php echo $key; ?>" <?php echo (($global_options->default_layer_fweight == $key) ? 'selected="selected"' : ''); ?>><?php echo $default_layer_fweight; ?></option>
                    <?php
                  }
                  ?>
                </select>
                <div class="spider_description"></div>
              </td>
            </tr>
            <tr>
              <td class="spider_label">
                <label for="default_layer_effect_in"><?php _e('Effect In:' , 'wds'); ?></label>
              </td>
              <td>
                <span style="display: table-cell;">
                  <input id="default_layer_start" class="spider_int_input" type="text" value="<?php echo $global_options->default_layer_start; ?>" name="default_layer_start"/><?php _e('ms' , 'wds'); ?>
                  <div class="spider_description"><?php __('Start', 'wds'); ?></div>
                </span>
                <span style="display: table-cell;">
                  <select class="select_icon select_icon_320" name="default_layer_effect_in" id="default_layer_effect_in" style="width:150px;">
                  <?php
                  foreach ( $default_layer_effects_in as $key => $default_layer_effect_in ) {
                    ?>
                    <option value="<?php echo $key; ?>" <?php if ( $global_options->default_layer_effect_in == $key ) {
                      echo 'selected="selected"';
                    } ?>><?php echo $default_layer_effect_in; ?></option>
                    <?php
                  }
                  ?>
                  </select>
                  <div class="spider_description"><?php _e('Effect', 'wds'); ?></div>
                </span>
                <span style="display: table-cell;">
                  <input id="default_layer_duration_eff_in" class="spider_int_input" type="text" value="<?php echo $global_options->default_layer_duration_eff_in; ?>" name="default_layer_duration_eff_in"/><?php _e('ms' , 'wds'); ?>
                  <div class="spider_description"><?php _e('Duration', 'wds'); ?></div>
                </span>
                <span style="display: table-cell;">
                  <input id="default_layer_infinite_in" type="text" name="default_layer_infinite_in" value="<?php echo $global_options->default_layer_infinite_in; ?>" class="spider_int_input" title="0 for play infinte times" />
                  <div class="spider_description"><?php _e('Iteration', 'wds'); ?></div>
                </span>
              </td>
            </tr>
            <tr>
              <td class="spider_label">
                <label for="default_layer_effect_out"><?php _e('Effect Out:','wds'); ?></label>
              </td>
              <td>
                <span style="display: table-cell;">
                  <input id="default_layer_end" class="spider_int_input" type="text" value="<?php echo $global_options->default_layer_end; ?>" name="default_layer_end"><?php _e('ms' , 'wds'); ?>
                  <div class="spider_description"><?php _e('Start', 'wds'); ?></div>
                </span>
                <span style="display: table-cell;">
                  <select class="select_icon select_icon_320" name="default_layer_effect_out" id="default_layer_effect_out" style="width:150px;">
                  <?php
                  foreach ($default_layer_effects_out as $key => $default_layer_effect_out) {
                    ?>
                    <option value="<?php echo $key; ?>" <?php if ($global_options->default_layer_effect_out == $key) echo 'selected="selected"'; ?>><?php echo $default_layer_effect_out; ?></option>
                    <?php
                  }
                  ?>
                  </select>
                  <div class="spider_description"><?php _e('Effect', 'wds'); ?></div>
                </span>
                <span style="display: table-cell;">
                  <input id="default_layer_duration_eff_out" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" value="<?php echo $global_options->default_layer_duration_eff_out; ?>" name="default_layer_duration_eff_out">ms
                  <div class="spider_description"><?php _e('Duration', 'wds'); ?></div>
                </span>
                <span style="display: table-cell;">
                  <input id="default_layer_infinite_out" type="text" name="default_layer_infinite_out" value="<?php echo $global_options->default_layer_infinite_out; ?>" class="spider_int_input" title="0 for play infinte times" />
                  <div class="spider_description"><?php _e('Iteration', 'wds'); ?></div>
                </span>
              </td>
            </tr>
            <tr>
              <td title="Add class" class="spider_label">
                <label for="default_layer_add_class"><?php _e('Add class:', 'wds'); ?> </label>
              </td>
              <td>
                <input id="default_layer_add_class" class="spider_char_input" type="text" value="<?php echo $global_options->default_layer_add_class; ?>" name="default_layer_add_class" />
             </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: right;">
                <input type="button" class="wds_buttons_320 action_buttons add_posts wds_free_button button_padding" value="<?php _e('Apply to existing layers', 'wds'); ?>"/>
              </td>
            </tr>
          </tbody>
        </table>
      </fieldset>
      <input id="task" name="task" type="hidden" value="" />
    </form>
    <?php
  }
}
