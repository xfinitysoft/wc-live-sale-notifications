<!-- This page is used for messages -->
<div class="xslsn-tab-container" id="xslsn-tab3C">
  <table class="form-table">
    <tr valign="top">
      <th><?php esc_html_e( 'Message purchased', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
					$xslsn_message_purchased = xslsn_get_field('xslsn-message-purchased', '');
				?>
        <textarea cols='50' rows='5' name="xslsn-live-sale-notification[xslsn-message-purchased]" value=""><?php esc_attr_e(trim($xslsn_message_purchased)); ?></textarea>

        <p class="description">
          <?php esc_html_e( '{first_name} - Customers first name', 'xslsn-live-sale-notification' ) ?>
        </p>
        <p class="description">
          <?php esc_html_e( '{city} - Customers city', 'xslsn-live-sale-notification' ) ?>
        </p>
        <p class="description">
          <?php esc_html_e( '{state} - Customers state', 'xslsn-live-sale-notification' ) ?>
        </p>
        <p class="description">
          <?php esc_html_e( '{country} - Customers country', 'xslsn-live-sale-notification' ) ?>
        </p>
        <p class="description">
          <?php esc_html_e( '{product} - Product title', 'xslsn-live-sale-notification' ) ?>
        </p>
        <p class="description">
          <?php esc_html_e( '{product_with_link} - Product title with link', 'xslsn-live-sale-notification' ) ?>
        </p>
        <p class="description">
          <?php esc_html_e( '{time_ago} - Time after purchase', 'xslsn-live-sale-notification' ) ?>
        </p>
        <p class="description">
          <?php esc_html_e( '{custom} - Use custom shortcode', 'xslsn-live-sale-notification' ) ?>
        </p>

      </td>
    </tr>

    <tr>
      <th><?php esc_html_e( 'Custom', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
					$xslsn_message_custom = xslsn_get_field ('xslsn-message-custom', '');
				?>
        <input type="text" name="xslsn-live-sale-notification[xslsn-message-custom]"
          value="<?php esc_attr_e($xslsn_message_custom); ?>" id="xslsn-message-custom">
        <?php esc_html_e( 'This is {custom} shortcode content.', 'xslsn-live-sale-notification' ) ?>
      </td>
    </tr>

    <tr>
      <th><?php esc_html_e( 'Min Number', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
					$xslsn_message_minnumber = xslsn_get_field ('xslsn-message-minnumber', '');
				?>
        <input type="number" class="small-text" name="xslsn-live-sale-notification[xslsn-message-minnumber]"
          value="<?php esc_attr_e($xslsn_message_minnumber); ?>" id="xslsn-message-minnumber">
      </td>
    </tr>

    <tr>
      <th><?php esc_html_e( 'Max number', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
					$xslsn_message_maxnumber = xslsn_get_field ('xslsn-message-maxnumber', '');
				?>
        <input type="number" class="small-text" name="xslsn-live-sale-notification[xslsn-message-maxnumber]"
          value="<?php esc_attr_e($xslsn_message_maxnumber); ?>" id="xslsn-message-maxnumber">
      </td>
    </tr>

  </table>
</div>

<!-- End of page messages -->