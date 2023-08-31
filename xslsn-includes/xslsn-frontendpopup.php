<?php 
	//This hook is used to excutes the front end js files 
	add_action('wp_enqueue_scripts', 'xslsn_enqueue_css_js_files_forfronetend');
	function xslsn_enqueue_css_js_files_forfronetend () {
		//getting the saved optiopnal data
		$xslsn_params = get_option( 'xslsn-live-sale-notification', true );
		$xslsn_shownotications = '1'; 
		if (isset($xslsn_params['xslsn-enable-notification']) && $xslsn_params['xslsn-enable-notification']!='on') {
			$xslsn_shownotications = '0';
		}
		if (isset($xslsn_params['xslsn-assign-homepage']) && $xslsn_params['xslsn-assign-homepage']==='on' && is_front_page()) {
			$xslsn_shownotications = '0';
		}
		if (isset($xslsn_params['xslsn-assign-checkoutpage']) && $xslsn_params['xslsn-assign-checkoutpage']==='on' && is_checkout()) {
			$xslsn_shownotications = '0';
		}
		if (isset($xslsn_params['xslsn-assign-cartpage']) && $xslsn_params['xslsn-assign-cartpage']==='on' && is_cart()) {
			$xslsn_shownotications = '0';
		}
		
		if ($xslsn_shownotications==='1') {
			wp_enqueue_style('xslsn-customcss',plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-css/xslsn-style.css');
			wp_enqueue_script("xslsn-mainfrontend", plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-js/xslsn-mainfrontend.js',array('jquery'),1.0,true);
		}
		if ( is_singular( 'product' ) ) {
			global $post;
			$xslsn_params['current_post_id'] = esc_attr__($post->ID);
			$xslsn_params['is_product_details_page'] = esc_attr__('1');
		} else {
			$xslsn_params['current_post_id'] = esc_attr__('0');
			$xslsn_params['is_product_details_page'] = esc_attr__('0');
		}
		wp_localize_script('xslsn-mainfrontend', 'xslsn_optionsdata',
				 array( 
				 	'xslsn_data'   => $xslsn_params,
				    'my_ajax_object' => admin_url( 'admin-ajax.php'),
				));
		if (isset($xslsn_params['xslsn_products_billing']) && $xslsn_params['xslsn_products_billing']==='4') {
			xslsn_addrecentviewedproductsids();
		}
	?>
	<!-- Adding the html content on the page for modal -->
	<input type="hidden" value="<?php esc_attr_e(plugin_dir_url( __DIR__ )); ?>" id="xslsn-plugindirpath">

	<?php	
	}
	function xswclsn_templates(){
		require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-notifications-templates.php");
	}
	add_action( 'wp_footer', 'xswclsn_templates', 100 );

	//adding the action for ajax call for admin panel 
	add_action( 'wp_ajax_xslsn_getPopupdata', 'xslsn_getPopupdata' );   
	//adding the action for ajax call for website
	add_action( 'wp_ajax_nopriv_xslsn_getPopupdata', 'xslsn_getPopupdata' );
	//Function is used for ajax call for getting the popup data   
	function xslsn_getPopupdata(){
		//getting the billing type
		$xslsn_billingtype = sanitize_text_field($_POST['xslsn_billingtype']);

		//if type is 0 then calling the real order data function 
		if ($xslsn_billingtype==='0') {
			xslsn_billingtype_billing();
		}
		//if the type is 1 then calling the selected prdo
		if ($xslsn_billingtype==='1') {
			xslsn_billingtype_selectedproduct();
		}
		//if the type is 2 then calling the latest product function
 		if ($xslsn_billingtype==='2') {
			xslsn_billingtype_latestproduct();
		}
		//if the type is 3 then calling the function to get the products by category
		if ($xslsn_billingtype==='3') {
			xslsn_billingtype_productsbycategory();
		}
		//if the type is 4 then it is calling recent product viewwd
		if ($xslsn_billingtype==='4') {
			xslsn_billingtype_productsrecentviewed();
		}
		
	
	}
	
	//function is used to saved the product in recent viewed list 
	function xslsn_billingtype_productsrecentviewed ()
	{
		//are used to get the saved option data
		$xslsn_livesalesnotificationsdata = get_option('xslsn-live-sale-notification',true);
		$xslsn_products_virtualtime = $xslsn_livesalesnotificationsdata['xslsn-products-virtualtime'];
		$message = $xslsn_livesalesnotificationsdata['xslsn-message-purchased'];

		//getting the products ids which is in list
		$xslsn_viewed_products = ! empty( $_COOKIE['xslsn_recentviewedproductsids'] ) ? (array) explode( '|', sanitize_text_field(wp_unslash( $_COOKIE['xslsn_recentviewedproductsids'] ) ) ) : array(); 
		$xslsn_productIds = array_reverse( array_filter( array_map( 'absint', $xslsn_viewed_products ) ) );
		
		//checking that if it is on single page 
		$xslsn_is_product_details_page = sanitize_text_field($_POST['xslsn_is_product_details_page']);
		$xslsn_current_post_id = sanitize_text_field($_POST['xslsn_current_post_id']);
		$xslsn_singleProduct = [];
		if ($xslsn_is_product_details_page==='1' 
		&& $xslsn_livesalesnotificationsdata['xslsn-productsdetails-runsingleproduct']==='on') {
			$xslsn_singleProduct[] = $xslsn_current_post_id;
			if (in_array($xslsn_current_post_id, $xslsn_productIds)) {
				if ($xslsn_livesalesnotificationsdata['xslsn-productsdetails-notificationshow']==='1') {
					$xslsn_singleProduct = wc_get_related_products(  $xslsn_current_post_id, 10);
					$xslsn_productIds =  $xslsn_singleProduct;
				} else {
					$xslsn_productIds = [$xslsn_current_post_id]; 
				
				}

			} else {
				return false;
			}
		}

		//getting the hours of time message
		$xslsn_hours = [];
		for ($xslsn_i=1; $xslsn_i <$xslsn_products_virtualtime ; $xslsn_i++) { 
			$xslsn_hours [] =$xslsn_i;
		}
		//getting the virual name and  city explode this with ,
		$xslsn_virtualfirstname = explode(',', $xslsn_livesalesnotificationsdata['xslsn-products-virtualfirstname']);
		$xslsn_virtualcity = explode(',', $xslsn_livesalesnotificationsdata['xslsn-products-virtualcity']);
		// shuffle the differnt arrys
		shuffle($xslsn_virtualfirstname);
		shuffle($xslsn_virtualcity);
		shuffle($xslsn_hours);
		shuffle($xslsn_productIds);
		//checking that if the product is exist on 0 index
		if (isset($xslsn_productIds[0])) {
			//getting the auto detect address option
        	$xslsn_products_address = $xslsn_livesalesnotificationsdata['xslsn-products-address'];
            //getting the product by id 
            $xslsn_productData = wc_get_product( $xslsn_productIds[0] );
            //getting the product link
            $xslsn_link = $xslsn_productData->get_permalink();
            //getting the product image details
            $xslsn_image = wp_get_attachment_image_src( get_post_thumbnail_id($xslsn_productIds[0]));
	        
	        $xslsn_billing_address = '';
	        $xslsn_firstname = '';
	        $xswcln_city = '';
	        $xslsn_country = '';
	        $xslsn_state='';
	        //Checking that virtual  name is set on first index
	        if (isset($xslsn_virtualfirstname[0])) {
	    		 $xslsn_firstname = $xslsn_virtualfirstname[0];
	        
	    	}

	    	//Checking that city is set in array and auto detect is off
	    	if (isset($xslsn_virtualcity[0]) && $xslsn_products_address!='xslsn-auto-detect') {
	    		 $xswcln_city = $xslsn_virtualcity[0];
	        
	    	}
	    	//getting the option if the product is in stock
	    	$xslsn_products_outofstock = $xslsn_livesalesnotificationsdata['xslsn-products-outofstock'];
	    	$xslsn_products_virtualcountry = $xslsn_livesalesnotificationsdata['xslsn-products-virtualcountry'];
	       	//checking if the virtual country is not empty and auto detect is off
	       	if ($xslsn_products_virtualcountry!='' && $xslsn_products_address!='xslsn-auto-detect') {
	    		$xslsn_country = $xslsn_products_virtualcountry;
			}

			//are checking auto detect address option is enable 
			if ($xslsn_products_address==='xslsn-auto-detect') {
				$xslsn_response_extranlapi = wp_remote_get( 'https://extreme-ip-lookup.com/json/' );
				$xslsn_response_extranlapi=json_decode($xslsn_response_extranlapi['body']);
	    		$xswcln_city = $xslsn_response_extranlapi->city;
	    		$xslsn_state = $xslsn_response_extranlapi->state;
	    		$xslsn_country = $xslsn_response_extranlapi->country;

			}
			$minnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-minnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-minnumber']: 1;
          	$maxnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']: 100;
          	$random_number = rand($minnumber,$maxnumber);
          	$custom = str_replace(
          		array(
					'{first_name}',
					'{city}',
					'{state}',
					'{country}',
					'{product}',
					'{product_with_link}',
					'{time_ago}',
					'{number}'
				),
				array(
					$xslsn_firstname,
					$xswcln_city,
					$xslsn_state,
					$xslsn_country,
					esc_attr__($xslsn_productData->get_data()['name']),
					'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
					esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
					$random_number

				), 
				$xslsn_livesalesnotificationsdata['xslsn-message-custom']
			);
			$message = str_replace(
				array(
					'{first_name}',
					'{city}',
					'{state}',
					'{country}',
					'{product}',
					'{product_with_link}',
					'{time_ago}',
					'{custom}',
					'{number}'
				),
				array(
					$xslsn_firstname,
					$xswcln_city,
					$xslsn_state,
					$xslsn_country,
					esc_attr__($xslsn_productData->get_data()['name']),
					'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
					esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
					$xslsn_livesalesnotificationsdata['xslsn-message-custom'],
					$random_number

				),
				$message
			);
			//if the product out stock in on then added the product if it is not in stock 
			if ($xslsn_products_outofstock==='on') {
	            $xslsn_orderItemsData[]  = [
				    			 'xslsn_orderId' =>'',
			    				 'xslsn_productId'=>esc_attr__($xslsn_productIds[0]),
			    				 'xslsn_link'=>esc_attr__($xslsn_link),
			    				 'xslsn_image'=>$xslsn_image,
			    				 'xslsn_title'=>$message,
			    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
			    				 'xslsn_timetoago'=>esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
			    				  	
			    				];
			    
			    	$xslsn_response = [
						'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
						'xslsn_data' =>$xslsn_orderItemsData[0],
						'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
					];			
		    		wp_send_json($xslsn_response);
    		} else {
    			//checking if the poduct is in stock only added if the product is in stoskc
    			if ($xslsn_productData->is_in_stock()==1) {
	    			$xslsn_orderItemsData[]  = [
				    			 'xslsn_orderId' =>'',
			    				 'xslsn_productId'=>esc_attr__($xslsn_productIds[0]),
			    				 'xslsn_link'=>esc_attr__($xslsn_link),
			    				 'xslsn_image'=>$xslsn_image,
			    				 'xslsn_title'=>$message,
			    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
			    				 'xslsn_timetoago'=>esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
			    				  	
			    				];
			    
			    	$xslsn_response = [
						'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
						'xslsn_data' =>$xslsn_orderItemsData[0],
						'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
					];			
		    		wp_send_json($xslsn_response);
	    		}
    		}

		}
		wp_die();
	}

	// Function is used get the products by category id
	function xslsn_billingtype_productsbycategory () 
	{
		//getting the optoional data which is saved into the db
		$xslsn_livesalesnotificationsdata = get_option( 'xslsn-live-sale-notification', true );
		$message = $xslsn_livesalesnotificationsdata['xslsn-message-purchased'];
		//getting the saved category data
		$xslsn_products_category = $xslsn_livesalesnotificationsdata['xslsn-products-category'];
		//Getting the product is in limit
		$xslsn_products_limit = $xslsn_livesalesnotificationsdata['xslsn-products-limit'];
		//checking the prodcuts ids which is exclude
		$xslsn_products_exclude = $xslsn_livesalesnotificationsdata['xslsn-products-exclude'];
		//checking that how much hours loop runs for virtual
		$xslsn_products_virtualtime = $xslsn_livesalesnotificationsdata['xslsn-products-virtualtime'];
		//checking that category count is greater then 0
		if (count($xslsn_products_category)>0) {
			//getting the product categogires
			$xslsn_categories = get_terms(
						[
							'taxonomy' => 'product_cat',
							'include'  => $xslsn_products_category
						]
					);
			//added the category term id which is link with product	
			$xslsn_categories_checked = array();
			if ( count( $xslsn_categories ) ) {
				foreach ( $xslsn_categories as $xslsn_category ) {
					$xslsn_categories_checked[] = $xslsn_category->term_id;
				}
			//if it is not arry then making this array
			if ( ! is_array( $xslsn_products_exclude ) ) {
				$xslsn_products_exclude = array();
			}	
			//preparing the quyer for fetching the product
			$xslsn_args = array(
							'post_type'      => 'product',
							'post_status'    => 'publish',
							'posts_per_page' => $xslsn_products_limit,
							'orderby'        => 'rand',
							'post__not_in'   => $xslsn_products_exclude,
							'tax_query'      => array(
								array(
									'taxonomy'         => 'product_cat',
									'field'            => 'id',
									'terms'            => $xslsn_categories_checked,
									'include_children' => false,
									'operator'         => 'IN'
								),
							),
							'meta_query'     => array(
								
							)
						);	

		$xslsn_productIds= [];
		//getting the prioduct ids
		$xslsn_latestproducts_the_query = new WP_Query( $xslsn_args );
		if ( $xslsn_latestproducts_the_query->have_posts() ) {
			while ( $xslsn_latestproducts_the_query->have_posts() ) {
				$xslsn_latestproducts_the_query->the_post();
				$xslsn_productIds[]=get_the_ID();
			}	
		}
		//checking that if it is on single page 
		$xslsn_is_product_details_page = sanitize_text_field($_POST['xslsn_is_product_details_page']);
		$xslsn_current_post_id = sanitize_text_field($_POST['xslsn_current_post_id']);
		$xslsn_singleProduct = [];
		if ($xslsn_is_product_details_page==='1' 
		&& $xslsn_livesalesnotificationsdata['xslsn-productsdetails-runsingleproduct']==='on') {
			$xslsn_singleProduct[] = $xslsn_current_post_id;
			if (in_array($xslsn_current_post_id, $xslsn_productIds)) {
				if ($xslsn_livesalesnotificationsdata['xslsn-productsdetails-notificationshow']==='1') {
					$xslsn_singleProduct = wc_get_related_products(  $xslsn_current_post_id, 10);
					$xslsn_productIds =  $xslsn_singleProduct;
				} else {
					$xslsn_productIds = [$xslsn_current_post_id]; 
					
				}

			} else {
				return false;
			}
		}

		//getting the hours on loop
		$xslsn_hours = [];
		for ($xslsn_i=1; $xslsn_i <$xslsn_products_virtualtime ; $xslsn_i++) { 
			$xslsn_hours [] =$xslsn_i;
		}
		//getting the virtaul name and city
		$xslsn_virtualfirstname = explode(',', $xslsn_livesalesnotificationsdata['xslsn-products-virtualfirstname']);
		$xslsn_virtualcity = explode(',', $xslsn_livesalesnotificationsdata['xslsn-products-virtualcity']);
		//shuffle the different arrays
		shuffle($xslsn_virtualfirstname);
		shuffle($xslsn_virtualcity);
		shuffle($xslsn_hours);
		shuffle($xslsn_productIds);
		//checking that product is exist on first index.

		if (isset($xslsn_productIds[0])) {
        	//getting that if the auto detect is on or not
        	$xslsn_products_address = $xslsn_livesalesnotificationsdata['xslsn-products-address'];
            //getting the product from database
            $xslsn_productData = wc_get_product( $xslsn_productIds[0] );
		    //getting the product link
		    $xslsn_link = $xslsn_productData->get_permalink();
		    //getting the produc image link
		    $xslsn_image = wp_get_attachment_image_src( get_post_thumbnail_id($xslsn_productIds[0]));
	        
	        $xslsn_billing_address = '';
	        $xslsn_firstname = '';
	        $xswcln_city = '';
	        $xslsn_country = '';
	        $xslsn_state='';
	        //Checking that virtual  name is set on first index
	        if (isset($xslsn_virtualfirstname[0])) {
	    		$xslsn_firstname=$xslsn_virtualfirstname[0];
	        
	    	}

	    	//Checking that city is set in array and auto detect is off
	    	if (isset($xslsn_virtualcity[0]) && $xslsn_products_address!='xslsn-auto-detect') {
	    		$xswcln_city = $xslsn_virtualcity[0];
	        
	    	}
	    	//getting the product is out of stock or not
	    	$xslsn_products_outofstock = $xslsn_livesalesnotificationsdata['xslsn-products-outofstock'];
	    	$xslsn_products_virtualcountry = $xslsn_livesalesnotificationsdata['xslsn-products-virtualcountry'];
	       	//checking if the virtual country is not empty and auto detect is off
	       	if ($xslsn_products_virtualcountry!='' && $xslsn_products_address!='xslsn-auto-detect') {
	    		$xslsn_country = $xslsn_products_virtualcountry;
			}

			//are checking auto detect address option is enable 
			if ($xslsn_products_address==='xslsn-auto-detect') {
				$xslsn_response_extranlapi = wp_remote_get( 'https://extreme-ip-lookup.com/json/' );
				$xslsn_response_extranlapi=json_decode($xslsn_response_extranlapi['body']);
	    		$xswcln_city = $xslsn_response_extranlapi->city;
	    		$xslsn_state = $xslsn_response_extranlapi->state;
	    		$xslsn_country = $xslsn_response_extranlapi->country;

			}
			$minnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-minnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-minnumber']: 1;
          	$maxnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']: 100;
          	$random_number = rand($minnumber,$maxnumber);
          	$custom = str_replace(
          		array(
					'{first_name}',
					'{city}',
					'{state}',
					'{country}',
					'{product}',
					'{product_with_link}',
					'{time_ago}',
					'{number}'
				),
				array(
					$xslsn_firstname,
					$xswcln_city,
					$xslsn_state,
					$xslsn_country,
					esc_attr__($xslsn_productData->get_data()['name']),
					'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
					esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
					$random_number

				), 
				$xslsn_livesalesnotificationsdata['xslsn-message-custom']
			);
			$message = str_replace(
				array(
					'{first_name}',
					'{city}',
					'{state}',
					'{country}',
					'{product}',
					'{product_with_link}',
					'{time_ago}',
					'{custom}',
					'{number}'
				),
				array(
					$xslsn_firstname,
					$xswcln_city,
					$xslsn_state,
					$xslsn_country,
					esc_attr__($xslsn_productData->get_data()['name']),
					'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
					esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
					$xslsn_livesalesnotificationsdata['xslsn-message-custom'],
					$random_number

				),
				$message
			);
			//getting that product out of stock is on then add the product if it is avialbe of not
			if ($xslsn_products_outofstock==='on') {
	            $xslsn_orderItemsData[]  = [
				    			 'xslsn_orderId' =>'',
			    				 'xslsn_productId'=>esc_attr__($xslsn_productIds[0]),
			    				 'xslsn_link'=>esc_attr__($xslsn_link),
			    				 'xslsn_image'=>$xslsn_image,
			    				 'xslsn_title'=>$message,
			    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
			    				 'xslsn_timetoago'=>esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
			    				  	
			    				];
			    
			    	$xslsn_response = [
						'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
						'xslsn_data' =>$xslsn_orderItemsData[0],
						'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
					];			
		    		wp_send_json($xslsn_response);
    		} else {	
    			//checking that if the porudct is in stock then only it will add on the list
    			if ($xslsn_productData->is_in_stock()==1) {
	    			$xslsn_orderItemsData[]  = [
				    			 'xslsn_orderId' =>'',
			    				 'xslsn_productId'=>esc_attr__($xslsn_productIds[0]),
			    				 'xslsn_link'=>esc_attr__($xslsn_link),
			    				 'xslsn_image'=>$xslsn_image,
			    				 'xslsn_title'=>$message,
			    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
			    				 'xslsn_timetoago'=>esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
			    				  	
			    				];
			    
			    	$xslsn_response = [
						'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
						'xslsn_data' =>$xslsn_orderItemsData[0],
						'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
					];			
		    		wp_send_json($xslsn_response);
	    		}
    		}

		}
		} 

		}
		wp_die();
	}
	
	// Function is used when the option is selected as selected product 
	function xslsn_billingtype_latestproduct () 
	{
		//getting the optional data which is saved
		$xslsn_livesalesnotificationsdata = get_option( 'xslsn-live-sale-notification', true );
		$message = $xslsn_livesalesnotificationsdata['xslsn-message-purchased'];
		//getting the product limit
		$xslsn_products_limit=$xslsn_livesalesnotificationsdata['xslsn-products-limit'];
		//getting the virual time 
		$xslsn_products_virtualtime = $xslsn_livesalesnotificationsdata['xslsn-products-virtualtime'];
		//preaparing the quyer for latest product
		$xslsn_args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => $xslsn_products_limit,
					'orderby'        => 'date',
					'order'          => 'DESC',
					'meta_query'     => array(
						
					),
				);
		//getting the ids for latest product
		$xslsn_productIds= [];
		//checking that if it is on single page 
		$xslsn_is_product_details_page = sanitize_text_field($_POST['xslsn_is_product_details_page']);
		$xslsn_current_post_id = sanitize_text_field($_POST['xslsn_current_post_id']);

		$xslsn_latestproducts_the_query = new WP_Query( $xslsn_args );
		if ( $xslsn_latestproducts_the_query->have_posts() ) {
			while ( $xslsn_latestproducts_the_query->have_posts() ) {
				$xslsn_latestproducts_the_query->the_post();
				$xslsn_productIds[]=get_the_ID();
			}	
		}

		$xslsn_singleProduct = [];
		if ($xslsn_is_product_details_page==='1' 
		&& $xslsn_livesalesnotificationsdata['xslsn-productsdetails-runsingleproduct']==='on') {
			$xslsn_singleProduct[] = $xslsn_current_post_id;
			if (in_array($xslsn_current_post_id, $xslsn_productIds)) {
				if ($xslsn_livesalesnotificationsdata['xslsn-productsdetails-notificationshow']==='1') {
					$xslsn_singleProduct = wc_get_related_products(  $xslsn_current_post_id, 10);
					$xslsn_productIds =  $xslsn_singleProduct;
				} else {
					$xslsn_productIds = [$xslsn_current_post_id]; 
				}

			} else {
				return false;
			}
		}

		//getting the hours from virtual time set from settings
		$xslsn_hours = [];
		for ($xslsn_i=1; $xslsn_i <$xslsn_products_virtualtime ; $xslsn_i++) { 
			$xslsn_hours [] =$xslsn_i;
		}
		//getting the virtaul first name an last name
		$xslsn_virtualfirstname = explode(',', $xslsn_livesalesnotificationsdata['xslsn-products-virtualfirstname']);
		$xslsn_virtualcity = explode(',', $xslsn_livesalesnotificationsdata['xslsn-products-virtualcity']);
		//shuffle the diffrent arrays
		shuffle($xslsn_virtualfirstname);
		shuffle($xslsn_virtualcity);
		shuffle($xslsn_hours);
		shuffle($xslsn_productIds);
		//checking that product is on first index
		if (isset($xslsn_productIds[0])) {
			//getting the auto detect address 
        	$xslsn_products_address = $xslsn_livesalesnotificationsdata['xslsn-products-address'];
            //getting the product by id
            $xslsn_productData = wc_get_product( $xslsn_productIds[0] );
            //getting the details page link
            $xslsn_link = $xslsn_productData->get_permalink();
            //getting the product image link
            $xslsn_image = wp_get_attachment_image_src( get_post_thumbnail_id($xslsn_productIds[0]));
	        $xslsn_billing_address = '';
	        $xslsn_firstname = '';
	        $xswcln_city = '';
	        $xslsn_country = '';
	        $xslsn_state='';
	        //Checking that virtual  name is set on first index
	        if (isset($xslsn_virtualfirstname[0])) {
	    		$xslsn_firstname =$xslsn_virtualfirstname[0];
	        
	    	}

	    	//Checking that city is set in array and auto detect is off
	    	if (isset($xslsn_virtualcity[0]) && $xslsn_products_address!='xslsn-auto-detect') {
	    		$xswcln_city = $xslsn_virtualcity[0];
	        
	    	}
	    	//getting the setting data for out of stock
	    	$xslsn_products_outofstock = $xslsn_livesalesnotificationsdata['xslsn-products-outofstock'];
	    	$xslsn_products_virtualcountry = $xslsn_livesalesnotificationsdata['xslsn-products-virtualcountry'];
	       	//checking if the virtual country is not empty and auto detect is off
	       	if ($xslsn_products_virtualcountry!='' && $xslsn_products_address!='xslsn-auto-detect') {
	    		$xslsn_country = $xslsn_products_virtualcountry;
			}

			//are checking auto detect address option is enable 
			if ($xslsn_products_address==='xslsn-auto-detect') {
				$xslsn_response_extranlapi = wp_remote_get( 'https://extreme-ip-lookup.com/json/' );
				$xslsn_response_extranlapi=json_decode($xslsn_response_extranlapi['body']);
	    		$xswcln_city = $xslsn_response_extranlapi->city;
	    		$xslsn_state = $xslsn_response_extranlapi->state;
	    		$xslsn_country = $xslsn_response_extranlapi->country;

			}
			$minnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-minnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-minnumber']: 1;
          	$maxnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']: 100;
          	$random_number = rand($minnumber,$maxnumber);
          	$custom = str_replace(
          		array(
					'{first_name}',
					'{city}',
					'{state}',
					'{country}',
					'{product}',
					'{product_with_link}',
					'{time_ago}',
					'{number}'
				),
				array(
					$xslsn_firstname,
					$xswcln_city,
					$xslsn_state,
					$xslsn_country,
					esc_attr__($xslsn_productData->get_data()['name']),
					'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
					esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
					$random_number

				), 
				$xslsn_livesalesnotificationsdata['xslsn-message-custom']
			);
			$message = str_replace(
				array(
					'{first_name}',
					'{city}',
					'{state}',
					'{country}',
					'{product}',
					'{product_with_link}',
					'{time_ago}',
					'{custom}',
					'{number}'
				),
				array(
					$xslsn_firstname,
					$xswcln_city,
					$xslsn_state,
					$xslsn_country,
					esc_attr__($xslsn_productData->get_data()['name']),
					'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
					esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
					$xslsn_livesalesnotificationsdata['xslsn-message-custom'],
					$random_number

				),
				$message
			);
			//checking if out of stock is on then add the product don't check if it is in stock or not
			if ($xslsn_products_outofstock==='on') {
	            $xslsn_orderItemsData[]  = [
				    			 'xslsn_orderId' =>'',
			    				 'xslsn_productId'=>esc_attr__($xslsn_productIds[0]),
			    				 'xslsn_link'=>esc_attr__($xslsn_link),
			    				 'xslsn_image'=>$xslsn_image,
			    				 'xslsn_title'=>$message ,
			    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
			    				 'xslsn_timetoago'=>esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
			    				  	
			    				];
			    
			    	$xslsn_response = [
						'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
						'xslsn_data' =>$xslsn_orderItemsData[0],
						'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
					];			
		    		wp_send_json($xslsn_response);
    		} else {
    			//checking that product must be in stock
    			if ($xslsn_productData->is_in_stock()==1) {
	    			$xslsn_orderItemsData[]  = [
				    			 'xslsn_orderId' =>'',
			    				 'xslsn_productId'=>esc_attr__($xslsn_productIds[0]),
			    				 'xslsn_link'=>esc_attr__($xslsn_link),
			    				 'xslsn_image'=>$xslsn_image,
			    				 'xslsn_title'=>$message,
			    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
			    				 'xslsn_timetoago'=>esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
			    				  	
			    				];
			    
			    	$xslsn_response = [
						'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
						'xslsn_data' =>$xslsn_orderItemsData[0],
						'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
					];			
		    		wp_send_json($xslsn_response);
	    		}
    		}

		}
		wp_die();

	}

	// Function is used when the option is selected as selected product
	function xslsn_billingtype_selectedproduct () 
	{
		//getting the data for all the saved options
		$xslsn_livesalesnotificationsdata = get_option( 'xslsn-live-sale-notification', true );
		$message = $xslsn_livesalesnotificationsdata['xslsn-message-purchased'];
		//getting the virtual time 
		$xslsn_products_virtualtime = $xslsn_livesalesnotificationsdata['xslsn-products-virtualtime'];
		//checking that if it is on single page 
		$xslsn_is_product_details_page = sanitize_text_field($_POST['xslsn_is_product_details_page']);
		$xslsn_current_post_id = sanitize_text_field($_POST['xslsn_current_post_id']);
		
		$xslsn_singleProduct = [];
		if ($xslsn_is_product_details_page==='1' 
		&& $xslsn_livesalesnotificationsdata['xslsn-productsdetails-runsingleproduct']==='on') {
			$xslsn_singleProduct[] = $xslsn_current_post_id;
			if (in_array($xslsn_current_post_id, $xslsn_livesalesnotificationsdata['xslsn-products-select'])) {
				if ($xslsn_livesalesnotificationsdata['xslsn-productsdetails-notificationshow']==='1') {
					$xslsn_singleProduct = wc_get_related_products(  $xslsn_current_post_id, 10);
					$xslsn_livesalesnotificationsdata['xslsn-products-select'] =  $xslsn_singleProduct;
				} else {
					$xslsn_livesalesnotificationsdata['xslsn-products-select'] = [$xslsn_current_post_id]; 
				}

			} else {
				return false;
			}
		}
		//shuffle the selected product
		shuffle($xslsn_livesalesnotificationsdata['xslsn-products-select']);
			
		//getting hours array which is set from admin panel
		$xslsn_hours = [];
		for ($xslsn_i=1; $xslsn_i <$xslsn_products_virtualtime ; $xslsn_i++) { 
			$xslsn_hours [] =$xslsn_i;
		}
		//getting the virtual name and city from settings data
		$xslsn_virtualfirstname = explode(',', $xslsn_livesalesnotificationsdata['xslsn-products-virtualfirstname']);
		$xslsn_virtualcity = explode(',', $xslsn_livesalesnotificationsdata['xslsn-products-virtualcity']);
		//shuffle all the arrays
		shuffle($xslsn_virtualfirstname);
		shuffle($xslsn_virtualcity);
		shuffle($xslsn_hours);
		//checking that if the product is exsit on first index
 		if (isset($xslsn_livesalesnotificationsdata['xslsn-products-select'][0])) {
        	//getting the product address
        	$xslsn_products_address = $xslsn_livesalesnotificationsdata['xslsn-products-address'];
            //getting the selected products
            $xslsn_productData = wc_get_product( $xslsn_livesalesnotificationsdata['xslsn-products-select'][0] );
            //getting the link of the product
            $xslsn_link = $xslsn_productData->get_permalink();
            //getting the image of the product
            $xslsn_image = wp_get_attachment_image_src( get_post_thumbnail_id($xslsn_livesalesnotificationsdata['xslsn-products-select'][0] ));
	        
	        $xslsn_firstname = '';
	        $xswcln_city = '';
	        $xslsn_country = '';
	        $xslsn_state='';
	        //Checking that virtual  name is set on first index
	        if (isset($xslsn_virtualfirstname[0])) {
	    		$xslsn_firstname = $xslsn_virtualfirstname[0].' ';
	        
	    	}

	    	//Checking that city is set in array and auto detect is off
	    	if (isset($xslsn_virtualcity[0]) && $xslsn_products_address!='xslsn-auto-detect') {
	    		$xswcln_city = $xslsn_virtualcity[0];
	        
	    	}
	    	//getting the value of out of stock is enable or not
	    	$xslsn_products_outofstock = $xslsn_livesalesnotificationsdata['xslsn-products-outofstock'];
	    	//getting the virtaul country
	    	$xslsn_products_virtualcountry = $xslsn_livesalesnotificationsdata['xslsn-products-virtualcountry'];
	       	//checking if the virtual country is not empty and auto detect is off
	       	if ($xslsn_products_virtualcountry!='' && $xslsn_products_address!='xslsn-auto-detect') {
	    		$xslsn_country = $xslsn_products_virtualcountry;
			}

			//are checking auto detect address option is enable 
			if ($xslsn_products_address==='xslsn-auto-detect') {
				$xslsn_response_extranlapi = wp_remote_get( 'https://extreme-ip-lookup.com/json/' );
				$xslsn_response_extranlapi=json_decode($xslsn_response_extranlapi['body']);
	    		$xswcln_city = $xslsn_response_extranlapi->city;
	    		$xslsn_state = $xslsn_response_extranlapi->state;
	    		$xslsn_country = $xslsn_response_extranlapi->country;

			}
			//checking that if the out of stock in on then all the products are inluded if they are not in stock
			$minnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-minnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-minnumber']: 1;
          	$maxnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']: 100;
          	$random_number = rand($minnumber,$maxnumber);
          	$custom = str_replace(
          		array(
					'{first_name}',
					'{city}',
					'{state}',
					'{country}',
					'{product}',
					'{product_with_link}',
					'{time_ago}',
					'{number}'
				),
				array(
					$xslsn_firstname,
					$xswcln_city,
					$xslsn_state,
					$xslsn_country,
					esc_attr__($xslsn_productData->get_data()['name']),
					'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
					esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
					$random_number

				), 
				$xslsn_livesalesnotificationsdata['xslsn-message-custom']
			);
			$message = str_replace(
				array(
					'{first_name}',
					'{city}',
					'{state}',
					'{country}',
					'{product}',
					'{product_with_link}',
					'{time_ago}',
					'{custom}',
					'{number}'
				),
				array(
					$xslsn_firstname,
					$xswcln_city,
					$xslsn_state,
					$xslsn_country,
					esc_attr__($xslsn_productData->get_data()['name']),
					'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
					esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
					$xslsn_livesalesnotificationsdata['xslsn-message-custom'],
					$random_number

				),
				$message
			);
			if ($xslsn_products_outofstock==='on') {
	            $xslsn_orderItemsData[]  = [
				    			 'xslsn_orderId' =>'',
			    				 'xslsn_productId'=>esc_attr__($xslsn_livesalesnotificationsdata['xslsn-products-select'][0]),
			    				 'xslsn_link'=>esc_attr__($xslsn_link),
			    				 'xslsn_image'=>$xslsn_image,
			    				 'xslsn_title'=>$message,
			    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
			    				 'xslsn_timetoago'=>esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
			    				  	
			    				];
			    
			    	$xslsn_response = [
						'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
						'xslsn_data' =>$xslsn_orderItemsData[0],
						'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
					];			
		    		wp_send_json($xslsn_response);
    		} else {
    			//checking that product must be in stock
    			if ($xslsn_productData->is_in_stock()==1) {
	    			$xslsn_orderItemsData[]  = [
				    			 'xslsn_orderId' =>'',
			    				 'xslsn_productId'=>esc_attr__($xslsn_livesalesnotificationsdata['xslsn-products-select'][0]),
			    				 'xslsn_link'=>esc_attr__($xslsn_link),
			    				 'xslsn_image'=>$xslsn_image,
			    				 'xslsn_title'=>$message,
			    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
			    				 'xslsn_timetoago'=>esc_attr__($xslsn_hours[0]).esc_html__('  hours ago', 'xslsn-live-sale-notification'),
			    				  	
			    				];
			    
			    	$xslsn_response = [
						'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
						'xslsn_data' =>$xslsn_orderItemsData[0],
						'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
					];			
		    		wp_send_json($xslsn_response);
	    		}
    		}

		}
       	wp_die();
	}

	//Function is called when the billing type is 0
	function xslsn_billingtype_billing() {
		//getting all the option saved in database
		$xslsn_livesalesnotificationsdata = get_option( 'xslsn-live-sale-notification', true );
		$message = $xslsn_livesalesnotificationsdata['xslsn-message-purchased'];
		
		//checking that if it is on single page 
		$xslsn_is_product_details_page = sanitize_text_field($_POST['xslsn_is_product_details_page']);
		$xslsn_current_post_id = sanitize_text_field($_POST['xslsn_current_post_id']);
		
		$xslsn_singleProduct = [];
		if ($xslsn_is_product_details_page==='1' 
		&& $xslsn_livesalesnotificationsdata['xslsn-productsdetails-runsingleproduct']==='on') {
			$xslsn_singleProduct[] = $xslsn_current_post_id;
			if ($xslsn_livesalesnotificationsdata['xslsn-productsdetails-notificationshow']==='1') {
				$xslsn_singleProduct = wc_get_related_products(  $xslsn_current_post_id, 10); 
			}			
		}

		
		
		//getting the products which is exlcluded
		$xslsn_excludeProduct = isset($xslsn_livesalesnotificationsdata['xslsn-products-exclude']) ? $xslsn_livesalesnotificationsdata['xslsn-products-exclude'] : array();
		//getting the order status which is requrires
		$xslsn_statuses = $xslsn_livesalesnotificationsdata['xslsn-products-orderstatus'];
		$xslsn_products_outofstock = $xslsn_livesalesnotificationsdata['xslsn-products-outofstock'];
		//getting the order type
		$xslsn_products_ordertime_type = $xslsn_livesalesnotificationsdata['xslsn-products-ordertime-type'];
		//getting order from time  which needs to be used in quyer
		$xslsn_products_ordertime = $xslsn_livesalesnotificationsdata['xslsn-products-ordertime'];
		if ($xslsn_products_ordertime_type==='xslsn_days') {
			$xslsn_products_ordertime_type ='days';
		}
		if ($xslsn_products_ordertime_type==='xslsn_hours') {
			$xslsn_products_ordertime_type ='hours';
		}
		if ($xslsn_products_ordertime_type==='xslsn_minutes') {
			$xslsn_products_ordertime_type ='minutes';
		}
		//getting the time stamp if order time is not empty and order type
		if ($xslsn_products_ordertime!='' && $xslsn_products_ordertime_type!='') {
			$xslsn_current_time = strtotime( "-" .$xslsn_products_ordertime . " " .$xslsn_products_ordertime_type);
			$xslsn_timestamp    = wp_date( 'Y-m-d G:i:s', $xslsn_current_time )."...".wp_date( 'Y-m-d G:i:s',strtotime('now') );
		}

		//getting the woocomerce orders		
		$xslsn_orders = wc_get_orders( array('numberposts' => -1, 'status'=>$xslsn_statuses,
		       'date_created' => $xslsn_timestamp,
		) );

		// Loop through each WC_Order object
		$xslsn_orderItemsData = [];
		foreach( $xslsn_orders as $xslsn_order ){
			$xslsn_billingData = $xslsn_order->get_data()['billing'];
			//loop on the orders items	
		    foreach ($xslsn_order->get_items() as $xslsn_order_items) {
		    	$xslsn_order_item_data = $xslsn_order_items->get_data();
		    	$xslsn_billing_address = '';
		    	//gettng the product by id
		    	if(!$xslsn_order_item_data['product_id']){
		    		continue;
		    	}
	            $xslsn_productData = wc_get_product( $xslsn_order_item_data['product_id']);
	            $xslsn_productdata = $xslsn_productData->get_data(); 

	            //getting the product link
				$xslsn_link = get_permalink($xslsn_order_item_data['product_id']);
				//getting the product image
	            $xslsn_image = wp_get_attachment_image_src( get_post_thumbnail_id( $xslsn_order_item_data['product_id'] ));
	          	$xslsn_billing_address='';
		        $xslsn_firstname = '';
		        $xswcln_city = '';
		        $xslsn_country = '';
		        $xslsn_state='';
	          	//getting the billing address of user
	          	if(isset($xslsn_billingData['city'])) {
	          		$xslsn_firstname = $xslsn_billingData['first_name'];
	          		$xswcln_city = $xslsn_billingData['city'];
	          		$xslsn_state = $xslsn_billingData['state'];
	          		$xslsn_country = $xslsn_billingData['country'];
	          	}
	          	$minnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-minnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-minnumber']: 1;
	          	$maxnumber = isset($xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']) ? $xslsn_livesalesnotificationsdata['xslsn-message-maxnumber']: 100;
	          	$random_number = rand($minnumber,$maxnumber);
	          	$custom = str_replace(
	          		array(
						'{first_name}',
						'{city}',
						'{state}',
						'{country}',
						'{product}',
						'{product_with_link}',
						'{time_ago}',
						'{number}'
					),
					array(
						$xslsn_firstname,
						$xswcln_city,
						$xslsn_state,
						$xslsn_country,
						esc_attr__($xslsn_productData->get_data()['name']),
						'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
						esc_attr__(xslsn_time_elapsed_string($xslsn_order->get_data()['date_created']->date('Y-m-d H:i:s'))),
						$random_number

					), 
					$xslsn_livesalesnotificationsdata['xslsn-message-custom']
				);
	          	$message = str_replace(
					array(
						'{first_name}',
						'{city}',
						'{state}',
						'{country}',
						'{product}',
						'{product_with_link}',
						'{time_ago}',
						'{custom}',
						'{number}'
					),
					array(
						$xslsn_firstname,
						$xswcln_city,
						$xslsn_state,
						$xslsn_country,
						esc_attr__($xslsn_productData->get_data()['name']),
						'<a herf="'.esc_attr__($xslsn_link).'"'.esc_attr__($xslsn_productData->get_data()['name']).'</a>',
						esc_attr__(xslsn_time_elapsed_string($xslsn_order->get_data()['date_created']->date('Y-m-d H:i:s'))),
						$xslsn_livesalesnotificationsdata['xslsn-message-custom'],
						$random_number

					),
					$message
				);

	          	//checkingg  order and product id is already saved in cookies or not
	          	if (isset($_COOKIE['xslsn_vieworderdetails_'.$xslsn_order_item_data['order_id'].'_'.$xslsn_order_item_data['product_id']]) && $_COOKIE['xslsn_vieworderdetails_'.$xslsn_order_item_data['order_id'].'_'.$xslsn_order_item_data['product_id']]==='1') {
	          	} else {
	          		//This Check is used when page is detail and it is enable from settings tab
		          	if (!empty($xslsn_singleProduct)) {
		          		if (in_array($xslsn_order_item_data['product_id'], $xslsn_singleProduct)) {
		          			$xslsn_orderItemsData[]  = [
			    			 'xslsn_orderId' =>esc_attr__($xslsn_order_item_data['order_id']),
		    				 'xslsn_productId'=>esc_attr__($xslsn_order_item_data['product_id']),
		    				 'xslsn_link'=>esc_attr__($xslsn_link),
		    				 'xslsn_image'=>$xslsn_image,
		    				 'xslsn_title'=>$message,
		    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
		    				 'xslsn_timetoago'=>esc_attr__(xslsn_time_elapsed_string($xslsn_order->get_data()['date_created']->date('Y-m-d H:i:s'))),
		    				  	
		    				];
		          		}	
		          	}  else {
		          		$xslsn_orderItemsData[]  = [
			    			 'xslsn_orderId' =>esc_attr__($xslsn_order_item_data['order_id']),
		    				 'xslsn_productId'=>esc_attr__($xslsn_order_item_data['product_id']),
		    				 'xslsn_link'=>esc_attr__($xslsn_link),
		    				 'xslsn_image'=>$xslsn_image,
		    				 'xslsn_title'=>$message,
		    				 'xslsn_productname'=>esc_attr__($xslsn_productData->get_data()['name']),
		    				 'xslsn_timetoago'=>esc_attr__(xslsn_time_elapsed_string($xslsn_order->get_data()['date_created']->date('Y-m-d H:i:s'))),
		    				  	
		    				];
		          	}

				          	
	    		}		
		    }
		}
    	
    	//are used to check if the items are excluded or not 
		foreach ($xslsn_orderItemsData as $xslsn_orderItemsKey=>$xslsn_orderItems) {
			if (in_array($xslsn_orderItems['xslsn_productId'], $xslsn_excludeProduct)) {
				unset($xslsn_orderItemsData[$xslsn_orderItemsKey]);
			} 
			//are used to check that proudct is out of stock or not
			if($xslsn_products_outofstock!='on') {
				//getting the product by id to check it is in stock or not
	            $xslsn_product = wc_get_product( $xslsn_orderItems['xslsn_productId'] );
	            if ($xslsn_product->is_in_stock()!=1) {
	            	unset($xslsn_orderItemsData[$xslsn_orderItemsKey]);
	            }
	           
			}
		}
		//reseting the array index		
		$xslsn_orderItemsData = array_values($xslsn_orderItemsData);
		//getting the first index
		if (isset($xslsn_orderItemsData[0])) {
			//saving the  cookies so next time this notifcation never shown to the same browsers
			setcookie("xslsn_vieworderdetails_".$xslsn_orderItemsData[0]['xslsn_orderId'].'_'.$xslsn_orderItemsData[0]['xslsn_productId'], '1', time()+30*24*60*60);

			$xslsn_response = [
				'xslsn_status' =>esc_html__('true', 'xslsn-live-sale-notification'),
				'xslsn_data' =>$xslsn_orderItemsData[0],
				'xslsn_message' =>esc_html__('Record Found', 'xslsn-live-sale-notification'),
			];
		} else {
			$xslsn_response = [
				'xslsn_status' =>esc_html__('false', 'xslsn-live-sale-notification'),
				'xslsn_data' =>[],
				'xslsn_message' =>esc_html__('No Record Found', 'xslsn-live-sale-notification'),
			];
		}

		wp_send_json($xslsn_response);
		wp_die();
	}

	function xslsn_time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => esc_html__('year', 'xslsn-live-sale-notification'),
	        'm' =>  esc_html__('month', 'xslsn-live-sale-notification'),
	        'w' =>  esc_html__('week', 'xslsn-live-sale-notification'),
	        'd' =>  esc_html__('day', 'xslsn-live-sale-notification'),
	        'h' =>  esc_html__('hour', 'xslsn-live-sale-notification'),
	        'i' =>  esc_html__('minute', 'xslsn-live-sale-notification'),
	        's' =>  esc_html__('second', 'xslsn-live-sale-notification'),
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . esc_html__(' ago', 'xslsn-live-sale-notification') :  esc_html__('just now', 'xslsn-live-sale-notification');
	}
	//Function is apply on the single page to add the recenet viewed product in cookies 
	function xslsn_addrecentviewedproductsids () {
		//checking that it is singel page for product
		if ( ! is_singular( 'product' ) ) {
			return;
		} 
		global $post;
		//checking that if xslsn_recentviewedproductsids saved in cookies or not
		if ( empty( $_COOKIE['xslsn_recentviewedproductsids'] ) ) { 
			$xslsn_viewed_products = array();
		} else {
			//getting the saved product ids
			$cookies = sanitize_text_field(wp_unslash( $_COOKIE['xslsn_recentviewedproductsids']));
			$xslsn_viewed_products = wp_parse_id_list( (array) explode( '|', $cookies) ); 
		
		}
		
		// removed if producd id is there
		$xslsn_keys = array_flip( $xslsn_viewed_products );
		if ( isset( $xslsn_keys[ $post->ID ] ) ) {
			unset( $xslsn_viewed_products[ $xslsn_keys[ $post->ID ] ] );
		}

		$xslsn_viewed_products[] = $post->ID;
		if ( count( $xslsn_viewed_products ) > 15 ) {
			array_shift( $xslsn_viewed_products );
		}
		// saving the products in recent viewed list
		wc_setcookie( 'xslsn_recentviewedproductsids', implode( '|', $xslsn_viewed_products ) );
		
	}
?>