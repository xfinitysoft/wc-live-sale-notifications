<?php 
	
	/**
	 * This hook is used to enque scripts for admin side.
	*/
	add_action('admin_enqueue_scripts', 'xslsn_enqueue_css_js_files');

	/**
	 * Including scripts and css for Admin side.
	*/
	function xslsn_enqueue_css_js_files() 
	{   
		
	    wp_enqueue_style('select2CSS', plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-css/select2.min.css', false, '1.0', 'all' );
	    wp_enqueue_script('select2JS', plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-js/select2.min.js', array( 'jquery' ), '1.0', true );
	    
	    wp_enqueue_style('xslsn-customcss',plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-css/xslsn-style.css');
		wp_enqueue_script("xslsn-adminarea", plugin_dir_url( __DIR__ ).'xslsn-assets/xslsn-js/xslsn-adminarea.js',array('jquery'),'1.0',true);
	}

	//adding the action for sidebar menu of plugin
	add_action( 'admin_menu', 'xslsn_options_page' );
	// Create menu for plugin
	function xslsn_options_page() {
		add_menu_page(
			__( 'Woo Live Sale Notification', 'xslsn-live-sale-notification' ),
			__( 'Woo Live Sale Notification', 'xslsn-live-sale-notification' ),
			'manage_options',
			'woocommerce_live_sale',
			'xslsn_setting_page_woo_live_sales_notifications',
			'dashicons-megaphone',2
		);
		add_submenu_page( 
			'woocommerce_live_sale',
			esc_html__( 'Support' , 'xswpph-domain' ), 
			esc_html__( 'Support' , 'xswpph-domain'  ), 
			'manage_options',
			'xslsn-support',
			'xslsn_support',
		);
	}
	//Function i used to render the live sales notifications admin tabs
	function xslsn_support () {
		//checking that woocommerce has been install or not
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    		require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-support.php");
		}
	}
	//Function i used to render the live sales notifications admin tabs
	function xslsn_setting_page_woo_live_sales_notifications () {
		//checking that woocommerce has been install or not
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    	require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-notifications-templates.php");
		?>


		<br><br><br><br>
		<!-- Tabs name for settings on admin panel -->
		<ul id="xslsn-tabs" class="nav-tab-wrapper xslsn-nav-tab-wrapper">
		  <li><a class="nav-tab nav-tab-active"
		      id="xslsn-tab1"><?php esc_html_e( 'General', 'xslsn-live-sale-notification'); ?></a></li>
		  <li><a class="nav-tab" id="xslsn-tab2"><?php esc_html_e( 'Design', 'xslsn-live-sale-notification'); ?></a></li>
		  <li><a class="nav-tab" id="xslsn-tab3"><?php esc_html_e( 'Message', 'xslsn-live-sale-notification'); ?></a></li>
		  <li><a class="nav-tab" id="xslsn-tab4"><?php esc_html_e( 'Products', 'xslsn-live-sale-notification'); ?></a></li>
		  <li><a class="nav-tab" id="xslsn-tab5"><?php esc_html_e( 'Product Detail', 'xslsn-live-sale-notification'); ?></a>
		  </li>
		  <li><a class="nav-tab" id="xslsn-tab6"><?php esc_html_e( 'Time', 'xslsn-live-sale-notification'); ?></a></li>
		  <li><a class="nav-tab" id="xslsn-tab7"><?php esc_html_e( 'Assign', 'xslsn-live-sale-notification'); ?></a></li>
		</ul>
		<form class="" method="post" action="">
		  <input type="hidden" value="<?php esc_attr_e(plugin_dir_url( __DIR__ )); ?>" id="xslsn-plugindirpath">
		  <?php 
				    wp_nonce_field( 'xslsn_action_nonce', '_xslsn_liveSaleNotification_nonce' );
					settings_fields( 'xslsn-live-sale-notification' );
					do_settings_sections( 'xslsn-live-sale-notification' );	
					//For the General Tab 
			    	require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-general-tab.php");
			    	//End General Tab
					
					//For the Design Tab 
			    	require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-design-tab.php");
			    	//End Design Tab

			    	//For the Message Tab 
			    	require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-message-tab.php");
			    	//End Message Tab

			    	//For the Product Tab 
			    	require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-products-tab.php");
			    	//End Product Tab

			    	//For the product details
					require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-productsdetails-tab.php");
			    	//end of product details

			    	//For the time tab
					require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-time-tab.php");
			    	//end of time tab
			    	//For the assing tab
					require_once(plugin_dir_path(__FILE__)."../xslsn-includes/xslsn-assign-tab.php");
				?>
		  <br>
		  <button
		    class="button button-primary button-large"><?php echo esc_html__( 'Save Changes', 'xslsn-live-sale-notification' ) ?>
		  </button>
		</form>

		<?php
		} else {
			esc_html_e('Please intall the woocommerce plugin first to use this plugin', 'xslsn-live-sale-notification');
		}
	}

	//action for saving the data
	add_action( 'admin_init', 'xslsn_save_data');
	//saving the options data into database
	function xslsn_save_data() {

		if ( ! current_user_can( 'manage_options' ) ) {
		return false;
		}
		if ( ! isset( $_POST['_xslsn_liveSaleNotification_nonce'] ) || ! 
		wp_verify_nonce( $_POST['_xslsn_liveSaleNotification_nonce'], 'xslsn_action_nonce' ) ) {
		return false;
		}
		$xslsn_data = wc_clean( $_POST['xslsn-live-sale-notification'] );
		update_option( 'xslsn-live-sale-notification', $xslsn_data );
	}

	//this function is used to retun the saved value of settings
	function xslsn_get_field( $xslsn_field, $xslsn_default = '' ) {
		$xslsn_params = get_option('xslsn-live-sale-notification',true);
		if (isset( $xslsn_params[$xslsn_field ] ) && $xslsn_field ) {
			return $xslsn_params[$xslsn_field ];
		} else {
			return $xslsn_default;
		}
	}
	add_action('wp_ajax_xslsn_send_mail','xslsn_send_mail');
	function xslsn_send_mail(){
		$data = array();
        parse_str($_POST['data'], $data);
        $data['plugin_name'] = 'Live Sale Notification';
        $data['version'] = 'lite';
        $data['website'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
        $to = 'xfinitysoft@gmail.com';
        switch ($data['type']) {
            case 'report':
                $subject = 'Report a bug';
                break;
            case 'hire':
                $subject = 'Hire us to customize/develope Plugin/Theme or WordPress projects';
                break;
            
            default:
                $subject = 'Request a Feature';
                break;
        }
        
        $body = '<html><body><table>';
        $body .='<tbody>';
        $body .='<tr><th>User Name</th><td>'.$data['xs_name'].'</td></tr>';
        $body .='<tr><th>User email</th><td>'.$data['xs_email'].'</td></tr>';
        $body .='<tr><th>Plugin Name</th><td>'.$data['plugin_name'].'</td></tr>';
        $body .='<tr><th>Version</th><td>'.$data['version'].'</td></tr>';
        $body .='<tr><th>Website</th><td><a href="'.$data['website'].'">'.$data['website'].'</a></td></tr>';
        $body .='<tr><th>Message</th><td>'.$data['xs_message'].'</td></tr>';
        $body .='</tbody>';
        $body .='</table></body></html>';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $params ="name=".$data['xs_name'];
        $params.="&email=".$data['xs_email'];
        $params.="&site=".$data['website'];
        $params.="&version=".$data['version'];
        $params.="&plugin_name=".$data['plugin_name'];
        $params.="&type=".$data['type'];
        $params.="&message=".$data['xs_message'];
        $sever_response = wp_remote_post("https://xfinitysoft.com/wp-json/plugin/v1/quote/save/?".$params);
        $se_api_response = json_decode( wp_remote_retrieve_body( $sever_response ), true );
        
        if($se_api_response['status']){
            $mail = wp_mail( $to, $subject, $body, $headers );
            wp_send_json(array('status'=>true));
        }else{
            wp_send_json(array('status'=>false));
        }
        wp_die();
	}
?>