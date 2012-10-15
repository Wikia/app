$( document ).ready( function () {

	// check for RapidHtml errors and display, if any
	var amountErrorString = "";
	var billingErrorString = "";
	var paymentErrorString = "";

	// generate formatted errors to display
	var temp = [];
	for ( var e in amountErrors )
		if ( amountErrors[e] != "" )
			temp[temp.length] = amountErrors[e];
	amountErrorString = temp.join( "<br />" );

	temp = [];
	for ( var f in billingErrors )
		if ( billingErrors[f] != "" )
			temp[temp.length] = billingErrors[f];
	billingErrorString = temp.join( "<br />" );

	temp = [];
	for ( var g in paymentErrors )
		if ( paymentErrors[g] != "" )
			temp[temp.length] = paymentErrors[g];
	paymentErrorString = temp.join( "<br />" );

	// show the errors
	if ( amountErrorString != "" ) {
		$( "#topError" ).html( amountErrorString );
	} else if ( billingErrorString != "" ) {
		$( "#topError" ).html( billingErrorString );
	} else if ( paymentErrorString != "" ) {
		$( "#topError" ).html( paymentErrorString );
	}
	
	$( '#dialog' ).dialog( {
		width: 600,
		resizable: false,
        autoOpen: false,
        modal: true,
        title: mw.msg( 'donate_interface-ccdc-button' )
	} );
	
	// If the form is being reloaded, restore the amount
	var previousAmount = $( 'input[name="amount"]' ).val();
	if ( previousAmount && previousAmount > 0  ) {
		var matched = false;
		$( 'input[name="amountRadio"]' ).each( function( index ) {
			if ( $( this ).val() == previousAmount ) {
				$( this ).attr( 'checked', true );
				matched = true;
			}
		} );
		if ( !matched ) {
			$( 'input#input_amount_other' ).attr( 'checked', true );
			$( 'input#other-amount' ).val( previousAmount );
		}
	}
	
	$( '#cc' ).click( function() {
	
		// Make sure cookies are enabled
		document.cookie = 'wmf_test=1;';
		if ( document.cookie.indexOf( 'wmf_test=1' ) != -1 ) {
			document.cookie = 'wmf_test=; expires=Thu, 01-Jan-70 00:00:01 GMT;'; // unset the cookie
		} else {
			alert( mw.msg( 'donate_interface-error-msg-cookies' ) ); // display error
			return false;
		}
		
		if ( validateAmount() ) {
			$( '#dialog' ).dialog( 'open' );
			$( "#spinner" ).hide(); // just in case
		}
	});
	$( '#pp' ).click( function() {
		if ( validateAmount() ) {
			//$( 'input#pp' ).attr( 'disabled', 'disabled' );
			$( "input[name='gateway']" ).val( 'paypal' );
			$( 'input[name="PaypalRedirect"]' ).val( "1" );
			document.paypalcontribution.action = actionURL;
			document.paypalcontribution.submit();
		}
	});
	
	// Set amount when a radio button is clicked
	$( 'input[name="amountRadio"]' ).click( function() {
		if ( !isNaN( $( this ).val() ) ) {
			setAmount( $( this ) );
		}
		if ( $( this ).val() == 'other' ) {
			setAmount( $( '#other-amount' ) );
		}
	} );
	// Change the amount when "other" is focused
	$( "#other-amount" ).focus( function() {
		$( '#input_amount_other' ).attr( 'checked', true );
		setAmount( $( '#other-amount' ) );
	} );
	// Reset the amount field when "other" is changed
	$( "#other-amount" ).keyup( function() {
		if ( $( '#input_amount_other' ).is( ':checked' ) ) {
			setAmount( $( this ) );
		}
	} );
	
	function setAmount(e) { $("input[name='amount']").val( e.val() ); }

	/* number of fieldsets */
	var fieldsetCount = $( '#donationForm' ).children().length;

	/* current position of fieldset / navigation link */
	var current 	= 1;

	/*
	Sum and save the widths of each one of the fieldsets.
	Set the final sum as the total width of the steps element.
	*/
	var stepsWidth	= 0;
	$( '#steps .step' ).each( function(i) {
        stepsWidth	 	+= 600; // Hard-coding as $.width() is not working for some reason
    } );
	$( '#steps' ).width( stepsWidth );

	/* To avoid problems in IE, focus the first input of the form */
	$( '#donationForm' ).children( ':first' ).find( ':input:first' ).focus();
	
	/* make continue buttons */
	$( 'a.continue-button' ).button();
	$( 'a#personal-continue' ).click( function(e) {
		if ( validatePersonal() ) {
			// Advance to the next step
			$( '#steps' ).stop().animate( { marginLeft: '-600px' }, 500, 
				function() {
        			$( '#donationForm' ).children( ':nth-child(1)' ).find( ':input:first' ).focus();
        		}
        	);
		}
		$( this ).blur();
		e.preventDefault();
		return false;
    });
    $( 'a#cc-continue' ).click( function(e) {
    	finalSubmit();
		e.preventDefault();
		return false;
    });
    
    /* Make back button */
	$( 'a.back-button' ).button();
	$( 'a.back-button' ).click( function(e) {
		/* Set current to 1 less than previous step */
		current = $( this ).parent().parent().index();
		$( '#steps' ).stop().animate( { marginLeft: '0px' }, 500 );
		$( this ).blur();
		e.preventDefault();
    });

	/* Hitting tab on the last input of each fieldset makes the form slide to the next step. */
	$( '#donationForm > fieldset' ).each( function() {
		var $fieldset = $( this );
		$fieldset.find( ':input:last' ).keydown( function(e) {
			if ( e.which == 9 ){ // 9 is the char code for tab
				$fieldset.find( 'a.continue-button' ).click();
				/* Force the blur for validation */
				e.preventDefault();
			}
		});
	});

	function finalSubmit() {
		var step = 2;
		var errors = false;
		
		$( '#donationForm' ).children( ':nth-child(' + step + ')' ).find( ':input:not(button).required' ).each( function() {
			var $this 		= $( this );
			var valueLength = $.trim( $this.val() ).length;
			if ( valueLength == 0 ) {
				errors = true;
				$this.css( 'background-color', '#FFEAEC' );
			} else {
				$this.css( 'background-color', '#FFFFFF' );
			}
		});
		
		// Validate credit card number
		cardNumber = $( '#card_num' ).val();
		cardNumber = $.trim( cardNumber );
		if ( cardNumber != '' ) {
			cardNumber = cardNumber.replace(/ /g,''); // remove any spaces
			// Make sure it contains only digits
			var ccCheckRegExp = /[^\d]/; 
			if ( ccCheckRegExp.test(cardNumber) ) {
				errors = true;
				$( '#card_num' ).css( 'background-color', '#FFEAEC' );
			} else {
				$( '#card_num' ).css( 'background-color', '#FFFFFF' );
			}
		}
		
		if ( errors ) {
			//alert( mw.msg( 'donate_interface-error-msg-validation' ) );
			return false;
		} else {
			/* Set country to US */
			$( "input[name='country']" ).val( 'US' );
							
			/* Set expiration date */
			$( "input[name='expiration']" ).val(
				$( "select[name='mos']" ).val() + $( "select[name='year']" ).val().substring( 2, 4 )
			)
			
			/* Submit the form */
			document.donationForm.action = $( "input[name='action']" ).val();
			$( "#spinner" ).show();
			document.donationForm.submit();
		}
	}
	
	function validatePersonal() {
		var step = 1;
		var errors = false;
		
		$( '#donationForm' ).children( ':nth-child(' + step + ')' ).find( ':input:not(button).required' ).each( function() {
			var $this 		= $( this );
			var valueLength = $.trim( $this.val() ).length;
			if ( valueLength == 0 ) {
				errors = true;
				$this.css( 'background-color', '#FFEAEC' );
			} else {
				$this.css( 'background-color', '#FFFFFF' );
			}
		});
		
		// Validate email address
		email = $( '#email' ).val();
		email = $.trim( email );
		if( email != '' ) {
			var apos = email.indexOf("@");
			var dotpos = email.lastIndexOf(".");
			if( apos < 1 || dotpos-apos < 2 ) {
				errors = true;
				$( '#email' ).css( 'background-color', '#FFEAEC' );
			} else {
				$( '#email' ).css( 'background-color', '#FFFFFF' );
			}
		}
		
		if ( errors ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Validate the donation amount to make sure it is formatted correctly and at least a minimum amount.
	 */
	function validateAmount() {
		var errors = false;
		var amount = $( "input[name='amount']" ).val(); // get the amount
		
		// Normalize weird amount formats.
		// Don't mess with these unless you know what you're doing.
		amount = amount.replace( /[,.](\d)$/, '\:$10' );
		amount = amount.replace( /[,.](\d)(\d)$/, '\:$1$2' );
		amount = amount.replace( /[,.]/g, '' );
		amount = amount.replace( /:/, '.' );
		$( 'input[name="amount"]' ).val( amount ); // set the new amount back into the form
		
		// Check amount is a real number greater than 0
		errors = ( amount == null || isNaN( amount ) || parseFloat( amount ) <= 0 );
		
		// Find out the currency code
		if ( $( 'input[name="currency_code"]' ).val() == '' ) {
			var currency_code = 'USD'; // hard-code since we're only running this in the US
			$( "input[name='currency_code']" ).val( currency_code );
		} else {
			var currency_code = $( 'input[name="currency_code"]' ).val();
		}
		
		// Check amount is at least the minimum
		if ( typeof( wgCurrencyMinimums[currency_code] ) == 'undefined' ) {
			wgCurrencyMinimums[currency_code] = 1;
		}
		if ( amount < wgCurrencyMinimums[currency_code] || errors ) {
			errors = true;
			alert( mw.msg( 'donate_interface-smallamount-error' ).replace( '$1', wgCurrencyMinimums[currency_code] + ' ' + currency_code ) );
			$( '#other-amount' ).val( '' );
			$( '#other-amount' ).focus();
		}
		if ( errors ) {
			return false;
		} else {
			return true;
		}
	};
});
