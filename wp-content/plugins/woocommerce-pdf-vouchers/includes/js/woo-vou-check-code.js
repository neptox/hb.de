jQuery( document ).ready( function( $ ) {
// Check Voucher code is valid or not
	$( document ).on( 'click', '#woo_vou_check_voucher_code', function() {
	
		//Voucher Code
		var voucode = $( '#woo_vou_voucher_code' ).val();
		
		if( voucode == '' || voucode == 'undefine' ) {
			
			//hide submit row
			$( '.woo-vou-voucher-code-submit-wrap' ).fadeOut();
			
			$( '.woo-vou-voucher-code-msg' ).removeClass( 'woo-vou-voucher-code-success' ).addClass( 'woo-vou-voucher-code-error' ).html( WooVouCheck.check_code_error ).show();
			
		} else {
			
			//show loader
			$( '.woo-vou-check-voucher-code-loader' ).css( 'display', 'inline' );
			
			//hide error message
			$( '.woo-vou-voucher-code-msg' ).hide();
			
			var data = {
							action	: 'woo_vou_check_voucher_code',
							voucode	: voucode
						};
			//call ajax to chcek voucher code
			jQuery.post( WooVouCheck.ajaxurl, data, function( response ) {
				//alert( response );
				if( response == 'success' ) {
					
					//show submit row
					$( '.woo-vou-voucher-code-submit-wrap' ).fadeIn();
					
					$( '.woo-vou-voucher-code-msg' ).removeClass( 'woo-vou-voucher-code-error' ).addClass( 'woo-vou-voucher-code-success' ).html( WooVouCheck.code_valid ).show();
					
				} else if( response == 'error' ) {
					
					//hide submit row
					$( '.woo-vou-voucher-code-submit-wrap' ).fadeOut();
					
					$( '.woo-vou-voucher-code-msg' ).removeClass( 'woo-vou-voucher-code-success' ).addClass( 'woo-vou-voucher-code-error' ).html( WooVouCheck.code_invalid ).show();
					
				} else if ( response ) {
					
					//hide submit row 
					$( '.woo-vou-voucher-code-submit-wrap' ).fadeOut();
					
					$( '.woo-vou-voucher-code-msg' ).removeClass( 'woo-vou-voucher-code-success' ).addClass( 'woo-vou-voucher-code-error' ).html( response ).show();
					
				}
				//hide loader
				$( '.woo-vou-check-voucher-code-loader' ).hide();
				
			});
		}
	});
	
	// Submit Voucher code
	$( document ).on( 'click', '#woo_vou_voucher_code_submit', function() {
	
		//Voucher Code
		var voucode = $( '#woo_vou_voucher_code' ).val();
		
		if( ( voucode == '' || voucode == 'undefine' ) ) {
			
			//hide submit row
			$( '.woo-vou-voucher-code-submit-wrap' ).fadeOut();
			
			$( '.woo-vou-voucher-code-msg' ).removeClass( 'woo-vou-voucher-code-success' ).addClass( 'woo-vou-voucher-code-error' ).html( WooVouCheck.check_code_error ).show();
			
		} else {
			
			//show loader
			$( '.woo-vou-voucher-code-submit-loader' ).css( 'display', 'inline' );
			
			//hide error message
			$( '.woo-vou-voucher-code-msg' ).hide();
			
			var data = {
							action		: 'woo_vou_save_voucher_code',
							voucode		: voucode
						};
			//call ajax to save voucher code
			jQuery.post( WooVouCheck.ajaxurl, data, function( response ) {
				//alert( response );
				if( response ) {
					
					//Voucher Code
					$( '#woo_vou_voucher_code' ).val( '' );
					
					//hide submit row
					$( '.woo-vou-voucher-code-submit-wrap' ).fadeOut();
					
					$( '.woo-vou-voucher-code-msg' ).removeClass( 'woo-vou-voucher-code-error' ).addClass( 'woo-vou-voucher-code-success' ).html( WooVouCheck.code_used_success ).show();
					
				}
				//hide loader
				$( '.woo-vou-voucher-code-submit-loader' ).hide();
				
			});
		}
		
	});
});