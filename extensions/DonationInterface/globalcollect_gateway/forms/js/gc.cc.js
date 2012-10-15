/*
 * The following variable are declared inline in webitects_2_3step.html:
 *   amountErrors, billingErrors, paymentErrors, scriptPath, actionURL
 */
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

    $( "#paymentContinueBtn" ).live( "click", function() {
        if ( validate_personal( document.payment ) && validateAmount() ) {
            $( "#payment" ).animate( { height:'314px' }, 1000 );
            displayCreditCardForm();
            // hide the continue button so that people don't get confused with two of them
            $( "#paymentContinue" ).hide();
        }
    } );

    // Set the cards to progress to step 3
    $( ".cardradio" ).live( "click", function() {
        if ( validate_personal( document.payment ) && validateAmount() ) {
            $( "#payment" ).animate( { height:'314px' }, 1000 );
            displayCreditCardForm();
            // hide the continue button so that people don't get confused with two of them
            $( "#paymentContinue" ).hide();
        }
        else {
            // show the continue button to indicate how to get to step 3 since they
            // have already clicked on a card image
            $( "#paymentContinue" ).show();
        }
    } );
} );