jQuery( document ).ready( function( $ ) {
	
	jQuery('input[name=_woo_vou_exp_type]').change(function(){
		var value = jQuery( 'input[name=_woo_vou_exp_type]:checked' ).val();
		
		if( value == 'specific_date' ){
			
			jQuery( '._woo_vou_exp_date_field' ).show();
			jQuery( '._woo_vou_days_diff_field' ).hide();
			jQuery( '._woo_vou_custom_days_field' ).hide();
			jQuery( '.custom-desc' ).hide();
			
		} else if( value == 'based_on_purchase' ){
			
			jQuery( '._woo_vou_days_diff_field ' ).show();
			jQuery( '._woo_vou_exp_date_field' ).hide();
			
			var woo_vou_days_diff = jQuery('select[name=_woo_vou_days_diff] option:selected').val();
			if( woo_vou_days_diff == 'cust' ){
				jQuery( '._woo_vou_custom_days_field' ).show();
				jQuery( '.custom-desc' ).hide();
			}else{
				jQuery( '._woo_vou_custom_days_field' ).hide();
				jQuery( '.custom-desc' ).show();
			}
		}
	});
	
	var exp_type = jQuery( 'input[name=_woo_vou_exp_type]:checked' ).val();
	
	if( exp_type == 'based_on_purchase' ){
		jQuery( '._woo_vou_exp_date_field' ).hide();
		
		var woo_vou_days_diff = jQuery('select[name=_woo_vou_days_diff] option:selected').val();
		
		if( woo_vou_days_diff == 'cust' ){
			jQuery( '._woo_vou_custom_days_field' ).show();
			jQuery( '.custom-desc' ).hide();
		}else{
			jQuery( '._woo_vou_custom_days_field' ).hide();
			jQuery( '.custom-desc' ).show();
		}
	}else if( exp_type == 'specific_date' ){
		
		jQuery( '._woo_vou_exp_date_field' ).show();
		jQuery( '._woo_vou_days_diff_field' ).hide();
		jQuery( '._woo_vou_custom_days_field' ).hide();
	}
	
	jQuery('._woo_vou_days_diff').change(function() {
		
		var days_diff = $(this).val();
		
        if( days_diff == 'cust' ){
        	jQuery( '._woo_vou_custom_days_field' ).show();
        	jQuery( '.custom-desc' ).hide();
        }else{
        	jQuery( '._woo_vou_custom_days_field' ).hide();
        	jQuery( '.custom-desc' ).show();
        }
	 	
	});
	
	jQuery(document).bind('woocommerce-product-type-change', function(e, select_val, test ) {
		//alert(select_val);
	});
	
	//on click of used codes button 
	$( document ).on( "click", ".woo-vou-meta-vou-purchased-data", function() {
		
		var popupcontent = $(this).parent().parent().find( '.woo-vou-purchased-codes-popup' );
		popupcontent.show();
		$(this).parent().parent().find( '.woo-vou-purchased-codes-popup-overlay' ).show();
		$('html, body').animate({ scrollTop: popupcontent.offset().top - 80 }, 500);
		
	});
	
	//on click of used codes button
	$( document ).on( "click", ".woo-vou-meta-vou-used-data", function() {
		
		var popupcontent = $(this).parent().parent().find( '.woo-vou-used-codes-popup' );
		popupcontent.show();
		$(this).parent().parent().find( '.woo-vou-used-codes-popup-overlay' ).show();
		$('html, body').animate({ scrollTop: popupcontent.offset().top - 80 }, 500);
		
	});
	
	//, .woo-vou-meta-vou-import-data
	$( document ).on( "click", ".woo-vou-meta-vou-import-data", function() {
		
		$('.woo-vou-file-errors').hide();
		$('.woo-vou-delete-code').val('');
		$('.woo-vou-no-of-voucher').val('');
		$('.woo-vou-code-prefix').val('');
		$('.woo-vou-code-seperator').val('');
		$('.woo-vou-code-pattern').val('');
		$('.woo-vou-csv-sep').val('');
		$('.woo-vou-csv-enc').val('');
		$('.woo-vou-csv-file').val('');
		
		$( '.woo-vou-import-content' ).show();
		$( '.woo-vou-import-overlay' ).show();
		
		var importcodecontent = $( '.woo-vou-import-content' );
		$('html, body').animate({ scrollTop: importcodecontent.offset().top - 60 }, 500);
		
	});
	
	
	//on click of close button or overlay
		
	$( document ).on( "click", ".woo-vou-popup-overlay, .woo-vou-close-button", function() {
		
		//when import csv file popup is open
		if( $('.woo-vou-file-errors').length > 0 ) {
			$('.woo-vou-file-errors').hide();
			$('.woo-vou-file-errors').html('');
		}
		
		//common code for both popup of voucher codes used and import csv file
		$( '.woo-vou-popup-content' ).hide();
		$( '.woo-vou-popup-overlay' ).hide();
	});
	
	//on click of import coupon codes button, import code
	$( document ).on( "click", ".woo-vou-import-btn", function() {
		
		var existing_code = $('#_woo_vou_codes').val();
		var delete_code = $( '.woo-vou-delete-code' ).val();
		var no_of_voucher = $( '.woo-vou-no-of-voucher' ).val();
		var code_prefix = $( '.woo-vou-code-prefix' ).val();
		var code_seperator = $( '.woo-vou-code-seperator' ).val();
		var code_pattern = $( '.woo-vou-code-pattern' ).val().toLowerCase();
		
		$( '.woo-vou-file-errors' ).html('').hide();
		
		var error_msg = '';
		if( no_of_voucher == '' ) {
			error_msg += WooVouMeta.noofvouchererror;
		}
		if( code_pattern == '' ) {
			
			error_msg += WooVouMeta.patternemptyerror;
			
		} else if( code_pattern.indexOf('l') == '-1' && code_pattern.indexOf('d') == '-1' ) {
			
			error_msg += WooVouMeta.generateerror;
		}
		
		if( error_msg != '' ) {
			$( '.woo-vou-file-errors' ).html(error_msg).show();
		} else {
		
			$( '.woo-vou-loader' ).show();
			var data = {
							action			: 'woo_vou_import_code',
							noofvoucher		: no_of_voucher,
							codeprefix		: code_prefix,
							codeseperator	: code_seperator,
							codepattern		: code_pattern,
							existingcode	: existing_code,
							deletecode		: delete_code
						};
		
			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			$.post(ajaxurl, data, function(response) {
				var import_code = response;
				$( '.woo-vou-loader' ).hide();
				$( '#_woo_vou_codes' ).val(import_code);
				$( '.woo-vou-popup-content' ).hide();
				$( '.woo-vou-popup-overlay' ).hide();
				$( '#woo_vou_codes_error' ).hide();
				$( '#woo_vou_days_error' ).hide();
				
				var voucodecontent = $( '#_woo_vou_codes' ).removeClass( 'woo-vou-codes-red-border' );
				$('html, body').animate({ scrollTop: voucodecontent.offset().top - 50 }, 500);
				
			});
		}
	});
	
	//ajax call to get voucher codes from csv file
	$( document ).on( "click", ".woo-vou-meta-vou-import-codes", function() {
		
		$('.woo-vou-file-errors').hide();
		$('.woo-vou-file-errors').html('');
		
		var fseprator = $('.woo-vou-csv-sep').val();
		var fenclosure = $('.woo-vou-csv-enc').val();
		var existing_code = $('#_woo_vou_codes').val();
		var ext = '';
		var filename = '';
		var error = false;
		var errorstr = '';
		
		$('.woo-vou-csv-file').filter(function(){
			
			filename = $(this).val();
			//alert(filename);
			ext = filename.substring(filename.lastIndexOf('.') + 1);
			
			if( filename == '' ) {
				error = true;
				errorstr += WooVouMeta.fileerror;
			}
			if( filename != '' && ext != 'csv') {
				error = true;
				errorstr += WooVouMeta.filetypeerror;
			}
		});
		
		if( error == true ) { //check file type must be csv
			
			$('.woo-vou-file-errors').show();
			$('.woo-vou-file-errors').html(errorstr);
			return false;
			
		} else {
			
			if( filename != '' ) {
				 
				$('#woo_vou_existing_code').val( existing_code );
				
				$('form#woo_vou_import_csv').ajaxForm({
				    beforeSend: function() {
				    },
				    uploadProgress: function(event, position, total, percentComplete) {
				    },
				    success: function() {
				    },
					complete: function(xhr) {
						
						//alert('ajaxfileupload---'+xhr.responseText);
						$('textarea#_woo_vou_codes').val(xhr.responseText);
						$( '.woo-vou-popup-content' ).hide();
						$( '.woo-vou-popup-overlay' ).hide();
						$( '#woo_vou_codes_error' ).hide();
						$( '#woo_vou_days_error' ).hide();
						$('.woo-vou-csv-file').attr({ value: '' });
						//filename = '';								
						
						var voucodecontent = $( '#_woo_vou_codes' ).removeClass( 'woo-vou-codes-red-border' );
						$('html, body').animate({ scrollTop: voucodecontent.offset().top - 50 }, 500);
						
					}
				});
			}
		}
	});
	
	//repeater field add more
	jQuery( document ).on( "click", ".woo-vou-repeater-add", function() {
	
		jQuery(this).prev('div.woo-vou-meta-repater-block')
			.clone()
			.insertAfter('.woo-vou-meta-repeat div.woo-vou-meta-repater-block:last');
			
		jQuery(this).parent().find('div.woo-vou-meta-repater-block:last input').val('');
		jQuery(this).parent().find('div.woo-vou-meta-repater-block:last .woo-vou-repeater-remove').show();
		
	});
	
	//remove repeater field
	jQuery( document ).on( "click", ".woo-vou-repeater-remove", function() {
	   jQuery(this).parent('.woo-vou-meta-repater-block').remove();
	});
	
	// Hide woocommerce voucher by changed product type bundle
	$( document ).on( 'change', '#_woo_product_type', function() {

		woo_vou_manage_voucher_option_by_bundle_product();
	});
	
	// Hide woocommerce voucher by clicked enable voucher
	$( document ).on( 'click', '#woo_variable_pricing', function() {

		woo_vou_manage_voucher_option_by_variable_product();
	});
	
	// Check Voucher Code is not empty on clicked publish/update button
	$( document ).on( 'click', '#publish', function() {
		
		var error = 'false';
		
		$( '#woo_vou_codes_error' ).hide();
		$( '#woo_vou_days_error' ).hide();
		
		
		var product_type = $( '#product-type' ).val();
		var validate = 'false';
		
		if( product_type == 'simple' && $( '#_downloadable' ).is( ':checked' ) ){
			var validate = 'true';
		} else if( product_type == 'variable' ){
			var validate = 'true';
		}
		
		if( $( '#_woo_vou_enable' ).is( ':checked' ) && validate == 'true' ) {
			
			var codes = $( '#_woo_vou_codes' ).removeClass( 'woo-vou-codes-red-border' ).val();
			if( codes == '' || codes == 'undefined' ) {
				
				$( this ).parent().find( '.spinner' ).hide();
				$( this ).removeClass( 'button-primary-disabled' );
				$( '#woo_vou_codes_error' ).show();
				
				var voucodecontent = $('#_woo_vou_codes').addClass( 'woo-vou-codes-red-border' ).focus();
				
				// If '_woo_vou_codes' is visible then drag to that otherwise drag to voucher tab
				if( $('#_woo_vou_codes').is(':visible') ) {
					
					var vou_top = $('#_woo_vou_codes');
					$('.woo_vou_voucher_tab').removeClass('woo-vou-codes-red-border');
					$( '#woocommerce-product-data' ).removeClass( 'woo-vou-codes-red-border' );
					
				} else if( $('.woo_vou_voucher_tab').is(':visible') ) {
					
					var vou_top = $('.woo_vou_voucher_tab').addClass('woo-vou-codes-red-border');
					$( '#_woo_vou_codes' ).removeClass( 'woo-vou-codes-red-border' );
					$( '#woocommerce-product-data' ).removeClass( 'woo-vou-codes-red-border' );
					
				} else {
					var vou_top = $('#woocommerce-product-data').addClass('woo-vou-codes-red-border');
					
					$( '#_woo_vou_codes' ).removeClass( 'woo-vou-codes-red-border' );
					$( '.woo_vou_voucher_tab' ).removeClass( 'woo-vou-codes-red-border' );
				}
				
				//$('html, body').animate({ scrollTop: vou_top - 50 }, 500);
				$('html, body').animate({ scrollTop: vou_top.offset().top - 50 }, 500);
				
				var error = 'true';
				//return false;
			}
		}

		/*var exp_type			= jQuery( 'input[name=_woo_vou_exp_type]:checked' ).val();	
		var woo_vou_days_diff	= jQuery('select[name=_woo_vou_days_diff] option:selected').val();
		
		if( exp_type == 'based_on_purchase' && woo_vou_days_diff == 'cust' ) {
			
			var days = $( '#_woo_vou_custom_days' ).removeClass( 'woo-vou-codes-red-border' ).val();
			if( days == '' || days == 'undefined' ) {
				
				$( this ).parent().find( '.spinner' ).hide();
				$( this ).removeClass( 'button-primary-disabled' );
				$( '#woo_vou_days_error' ).show();
				
				var voucodecontent = $('#_woo_vou_custom_days').addClass( 'woo-vou-codes-red-border' ).focus(); 
				$('html, body').animate({ scrollTop: voucodecontent.offset().top - 50 }, 500);
				
				var error = 'true';
				
			}else if( ( days != '' && !woo_vou_is_numeric(days) ) || days < '1' ) {
				
				$( this ).parent().find( '.spinner' ).hide();
				$( this ).removeClass( 'button-primary-disabled' );
				$( '#woo_vou_days_error' ).show();
				
				var voucodecontent = $('#_woo_vou_custom_days').addClass( 'woo-vou-codes-red-border' ).focus(); 
				$('html, body').animate({ scrollTop: voucodecontent.offset().top - 50 }, 500);
				
				var error = 'true';
			}
		}*/
		
		if( error == 'true' ){
			return false;
		}else {
			return true;
		}
	});
	
	// Check Voucher Code validate on key up
	$( document ).on( 'keyup', '#_woo_vou_codes', function() {
		
		var codes = $( this ).val();
		if( codes == '' || codes == 'undefined' ) {
			
			$( this ).addClass( 'woo-vou-codes-red-border' );
			$( '#woo_vou_codes_error' ).show();
			
		} else {
			
			$('.woo_vou_voucher_tab').removeClass('woo-vou-codes-red-border');
			$( this ).removeClass( 'woo-vou-codes-red-border' );
			$( '#woo_vou_codes_error' ).hide();
		}
	});
	
});

function woo_vou_is_numeric(input){
	
    return (input - 0) == input && (''+input).replace(/^\s+|\s+$/g, "").length > 0;
}

// The function that allow only number [0-9]
function woo_vou_is_number_key_per_page( evt ) {
	
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}