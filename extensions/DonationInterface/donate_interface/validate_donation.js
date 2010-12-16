//<![CDATA[
function validateForm( form ) {

	var minimums = {
		'USD' : 1,
		'GBP' : 1, // $1.26
		'EUR' : 1, // $1.26
		'AUD' : 2, // $1.35
		'CAD' : 1, // $0.84
		'CHF' : 1, // $0.85
		'CZK' : 20, // $1.03
		'DKK' : 5, // $0.85
		'HKD' : 10, // $1.29
		'HUF' : 200, // $0.97
		'JPY' : 100, // $1
		'NZD' : 2, // $1.18
		'NOK' : 10, // $1.44
		'PLN' : 5, // $1.78
		'SGD' : 2, // $1.35
		'SEK' : 10, // $1.28
	};

	var error = true;

	// Get amount selection
	var amount = null;
	for ( var i = 0; i < form.amount.length; i++ ) {
		if ( form.amount[i].checked ) {
			amount = form.amount[i].value;
		}
	}
	if ( form.amount2.value != '' ) {
		amount = form.amount2.value;
	}
	// Check amount is a real number
	error = ( amount == null || isNaN( amount ) || amount.value <= 0 );
	if ( error ) {
		alert( 'You must enter a valid amount.' );
	}

	// Check amount is at least the minimum
	var currency = form.currency_code[form.currency_code.selectedIndex].value;
	if ( typeof( minimums[currency] ) == 'undefined' ) {
		minimums[currency] = 1;
	}

	if ( amount < minimums[currency] ) {
		alert( 'You must contribute at least $1'.replace('$1', minimums[currency] + ' ' + currency ) );
		error = true;
	}

	return !error;
}
//]]>