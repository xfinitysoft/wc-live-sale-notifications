<!-- Start the page for product  -->
<div class="xslsn-tab-container" id="xslsn-tab4C">
  <table class="form-table">
    <tr>
      <th><?php esc_html_e( 'Show Products', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <select name="xslsn-live-sale-notification[xslsn_products_billing]" id="xslsn-products-billing">
          <?php $xslsn_products_billing =  xslsn_get_field('xslsn_products_billing', ''); ?>
          <option value="<?php esc_attr_e('0');?>" <?php if($xslsn_products_billing==='0'){esc_attr_e('selected');} ?>>
            <?php esc_html_e('Get from Billing', 'xslsn-live-sale-notification'); ?></option>
          <option value="<?php esc_attr_e('1');?>" <?php if($xslsn_products_billing==='1'){esc_attr_e('selected');} ?>>
            <?php esc_html_e('Select Products', 'xslsn-live-sale-notification'); ?></option>
          <option value="<?php esc_attr_e('2');?>" <?php if($xslsn_products_billing==='2'){esc_attr_e('selected');} ?>>
            <?php esc_html_e('Latest Products', 'xslsn-live-sale-notification'); ?></option>
          <option value="<?php esc_attr_e('3');?>" <?php if($xslsn_products_billing==='3'){esc_attr_e('selected');} ?>>
            <?php esc_html_e('Select Categories', 'xslsn-live-sale-notification'); ?></option>
          <option value="<?php esc_attr_e('4');?>" <?php if($xslsn_products_billing==='4'){esc_attr_e('selected');} ?>>
            <?php esc_html_e('Recent Viewed Products', 'xslsn-live-sale-notification'); ?></option>
        </select>
      </td>
    </tr>
    <tr
      class="xslsn-live-sale-product xslsn-live-sale-product-0 xslsn-live-sale-product-1 xslsn-live-sale-product-2 xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><?php esc_html_e( 'Out-of-stock products', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-switches">
          <?php 
            $xslsn_products_outofstock =  xslsn_get_field('xslsn-products-outofstock', '');
            $xslsn_products_outofstock_checked = '';
            if ( isset($xslsn_products_outofstock) && $xslsn_products_outofstock==='on' ) {
              $xslsn_products_outofstock_checked = 'checked';
            }
         	?>
          <label for="xslsn-products-outofstock">
            <input type="checkbox" id="xslsn-products-outofstock"
              name="xslsn-live-sale-notification[xslsn-products-outofstock]"
              <?php esc_attr_e($xslsn_products_outofstock_checked);?>>
            <?php esc_html_e( 'Turn on to show out-of-stock products on notifications.', 'xslsn-live-sale-notification' ) ?>
          </label>
        </div>
      </td>
    </tr>



    <tr class="xslsn-live-sale-product xslsn-live-sale-product-3">
      <th><?php esc_html_e( 'Select Categories', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php $xslsn_products_category =  xslsn_get_field('xslsn-products-category', '');?>
        <select class="xsw-select2" multiple name="xslsn-live-sale-notification[xslsn-products-category][]">
          <?php 
				$xslsn_categories = get_terms(
										array(
											'taxonomy' => 'product_cat',
										)
									);
				foreach ($xslsn_categories as $xslsn_category) {
					$xslsn_datacategory_selected ='';
					if (is_array($xslsn_products_category) && in_array($xslsn_category->term_id, $xslsn_products_category))
					{
						$xslsn_datacategory_selected ='selected';
					}
			  ?>
          <option value="<?php echo esc_attr( $xslsn_category->term_id ) ?>"
            <?php esc_attr_e($xslsn_datacategory_selected);?>><?php echo esc_html( $xslsn_category->name ) ?>
          </option>
          <?php } ?>

        </select>
      </td>
    </tr>

    <tr class="xslsn-live-sale-product xslsn-live-sale-product-0 xslsn-live-sale-product-3">
      <th><?php esc_html_e( 'Exclude Products', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php $xslsn_products_exclude =  xslsn_get_field('xslsn-products-exclude', '');?>
        <select class="xsw-select2" multiple name="xslsn-live-sale-notification[xslsn-products-exclude][]"
          class="xsw-select2 small-text">
          <?php
    			$xslsn_args_p= array(
									'post_type'      => array( 'product' ),
									'post_status'    => 'publish',
									'posts_per_page' => - 1,
								);
				$xslsn_the_query_p = new WP_Query( $xslsn_args_p );
				if ( $xslsn_the_query_p->have_posts() ) {
					$xslsn_products = $xslsn_the_query_p->posts;
					foreach ( $xslsn_products as $xslsn_product ) {
						$xslsn_data = wc_get_product( $xslsn_product );
						$xslsn_data_selected ='';
						if (is_array($xslsn_products_exclude) && in_array($xslsn_data->get_id(), $xslsn_products_exclude))
						{
							$xslsn_data_selected ='selected';
						}
					?>
          <option value="<?php echo esc_attr( $xslsn_data->get_id() ) ?>" <?php esc_attr_e($xslsn_data_selected);?>>
            <?php echo esc_html( $xslsn_data->get_title() ) ?></option>
          <?php		
					}
				}	
				?>
        </select>
        <p class="description">
          <?php esc_html_e( 'These products will not show on notification.', 'xslsn-live-sale-notification' ) ?>
        </p>
      </td>
    </tr>

    <tr
      class="xslsn-live-sale-product xslsn-live-sale-product-2 xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><?php esc_html_e('Product limit', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php
         		$xslsn_products_limit =  xslsn_get_field('xslsn-products-limit', '');
         	?>
        <input type="number" name="xslsn-live-sale-notification[xslsn-products-limit]"
          value="<?php esc_attr_e($xslsn_products_limit); ?>">
        <p class="description">
          <?php esc_html_e('Product quantity will be got in list latest products.', 'xslsn-live-sale-notification');?>
        </p>
      </td>
    </tr>
    <tr
      class="xslsn-live-sale-product xslsn-live-sale-product-0 xslsn-live-sale-product-1  xslsn-live-sale-product-2 xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><?php esc_html_e( 'External link', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <div class="xslsn-switches">
          <?php 
             	$xslsn_products_external_link =  xslsn_get_field('xslsn-products-external-link', '');
             	$xslsn_products_external_link_checked = '';
             	if ( isset($xslsn_products_external_link) && $xslsn_products_external_link==='on' ) {
             		$xslsn_products_external_link_checked = 'checked';
             	}
         	?> <label for="xslsn-products-external-link">
            <input type="checkbox" id="xslsn-products-external-link"
              name="xslsn-live-sale-notification[xslsn-products-external-link]"
              <?php esc_attr_e($xslsn_products_external_link_checked);?>>
            <?php esc_html_e( 'Working with External/Affiliate product. Product link is product URL.', 'xslsn-live-sale-notification' ) ?>
          </label>
        </div>
      </td>
    </tr>

    <tr class="xslsn-live-sale-product  xslsn-live-sale-product-1 ">
      <th><?php esc_html_e( 'Select Products', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php $xslsn_products_select =  xslsn_get_field('xslsn-products-select', '');?>
        <select class="xsw-select2" multiple name="xslsn-live-sale-notification[xslsn-products-select][]">
          <?php
    			$xslsn_args_p= array(
									'post_type'      => array( 'product' ),
									'post_status'    => 'publish',
									'posts_per_page' => - 1,
								);
				$xslsn_the_query_p = new WP_Query( $xslsn_args_p );
				if ( $xslsn_the_query_p->have_posts() ) {
					$xslsn_products = $xslsn_the_query_p->posts;
					foreach ( $xslsn_products as $xslsn_product ) {
						$xslsn_data = wc_get_product( $xslsn_product );
						$xslsn_data_selected ='';
						if (is_array($xslsn_products_select) && in_array($xslsn_data->get_id(), $xslsn_products_select))
						{
							$xslsn_data_selected ='selected';
						}
					?>
          <option value="<?php echo esc_attr( $xslsn_data->get_id() ) ?>" <?php esc_attr_e($xslsn_data_selected);?>>
            <?php echo esc_html( $xslsn_data->get_title() ) ?></option>
          <?php		
					}
				}	
				?>
        </select>
      </td>
    </tr>

    <tr
      class="xslsn-live-sale-product xslsn-live-sale-product-1 xslsn-live-sale-product-2 xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><?php esc_html_e( 'Virtual First Name', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
				$xslsn_products_virtualfirstname = xslsn_get_field ('xslsn-products-virtualfirstname', '');
			?>
        <textarea rows="5" cols="40" class="text-small code"
          name="xslsn-live-sale-notification[xslsn-products-virtualfirstname]"><?php esc_attr_e($xslsn_products_virtualfirstname); ?></textarea>
        <p class="description">
          <?php esc_html_e('Virtual first name what will show on notification. Each first name spreate with comma', 'xslsn-live-sale-notification', 'xslsn-live-sale-notification'); ?>
        </p>
      </td>
    </tr>

    <tr
      class="xslsn-live-sale-product xslsn-live-sale-product-1 xslsn-live-sale-product-2 xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><?php esc_html_e( 'Virtual Time', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
          $xslsn_products_virtualtime = xslsn_get_field ('xslsn-products-virtualtime', '');
        ?>
        <input type="text" name="xslsn-live-sale-notification[xslsn-products-virtualtime]"
          value="<?php esc_attr_e($xslsn_products_virtualtime); ?>">
          <p class="description">
            <?php esc_html_e('Hours', 'xslsn-live-sale-notification'); ?>
            <?php esc_html_e('Time will auto get random in this time threshold ago.', 'xslsn-live-sale-notification'); ?>
          </p>
      </td>
    </tr>

    <tr class="xslsn-live-sale-product xslsn-live-sale-product-1 xslsn-live-sale-product-2 xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><br><?php esc_html_e( 'Address', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
          $xslsn_products_address = xslsn_get_field ('xslsn-products-address', '');
        ?>
        <select name="xslsn-live-sale-notification[xslsn-products-address]" id="xslsn-products-address">
          <option value="<?php esc_attr_e('xslsn-virtual'); ?>"
            <?php if ($xslsn_products_address==='xslsn-virtual') {esc_attr_e('selected');}?>>
            <?php esc_html_e('Virtual', 'xslsn-live-sale-notification'); ?></option>
          <option value="<?php esc_attr_e('xslsn-auto-detect'); ?>"
            <?php if ($xslsn_products_address==='xslsn-auto-detect') {esc_attr_e('selected');}?>>
            <?php esc_html_e('Auto Detect', 'xslsn-live-sale-notification'); ?></option>
        </select>
        <p class="description">
          <?php esc_html_e('You can use auto detect address or make virtual address of customer.', 'xslsn-live-sale-notification'); ?>
        </p>
      </td>
    </tr>

    <tr class="xslsn-live-sale-product xslsn-live-sale-product-1 xslsn-auto-detect xslsn-live-sale-product-2 xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><?php esc_html_e( 'Virtual City', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
				$xslsn_products_virtualcity = xslsn_get_field ('xslsn-products-virtualcity', '');
			?>
        <textarea rows="5" cols="50"
          name="xslsn-live-sale-notification[xslsn-products-virtualcity]"><?php esc_attr_e($xslsn_products_virtualcity); ?></textarea>
          <p class="description">
            <?php esc_html_e('Virtual city name what will show on notification. Each city name on a line.', 'xslsn-live-sale-notification'); ?>
          </p>
      </td>
    </tr>

    <tr class="xslsn-live-sale-product xslsn-live-sale-product-1 xslsn-auto-detect xslsn-live-sale-product-2  xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><?php esc_html_e( 'Virtual Country', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
				$xslsn_products_virtualcountry = xslsn_get_field ('xslsn-products-virtualcountry', '');
			?>
        <input type="text" name="xslsn-live-sale-notification[xslsn-products-virtualcountry]"
          value="<?php esc_attr_e($xslsn_products_virtualcountry); ?>">
          <p class="description">
            <?php esc_html_e('Virtual country name what will show on notification.', 'xslsn-live-sale-notification'); ?>
          </p>
      </td>
    </tr>

    <tr class="xslsn-live-sale-product xslsn-live-sale-product-0">
      <th><?php esc_html_e( 'Order Time', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
    			$xslsn_products_ordertime =  xslsn_get_field('xslsn-products-ordertime', '');
    			$xslsn_products_ordertime_type =  xslsn_get_field('xslsn-products-ordertime-type', '');
    		?>
        <input type="number" class="small-text" name="xslsn-live-sale-notification[xslsn-products-ordertime]"
          value="<?php esc_attr_e($xslsn_products_ordertime); ?>">
        <select name="xslsn-live-sale-notification[xslsn-products-ordertime-type]">
          <option value="<?php esc_attr_e('xslsn_hours'); ?>"
            <?php if ($xslsn_products_ordertime_type==='xslsn_hours') {esc_html_e('selected');}?>>
            <?php esc_html_e('Hours', 'xslsn-live-sale-notification'); ?></option>
          <option value="<?php esc_attr_e('xslsn_days'); ?>"
            <?php if ($xslsn_products_ordertime_type==='xslsn_days') {esc_html_e('selected');}?>>
            <?php esc_html_e('Days', 'xslsn-live-sale-notification'); ?></option>
          <option value="<?php esc_attr_e('xslsn_minutes'); ?>"
            <?php if ($xslsn_products_ordertime_type==='xslsn_minutes') {esc_html_e('selected');}?>>
            <?php esc_html_e('Minutes', 'xslsn-live-sale-notification'); ?></option>
        </select>
        <p class="description">
          <?php esc_html_e( 'Products in this recently time will get from order', 'xslsn-live-sale-notification' ) ?>
        </p>
      </td>

    </tr>
    <tr class="xslsn-live-sale-product xslsn-live-sale-product-0">
      <th><?php esc_html_e( 'Order Status', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php 
    			$xslsn_products_orderstatus =  xslsn_get_field('xslsn-products-orderstatus', '');
			?>
        <select class="xsw-select2" name="xslsn-live-sale-notification[xslsn-products-orderstatus][]" multiple>
          <?php 
    				$xslsn_statuses= wc_get_order_statuses();
    				foreach ($xslsn_statuses as $xslsn_key => $xslsn_statuse) {
    					$xslsn_orderstatus_selected ='';
						if (in_array($xslsn_key, $xslsn_products_orderstatus))
						{
							$xslsn_orderstatus_selected ='selected';
						}

    			?>
          <option value="<?php esc_attr_e($xslsn_key); ?>" <?php esc_attr_e($xslsn_orderstatus_selected);?>>
            <?php esc_html_e($xslsn_statuse, 'xslsn-live-sale-notification'); ?></option>
          <?php 	} ?>
        </select>

      </td>

    </tr>
    <tr
      class="xslsn-live-sale-product xslsn-live-sale-product-0 xslsn-live-sale-product-1 xslsn-live-sale-product-2 xslsn-live-sale-product-3 xslsn-live-sale-product-4">
      <th><?php esc_html_e( 'Product image size', 'xslsn-live-sale-notification' ) ?></th>
      <td>
        <?php
				$xslsn_products_imagesize =  xslsn_get_field('xslsn-products-imagesize', '');
			?>
        <select name="xslsn-live-sale-notification[xslsn-products-imagesize]">
          <option value="<?php esc_attr_e('xslsn_shop_thumbnail');?>"
            <?php if ($xslsn_products_imagesize==='xslsn_shop_thumbnail'){esc_attr_e('selected');}?>>
            <?php esc_html_e('shop_thumbnail- 100x100', 'xslsn-live-sale-notification');?></option>
          <option value="<?php esc_attr_e('xslsn_shop_catalog');?>"
            <?php if ($xslsn_products_imagesize==='xslsn_shop_catalog'){esc_attr_e('selected');}?>>
            <?php esc_html_e('shop_catalog- 450x450', 'xslsn-live-sale-notification');?></option>
          <option value="<?php esc_attr_e('xslsn_shop_single');?>"
            <?php if ($xslsn_products_imagesize==='xslsn_shop_single'){esc_attr_e('selected');}?>>
            <?php esc_html_e('shop_single- 600x0', 'xslsn-live-sale-notification');?></option>
        </select>
        <br>
        <p class="description">
          <?php esc_html_e( 'Image size will get form your WordPress site.', 'xslsn-live-sale-notification' ) ?></p>
      </td>

    </tr>
  </table>
</div>
<!-- End the page for product tab -->