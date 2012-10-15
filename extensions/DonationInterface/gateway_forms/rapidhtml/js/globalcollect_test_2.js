// make HTML5 placeholders work in non supportive browsers
$("input[placeholder]").each(function() {
	if($(this).val()=="") {
		$(this).addClass('hasplaceholder');
		$(this).val($(this).attr("placeholder"));
		$(this).focus(function() {
			if($(this).val()==$(this).attr("placeholder")) $(this).val("");
			$(this).removeClass('hasplaceholder');
		});
		$(this).blur(function() {
			if($(this).val()=="") {
				$(this).addClass('hasplaceholder');
				$(this).val($(this).attr("placeholder"));
			}
		});
	}
});

// clear the placeholder values on form submit
$('form').submit(function(evt){
	$('input[placeholder]').each(function(){
		if($(this).attr("placeholder") == $(this).val()) {$(this).val('');}
	});
});

window.formCheck = function( ccform ) {
	var fields = ['emailAdd','fname','lname','street','city','zip'],
		numFields = fields.length,
		i,
		output = '',
		currField = '';

	for( i = 0; i < numFields; i++ ) {
		if( document.getElementById( fields[i] ).value == '' ) {
			currField = mw.msg( 'donate_interface-error-msg-' + fields[i] );
			output += mw.msg( 'donate_interface-error-msg-js' ) + ' ' + currField + '.\r\n';
		}
	}
	
	if (document.getElementById('fname').value == '$first') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' first name.\r\n';
	}
	if (document.getElementById('lname').value == '$last') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' last name.\r\n';
	}
	if (document.getElementById('street').value == '$street') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' street address.\r\n';
	}
	if (document.getElementById('city').value == '$city') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' city.\r\n';
	}
	if (document.getElementById('zip').value == '$zip') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' zip code.\r\n';
	}
	
	var stateField = document.getElementById( 'state' );
	if( stateField.options[stateField.selectedIndex].value == '' ) {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-state-province' ) + '.\r\n';
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
	}
}
