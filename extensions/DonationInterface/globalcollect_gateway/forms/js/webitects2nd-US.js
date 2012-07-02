/*
 * The following variable are declared inline in webitects_2_3step.html:
 *   amountErrors, billingErrors, paymentErrors, scriptPath, actionURL
 */
$( document ).ready( function () {

	$( "#step2header" ).show();
	$( "#step2wrapper" ).show();

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
	}
	if ( billingErrorString != "" ) {
		$( "#billingErrorMessages" ).html( billingErrorString );
	}
	if ( paymentErrorString != "" ) {
		$( "#paymentErrorMessages" ).html( paymentErrorString );
	}

	$( "#paymentContinueBtn" ).live( "click", function() {
		if ( validate_personal( document.paypalcontribution ) && validateAmount() ) {
			displayCreditCardForm()
		}
	} );
	// Set the cards to progress to step 3
	$( ".cardradio" ).live( "click", function() {
		if ( validate_personal( document.paypalcontribution ) && validateAmount() ) {
			displayCreditCardForm()
		}
		else {
			// show the continue button to indicate how to get to step 3 since they
			// have already clicked on a card image
			$( "#paymentContinue" ).show();
		}
	} );

	// init all of the header actions
	$( "#step2header" ).click( function() {
		if ( validateAmount() ) {
			showStep2();
		}
	} );
	$( "#step3header" ).click( function() {
		if ( validateAmount() ) {
			displayCreditCardForm();
		}
	} );

	// check to see if amount was passed from the previous step
	var amount = $( 'input[name="amount"]' ); // get the amount field
	if( amount == null || isNaN( amount.val() ) || amount.val() <= 0 ){
		// the amount is not set
		$( "#step1wrapper" ).slideDown();
//		$( "#selected-amount" ).html( '(' + $( 'input[name="currency_code"]' ).val() + ')' );

	} else {
		showAmount( $( 'input[name="amount"]' ) );
	}
	
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

	$( "#step1header" ).click( function() {
		showStep1();
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
} );

// set the hidden amount input to the value of the selected element
function setAmount( e ) {
	$( 'input[name="amount"]' ).val( e.val() );
	showAmount( e );
}
// Display selected amount
function showAmount( e ) {
	if( e.val() == "other" ){
		e = $( "#other-amount" );
	}
	$( "#selected-amount" ).html( "$" + e.val() );
	$( "#change-amount" ).show();
}

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