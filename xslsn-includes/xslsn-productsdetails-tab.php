<!-- Start the settigns tab for product details -->
<div class="xslsn-tab-container" id="xslsn-tab5C">
  <table class="form-table">
    <tr>
      <th><?php esc_html_e('Run single product', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-switches">
          <?php 
             	$xslsn_productsdetails_runsingleproduct =  xslsn_get_field('xslsn-productsdetails-runsingleproduct', '');
             	$xslsn_productsdetails_runsingleproduct_checked = '';
             	if ( isset($xslsn_productsdetails_runsingleproduct) && $xslsn_productsdetails_runsingleproduct==='on' ) {
             		$xslsn_productsdetails_runsingleproduct_checked = 'checked';
             	}
         	?>
          <label for="xslsn-productsdetails-runsingleproduct">
            <input type="checkbox" id="xslsn-productsdetails-runsingleproduct"
              name="xslsn-live-sale-notification[xslsn-productsdetails-runsingleproduct]"
              <?php esc_attr_e($xslsn_productsdetails_runsingleproduct_checked);?>>
            <?php esc_html_e( 'Notification will only display current product in product detail page that they are viewing.', 'xslsn-live-sale-notification' ) ?>
          </label>
        </div>
      </td>
    </tr>
    <tr>
      <th><?php esc_html_e('Notification show', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <select name="xslsn-live-sale-notification[xslsn-productsdetails-notificationshow]">
          <?php
              $xslsn_productsdetails_runsingleproduct =  xslsn_get_field('xslsn-productsdetails-notificationshow', '');
            ?>
          <option value="<?php esc_attr_e('0');?>"
            <?php if ($xslsn_productsdetails_runsingleproduct==='0') {esc_attr_e('selected');}?>>
            <?php esc_html_e('Current Product', 'xslsn-live-sale-notification');?></option>
          <option value="<?php esc_attr_e('1');?>"
            <?php if ($xslsn_productsdetails_runsingleproduct==='1') {esc_attr_e('selected');}?>>
            <?php esc_html_e('Product in the same category', 'xslsn-live-sale-notification');?></option>
        </select>
        <p class="description">
          <?php esc_html_e('In product single page, Notification can only display current product or other products in the same category.','xslsn-live-sale-notification');?>
        </p>
      </td>
    </tr>
  </table>
</div>
<!-- End the tab for product details -->