/**
 * GlobalCollect Validation
 *
 * Things you need to know:
 * - jquery.validate.js is awesome
 * - Howto change the default messages: @link http://stackoverflow.com/questions/2457032/jquery-validation-change-default-error-message
 *
 * @since r100950
 */
 
/*******************************************************************************

Helpers

*******************************************************************************/

/**
 * clearField
 *
 * @param object field
 * @param string field
 */
window.clearField = function( field, defaultValue ) {
	if (field.value == defaultValue) {
		field.value = '';
		field.style.color = 'black';
	}
};

/**
 * isset
 *
 * @param mixed varname
 */
function isset( varname ){
    if ( typeof( varname ) == "undefined" ) {
        return false;
    }
    else {
        return true;
    }
}

/**
 * empty
 *
 * @param mixed value
 */
function empty( value ) {

    var key;
 
    if ( value === '' || value === 0 || value === '0' || value === null || value === false || typeof value === 'undefined' ) {
        return true;
    }
    else if ( typeof value == 'object' ) {
        for ( key in value ) {
            return false;
        }
        return true;
    }
 
    return false;
}
 
/*******************************************************************************

Form Methods 

*******************************************************************************/

/**
 * setAmount
 *
 * @param object e	The element
 */
setAmount = function( e ) {
	$('input[name="amount"]').val(e.val());
};


/*******************************************************************************

Validate Elements

*******************************************************************************/

/**
 * Validate the element: amount
 *
 */
function validateElementAmount( options ) {
    
	// Need to distinguish between single amount field and radio buttons.
	$().ready(function() {

		var amountSelector = '#amount';
		
		// Check to see if the element exists
		if ( $("input[name='amountRadio']").length ) {
			amountSelector = "input[name='amountRadio']";
			$( amountSelector ).click(function(){ setAmount($(this)); });

			$("#other-amount").focus(function(){ $('#input_amount_other').prop('checked', true); });
			$("#other-amount").change(function(){ setAmount($(this)); });
		}
		
		/**
		 * Convert to an integer value because we will not test for:
		 * - 1.00
		 * - 0.00
		 * - 1,00
		 */
		jQuery.validator.addMethod("requirefunds", function(value, element, params) {
			
			var integerValue = parseInt( value );
			
			if ( isset( params.min ) ) {
				params.min = parseInt( params.min );
			}
			else {
				params.min = 0;
			}
			
			return integerValue >= params.min;
		}, mw.msg( 'donate_interface-error-msg-invalid-amount' ) );

        $( amountSelector ).rules("add", 
            {
                required: true,
				requirefunds: { 
					min: 1,
				},
            }
        );
    });
}

/**
 * Validate the element: emailAdd
 *
 */
function validateElementEmail( options ) {
    
	$().ready(function() {

        $("#emailAdd").rules("add", 
            {
                required: true,
                email: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-emailAdd' ),
                    email: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-emailAdd' ),
                }
            }
        );
    });
}

/**
 * Validate the element: fname
 *
 */
function validateElementFirstName( options ) {
    
	$().ready(function() {

        $("#fname").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-fname' ),
                }
            }
        );
    });
}

/**
 * Validate the element: lname
 *
 */
function validateElementLastName( options ) {
    
	$().ready(function() {

        $("#lname").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-lname' ),
                }
            }
        );
    });
}

/**
 * Validate the element: street
 *
 */
function validateElementStreet( options ) {
    
	$().ready(function() {

        $("#street").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-street' ),
                }
            }
        );
    });
}

/**
 * Validate the element: city
 *
 */
function validateElementCity( options ) {
    
	$().ready(function() {

        $("#city").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-city' ),
                }
            }
        );
    });
}

/**
 * Validate the element: state
 *
 * @todo
 * - This should only be required for the US at this point.
 * - It will be required outside the US, but that may be dependent on payment type.
 *
 */
function validateElementState( options ) {

	$().ready(function() {

		// Do not try to validate state if the field does not exist.
		if ( !$("#state").length ) {
			return;
		}

        $("#state").rules("add", 
            {
                required: true,
                notEqual: 'YY',
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-state-province' ),
                    notEqual: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-state-province' ),
                }
            }
        );
    });
}

/**
 * Validate the element: zip
 *
 */
function validateElementZip( options ) {
    
	$().ready(function() {

        $("#zip").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-zip' ),
                }
            }
        );
    });
}

/**
 * Validate the element: country
 *
 * @todo
 * - This should handle dropdowns
 *
 */
function validateElementCountry( options ) {
    
	$().ready(function() {

        $("#country").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-country' ),
                }
            }
        );
    });
}

/**
 * Validate the element: card_num
 *
 * @todo
 * - There are more options we can test. They are commented out.
 *
 */
function validateElementCardNumber( options ) {
    
	$().ready(function() {

        $("#card_num").rules("add", 
            {
                required: true,
                //creditcard: true,
                //creditcardtypes: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-card_num' ),
                }
            }
        );
    });
}

/**
 * Validate the element: cvv
 *
 */
function validateElementCvv( options ) {
    
	$().ready(function() {

        $("#cvv").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-cvv' ),
                }
            }
        );
    });
}

/**
 * Validate the element: payment_method
 *
 */
function validateElementPaymentMethod( options ) {
    
	$().ready(function() {

		// Hidden elements do not have ids
		$('#' + options.formId + " input[name=payment_method]").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-payment_method' ),
                }
            }
        );
    });
}

/**
 * Validate the element: payment_submethod
 *
 */
function validateElementPaymentSubmethod( options ) {
    
	$().ready(function() {

		// Hidden elements do not have ids
		$('#' + options.formId + " input[name=payment_submethod]").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-payment_submethod' ),
                }
            }
        );
    });
}

/**
 * Validate the element: issuer_id
 *
 */
function validateElementIssuerId( options ) {
    
	$().ready(function() {

        $("#issuer_id").rules("add", 
            {
                required: true,
                messages: {
                    required: mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-issuer_id' ),
                }
            }
        );
    });
}

/*******************************************************************************

Validate Element Groups

*******************************************************************************/

/**
 * Validate GlobalCollect payment forms
 * 
 * See how to implement error containers
 * @link http://jquery.bassistance.de/validate/demo/errorcontainer-demo.html
 *
 * Notes:
 * - To make cancel buttons not attempt form validation, add class="cancel" to the button element.
 * - Validation does not ignore hidden fields.
 * - This attaches a listener for a form submit event. When the form is submitted, it is captured and validated.
 */
$().ready(function() {

	if ( !isset( validatePaymentForm.formId ) ) {
		validatePaymentForm.formId = '';
	}

	if ( empty( validatePaymentForm.formId ) ) {
		
		// An id must be specified to validate the form.
		return;
	}

	// Options for plugin jquery.validate.js
	var validateOptions = {
		//ignore: ':hidden',
	}
	
	/* 
	 * This is where everything happens: .validate( validateOptions );
	 */
	$("#" + validatePaymentForm.formId).validate( validateOptions );

	// Check for payment_method
	if ( !isset( validatePaymentForm.payment_method ) ) {
		validatePaymentForm.payment_method = '';
	}

	// Check for payment_submethod
	if ( !isset( validatePaymentForm.payment_submethod ) ) {
		validatePaymentForm.payment_submethod = '';
	}

	// Initialize validate options if not set.
	if ( !isset( validatePaymentForm.validate ) ) {
		validatePaymentForm.validate = {};
	}

	/*
	 * Setup default validations based on payment_method
	 */
	
	if ( validatePaymentForm.payment_method == 'cc' ) {
		
		// card_num and cvv are not validated on our site.
		validatePaymentForm.validate.state = true;
	}
	else if ( validatePaymentForm.payment_method == 'bt' ) {
		
		validatePaymentForm.validate.payment = true;
		validatePaymentForm.validate.state = false;
	}
	else if ( validatePaymentForm.payment_method == 'rtbt' ) {
		
		validatePaymentForm.validate.payment = true;
		validatePaymentForm.validate.state = false;
	}

	/*
	 * Setup default validations based on payment_submethod
	 */
	
	if ( validatePaymentForm.payment_submethod == 'rtbt_ideal' ) {
		
		// Ideal requires issuer_id
		validatePaymentForm.validate.issuerId = true;
	}
	else if ( validatePaymentForm.payment_submethod == 'rtbt_eps' ) {
		
		// eps requires issuer_id
		validatePaymentForm.validate.issuerId = true;
	}

	/*
	 * Standard elements groups to validate
	 */
	
	// Options: Validate address
	if ( !isset( validatePaymentForm.validate.address ) ) {
		validatePaymentForm.validate.address = true;
	}
	
	// Options: Validate amount
	if ( !isset( validatePaymentForm.validate.amount ) ) {
		validatePaymentForm.validate.amount = true;
	}
	
	// Options: Validate creditCard
	if ( !isset( validatePaymentForm.validate.creditCard ) ) {
		validatePaymentForm.validate.creditCard = false;
	}
	
	// Options: Validate email
	if ( !isset( validatePaymentForm.validate.email ) ) {
		validatePaymentForm.validate.email = true;
	}
	
	// Options: Validate issuerId
	if ( !isset( validatePaymentForm.validate.issuerId ) ) {
		validatePaymentForm.validate.issuerId = false;
	}
	
	// Options: Validate name
	if ( !isset( validatePaymentForm.validate.name ) ) {
		validatePaymentForm.validate.name = true;
	}
	
	// Options: Validate payment
	if ( !isset( validatePaymentForm.validate.payment ) ) {
		validatePaymentForm.validate.payment = false;
	}

	/*
	 * Standard elements groups to validate if enabled
	 */

	// Validate: address
	if ( validatePaymentForm.validate.address ) {
		validateElementStreet( validatePaymentForm );
		validateElementCity( validatePaymentForm );
		
		if ( validatePaymentForm.validate.state ) {
			validateElementState( validatePaymentForm );
		}
		
		validateElementCountry( validatePaymentForm );
		
		// Zip is not ready
		//validateElementZip( validatePaymentForm );
	}
	
	// Validate: amount
	if ( validatePaymentForm.validate.amount ) {
		validateElementAmount( validatePaymentForm );
	}
	
	// Validate: creditCard
	if ( validatePaymentForm.validate.creditCard ) {
		validateElementCardNumber( validatePaymentForm );
		validateElementCvv( validatePaymentForm );
	}
	
	// Validate: email
	if ( validatePaymentForm.validate.email ) {
		validateElementEmail( validatePaymentForm );
	}
	
	// Validate: name
	if ( validatePaymentForm.validate.name ) {
		validateElementFirstName( validatePaymentForm );
		validateElementLastName( validatePaymentForm );
	}
	
	// Validate: payment
	if ( validatePaymentForm.validate.payment ) {
		validateElementPaymentMethod( validatePaymentForm );
		validateElementPaymentSubmethod( validatePaymentForm );
	
		// Validate: issuer_id
		if ( validatePaymentForm.validate.issuerId ) {
			validateElementIssuerId( validatePaymentForm );
		}
	}

});

