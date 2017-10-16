/**
 * Javascript code to be used with input type regexp.
 *
 * @author Stephan Gambke
 *
 */

/**
 * Validates inputs of type regexp.
 *
 * @param input_id (String) the id string of the input to check
 * @param params (Object) the parameter object for the check, contains
 *		retext: (String) regular expression the input's value has to match
 *		inverse: (Boolean) if the check result shall be inverted
 *		message: (String) the message too be printed if the input's value does not match
 * @return (Boolean) true, if the input's value matches the regular expression in
 *         retext, false otherwise; the value is inverted if inverse is true
 */
window.SFI_RE_validate = function( input_id, params ) { //input_number, retext, inverse, message, multiple

	var match;
	var message;
	try {
		var re = new RegExp( params.retext );
		match = re.test( jQuery('#' + input_id).val() );
		message = params.message;
	} catch (e) {
		match = false;
		message = params.error.replace('$1', e );
	}

	if ( ( match && ! params.inverse ) || ( ! match && params.inverse ) ) {
		return true;
	} else {
		jQuery( '#' + input_id ).parent().addErrorMessage( message );
		return false;
	}
};
