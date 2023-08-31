<!-- This page is used for desing tab in admin panel -->
<div class="xslsn-tab-container" id="xslsn-tab2C">
  <table class="form-table">
    <tr valign="top">
      <th class="titledesc">
        <label for="xsfsb_enable">
          <?php esc_html_e( 'Highlight color', 'xslsn-live-sale-notification' ) ?>
        </label>
      </th>
      <td>
        <?php 
          $xslsn_highlight_color = xslsn_get_field ('xslsn-highlight-color', '');
        ?>
        <input type="color" name="xslsn-live-sale-notification[xslsn-highlight-color]"
          value="<?php esc_attr_e($xslsn_highlight_color); ?>" id="xslsn-highlight-color">
      </td>
    </tr>
    <tr valign="top">
      <th class="titledesc">
        <label for="xsfsb_enable">
          <?php esc_html_e( 'Text color', 'xslsn-live-sale-notification' ) ?>
        </label>
      </th>
      <td>
        <?php 
          $xslsn_text_color = xslsn_get_field ('xslsn-text-color', '');
        ?>
        <input type="color" name="xslsn-live-sale-notification[xslsn-text-color]"
          value="<?php esc_attr_e($xslsn_text_color); ?>" id="xslsn-text-color">
      </td>
    </tr>
    <tr valign="top">
      <th class="titledesc">
        <label for="xsfsb_enable">
          <?php esc_html_e( 'Background color', 'xslsn-live-sale-notification' ) ?>
        </label>
      </th>
      <td>
        <?php 
          $xslsn_background_color = xslsn_get_field ('xslsn-background-color', '');
        ?>
        <input type="color" name="xslsn-live-sale-notification[xslsn-background-color]"
          value="<?php esc_attr_e($xslsn_background_color); ?>" id="xslsn-background-color">
      </td>
    </tr>

    <tr valign="top">
      <th class="titledesc">
        <label for="xsfsb_enable">
          <?php esc_html_e( 'Image padding', 'xslsn-live-sale-notification' ) ?>
        </label>
      </th>
      <td>
        <?php 
          $xslsn_imagepadding = xslsn_get_field ('xslsn-imagepadding', '');
        ?>
        <input class="small-text" type="number" name="xslsn-live-sale-notification[xslsn-imagepadding]"
          value="<?php esc_attr_e($xslsn_imagepadding); ?>" id="xslsn-imagepadding">
        <?php esc_html_e( 'Gap between product image and notifications border', 'xslsn-live-sale-notification' ) ?>
      </td>
    </tr>
    <tr>
      <th><?php esc_html_e('Templates', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-style-wrapper">
          <div class="xslsn-style-inner">
            <?php 
              $xslsn_desing_style = xslsn_get_field ('xslsn-template-style', '');
            ?>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style1.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style1" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style1"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style1') {esc_attr_e("checked"); }?> id="xslsn-style1">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 1', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>

            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style2.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style2" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style2"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style2') {esc_attr_e("checked"); }?> id="xslsn-style2">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 2', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>

            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style3.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style3" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style3"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style3') {esc_attr_e("checked"); }?> id="xslsn-style3">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 3', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>

            <!-- New Work -->
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style4.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style4" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style4"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style4') {esc_attr_e("checked"); }?> id="xslsn-style4">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 4', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div> 

            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style5.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style5" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style5"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style5') {esc_attr_e("checked"); }?> id="xslsn-style5">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 5', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style6.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style6" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style6"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style6') {esc_attr_e("checked"); }?> id="xslsn-style6">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 6', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style7.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style7" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style7"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style7') {esc_attr_e("checked"); }?> id="xslsn-style7">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 7', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style8.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style8" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style8"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style8') {esc_attr_e("checked"); }?> id="xslsn-style8">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 8', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style9.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style9" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style9"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style9') {esc_attr_e("checked"); }?> id="xslsn-style9">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 9', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style10.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style10" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style10"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style10') {esc_attr_e("checked"); }?> id="xslsn-style10">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 10', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style11.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style11" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style11"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style11') {esc_attr_e("checked"); }?> id="xslsn-style11">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 11', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/xslsn_style12.png'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-style12" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-style]"
                    value="<?php esc_attr_e("xslsn_style12"); ?>"
                    <?php if( $xslsn_desing_style==='xslsn_style12') {esc_attr_e("checked"); }?> id="xslsn-style12">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Style 12', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>


          </div>
        </div>
      </td>
    </tr>

    <tr>
      <th><?php esc_html_e( 'Image Position', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
				$xslsn_position = xslsn_get_field ('xslsn-position', '');
			?>
        <select name="xslsn-live-sale-notification[xslsn-position]" class="xslsn-select xslsn-position">
          <option value="xslsn_position_left"
            <?php if ($xslsn_position ==='xslsn_position_left'){esc_attr_e('selected'); }?>>
            <?php esc_html_e('Left', 'xslsn-live-sale-notification'); ?></option>
          <option value="xslsn_position_right"
            <?php if ($xslsn_position ==='xslsn_position_right'){esc_attr_e('selected'); }?>>
            <?php esc_html_e('Right', 'xslsn-live-sale-notification'); ?></option>
        </select>

      </td>
    </tr>
    <tr>
      <th><?php esc_html_e('Position', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-style-wrapper">
          <div class="xslsn-style-inner">
            <?php 
				$xslsn_template_position = xslsn_get_field ('xslsn-template-position', '');
		    ?>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/position_1.jpg'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-position-bottomleft" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-position]"
                    value="<?php esc_attr_e("xslsn_position_bottomleft"); ?>"
                    <?php if( $xslsn_template_position==='xslsn_position_bottomleft') {esc_attr_e("checked"); }?>
                    id="xslsn-position-bottomleft">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Bottom Left', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>

            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/position_2.jpg'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-bottomright" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-position]"
                    value="<?php esc_attr_e("xslsn_position_bottomright"); ?>"
                    <?php if( $xslsn_template_position==='xslsn_position_bottomright') {esc_attr_e("checked"); }?>
                    id="xslsn-bottomright">
                  <span class="xslsn-new-slider round"></span>

                </label>
                <span class="description"><?php esc_html_e( 'Bottom Right', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>
            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/position_3.jpg'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-topleft" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-position]"
                    value="<?php esc_attr_e("xslsn_position_topleft"); ?>"
                    <?php if( $xslsn_template_position==='xslsn_position_topleft') {esc_attr_e("checked"); }?>
                    id="xslsn-topleft">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Top Left', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>

            <div class="xslsn-single-style">
              <img src="<?php esc_attr_e(plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-img/position_4.jpg'); ?>">
              <div class="xslsn-style-switches">
                <label for="xslsn-topright" class="xslsn-new-switch">
                  <input type="radio" name="xslsn-live-sale-notification[xslsn-template-position]"
                    value="<?php esc_attr_e("xslsn_position_topright"); ?>"
                    <?php if( $xslsn_template_position==='xslsn_position_topright') {esc_attr_e("checked"); }?>
                    id="xslsn-topright">
                  <span class="xslsn-new-slider round"></span>
                </label>
                <span class="description"><?php esc_html_e( 'Top Right', 'xslsn-live-sale-notification' ) ?></span>
              </div>
            </div>


          </div>
        </div>
      </td>
    </tr>
    <tr>
      <th><?php esc_html_e( 'Rounded corner style', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-switches">
          <?php 
             	$xslsn_enableroundcornerborder =  xslsn_get_field('xslsn-enableroundcornerborder', '');
             	$xslsn_enableroundcornerborder_checked = '';
             	if ( isset($xslsn_enableroundcornerborder) && $xslsn_enableroundcornerborder==='on' ) {
             		$xslsn_enableroundcornerborder_checked = 'checked';
             	}
         	?>
          <label for="xslsn-enableroundcornerborder">
            <input type="checkbox" id="xslsn-enableroundcornerborder"
              name="xslsn-live-sale-notification[xslsn-enableroundcornerborder]"
              <?php esc_attr_e($xslsn_enableroundcornerborder_checked);?>>
            <?php esc_html_e( 'Message will be rounded and product image is round instead of square', 'xslsn-live-sale-notification' ) ?>
          </label>
        </div>
      </td>
    </tr>
    <tr class="xslsn-custom-rounded-corner">
      <th><?php esc_html_e( 'Custom Rounded corner', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
				$xslsn_custom_rounded_corner = xslsn_get_field ('xslsn-custom-rounded-corner', '');
			?>
        <input class="small-text" type="number" name="xslsn-live-sale-notification[xslsn-custom-rounded-corner]"
          value="<?php esc_attr_e($xslsn_custom_rounded_corner); ?>" id="xslsn-custom-rounded-corner">
        px
      </td>
    </tr>

    <tr>
      <th><?php esc_html_e( 'Show Close Icon', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-switches">
          <?php 
             	$xslsn_showcloseicon =  xslsn_get_field('xslsn-showcloseicon', '');
             	$xslsn_showcloseicon_checked = '';
             	if ( isset($xslsn_showcloseicon) && $xslsn_showcloseicon==='on' ) {
             		$xslsn_showcloseicon_checked = 'checked';
             	}
         	?>
          <label for="xslsn-showcloseicon">
            <input type="checkbox" id="xslsn-showcloseicon"
              name="xslsn-live-sale-notification[xslsn-showcloseicon]"
              <?php esc_attr_e($xslsn_showcloseicon_checked);?>>
          </label>
        </div>

      </td>
    </tr>
    <tr class="xslsn-showcloseicon">
      <th><?php esc_html_e( 'Time Close', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
				$xslsn_xslsn_timeclose = xslsn_get_field ('xslsn-timeclose', '');
			?>
        <input class="small-text" type="number" name="xslsn-live-sale-notification[xslsn-timeclose]"
          value="<?php esc_attr_e($xslsn_xslsn_timeclose); ?>" id="xslsn-timeclose">
      </td>
    </tr>
    <tr class="xslsn-showcloseicon">
      <th><?php esc_html_e( 'Close icon color', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
				$xslsn_closeiconcolor = xslsn_get_field ('xslsn-closeiconcolor', '');
			?>
        <input type="color" name="xslsn-live-sale-notification[xslsn-closeiconcolor]"
          value="<?php esc_attr_e($xslsn_closeiconcolor); ?>" id="xslsn-closeiconcolor">
      </td>
    </tr>
    <tr>
      <th><?php esc_html_e( 'Image redirect', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-switches">
          <?php 
             	$xslsn_imageredirect =  xslsn_get_field('xslsn-imageredirect', '');
             	$xslsn_imageredirect_checked = '';
             	if ( isset($xslsn_imageredirect) && $xslsn_imageredirect==='on' ) {
             		$xslsn_imageredirect_checked = 'checked';
             	}
         	?>
          <label for="xslsn-imageredirect">
            <input type="checkbox" id="xslsn-imageredirect"
              name="xslsn-live-sale-notification[xslsn-imageredirect]"
              <?php esc_attr_e($xslsn_imageredirect_checked);?>>
          </label>
        </div>

      </td>
    </tr>
    <tr>
      <th><?php esc_html_e('Link target', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-switches">
          <?php 
             	$xslsn_linktarget =  xslsn_get_field('xslsn-linktarget', '');
             	$xslsn_linktarget_checked = '';
             	if ( isset($xslsn_linktarget) && $xslsn_linktarget==='on' ) {
             		$xslsn_linktarget_checked = 'checked';
             	}
         	?>
          <label for="xslsn-linktarget">
            <input type="checkbox" id="xslsn-linktarget" name="xslsn-live-sale-notification[xslsn-linktarget]"
              <?php esc_attr_e($xslsn_linktarget_checked);?>>
            <?php esc_attr_e('Open link on new tab.', 'xslsn-live-sale-notification');?>
          </label>
        </div>
      </td>
    </tr>
    <tr>
      <th valign="top">
        <?php esc_html_e( 'Custom CSS', 'xslsn-live-sale-notification' ) ?>
      </th>
      <td>
        <?php 
					$xslsn_customcss = xslsn_get_field('xslsn_desing_customcss', '');
				?>
        <textarea rows="8" class="large-text code"
          name="xslsn-live-sale-notification[xslsn_desing_customcss]"><?php esc_attr_e($xslsn_customcss); ?></textarea>
      </td>
    </tr>

  </table>
</div>