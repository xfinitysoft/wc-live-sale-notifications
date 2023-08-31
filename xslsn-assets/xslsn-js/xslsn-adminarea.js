//Are used for the admin panel options settings logic
(function ($) {
  'use strict';
  $('document').ready(function () {
    $('.xsw-select2').select2();
    //calling the function on page load 
    xslsn_AdminPageOnLoad();
    //This function is used on admin load for active the first tab
    function xslsn_AdminPageOnLoad() {
      //On First Load of page it will hide all the tab and shows the first tab
      //$('#xslsn-tabs li a:not(:first)').addClass('xslsn-inactive');
      $('.xslsn-tab-container').hide();
      $('.xslsn-progressbarcontent').hide();
      $('.xslsn-tab-container:first').show();
      //round corner enable
      if ($('#xslsn-enableroundcornerborder').prop("checked") == true) {
        $('.xslsn-custom-rounded-corner').hide();
      } else {
        $('.xslsn-custom-rounded-corner').show();
      }

      //close icon for template
      if ($('#xslsn-showcloseicon').prop("checked") == true) {
        $('.xslsn-showcloseicon').show();
      } else {
        $('.xslsn-showcloseicon').hide();
      }

      //For product panel 
      var xslsn_products_billing = $('#xslsn-products-billing').val();
      xslsn_products_billing_callback(xslsn_products_billing);
      var xslsn_products_address = $('#xslsn-products-address').val();
      if (xslsn_products_address === 'xslsn-auto-detect') {
        $('.xslsn-auto-detect').hide();
      } else {
        $('.xslsn-auto-detect').show();
      }
    }

    /* Are used to change to tab content */
    $('#xslsn-tabs li a').on('click', function () {
      var xslsn_tab = $(this).attr('id');
      console.log(xslsn_tab);
      if (!$(this).hasClass('nav-tab-active')) {
        $('#xslsn-tabs li a').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.xslsn-tab-container').hide();
        $('#' + xslsn_tab + 'C').fadeIn('slow');
        $('.xslsn-progressbarcontent').hide();
        $('.xslsn-progressbarpreview').hide();
      }

      if (xslsn_tab === 'xslsn-tab2') {
        $('.xslsn-admin-modalmain').show();
        xslsn_loadadminareadesing();
      } else {
        $('.xslsn-admin-modalmain').hide();
      }

      if (xslsn_tab === 'xslsn-tab4') {
        var xslsn_products_billing = $('#xslsn-products-billing').val();
        if (xslsn_products_billing === '0') {
          $('.xslsn-auto-detect').hide();
        }
      }
    });

    //On change event of round corner
    $('#xslsn-enableroundcornerborder').on('change', function () {
      if (this.checked == true) {
        $('.xslsn-custom-rounded-corner').hide();
        $('.xslsn-admin-modalmain').addClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').addClass('xslsn-admin-modalmain-borderradius');
      } else {
        $('.xslsn-custom-rounded-corner').show();
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }
    });

    //On change event of close icon
    $('#xslsn-showcloseicon').on('change', function () {
      if (this.checked == true) {
        $('.xslsn-showcloseicon').show();
        $('.xslsn-closeicon').show();
        $('.xslsn-sf-design-content-close').show();
        var xslsn_closeiconcolor = $('#xslsn-closeiconcolor').val();
        $('.xslsn-closeicon').css('color', xslsn_closeiconcolor);
      } else {
        $('.xslsn-showcloseicon').hide();
        $('.xslsn-closeicon').hide();
        $('.xslsn-sf-design-content-close').hide();
      }
    });

    //on change for select box 
    function xslsn_products_billing_callback(xslsn_selectedid) {
      $('.xslsn-live-sale-product').hide();
      $('.xslsn-live-sale-product-' + xslsn_selectedid).show();
    }
    $('#xslsn-products-billing').on('change', function () {
      var xslsn_products_billing = $(this).val();
      xslsn_products_billing_callback(xslsn_products_billing);
    });

    $('#xslsn-products-address').on('change', function () {
      var xslsn_products_address = $(this).val();
      if (xslsn_products_address === 'xslsn-auto-detect') {
        $('.xslsn-auto-detect').hide();
      } else {
        $('.xslsn-auto-detect').show();
      }
    });

    $('#xslsn-style12,#xslsn-style11,#xslsn-style10,#xslsn-style9,#xslsn-style8,#xslsn-style7,#xslsn-style6,#xslsn-style5,#xslsn-style4,#xslsn-closeiconcolor,#xslsn-custom-rounded-corner,#xslsn-topright,#xslsn-topleft,#xslsn-bottomright,#xslsn-position-bottomleft,.xslsn-position,#xslsn-style3,#xslsn-style2,#xslsn-style1,#xslsn-imagepadding').on('change', function () {
        xslsn_loadadminareadesing();
    });

    //This function is used to load desing of popup on admin area

    function xslsn_loadadminareadesing() {
      var xslsn_imagepadding = $('#xslsn-imagepadding').val();
      var xslsn_position = $('.xslsn-position').val();
      $('.xslsn-sf-design-thumbnail').css('padding', xslsn_imagepadding);

      //Hide all the Modals
      $('.xslsn-notitemp-style1').hide();
      $('.xslsn-notitemp-style2').hide();
      $('.xslsn-notitemp-style3').hide();
      $('.xslsn-notitemp-style4').hide();
      $('.xslsn-notitemp-style5').hide();
      $('.xslsn-admin-modalmain').css('border-color', 'transparent');
      if ($('#xslsn-style12').prop('checked') == true) {
        $('.xslsn-notitemp-style5').show();
        $('#xslsn-enableroundcornerborder').prop('checked', true);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#ffffff");
        $('#xslsn-background-color').css('color', "#ffffff");
        $('.xslsn-admin-modalmain').addClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').addClass('xslsn-admin-modalmain-borderradius');

      }
      if ($('#xslsn-style11').prop('checked') == true) {
        $('.xslsn-notitemp-style4').show();
        $('#xslsn-enableroundcornerborder').prop('checked', true);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#ffffff");
        $('#xslsn-background-color').css('color', "#ffffff");
        $('.xslsn-admin-modalmain').addClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').addClass('xslsn-admin-modalmain-borderradius');
      }
      if ($('#xslsn-style10').prop('checked') == true) {
        $('.xslsn-notitemp-style4').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#ffffff");
        $('#xslsn-background-color').css('color', "#ffffff");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }
      if ($('#xslsn-style9').prop('checked') == true) {
        $('.xslsn-notitemp-style3').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain-rect').attr('fill', '#DC3545');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('.xslsn-admin-modalmain-seconddiv-abouttoago').css('color', '#6c757d');
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#DC3545");
        $('#xslsn-background-color').css('color', "#DC3545");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }
      if ($('#xslsn-style8').prop('checked') == true) {
        $('.xslsn-notitemp-style3').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain-rect').attr('fill', '#FFC107');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('.xslsn-admin-modalmain-seconddiv-abouttoago').css('color', '#6c757d');
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#FFC107");
        $('#xslsn-background-color').css('color', "#FFC107");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }
      if ($('#xslsn-style7').prop('checked') == true) {
        $('.xslsn-notitemp-style3').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain-rect').attr('fill', '#4DD66D');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('.xslsn-admin-modalmain-seconddiv-abouttoago').css('color', '#6c757d');
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#4DD66D");
        $('#xslsn-background-color').css('color', "#4DD66D");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }
      if ($('#xslsn-style6').prop('checked') == true) {
        $('.xslsn-notitemp-style2').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain').css('border-color', '#DC3545');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('.xslsn-admin-modalmain-seconddiv-abouttoago').css('color', '#6c757d');
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#DC3545");
        $('#xslsn-background-color').css('color', "#DC3545");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }
      if ($('#xslsn-style5').prop('checked') == true) {
        $('.xslsn-notitemp-style2').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain').css('border-color', '#FFC107');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('.xslsn-admin-modalmain-seconddiv-abouttoago').css('color', '#6c757d');
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#FFC107");
        $('#xslsn-background-color').css('color', "#FFC107");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }
      if ($('#xslsn-style4').prop('checked') == true) {
        $('.xslsn-notitemp-style2').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain').css('background', 'white');
        $('.xslsn-admin-modalmain').css('border-color', '#4DD66D');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#343a40");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#000000");
        $('.xslsn-admin-modalmain-seconddiv-abouttoago').css('color', '#6c757d');
        $('#xslsn-highlight-color').val("#000000");
        $('#xslsn-highlight-color').css('color', "#000000");
        $('#xslsn-text-color').val("#343a40");
        $('#xslsn-text-color').css('color', "#343a40");
        $('#xslsn-background-color').val("#4DD66D");
        $('#xslsn-background-color').css('color', "#4DD66D");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');

      }

      if ($('#xslsn-style3').prop('checked') == true) {
        $('.xslsn-notitemp-style1').show();
        $('#xslsn-enableroundcornerborder').prop('checked', true);
        $('.xslsn-admin-modalmain').css('background', '#DC3545');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#ffffff");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#ffffff");
        $('#xslsn-highlight-color').val("#ffffff");
        $('#xslsn-highlight-color').css('color', "#ffffff");
        $('#xslsn-text-color').val("#ffffff");
        $('#xslsn-text-color').css('color', "#ffffff");
        $('#xslsn-background-color').val('#DC3545');
        $('#xslsn-background-color').css('color', '#DC3545');
        $('.xslsn-admin-modalmain').addClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').addClass('xslsn-admin-modalmain-borderradius');
      }
      if ($('#xslsn-style2').prop('checked') == true) {
        $('.xslsn-notitemp-style1').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain').css('background', '#FFC107');
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#ffffff");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#ffffff");
        $('#xslsn-highlight-color').val("#ffffff");
        $('#xslsn-highlight-color').css('color', "#ffffff");
        $('#xslsn-text-color').val("#ffffff");
        $('#xslsn-text-color').css('color', "#ffffff");
        $('#xslsn-background-color').val("#FFC107");
        $('#xslsn-background-color').css('color', "#FFC107");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }
      if ($('#xslsn-style1').prop('checked') == true) {
        $('.xslsn-notitemp-style1').show();
        $('#xslsn-enableroundcornerborder').prop('checked', false);
        $('.xslsn-admin-modalmain-seconddiv-title-a').css('color', "#ffffff");
        $('.xslsn-admin-modalmain-seconddiv-title').css('color', "#ffffff");
        $('.xslsn-admin-modalmain').css('background', "#2271B1");
        $('#xslsn-highlight-color').val("#ffffff");
        $('#xslsn-highlight-color').css('color', "#ffffff");
        $('#xslsn-text-color').val("#ffffff");
        $('#xslsn-text-color').css('color', "#ffffff");
        $('#xslsn-background-color').val("#2271B1");
        $('#xslsn-background-color').css('color', "#2271B1");
        $('.xslsn-admin-modalmain').removeClass('xslsn-admin-modalmain-borderradius');
        $('.xslsn-admin-modalmain-firstdiv-img').removeClass('xslsn-admin-modalmain-borderradius');
        var xslsn_custom_rounded_corner = $('#xslsn-custom-rounded-corner').val();
        $('.xslsn-admin-modalmain').css('border-radius', xslsn_custom_rounded_corner + 'px');
        $('.xslsn-admin-modalmain-firstdiv-img').css('border-radius', xslsn_custom_rounded_corner + 'px');
      }

      if (xslsn_position === 'xslsn_position_right') {
        $('.xslsn-solid-fill-design-body,.xslsn-left-rounded-design-body').addClass('xslsn-position-right');
        $('.xslsn-sf-design-content-close').css('right', '15px');
      } else {
        $('.xslsn-solid-fill-design-body,.xslsn-left-rounded-design-body').removeClass('xslsn-position-right');
        $('.xslsn-sf-design-content-close').css('right', '0px');
      }
      //For bottom left checkbox
      $('.xslsn-admin-modalmain').removeClass('xslsn-position-bottomleft');
      $('.xslsn-admin-modalmain').removeClass('xslsn-position-bottomright');
      $('.xslsn-admin-modalmain').removeClass('xslsn-position-topleft');
      $('.xslsn-admin-modalmain').removeClass('xslsn-position-topright');
      if ($('#xslsn-position-bottomleft').prop('checked') == true) {
        $('.xslsn-admin-modalmain').addClass('xslsn-position-bottomleft');
      }
      if ($('#xslsn-bottomright').prop('checked') == true) {
        $('.xslsn-admin-modalmain').addClass('xslsn-position-bottomright');
      }
      if ($('#xslsn-topleft').prop('checked') == true) {
        $('.xslsn-admin-modalmain').addClass('xslsn-position-topleft');
      }
      if ($('#xslsn-topright').prop('checked') == true) {
        $('.xslsn-admin-modalmain').addClass('xslsn-position-topright');
      }
      if ($('#xslsn-showcloseicon').prop("checked") == true) {
        $('.xslsn-closeicon').show();
        $('.xslsn-sf-design-content-close').show();
        var xslsn_closeiconcolor = $('#xslsn-closeiconcolor').val();
        $('.xslsn-closeicon').css('color', xslsn_closeiconcolor);
      }else{
        $('.xslsn-closeicon').hide();
        $('.xslsn-sf-design-content-close').hide();
      }
    }
    jQuery('#xs_name , #xs_email , #xs_message').on('change',function(e){
        if(!jQuery(this).val()){
            jQuery(this).addClass("error");
        }else{
            jQuery(this).removeClass("error");
        }
    });
    $('.xslsn_support_form').on('submit' , function(e){ 
        e.preventDefault();
        jQuery('.xs-send-email-notice').hide();
        jQuery('.xs-mail-spinner').addClass('xs_is_active');
        jQuery('#xs_name').removeClass("error");
        jQuery('#xs_email').removeClass("error");
        jQuery('#xs_message').removeClass("error"); 
        
        $.ajax({ 
            url:ajaxurl,
            type:'post',
            data:{'action':'xslsn_send_mail','data':$(this).serialize()},
            beforeSend: function(){
              if(!jQuery('#xs_name').val()){
                    jQuery('#xs_name').addClass("error");
                    jQuery('.xs-send-email-notice').removeClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('error');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Please fill all the fields');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    jQuery('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                 if(!jQuery('#xs_email').val()){
                    jQuery('#xs_email').addClass("error");
                    jQuery('.xs-send-email-notice').removeClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('error');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Please fill all the fields');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    jQuery('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                 if(!jQuery('#xs_message').val()){
                    jQuery('#xs_message').addClass("error");
                    jQuery('.xs-send-email-notice').removeClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('error');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Please fill all the fields');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    jQuery('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                jQuery('.xs-send-mail').prop('disabled',true);
                $(".xslsn_support_form :input").prop("disabled", true);
                $("#xs_message").prop("disabled", true);
            },
            success: function(res){
                jQuery('.xs-send-email-notice').find('.xs-notice-dismiss').show();
                jQuery('.xs-send-mail').prop('disabled',false);
                jQuery(".xslsn_support_form :input").prop("disabled", false);
                jQuery("#xs_message").prop("disabled", false);
                if(res.status == true){
                    jQuery('.xs-send-email-notice').removeClass('error');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Successfully sent');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                    jQuery('.xslsn_support_form')[0].reset();
                }else{
                    jQuery('.xs-send-email-notice').removeClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('error');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Sent Failed');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                }
                jQuery('.xs-mail-spinner').removeClass('xs_is_active');
            }

        });
    });
    $('.xs-notice-dismiss').on('click',function(e){
        e.preventDefault();
        $(this).parent().hide();
        $(this).hide();
    });
  });
})(jQuery);