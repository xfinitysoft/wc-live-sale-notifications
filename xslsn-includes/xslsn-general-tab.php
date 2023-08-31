<!-- This page is used for gerneral page  -->
<div class="xslsn-tab-container" id="xslsn-tab1C">
  <table class="form-table">
    <tbody>
      <tr valign="top">
        <th>
          <?php esc_html_e( 'Enable', 'xslsn-live-sale-notification' ) ?>
        </th>
        <td>
          <label for="xslsn-enable-notification" class="xslsn-new-switch">
            <?php 
	             	$xslsn_enable_notification =  xslsn_get_field('xslsn-enable-notification', '');
	             	$xslsn_enable_notification_checked = '';
	             	if ( isset($xslsn_enable_notification) && $xslsn_enable_notification==='on' ) {
	             		$xslsn_enable_notification_checked = 'checked';
	             	}
             	?>
            <input type="checkbox" id="xslsn-enable-notification"
              name="xslsn-live-sale-notification[xslsn-enable-notification]"
              <?php esc_attr_e($xslsn_enable_notification_checked);?>>
            <span class="xslsn-new-slider round"></span>
          </label>
        </td>
      </tr>
      <tr valign="top">
        <th>
          <?php esc_html_e( 'Mobile', 'xslsn-live-sale-notification' ) ?>
        </th>
        <td>
          <label for="xslsn-enable-notification-mobile" class="xslsn-new-switch">
            <?php 
	             	$xslsn_enable_notification_mobile =  xslsn_get_field('xslsn-enable-notification-mobile', '');
	             	$xslsn_enable_notification_mobile_checked = '';
	             	if ( isset($xslsn_enable_notification_mobile) && $xslsn_enable_notification_mobile==='on' ) {
	             		$xslsn_enable_notification_mobile_checked = 'checked';
	             	}
             	?>
            <input type="checkbox" id="xslsn-enable-notification-mobile"
              name="xslsn-live-sale-notification[xslsn-enable-notification-mobile]"
              <?php esc_attr_e($xslsn_enable_notification_mobile_checked);?>>
            <span class="xslsn-new-slider round"></span>
          </label>
          <p class="description">
            <?php esc_html_e( 'Notification will show on mobile and responsive.', 'xslsn-live-sale-notification' ) ?>
          </p>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<!-- End page of  general tab -->