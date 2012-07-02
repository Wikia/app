$(function() {

	$( '#dialog' ).dialog( {
		width: 600,
		resizable: false,
        autoOpen: false,
        modal: true,
        title: 'Donate by Credit Card'
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
		if ( validateAmount( document.paypalcontribution ) ) {
			$( '#dialog' ).dialog( 'open' );
		}
	});
	$( '#pp' ).click( function() {
		if ( validateAmount( document.paypalcontribution ) ) {
			$( "input[name='gateway']" ).val( 'paypal' );
			document.paypalcontribution.action = "https://wikimediafoundation.org/wiki/Special:ContributionTracking/en";
			$( '#loading' ).html( "<img src='../images/loading.gif' /> Redirecting to PayPal..." );
			document.paypalcontribution.submit();
		}
	});
	
	/* Set selected amount to amount */
	$( "input[name='amountRadio']" ).click( function() { setAmount( $( this ) ); } );
	$( "#other-amount" ).keyup( function() { setAmount( $( this ) ); } );
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
    var widths 		= new Array();
	$( '#steps .step' ).each( function(i) {
        var $step 		= $( this );
		widths[i]  		= stepsWidth;
        stepsWidth	 	+= 600; // Hard-coding as $.width() is not working for some reason
    } );
	$( '#steps' ).width( stepsWidth );

	/* To avoid problems in IE, focus the first input of the form */
	$( '#donationForm' ).children( ':first' ).find( ':input:first' ).focus();
	
	/* make continue buttons */
	$( 'a.continue-button' ).button();
	$( 'a.continue-button' ).click( function(e) {
		var $this	= $( this );
		current = $( this ).parent().parent().index() + 1;
		if ( current == fieldsetCount ) {
			finalSubmit();
			return false;
		}
		if ( validateStep( current ) === 1 ) {
			current = current + 1;
			$( '#steps' ).stop().animate( { marginLeft: '-' + widths[current - 1] + 'px' }, 500, 
				function() {
        			$( '#donationForm' ).children( ':nth-child(' + parseInt(current) + ')' ).find( ':input:first' ).focus();
        		}
        	);
		} else {
			$this.blur();
		}
		
        e.preventDefault();
    });
    
    /* Make back button */
	$( 'a.back-button' ).button();
	$( 'a.back-button' ).click( function(e) {
		var $this	= $( this );
		/* Set current to 1 less than previous step */
		current = $( this ).parent().parent().index();
		
		$( '#steps' ).stop().animate( { marginLeft: '+' + widths[current - 1] + 'px' }, 500 );
		
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

	/*
	Validates errors on all the fieldsets.
	Records if the form has errors in $( '#donationForm' ).data().
	*/
	function validateSteps() {
		var formErrors = false;
		for( var i = 1; i < fieldsetCount; ++i ) {
			var error = validateStep(i);
			if ( error == -1 ) formErrors = true;
		}
		$( '#donationForm' ).data( 'errors', formErrors );
	}
	
	function finalSubmit() {
		var formErrors = false;
		for( var i = 1; i <= fieldsetCount; ++i ) {
			var error = validateStep(i);
			if ( error == -1 ) formErrors = true;
		}
		$( '#donationForm' ).data( 'errors', formErrors );
		
		if ( $( '#donationForm' ).data( 'errors' ) ) {
			alert( 'Please correct the errors in the form.' );
			return false;
		} else {
			/* Set country to US */
			$( "input[name='country']" ).val('US' );
			
			/* Submit the form */
			var sendData = {
				'action': 'donate',
				'gateway': 'globalcollect',
				'currency_code': 'USD',
				'amount': $( "input[name='amount']" ).val(),
				'fname': $( "input[name='fname']" ).val(),
				'lname': $( "input[name='lname']" ).val(),
				'street': $( "input[name='street']" ).val(),
				'city': $( "input[name='city']" ).val(),
				'state': $( 'select#state option:selected' ).val(),
				'zip': $( "input[name='zip']" ).val(),
				'emailAdd': $( "input[name='emailAdd']" ).val(),
				'country': 'US',
				'payment_method': 'cc',
				'language': 'en',
				'card_type': 'visa',
				
				'format': 'json'
			};
	
			$.ajax( {
				'url': mw.util.wikiScript( 'api' ),
				'data': sendData,
				'dataType': 'json',
				'type': 'GET',
				'success': function( data ) {
					if ( typeof data.error !== 'undefined' ) {
						alert( ajaxError );
						// Send them back to the beginning
					} else if ( typeof data.result !== 'undefined' ) {
						if ( data.result.errors ) {
							var errors = new Array();
							$.each( data.result.errors, function( index, value ) {
								alert( value ); // Show them the error
								// Send them back to the beginning
							} );
						} else {
							if ( data.result.formaction ) {
								$( '#payment' ).empty();
								// Insert the iframe into the form
								$( '#payment' ).append(
									'<iframe src="'+data.result.formaction+'" width="318" height="314" frameborder="0"></iframe>'
								);
		
							}
						}
					}
				},
				'error': function( xhr ) {
					alert( ajaxError );
					// Send them back to the beginning
				}
			} );
			//document.donationForm.action = $( "input[name='action']" ).val();
			//document.donationForm.submit();
		}
	}

	/*
	validates one fieldset
	returns -1 if errors found, or 1 if not
	*/
	function validateStep( step ) {
		var error = 1;
		$( '#donationForm' ).children( ':nth-child(' + parseInt(step) + ')' ).find( ':input:not(button).required' ).each( function() {
			var $this 		= $( this );
			var valueLength = jQuery.trim( $this.val() ).length;

			if ( valueLength == '' ) {
				error = -1;
				$this.css( 'background-color', '#FFEDEF' );
			} else {
				$this.css( 'background-color', '#FFFFFF' );
			}
		});

		return error;
	}
	
	function validateAmount(){
		var error = true;
		var amount = $( "input[name='amount']" ).val(); // get the amount
		var otherAmount = amount // create a working copy
		otherAmount = otherAmount.replace( /[,.](\d)$/, '\:$10' );
		otherAmount = otherAmount.replace( /[,.](\d)(\d)$/, '\:$1$2' );
		otherAmount = otherAmount.replace( /[,.]/g, '' );
		otherAmount = otherAmount.replace( /:/, '.' );
		amount = otherAmount; // reset amount to working copy amount
		$( "input[name='amount']" ).val( amount ); // set the new amount back into the form
		
		// Check amount is a real number, sets error as true (good) if no issues
		error = ( amount == null || isNaN( amount ) || amount.value <= 0 );
		// Check amount is at least the minimum
		var currency = 'USD'; // hard-coded for these forms and tests
		$( "input[name='currency_code']" ).val( currency );
		if ( typeof( wgCurrencyMinimums[currency] ) == 'undefined' ) {
			wgCurrencyMinimums[currency] = 1;
		}
		if ( amount < wgCurrencyMinimums[currency] || error ) {
			alert( 'You must contribute at least $1'.replace('$1', wgCurrencyMinimums[currency] + ' ' + currency ) );
			error = true;
		}
		return !error;
	};
});
