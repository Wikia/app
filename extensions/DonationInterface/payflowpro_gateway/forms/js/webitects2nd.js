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
		if ( validate_personal( document.paypalcontribution ) ) {
			displayCreditCardForm()
		}
	} );
	// Set the cards to progress to step 3
	$( ".cardradio" ).live( "click", function() {
		if ( validate_personal( document.paypalcontribution ) ) {
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
		showStep2();
	} );
	$( "#step3header" ).click( function() {
		displayCreditCardForm();
	} );
} );

window.showStep2 = function() {
	if ( $( '#step3wrapper' ).is(":visible") ) {
		$( "#paymentContinue" ).show(); // Show continue button in 2nd section
	}
	// show the correct sections
	$( "#step2wrapper" ).slideDown();
	$( "#step3wrapper" ).slideUp();
	$( "#change-billing" ).hide();
	$( "#change-payment" ).show();
	$( "#step2header" ).show(); // just in case
}

window.showStep3 = function() {
	// show the correct sections
	$( "#step2wrapper" ).slideUp();
	$( "#step3wrapper" ).slideDown();
	$( "#change-billing" ).show();
	$( "#change-payment" ).hide();
	$( "#step3header" ).show(); // just in case
}