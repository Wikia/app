
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
		showAmount( $( 'input[name="amount"]' ) ); // lets go ahead and assume there is something to show
	}
	if ( paymentErrorString != "" ) {
		$( "#paymentErrorMessages" ).html( paymentErrorString );
		showAmount( $( 'input[name="amount"]' ) ); // lets go ahead and assume there is something to show
	}
	$( "#bt-continueBtn" ).live( "click", function() {
		if ( validateAmount() && validate_personal( document.paypalcontribution ) ) {
			document.paypalcontribution.action = actionURL;
			document.paypalcontribution.submit();
		}
	} );


	// check to see if amount was passed from the previous step
	var amount = $( 'input[name="amount"]' ); // get the amount field
	if( amount == null || isNaN( amount.val() ) || amount.val() <= 0 ){
		// the amount is not set
		$( "#step1wrapper" ).slideDown();
//		showAmount( document.getElementByName( 'amount' ) );
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
		$( "#step1wrapper" ).slideDown();
		$( "#change-amount" ).hide();
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
	showAmount( $( 'input[name="amount"]' ) );
} );

// set the hidden amount input to the value of the selected element
function setAmount( e ) {
	$( 'input[name="amount"]' ).val( e.val() );
}
