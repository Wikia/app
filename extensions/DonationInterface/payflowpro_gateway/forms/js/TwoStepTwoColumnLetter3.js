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

	$( "#ccSubmitButton" ).click( function() {
		// Set expiration date
		$( "input[name='expiration']" ).val(
			$( "select[name='mos']" ).val() + $( "select[name='year']" ).val().substring( 2, 4 )
		)
		// Safety check for people who hit the back button on forms with amount radio buttons
		if ( $( "input[name='amountRadio']" ).length ) {
			checkedValue = $( "input[name='amountRadio']:checked" ).val();
			currentAmount = $( 'input[name="amount"]' ).val();
			// The currenctAmount could be set to empty string or '0.00'
			if ( ( currentAmount == '0.00' || currentAmount == '' ) && checkedValue && !isNaN( checkedValue ) ) {
				$( 'input[name="amount"]' ).val( checkedValue );
			}
		}
		if ( validateAmount() ) {
			if ( validate_form() ) {
				return true;
			}
		}
		return false;
	} );
	
} );
