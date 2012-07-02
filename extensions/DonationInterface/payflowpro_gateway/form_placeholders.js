//<![CDATA[
( function( $ ) {
	$(document).ready(function() {
		if ( $( '#fname' ).val() == '') {
			$( '#fname' ).css( 'color', '#999999' );
			$( '#fname' ).val( mw.msg( 'donate_interface-donor-fname' ) );
		}
		if ( $( '#lname' ).val() == '') {
			$( '#lname' ).css( 'color', '#999999' );
			$( '#lname' ).val( mw.msg( 'donate_interface-donor-lname' ) );
		}
	});
})(jQuery);

window.formCheck = function( ccform ) {
	var fields = ['emailAdd','fname','lname','street','city','zip','card_num','cvv' ],
		numFields = fields.length,
		i,
		output = '',
		currField = '';

	for( i = 0; i < numFields; i++ ) {
		if ( document.getElementById( fields[i] ) ) { // Make sure field exists
			if( document.getElementById( fields[i] ).value == '' ) {
				currField = mw.msg( 'donate_interface-error-msg-' + fields[i] );
				output += mw.msg( 'donate_interface-error-msg-js' ) + ' ' + currField + '.\r\n';
			}
		}
	}
	
	if (document.getElementById('fname').value == mw.msg( 'donate_interface-donor-fname' )) {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' first name.\r\n';
	}
	if (document.getElementById('lname').value == mw.msg( 'donate_interface-donor-lname' )) {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' last name.\r\n';
	}
	
	var stateField = document.getElementById( 'state' );
	if ( stateField && stateField.type == 'select-one' ) { // state is a dropdown select
		var selectedState = stateField.options[stateField.selectedIndex].value;
		if ( selectedState == 'YY' || selectedState == '' ) {
			output += mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-state-province' ) + '.\r\n';
		}
	}
	
	var countryField = document.getElementById( 'country' );
	if ( countryField && countryField.type == 'select-one' ) { // country is a dropdown select
		if ( countryField.options[countryField.selectedIndex].value == '' ) {
			output += mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-country' ) + '.\r\n';
		}
	} else { // country is a hidden or text input
		if ( countryField.value == '' ) {
			output += mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-country' ) + '.\r\n';
		}
	}

	// validate email address
	var apos = document.payment.emailAdd.value.indexOf("@");
	var dotpos = document.payment.emailAdd.value.lastIndexOf(".");

	if( apos < 1 || dotpos-apos < 2 ) {
		output += mw.msg( 'donate_interface-error-msg-email' ) + '.\r\n';
	}
	
	// Make sure cookies are enabled
	document.cookie = 'wmf_test=1;';
	if ( document.cookie.indexOf( 'wmf_test=1' ) != -1 ) {
		document.cookie = 'wmf_test=; expires=Thu, 01-Jan-70 00:00:01 GMT;'; // unset the cookie
	} else {
		output += mw.msg( 'donate_interface-error-msg-cookies' ); // display error
	}
	
	if( output ) {
		alert( output );
		return false;
	} else {
		return true;
	}
}
//]]>
