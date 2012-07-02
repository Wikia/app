/*
 * The following variable are declared inline in webitects_2_3step.html:
 *   amountErrors, billingErrors, paymentErrors, scriptPath, actionURL
 */
$( document ).ready( function () {

	// check for RapidHtml errors and display, if any
	var amountErrorString = "",
		billingErrorString = "",
		paymentErrorString = "";

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
	var prevError = false;
	if ( amountErrorString != "" ) {
		$( "#amtErrorMessages" ).html( amountErrorString );
		prevError = true;
		showStep2(); // init the headers
		showStep3();
		showStep1(); // should be default, but ensure
	}
	if ( billingErrorString != "" ) {
		$( "#billingErrorMessages" ).html( billingErrorString );
		if ( !prevError ) {
			showStep1(); // init the headers
			showStep3();
			showStep2();
			prevError = true;
		}
		showAmount( $( 'input[name="amount"]' ) ); // lets go ahead and assume there is something to show
	}
	if ( paymentErrorString != "" ) {
		$( "#paymentErrorMessages" ).html( paymentErrorString );
		if ( !prevError ) {
			showStep1(); // init the headers
			showStep2();
			showStep3();
		}
		showAmount( $( 'input[name="amount"]' ) ); // lets go ahead and assume there is something to show
	}
	
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
	
	$( "#cc" ).click( function() {
		/* safety check for people who hit the back button */
		checkedValue = $( "input[name='amountRadio']:checked" ).val();
		if ( $( 'input[name="amount"]' ).val() == '0.00' && checkedValue && !isNaN( checkedValue ) ) {
			setAmount( $( "input[name='amountRadio']:checked" ) );
		}
		if ( validateAmount() ) {
			showAmount( $( 'input[name="amount"]' ) );
			showStep2();
		}
	} );

	$( "#pp" ).click( function() {
		/* safety check for people who hit the back button */
		checkedValue = $( "input[name='amountRadio']:checked" ).val();
		if ( $( 'input[name="amount"]' ).val() == '0.00' && checkedValue && !isNaN( checkedValue ) ) {
			setAmount( checkedValue );
		}
		if ( validateAmount() ) {
			// set the action to go to PayPal
			$( 'input[name="gateway"]' ).val( "paypal" );
			$( 'input[name="PaypalRedirect"]' ).val( "1" );
			$( "#loading" ).html( '<img alt="loading" src="'+mw.config.get( 'wgScriptPath' )+'/extensions/DonationInterface/gateway_forms/includes/loading-white.gif" /> Redirecting to PayPal…' );
			document.paypalcontribution.action = actionURL;
			document.paypalcontribution.submit();
		}
	} );
	$( "#paymentContinueBtn" ).live( "click", function() {
		if ( validate_personal( document.paypalcontribution ) && validateAmount() ) {
			displayCreditCardForm()
		}
	} );
	// Set the cards to progress to step 3
	$( ".cardradio" ).live( "click", function() {
		if ( validate_personal( document.paypalcontribution ) && validateAmount() ) {
			displayCreditCardForm()
		} else {
			// show the continue button to indicate how to get to step 3 since they
			// have already clicked on a card image
			$( "#paymentContinue" ).show();
		}
	} );

	$( "#submitcreditcard" ).click( function() {
		if ( validate_cc() ) {
			// set the hidden expiration date input from the two selects
			$( 'input[name="expiration"]' ).val(
				$( 'select[name="mos"]' ).val() + $( 'select[name="year"]' ).val().substring( 2, 4 )
			);
			document.paypalcontribution.action = actionURL;
			document.paypalcontribution.submit();
		}
	} );
	// init all of the header actions
	$( "#step1header" ).click( function() {
		showStep1();
	} );
	$( "#step2header" ).click( function() {
		if ( validateAmount() ) {
			showAmount( $( 'input[name="amount"]' ) );
			showStep2();
		}
	} );
	$( "#step3header" ).click( function() {
		if ( validateAmount() ) {
			showAmount( $( 'input[name="amount"]' ) );
			displayCreditCardForm();
		}
	} );
	
	// For when people switch back to Other from another value
	$( '#input_amount_other' ).click( function() {
		var otherAmount = $( 'input#other-amount' ).val();
		if ( otherAmount ) {
			setAmount( $( 'input#other-amount' ) );
		}
	} );
	// Set selected amount to amount
	$( 'input[name="amountRadio"]' ).click( function() {
		if ( !isNaN( $( this ).val() ) ) {
			setAmount( $( this ) );
		}
	} );
	// reset the amount field when "other" is changed
	$( "#other-amount" ).keyup( function() {
		if ( $( '#input_amount_other' ).is( ':checked' ) ) {
			setAmount( $( this ) );
		}
	} );
	// change the amount when "other" is focused
	$( "#other-amount" ).focus( function() {
		$( '#input_amount_other' ).attr( 'checked', true );
		var otherAmount = $( 'input#other-amount' ).val();
		if ( otherAmount ) {
			setAmount( $( 'input#other-amount' ) );
		}
	} );

	// show the CVV help image on click
	$( "#where" ).click( function() {
		$( "#codes" ).toggle();
		return false;
	} );

} );

window.showStep1 = function() {
	// show the correct sections
	$( "#step1wrapper" ).slideDown();
	$( "#step2wrapper" ).slideUp();
	$( "#step3wrapper" ).slideUp();
	$( "#change-amount" ).hide();
	$( "#change-billing" ).show();
	$( "#change-payment" ).show();
	$( "#step1header" ).show(); // just in case
}

window.showStep2 = function() {
	if ( $( '#step3wrapper' ).is(":visible") ) {
		$( "#paymentContinue" ).show(); // Show continue button in 2nd section
	}
	// show the correct sections
	$( "#step1wrapper" ).slideUp();
	$( "#step2wrapper" ).slideDown();
	$( "#step3wrapper" ).slideUp();
	$( "#change-amount" ).show();
	$( "#change-billing" ).hide();
	$( "#change-payment" ).show();
	$( "#step2header" ).show(); // just in case
}

window.showStep3 = function() {
	// show the correct sections
	$( "#step1wrapper" ).slideUp();
	$( "#step2wrapper" ).slideUp();
	$( "#step3wrapper" ).slideDown();
	$( "#change-amount" ).show();
	$( "#change-billing" ).show();
	$( "#change-payment" ).hide();
	$( "#step3header" ).show(); // just in case
}
// Fix behavior of images in labels
// TODO: check that disabling this is okay in things other than Chrome
// $("label img").live("click", function() { $("#" + $(this).parents( "label" ).attr( "for" )).click(); });
