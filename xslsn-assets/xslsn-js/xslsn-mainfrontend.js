//This file is used to for front end 
(function($){
	'use strict';
	$('document').ready(function() {
		//This function is called on page on load that any popup is remaing or not.
		if(window.matchMedia("(max-width: 767px)").matches && !xslsn_optionsdata.xslsn_data['xslsn-enable-notification-mobile']){
			
		} else {
			//getting the data for all saved options
			var xslsn_data= xslsn_optionsdata.xslsn_data;
			//calling the function to load the popup
			xslsn_getPopupdata();
			//setting the time to run the popup how many times 
			setTimeout(function(){
				var xslsn_notification_perpage = 0;
				setInterval(function(){
					xslsn_notification_perpage = xslsn_notification_perpage+1;
					if (10 > xslsn_notification_perpage) {
						xslsn_getPopupdata();
					}
					
				},11000);
			
			},11000);
		}
		//function is used  to laod the popup data form ajax call
		function xslsn_getPopupdata () {
			//settings the parms for popup data
			var xslsn_popupdata = 
				{
					xslsn_billingtype: xslsn_optionsdata.xslsn_data.xslsn_products_billing,
					xslsn_is_product_details_page: xslsn_optionsdata.xslsn_data.is_product_details_page,
					xslsn_current_post_id: xslsn_optionsdata.xslsn_data.current_post_id,
					action: 'xslsn_getPopupdata'
				};
			//This is used to update the modal data 
			jQuery.ajax({
			type: "post",
			dataType: "json",
			url: xslsn_optionsdata.my_ajax_object,
			data: xslsn_popupdata,
			success: function(xslsn_response){
				if (xslsn_response.xslsn_status==='true') {
					//function is call to load the notification modal data
					xslsn_loadTheNotifcationModal(xslsn_response.xslsn_data);
				}
			}});	
		}

		//Function is used to load the notification modal data
		function xslsn_loadTheNotifcationModal (xslsn_modaldata) {
			var xslsn_saveddata=xslsn_optionsdata.xslsn_data; 
			$('.xslsn-admin-modalmain').show();
			if (xslsn_modaldata.xslsn_image) {
				if (xslsn_modaldata.xslsn_image[0]) {
					$('.xslsn-admin-modalmain-firstdiv-img').attr('src', xslsn_modaldata.xslsn_image[0]);
				}
 				
			}
		    
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style3' || xslsn_saveddata['xslsn-template-style']==='xslsn_style5' || xslsn_saveddata['xslsn-template-style']==='xslsn_style4') {
				$('.xslsn-admin-modalmain-seconddiv-title').html(xslsn_modaldata.xslsn_title+' <a class="xslsn-admin-modalmain-seconddiv-title-a"></a>');
			} else {
				$('.xslsn-admin-modalmain-seconddiv-title').html(xslsn_modaldata.xslsn_title);
			}	
			$('.xslsn-admin-modalmain-seconddiv-title-a').html(xslsn_modaldata.xslsn_productname);
			$('.xslsn-admin-modalmain-seconddiv-abouttoago').html(xslsn_modaldata.xslsn_timetoago);
			if (xslsn_saveddata['xslsn-imageredirect']) {
				$('.xslsn-admin-modalmain-seconddiv-title-a').attr('href', xslsn_modaldata.xslsn_link);
			}
			if (xslsn_saveddata['xslsn-linktarget']) {
				$('.xslsn-admin-modalmain-seconddiv-title-a').attr('target', '_blank');
			}
			//Calling the function to apply the desing which is set in admin area
			if(xslsn_optionsdata.sound_enable === 'on'){
				xslsn_playsound();
			}
			xslsn_loadadminareadesing();
		}
		//Function is used to setup the desing of modal
		function xslsn_loadadminareadesing () {
			var xslsn_saveddata=xslsn_optionsdata.xslsn_data; 
			var xslsn_highlight_color = xslsn_saveddata['xslsn-highlight-color'];
			var xslsn_text_color = xslsn_saveddata['xslsn-text-color'];
			var xslsn_imagepadding = xslsn_saveddata['xslsn-imagepadding'];
			var xslsn_background_color = xslsn_saveddata['xslsn-background-color'];
			var xslsn_plugindirpath = $('#xslsn-plugindirpath').val();
			var xslsn_position = xslsn_saveddata['xslsn-position'];
			$('.xslsn-admin-modalmain-seconddiv-title-a').css('color', xslsn_highlight_color);
			$('.xslsn-admin-modalmain-seconddiv-title').css('color', xslsn_text_color);
			$('.xslsn-sf-design-thumbnail').css('padding', xslsn_imagepadding);

			
			//Hide all the Modals
			$('.xslsn-notitemp-style1').hide();
			$('.xslsn-notitemp-style2').hide();
			$('.xslsn-notitemp-style3').hide();
			$('.xslsn-notitemp-style4').hide();
			$('.xslsn-notitemp-style5').hide();
			$('.xslsn-admin-modalmain').css('border-color', 'transparent');
			//checking which style needs to apply
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style1'){
				$('.xslsn-notitemp-style1').show();
				$('.xslsn-admin-modalmain').css('background', xslsn_background_color);
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style2'){
				$('.xslsn-notitemp-style1').show();
				$('.xslsn-admin-modalmain').css('background', xslsn_background_color);
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style3'){
				$('.xslsn-notitemp-style1').show();
				$('.xslsn-admin-modalmain').css('background', xslsn_background_color);
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style4'){
				$('.xslsn-notitemp-style2').show();
				$('.xslsn-admin-modalmain').css('background', 'white');
				$('.xslsn-admin-modalmain').css('border-color', xslsn_background_color);
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style5'){
				$('.xslsn-notitemp-style2').show();
				$('.xslsn-admin-modalmain').css('background', 'white');
				$('.xslsn-admin-modalmain').css('border-color', xslsn_background_color);
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style6'){
				$('.xslsn-notitemp-style2').show();
				$('.xslsn-admin-modalmain').css('background', 'white');
				$('.xslsn-admin-modalmain').css('border-color', xslsn_background_color);
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style7'){
				$('.xslsn-notitemp-style3').show();
				$('.xslsn-admin-modalmain-rect').attr('fill', xslsn_background_color);
				$('.xslsn-admin-modalmain').css('background', 'white');
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style8'){
				$('.xslsn-notitemp-style3').show();
				$('.xslsn-admin-modalmain-rect').attr('fill', xslsn_background_color);
				$('.xslsn-admin-modalmain').css('background', 'white');
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style9'){
				$('.xslsn-notitemp-style3').show();
				$('.xslsn-admin-modalmain-rect').attr('fill', xslsn_background_color);
				$('.xslsn-admin-modalmain').css('background', 'white');
			}
			
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style10') {
				$('.xslsn-notitemp-style4').show();
				$('.xslsn-admin-modalmain').css('background', 'white');
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style11') {
				$('.xslsn-notitemp-style4').show();
				$('.xslsn-admin-modalmain').css('background', 'white');
			}
			if (xslsn_saveddata['xslsn-template-style']==='xslsn_style12') {
				$('.xslsn-notitemp-style5').show();
				$('.xslsn-admin-modalmain').css('background', 'white');
			}
			
			//are used to check what is the position
			if (xslsn_saveddata['xslsn-position']==='xslsn_position_right') {
				$('.xslsn-solid-fill-design-body,.xslsn-left-rounded-design-body').addClass('xslsn-position-right');
				$('.xslsn-sf-design-content-close').css('right', '15px');
			} else {
				$('.xslsn-solid-fill-design-body,.xslsn-left-rounded-design-body').removeClass('xslsn-position-right');
				$('.xslsn-sf-design-content-close').css('right', '0px');
			}
			//For bottom left checkbox
			$('.xslsn-admin-modalmain').removeClass('xslsn-position-frontend-bottomleft');
			$('.xslsn-admin-modalmain').removeClass('xslsn-position-bottomright');
			$('.xslsn-admin-modalmain').removeClass('xslsn-position-frontend-topleft');
			$('.xslsn-admin-modalmain').removeClass('xslsn-position-topright');
			
			if (xslsn_saveddata['xslsn-template-position']==='xslsn_position_bottomleft') {
				$('.xslsn-admin-modalmain').addClass('xslsn-position-frontend-bottomleft');
			}
			if (xslsn_saveddata['xslsn-template-position']==='xslsn_position_bottomright') {
				$('.xslsn-admin-modalmain').addClass('xslsn-position-bottomright');
			}
			if (xslsn_saveddata['xslsn-template-position']==='xslsn_position_topleft') {
				$('.xslsn-admin-modalmain').addClass('xslsn-position-frontend-topleft');
			}
			if (xslsn_saveddata['xslsn-template-position']==='xslsn_position_topright') {
				$('.xslsn-admin-modalmain').addClass('xslsn-position-topright');
			}
			
			//are used to check border corner is enable or not
			if (xslsn_saveddata['xslsn-enableroundcornerborder']) {
				$('.xslsn-admin-modalmain').addClass('xslsn-admin-modalmain-borderradius');
				$('.xslsn-admin-modalmain-firstdiv-img').addClass('xslsn-admin-modalmain-borderradius');
			} else {
				$('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
				$('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
				var xslsn_custom_rounded_corner =xslsn_saveddata['xslsn-custom-rounded-corner'];
				$('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner+'px');
				$('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner+'px');
			}
			//are used to check close icon is show or not
			if (xslsn_saveddata['xslsn-showcloseicon']) {
				$('.xslsn-closeicon').show();
				$('.xslsn-sf-design-content-close').show();
				var xslsn_closeiconcolor = xslsn_saveddata['xslsn-closeiconcolor'];
				$('.xslsn-closeicon').css('color', xslsn_closeiconcolor);
			} else {
				$('.xslsn-closeicon').hide();
				$('.xslsn-sf-design-content-close').hide();
			}
			xslsn_noticloseModales();
			
		}
		//after clicking on close icon closing the modal on that much of time
		$('.xslsn-closeicon').on('click', function(){
			var xslsn_saveddata=xslsn_optionsdata.xslsn_data; 
			setTimeout(function(){
				xslsn_noticloseModales();
			},3000);

		});
		//function is used to close the modal 
		function xslsn_noticloseModales () {
			var xslsn_saveddata=xslsn_optionsdata.xslsn_data; 
			setTimeout(function(){
				//Hide all the Modals
				$('.xslsn-notitemp-style1').hide();
				$('.xslsn-notitemp-style2').hide();
				$('.xslsn-notitemp-style3').hide();
				$('.xslsn-notitemp-style4').hide();
				$('.xslsn-notitemp-style5').hide();
				
			},10000);
			
		}
	});
	
})(jQuery); 
